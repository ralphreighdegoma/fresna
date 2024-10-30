<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected $appends = [
        'time_readable',
        'mini_comment',
        'category_title'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'item_id');
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

    protected function getTimeReadableAttribute(): string
    {
        $hours = intval($this->hours);
        $minutes = intval($this->minutes);

        return ($hours < 10 ? '0' : '').$hours.':'.($minutes < 10 ? '0' : '').$minutes;
    }

    protected function miniComment(): Attribute
    {
        return Attribute::make(
            get: fn () => substr($this->description, 0, 60)."...",
        );
    }

    protected function getCategoryTitleAttribute(): string
    {
        $category_list =
        [
            'task' => 'Task'
        ];

        return $category_list[$this->category];
    }
}
