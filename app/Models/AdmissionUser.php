<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class AdmissionUser extends Authenticatable
{
  use HasApiTokens, HasFactory;

  protected $fillable = [
    'school_id',
    'admission_id',
    'name',
    'username',
    'password',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];
}
