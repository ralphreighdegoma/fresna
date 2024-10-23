<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = [
        'status',
        'title',
        'client_id',
        'organisation',
        'referral_reason',
        'referral_description',
        'expected_outcome',
        'referred_to_id',
        'max_hours',
        'max_cost'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function referredTo()
    {
        return $this->belongsTo(User::class, 'referred_to_id');
    }
}
