<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
class Note extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    protected $appends = [
        'mini_content',
        'readable_created_at',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically set the user_id when creating a note
        static::creating(function ($note) {
            $note->user_id = Auth::id(); // Set the current user's ID
        });
    }

    public function sharedNotes()
    {
        return $this->hasMany(SharedNote::class, 'note_id');
    }

    protected function miniContent(): Attribute
    {
        // return Attribute::make(
        //     get: fn (string $value) => asset('storage/' . $value),
        // );

        //cut the description
        return Attribute::make(
            get: fn () => substr($this->content, 0, 60)."...",
        );
    }

    protected function getReadableCreatedAtAttribute(): string
    {
        // return Attribute::make(
        //     get: fn (string $value) => asset('storage/' . $value),
        // );

        //cut the description
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
