<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Group extends Model
{
    protected $fillable = [
        'user_id',
        'company',
        'name',
        'program_type',
        'business_advisor_id',
        'status',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function businessAdvisor()
    {
        return $this->belongsTo(User::class, 'business_advisor_id');
    }

    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Automatically set the user_id when creating a note
        static::creating(function ($note) {
            $note->user_id = Auth::id(); // Set the current user's ID
        });
    }
}
