<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    /** @use HasFactory<\Database\Factories\AdmissionFactory> */
    use HasFactory;

    protected $fillable = [
      'school_id',
      'user_id',
      'name',
      'class_name',
      'gender',
      'dob',
      'stay_type',
      'father_name',
      'mother_name',
      'guardian_name',
      'guardian_occupation',
      'guardian_phone',
      'guardian_email',
      'upozilla',
      'union_pourosova',
      'ward',
      'village_moholla',
      'student_photo_path',
      'birth_certificate_path',
      'status',
      'application_fee',
      'payment_tracking_id',
      'username',
      'password',
      'password_text'
    ];
}
