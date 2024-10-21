<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskComment extends Model
{
    protected $fillable = [
      'user_id',
      'content',
      'task_id',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Automatically set the user_id when creating a comment
        static::creating(function ($comment) {
            $comment->user_id = Auth::id(); // Set the current user's ID
        });
    }
}
