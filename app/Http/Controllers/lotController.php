<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_auction_category;
use App\Models\tbl_auction;
use App\Models\tbl_lot;

class lotController extends Controller
{
    function add_lot(request $request){
        $data['category'] = tbl_auction_category::all();
        $data['auctions'] = tbl_auction::select('title','id')->get();
        return view('lot.add_lot',$data);
    }

    function post_lot(request $request){
        if($request->hasFile('img')){
            $file = $request->file('img');
            $path = $file->move(public_path('storage/auction'), $file->getClientOriginalName());
            $request->img = 'storage/auction/'.$path->getFilename();
        }
        $lot = tbl_lot::create([
            'auction_id' => $request->auction_id,
            'lot_num' => $request->lot_num,
            'title'   => $request->title,
            'description'=> $request->description,
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
            'pickup_instruction' =>  $request->pickup_instruction,
            'notes' => $request->notes,
        ]);

        return redirect('lot-list');

    }


    function lot_list(request $request){
        $data['lots'] = tbl_lot::all()->toArray();
        return view('lot.lot_list', $data);
    }
}
