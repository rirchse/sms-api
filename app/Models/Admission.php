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
      'name_en',
      'name_bn',
      'name_ar',
      'dob',
      'birth_certificate_no',
      'gender',
      'height',
      'weight',
      'age',
      'nationality',
      'blood_group',
      'identify_sign',
      'present_village',
      'present_post',
      'present_upazilla',
      'present_post_code',
      'present_zilla',
      'permanent_village',
      'permanent_post',
      'permanent_upazilla',
      'permanent_zilla',
      'permanent_post_code',
      'father_name_bn',
      'father_name_en',
      'father_education',
      'father_occupation',
      'father_monthly_earning',
      'father_mobile_no',
      'father_nid_no',
      'father_dob',
      'mother_name_bn',
      'mother_name_en',
      'mother_education',
      'mother_occupation',
      'mother_monthly_earning',
      'mother_mobile_no',
      'mother_nid_no',
      'mother_dob',
      'guardian_name',
      'guardian_student_relation',
      'guardian_present_address',
      'guardian_permanent_address',
      'guardian_education',
      'guardian_occupation',
      'guardian_monthly_earning',
      'guardian_mobile_no',
      'guardian_nid_no',
      'guardian_dob',
      'class_name',
      'session_name',
      'division',
      'previous_institute_name',
      'sibling_details',
      'student_photo',
      'student_signature',
      'status',
      'application_fee',
      'payment_tracking_id',
      'username',
      'password',
    ];
}
