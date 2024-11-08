<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThreadParticipant extends Model
{
    protected $fillable = [
        'thread_id',
        'user_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
