<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

  //APPENDS
  protected $appends = [
    'mini_description',
  ];

  

  public function user()
  {
      return $this->belongsTo(User::class);
  }

  public function comments()
  {
      return $this->hasMany(TaskComment::class);
  }


  protected function miniDescription(): Attribute
    {
        // return Attribute::make(
        //     get: fn (string $value) => asset('storage/' . $value),
        // );

        //cut the description
        return Attribute::make(
            get: fn () => substr($this->description, 0, 60)."...",
        );
    }
}
