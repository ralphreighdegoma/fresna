<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TimeSheet extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'category',
        'item_id',
        'comment',
        'hours',
        'minutes',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }


    public function timeSheetComments()
    {
        return $this->hasMany(TimeSheetComment::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Automatically set the user_id when creating a comment
        static::creating(function ($item) {
            $item->user_id = Auth::id(); // Set the current user's ID
        });
    }
}
