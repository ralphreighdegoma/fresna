<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'account_id', 'contact_group_id', 'name', 'description', 'status', 'scheduled_at'];
}
