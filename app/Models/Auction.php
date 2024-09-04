<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $table = 'tbl_auction';
    protected $guarded = [];

    public function lots(){
        return $this->hasMany(Lot::class,'auction_id');
    }
    
}
