<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuctionCategory;
use App\Models\Auction;
use App\Models\Lot;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Validator;
use Storage;

class LotController extends Controller
{
    function add_lot(request $request)
    {
        $data['category'] = AuctionCategory::all();
        $data['auctions'] = Auction::select('title', 'id')->get();
        return view('lot.add_lot', $data);
    }

    function post_lot(request $request)
    {
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $postFields = [
                'path' =>'storage/auction/',
                'image' =>  curl_file_create($file->getPathname(), $file->getMimeType(), $file->getClientOriginalName()),
            ]  ;
            $path = $this->postApi('image-upload',$postFields);  
            $request->img = $path['storage_path'];
        }
        $lot = Lot::create([
            'enc_id' => md5(date('Y-m-d H:i:s')),
            'auction_id' => $request->auction_id,
            'lot_num' => $request->lot_num,
            'title' => $request->title,
            'description' => $request->description,
            'img' => $request->img,
            'category' => json_encode($request->category),
            'condition' => $request->condition,
            'dimension' => $request->dimension,
            'start_bid' => $request->start_bid,
            'next_bid' => $request->next_bid,
            'reserve_bid' => $request->reserve_bid,
            'buyer_premium' => $request->buyer_premium,
            'store_price' => $request->store_price,
            'ship_info' => $request->ship_info,
            'ship_cost' => $request->ship_cost,
            'ship_restriction' => $request->ship_restriction,
            'pickup' => $request->pickup,
            'pickup_address' => $request->pickup_address,
            'pickup_instruction' => $request->pickup_instruction,
            'notes' => $request->notes,
        ]);

        return redirect('lot-list');

    }

    function lot_edit(request $request, $id)
    {
        $data['lot'] = Lot::where('enc_id', $id)->firstOrFail()->toArray();
        $data['auctions'] = Auction::select('title', 'id')->get();
        $data['category'] = AuctionCategory::all();

        return view('lot.edit_lot', $data);

    }

    function update_lot(request $request, $slug)
    {
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $postFields = [
                'path' =>'storage/auction/',
                'image' =>  curl_file_create($file->getPathname(), $file->getMimeType(), $file->getClientOriginalName()),
            ]  ;
            $path = $this->postApi('image-upload',$postFields);  
            $request->img = $path['storage_path'];
        }
        $lot = Lot::firstOrFail()->where('enc_id', $slug)->first();
        if (!$lot) {
            die('No Lot found');
        }
        $lot->auction_id = $request->auction_id;
        $lot->lot_num = $request->lot_num;
        $lot->title = $request->title;
        $lot->description = $request->description;
        $lot->img = $request->img;
        $lot->category = json_encode($request->category);
        $lot->condition = $request->condition;
        $lot->dimension = $request->dimension;
        $lot->start_bid = $request->start_bid;
        $lot->next_bid = $request->next_bid;
        $lot->reserve_bid = $request->reserve_bid;
        $lot->buyer_premium = $request->buyer_premium;
        $lot->store_price = $request->store_price;
        $lot->ship_info = $request->ship_info;
        $lot->ship_cost = $request->ship_cost;
        $lot->ship_restriction = $request->ship_restriction;
        $lot->pickup = $request->pickup;
        $lot->pickup_address = $request->pickup_address;
        $lot->pickup_instruction = $request->pickup_instruction;
        $lot->notes = $request->notes;
        $lot->save();
        return redirect('lot-list');
    }
    function BulkUploadsLots(request $request)
    {
        $data['auctions'] = Auction::select('title', 'id')->get();
        return view('lot.bulk_add_lots', $data);
    }
    function post_bulk_lots(request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'auction_id' => 'required|int'
        ]);

        $path = $request->file('file')->store('temp');
        $filePath = storage_path('app/' . $path);

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $imagePaths = $this->extractImages($sheet);
        $auction_id = $request->auction_id;
        foreach ($sheet->getRowIterator() as $rowIndex => $row) {
            if ($rowIndex === 1) {
                continue;
            }

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $columns = [];
            foreach ($cellIterator as $cell) {
                $columns[] = $cell->getValue();
            }
            $img = isset($imagePaths[$rowIndex - 1]) ? $imagePaths[$rowIndex - 1] : 'null';
            echo $img;
            echo "<br>";
            Lot::create([
                'enc_id' => md5(date('Y-m-d H:i:s')),
                'auction_id' => $auction_id,
                'lot_num' => trim($columns[0]),
                'title' => trim($columns[1]),
                'description' => trim($columns[2]),
                'img' => $img,
                'category' => trim($columns[4]),
                'condition' => trim($columns[5]),
                'dimension' => trim($columns[6]),
                'start_bid' => trim($columns[7]),
                'next_bid' => trim($columns[8]),
                'reserve_bid' => trim($columns[9]),
                'buyer_premium' => trim($columns[10]),
                'store_price' => trim($columns[11]),
                'ship_info' => trim($columns[12]),
                'ship_cost' => trim($columns[13]),
                'ship_restriction' => trim($columns[14]),
                'pickup' => trim($columns[15]),
                'pickup_address' => trim($columns[16]),
                'pickup_instruction' => trim($columns[17]),
                'notes' => trim($columns[18]),
            ]);
        }
        Storage::delete($path);
        return redirect('auction-list');
    }

    private function extractImages($sheet)
    {
        $imagePaths = [];
        foreach ($sheet->getDrawingCollection() as $drawing) {
            $coordinates = $drawing->getCoordinates();
            $rowIndex = $sheet->getCell($coordinates)->getRow();
            $originalFilename = "";
            if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing) {
                ob_start();
                call_user_func(
                    $drawing->getRenderingFunction(),
                    $drawing->getImageResource()
                );
                $imageContents = ob_get_contents();
                ob_end_clean();
                $extension = $this->mimeToExtension($drawing->getMimeType());
            } else {
                $path = $drawing->getPath();
                $imageContents = file_get_contents($path);
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                $originalFilename = pathinfo($path, PATHINFO_BASENAME);
            }

            $newImageName = uniqid() . '.' . $extension;
            $postFields = [
                'path' =>'storage/auction/',
                'image' =>  curl_file_create($path, mime_content_type($path), basename($path)),
            ]  ;
            $path = $this->postApi('image-upload',$postFields);  
            $imagePaths[$rowIndex - 1] = $path['storage_path'];;




            $path = $drawing->getPath();
            $imageContents = file_get_contents($path);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            
        }

        return $imagePaths;
    }

    private function mimeToExtension($mime)
    {
        $mime_map = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/bmp' => 'bmp',
            'image/tiff' => 'tif',
        ];

        return isset($mime_map[$mime]) ? $mime_map[$mime] : 'bin';
    }


    function lot_list(request $request)
    {
        $data['lots'] = Lot::all()->toArray();
        return view('lot.lot_list', $data);
    }
}
