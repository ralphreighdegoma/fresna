<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  protected $fillable = [
    'title',
    'description',
    'due_date',
    'attachments',
    'user_id',
    'reminder',
    'reminder_repeat',
    // 'comments',
  ];

  protected $casts = [
    'attachments' => 'array',
  ];

  public function user()
  {
      return $this->belongsTo(User::class);
  }

  public function comments()
  {
      return $this->hasMany(TaskComment::class);
  }
}
