<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionRegister extends Model
{
    use HasFactory;
    protected $table = 'auction_register';
    protected $guarded = [];
    protected $fillable = ['approved','status'];

    function auctions(){
        return $this->belongsTo(Auction::class,'auction_id','id');
    }

    function user(){
        return $this->belongsTo(User::class,'user_id','user_id');
    }
}
