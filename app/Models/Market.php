<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Vendor(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function Products(){
        return $this->hasMany(Product::class);
    }
    public function Subscriptions(){
        return $this->hasMany(Subscription::class);
    }
    public function Orders(){
        return $this->hasMany(Order::class);
    }
}
