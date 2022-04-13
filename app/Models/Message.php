<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function Mail()
    {
        return $this->belongsTo(Mail::class, "mail_id", "mail_id");
    }


    public function Attachments()
    {
        return $this->hasMany(MessageAttachment::class, "message_id", "message_id");
    }
}
