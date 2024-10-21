<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',   // ID of the user who sent the message
        'receiver_id', // ID of the user who receives the message
        'thread_id',   // ID of the thread this message belongs to
        'body'         // Content of the message
    ];

}
