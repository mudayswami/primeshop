<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\auctionController;
use App\Http\Controllers\lotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[dashboardController::class,'dashboard']);

// Auction

Route::get('add-auction',[auctionController::class,'add_auction']);
Route::post('add-auction',[auctionController::class,'post_auction']);
Route::get('bulk-upload-auction',[auctionController::class,'bulk_upload_auction']);
Route::post('bulk-add-auction',[auctionController::class,'post_bulk_auction']);
Route::get('auction/edit/{id}',[auctionController::class,'auction_edit']);
Route::post('update-auction/{slug}',[auctionController::class,'update_auction']);
Route::post('delete-auction/{slug}',[auctionController::class,'auction_delete']);
Route::get('auction-list',[auctionController::class,'auction_list']);
Route::get('add-auction-category',[auctionController::class,'add_category']);
Route::post('add-auction-category',[auctionController::class,'post_category']);

// End Auction


// Lots

Route::get('add-lot',[lotController::class,'add_lot']);
Route::post('add-lot',[lotController::class,'post_lot']);
Route::get('lot/edit/{slug}',[lotController::class,'lot_edit']);
Route::post('update-lot/{slug}',[lotController::class,'update_lot']);
Route::get('lot-list',[lotController::class,'lot_list']);
Route::get('bulk-upload-lots',[lotController::class,'BulkUploadsLots']);
Route::post('bulk-add-lots',[lotController::class,'post_bulk_lots']);
// End Lots