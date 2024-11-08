<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = [
        'status',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function last_message()
    {
        return $this->hasOne(Message::class, 'thread_id')->latest();
    }

    public function participants()
    {
        return $this->hasMany(ThreadParticipant::class);
    }
}
