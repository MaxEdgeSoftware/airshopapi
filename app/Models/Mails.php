<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mails extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function Messages()
    {
        return $this->hasMany(Message::class, 'mail_id', 'mail_id');
    }

    public function Sender()
    {
        return $this->hasOne(User::class, "email", "sender");
    }

    public function To()
    {
        return $this->hasOne(User::class, "email", "to");
    }
}
