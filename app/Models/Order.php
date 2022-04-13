<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Store(){
        return $this->belongsTo(Market::class);
    }

    public function Products(){
        return $this->hasMany(Orderbreakdown::class);
    }
}
