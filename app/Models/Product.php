<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Store(){
        return $this->belongsTo(Market::class);
    }


    public function PStore(){
        return $this->belongsTo(Market::class, "market_id", "id");
    }
}
