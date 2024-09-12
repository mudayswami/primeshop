<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionCategory extends Model
{
    use HasFactory;

    protected $table = 'tbl_auction_category';

    protected $guarded = [''];
    public static function getActiveCategories() {
        return self::where('status', 1)->get(); 
    }
}
