<?php

namespace App\Http\Controllers;

use App\Models\AuctionRegister;
use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\AuctionCategory;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Illuminate\Support\Facades\Storage;
use App\Models\Bids;
use DB;

class AuctionController extends Controller
{
    function add_auction()
    {
        $data['category'] = AuctionCategory::all();
        return view("auction.add_auction", $data);
    }

    function post_auction(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required|string',
                'img' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'lots' => 'required',
                'category' => 'required',
            ]);
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $postFields = [
                    'path' => 'storage/auction',
                    'image' => curl_file_create($file->getPathname(), $file->getMimeType(), $file->getClientOriginalName()),
                ];
                $path = $this->postApi('image-upload', $postFields);
                $request->img = $path['storage_path'];
            }
            $auction = Auction::create([
                'enc_id' => md5(date('Y-m-d H:i:s')),
                'title' => $request->title,
                'description' => $request->description,
                'start' => $request->start_date,
                'end' => $request->end_date,
                'img' => $request->img,
                'type' => $request->type,
                'category' => json_encode($request->category),
                'location' => $request->location,
                'lots' => $request->lots,
                'terms_and_conditions' => $request->terms,
                'buyer_premium' => $request->buyer_premium,
                'seller_commission' => $request->seller_premium,
                'fees' => $request->fees,
                'vat_rate' => $request->vat,
                'other_tax' => $request->taxes,
            ]);
            return redirect('auction-list');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    function bulk_upload_auction(request $request)
    {
        return view('auction.bulk_add_auction');
    }
    function post_bulk_auction(request $request)
    {
        try {

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
                Auction::create([
                    'enc_id' => md5(date('Y-m-d H:i:s')),
                    'title' => trim($columns[0]),
                    'description' => trim($columns[1]),
                    'start' => ExcelDate::excelToDateTimeObject($columns[2]),
                    'end' => ExcelDate::excelToDateTimeObject($columns[3]),
                    'img' => $img,
                    'type' => trim($columns[5]),
                    'category' => trim($columns[6]),
                    'location' => trim($columns[7]),
                    'lots' => trim($columns[8]),
                    'terms_and_conditions' => trim($columns[9]),
                    'buyer_premium' => trim($columns[10]),
                    'seller_commission' => trim($columns[11]),
                    'fees' => trim($columns[12]),
                    'vat_rate' => trim($columns[13]),
                    'other_tax' => trim($columns[14]),
                ]);
            }
            Storage::delete($path);
            return redirect('auction-list');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
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
            $postFields = [
                'path' => 'storage/auction',
                'image' => curl_file_create($path, mime_content_type($path), basename($path)),
            ];
            $path = $this->postApi('image-upload', $postFields);
            $imagePaths[$rowIndex - 1] = $path['storage_path'];
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
        $data['auctions'] = Auction::all()->sortByDesc('id');
        return view('auction.auction_list', $data);
    }

    function auction_edit(request $request, $id)
    {
        $data['category'] = AuctionCategory::all();
        $data['auction'] = Auction::find($id)->toArray();
        return view('auction.edit_auction', $data);
    }

    function update_auction(request $request, $slug)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required|string',
                'img' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'lots' => 'required',
                'category' => 'required',
            ]);
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $postFields = [
                    'path' => 'storage/auction',
                    'image' => curl_file_create($file->getPathname(), $file->getMimeType(), $file->getClientOriginalName()),
                ];
                $path = $this->postApi('image-upload', $postFields);
                $request->img = $path['storage_path'];
            }
            $auction = Auction::find($slug);
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
            $auction->location = $request->location;
            $auction->lots = $request->lots;
            $auction->terms_and_conditions = $request->terms;
            $auction->buyer_premium = $request->buyer_premium;
            $auction->seller_commission = $request->seller_premium;
            $auction->fees = $request->fees;
            $auction->vat_rate = $request->vat;
            $auction->other_tax = $request->taxes;
            $auction->save();
            return redirect('auction-list');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    function auction_delete(request $request, $id)
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $auction = Auction::findOrFail($id);
            $auction->delete();
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
    public function add_category(request $request)
    {
        $data['category'] = AuctionCategory::all();
        return view('auction.add_category', $data);
    }

    function post_category(request $request)
    {
        $category = AuctionCategory::create([
            'category' => $request->title
        ]);
        return "Done";
    }

    function approveBiding()
    {
        $data['auction'] = AuctionRegister::join('tbl_auction', 'auction_register.auction_id', '=', 'tbl_auction.id')->
            join('user', 'user.user_id', '=', 'auction_register.user_id')
            ->select('auction_register.*', 'user.first_name', 'user.last_name', 'tbl_auction.title', 'tbl_auction.start', 'tbl_auction.end')->orderBy('created_at', 'desc')->get();
        return view('auction.approveBidding', $data);
    }

    function auctionApprove(Request $request)
    {
        $id = $request->id;
        if (empty($id))
            return 'Id not found';
        $register = AuctionRegister::find($id);
        if (!empty($register)) {
            $register->approved = $request->status;
            $register->save();

            return $request->status;
        } else {
            return $request->status;
        }
    }

    function bids(Request $request)
    {

        $data['bids'] = Bids::join('tbl_lot', 'bids.lot', '=', 'tbl_lot.id')->join('user', 'user.user_id', '=', 'bids.user_id')
            ->select('bids.*', 'tbl_lot.enc_id', 'tbl_lot.title', 'user.first_name', 'user.last_name')->get();
        return view('auction.bids', $data);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:won,lost,outbid,leading,withdrawn',
        ]);
        $item = Bids::find($id);
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }
        $item->status = $request->status;
        $item->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
    function updateCategory(Request $request, $id)
    {
        $category = AuctionCategory::find($id)->first();
        $category->category = $request->category;
        $category->save();
        return redirect('add-auction-category')->with('success', 'Category Update successfully.');
        ;
    }
    function deleteCategory(Request $request, $id)
    {
        $category = AuctionCategory::destroy($id);
        return redirect('add-auction-category')->with('success', 'Category deleted successfully.');
        ;
    }

    function winners(Request $request)
    {

        $data['winner'] = Bids::join('tbl_lot', 'bids.lot', '=', 'tbl_lot.id')->join('user', 'user.user_id', '=', 'bids.user_id')
            ->select('bids.*', 'tbl_lot.enc_id', 'tbl_lot.title', 'user.first_name', 'user.last_name')->where('bids.status', '=', 'won')->get();
        return view('auction.winners', $data);
    }

}
