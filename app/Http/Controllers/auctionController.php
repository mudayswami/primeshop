<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_auction;
use App\Models\tbl_auction_category;
use Maatwebsite\Excel\Facades\Excel;
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

    function bulk_upload_auction(request $request){
        return view('auction.bulk_add_auction');
    }
    function post_bulk_auction(request $request)
    {   
        $path = $request->file('file')->store('temp');

        $data = Excel::toArray([], storage_path('app/' . $path));
        dd($data);

        foreach ($data[0] as $row) {

            $imagePath = $this->handleImage($row['img'], $request);
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $path = $file->move(public_path('storage/auction'), $file->getClientOriginalName());
                $request->img = 'storage/auction/' . $path->getFilename();
            }
            tbl_auction::create([
                'title' => $row['title'],
                'description' => $row['description'],
                'start' => $row['Start Date'],
                'next' => $row['Start Date'],
                'img' => $imagePath,
                
            ]);
        }

        // Delete the temporary file
        Storage::delete($path);
        // $csv = $request->file('file');
        // $file_path = $csv->getRealPath();
        // $csv_file = fopen($file_path, "r");
        // $header = fgetcsv($csv_file);
        // $count_new = 0;
        // while ($column = fgetcsv($csv_file)) {
        //     $auction = tbl_auction::create([
        //         'title' => trim($column[0]),
        //         'description' => trim($column[1]),
        //         'start' =>trim($column[2]),
        //         'end' => trim($column[3]),
        //         'img' => trim($column[4]),
        //         'type' => trim($column[5]),
        //         'category' => trim($column[6]),
        //         'lots' => trim($column[7]),
        //         'terms_and_conditions' => trim($column[8]),
        //         'buyer_premium' => trim($column[9]),
        //         'seller_commission' => trim($column[10]),
        //         'fees' => trim($column[11]),
        //         'vat_rate' => trim($column[12]),
        //         'other_tax' => trim($column[13]),
        //     ]);
        //     $count_new++;
        // }
        return redirect('auction-list');
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
