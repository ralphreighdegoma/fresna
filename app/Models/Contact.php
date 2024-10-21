<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Contact extends Model
{
    use HasFactory;

    protected $casts = [
      'indigenous_organization' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'work_number',
        'organisation_name',
        'photo',
        'asic_code',
        'suburb',
        'post_code',
        'state',
        'region',
        'indigenous_organization',
        'company_structure',
        'organisation_type',
        'status',
        'business_advisor_id',
        'program_type_id',
        'course_id',
        'resource_id',
        'level_access',
        'referred',
        'refer_name',
        'refer_organisation',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically set the user_id when creating a comment
        static::creating(function ($contact) {
            $contact->user_id = $contact->user_id ? $contact->user_id : Auth::id(); // Set the current user's ID
        });
    }

    public function businessAdvisor()
    {
      return $this->belongsTo(User::class, 'id', 'business_advisor_id');
    }
}
