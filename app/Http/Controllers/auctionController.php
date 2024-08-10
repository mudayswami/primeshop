<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_auction;
use App\Models\tbl_auction_category;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Illuminate\Support\Facades\Storage;

class auctionController extends Controller
{
    function add_auction()
    {
        $data['category'] = tbl_auction_category::all();
        return view("auction.add_auction", $data);
    }

    function post_auction(Request $request)
    {
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $path = $file->move(public_path('storage/auction'), $file->getClientOriginalName());
            $request->img = 'storage/auction/' . $path->getFilename();
        }
        $auction = tbl_auction::create([
            'enc_id'=> md5(date('Y-m-d H:i:s')),
            'title' => $request->title,
            'description' => $request->description,
            'start' => $request->start_date,
            'end' => $request->end_date,
            'img' => $request->img,
            'type' => $request->type,
            'category' => json_encode($request->category),
            'lots' => $request->lots,
            'terms_and_conditions' => $request->terms,
            'buyer_premium' => $request->buyer_premium,
            'seller_commission' => $request->seller_premium,
            'fees' => $request->fees,
            'vat_rate' => $request->vat,
            'other_tax' => $request->taxes,
        ]);
        return redirect('auction-list');
    }

    function bulk_upload_auction(request $request)
    {
        return view('auction.bulk_add_auction');
    }
    function post_bulk_auction(request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $path = $request->file('file')->store('temp');
        $filePath = storage_path('app/' . $path);

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $imagePaths = $this->extractImages($sheet);
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
            tbl_auction::create([
                'enc_id'=> md5(date('Y-m-d H:i:s')),
                'title' => trim($columns[0]),
                'description' => trim($columns[1]),
                'start' =>  ExcelDate::excelToDateTimeObject($columns[2]),
                'end' =>  ExcelDate::excelToDateTimeObject($columns[3]),
                'img' => $img,
                'type' => trim($columns[5]),
                'category' => trim($columns[6]),
                'lots' => trim($columns[7]),
                'terms_and_conditions' => trim($columns[8]),
                'buyer_premium' => trim($columns[9]),
                'seller_commission' => trim($columns[10]),
                'fees' => trim($columns[11]),
                'vat_rate' => trim($columns[12]),
                'other_tax' => trim($columns[13]),
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
            }

            $newImageName = uniqid() . '.' . $extension;
            $p = Storage::disk('public')->put('storage/auction/' . $newImageName, $imageContents);
            $imagePaths[$rowIndex - 1] = 'storage/auction/' . $newImageName;
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

    function auction_list(request $request)
    {
        $data['auctions'] = tbl_auction::all()->sortByDesc('id');
        return view('auction.auction_list', $data);
    }

    function auction_edit(request $request, $id)
    {
        $data['category'] = tbl_auction_category::all();
        $data['auction'] = tbl_auction::find($id)->toArray();
        return view('auction.edit_auction', $data);
    }

    function update_auction(request $request, $slug)
    {
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $path = $file->move(public_path('storage/auction'), $file->getClientOriginalName());
            $request->img = 'storage/auction/' . $path->getFilename();
        }
        $auction = tbl_auction::find($slug);
        if (!$auction) {
            die('no auction found');
        }
        $auction->title = $request->title;
        $auction->status = $request->status;
        $auction->description = $request->description;
        $auction->start = $request->start_date;
        $auction->end = $request->end_date;
        $auction->img = $request->img;
        $auction->type = $request->type;
        $auction->category = json_encode($request->category);
        $auction->lots = $request->lots;
        $auction->terms_and_conditions = $request->terms;
        $auction->buyer_premium = $request->buyer_premium;
        $auction->seller_commission = $request->seller_premium;
        $auction->fees = $request->fees;
        $auction->vat_rate = $request->vat;
        $auction->other_tax = $request->taxes;
        $auction->save();
        return redirect('auction-list');
    }
    function auction_delete(request $request, $id)
    {
        try {
            $auction = tbl_auction::findOrFail($id);
            $auction->delete();
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
    public function add_category(request $request)
    {
        $data['category'] = tbl_auction_category::all();
        return view('auction.add_category', $data);
    }

    function post_category(request $request)
    {
        $category = tbl_auction_category::create([
            'category' => $request->title
        ]);
        return "Done";
    }



}
