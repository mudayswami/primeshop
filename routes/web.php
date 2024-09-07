<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\UserController;
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
Route::middleware(['auth', 'verified'])->group(function () {
Route::get('/',[DashboardController::class,'dashboard']);

// Auction
Route::get('add-auction',[AuctionController::class,'add_auction']);
Route::post('add-auction',[AuctionController::class,'post_auction']);
Route::get('bulk-upload-auction',[AuctionController::class,'bulk_upload_auction']);
Route::post('bulk-add-auction',[AuctionController::class,'post_bulk_auction']);
Route::get('auction/edit/{id}',[AuctionController::class,'auction_edit']);
Route::post('update-auction/{slug}',[AuctionController::class,'update_auction']);
Route::post('delete-auction/{slug}',[AuctionController::class,'auction_delete']);
Route::get('auction-list',[AuctionController::class,'auction_list']);
Route::get('add-auction-category',[AuctionController::class,'add_category']);
Route::post('add-auction-category',[AuctionController::class,'post_category']);
Route::get('approve-bidding',[AuctionController::class,'approveBiding']);
Route::get('bids',[AuctionController::class,'bids']);
Route::post('auction-approve',[AuctionController::class,'auctionApprove']);
// End Auction


// Lots
Route::get('add-lot',[LotController::class,'add_lot']);
Route::post('add-lot',[LotController::class,'post_lot']);
Route::get('lot/edit/{slug}',[LotController::class,'lot_edit']);
Route::post('update-lot/{slug}',[LotController::class,'update_lot']);
Route::get('lot-list',[LotController::class,'lot_list']);
Route::get('bulk-upload-lots',[LotController::class,'BulkUploadsLots']);
Route::post('bulk-add-lots',[LotController::class,'post_bulk_lots']);
// End Lots
});


Route::get('login',[UserController::class,'login'])->name('login');
Route::get('logout',[UserController::class,'logout']);
Route::post('login',[UserController::class,'postLogin']);
Route::get('register',[UserController::class,'register']);
Route::post('register',[UserController::class,'postRegister']);