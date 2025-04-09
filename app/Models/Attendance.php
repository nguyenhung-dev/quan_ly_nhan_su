<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
  use HasFactory;

  protected $table = 'attendances';

  protected $fillable = [
    'date',
    'check_in',
    'check_out',
    'status',
    'user_id',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

}