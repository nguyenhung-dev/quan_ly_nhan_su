<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;
  protected $table = 'users';

  protected $fillable = [
    'name',
    'email',
    'password',
    'phone',
    'adress',
    'birthday',
    'avatar',
    'gender',
    'position_id',
    'role',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'birthday' => 'date',
    'avatar' => 'string',
    'email_verified_at' => 'datetime',
  ];

  public function isAdmin()
  {
    return $this->role === 'admin';
  }

  public function isEmployee()
  {
    return $this->role === 'employee' || $this->role === 'staff';
  }
  public function position()
  {
    return $this->belongsTo(Position::class);
  }
}