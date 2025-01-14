<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderbreakdown extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Order(){
        return $this->belongsTo(Order::class);
    }
}
