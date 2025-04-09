<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'month',
        'year',
        'total_working_days',
        'late_or_absent_days',
        'status',
        'bonus',
        'penalty',
        'final_salary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}