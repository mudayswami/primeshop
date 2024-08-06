<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_lot extends Model
{
    use HasFactory;

    protected $table = "tbl_lot";


    protected $guarded = [];
    public function auction(){
        return $this->belongsTo(tbl_auction::class,'auction_id');
    }
}
