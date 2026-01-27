<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('school', function ($query) {
            if (app()->bound('school')) {
                $query->where('school_id', app('school')->id);
            }
        });
    }
}
