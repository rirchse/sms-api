<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AdmissionAuthController;
use App\Http\Controllers\SourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Admission;
use App\Models\User;
use App\Models\Student;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $admissions = Admission::orderBy('id', 'DESC')
      ->paginate(25);

      return response()->json([
        'admissions' => $admissions
      ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $data = $request->validate([
        'name_en' => 'nullable|string',
        'name_bn' => 'nullable|string',
        'name_ar' => 'nullable|string',
        'dob' => 'nullable|string',
        'birth_certificate_no' => 'nullable|string|unique:admissions',
        'gender' => 'nullable|string',
        'height' => 'nullable|string',
        'weight' => 'nullable|string',
        'age' => 'nullable|string',
        'nationality' => 'nullable|string',
        'blood_group' => 'nullable|string',
        'identify_sign' => 'nullable|string',
        'present_village' => 'nullable|string',
        'present_post' => 'nullable|string',
        'present_upazilla' => 'nullable|string',
        'present_post_code' => 'nullable|string',
        'present_zilla' => 'nullable|string',
        'permanent_village' => 'nullable|string',
        'permanent_post' => 'nullable|string',
        'permanent_upazilla' => 'nullable|string',
        'permanent_zilla' => 'nullable|string',
        'permanent_post_code' => 'nullable|string',
        'father_name_bn' => 'nullable|string',
        'father_name_en' => 'nullable|string',
        'father_education' => 'nullable|string',
        'father_occupation' => 'nullable|string',
        'father_monthly_earning' => 'nullable|string',
        'father_mobile_no' => 'nullable|string',
        'father_nid_no' => 'nullable|string',
        'father_dob' => 'nullable|string',
        'mother_name_bn' => 'nullable|string',
        'mother_name_en' => 'nullable|string',
        'mother_education' => 'nullable|string',
        'mother_occupation' => 'nullable|string',
        'mother_monthly_earning' => 'nullable|string',
        'mother_mobile_no' => 'nullable|string',
        'mother_nid_no' => 'nullable|string',
        'mother_dob' => 'nullable|string',
        'guardian_name' => 'nullable|string',
        'guardian_student_relation' => 'nullable|string',
        'guardian_present_address' => 'nullable|string',
        'guardian_permanent_address' => 'nullable|string',
        'guardian_education' => 'nullable|string',
        'guardian_occupation' => 'nullable|string',
        'guardian_monthly_earning' => 'nullable|string',
        'guardian_mobile_no' => 'nullable|string',
        'guardian_nid_no' => 'nullable|string',
        'guardian_dob' => 'nullable|string',
        'class_name' => 'nullable|string',
        'session_name' => 'nullable|string',
        'division' => 'nullable|string',
        'previous_institute_name' => 'nullable|string',
        'sibling_details' => 'nullable|string',
        'student_photo' => 'nullable|image:mimes:jpg,jpeg,png,gif|max:1000',
        'student_signature' => 'nullable|image:mimes:jpg,jpeg,png,gif|max:1000',
        'application_fee' => 'nullable|string',
        'payment_tracking_id' => 'nullable|string',
        'username' => 'nullable|string',
        'password' => 'nullable|string',
      ]);

      if(isset($data['_token']))
      {
        unset($data['_token']);
      }

      $school_id = app('school')->id;

      $data['school_id'] = $school_id;

      // 1. Generate a UNIQUE 6-digit username
      do {
        $year = now()->format('Y');
        $id = random_int(1000, 9990);
        $username = "{$year}-{$school_id}-{$id}";
        $data['username'] = $username;
      } while (Admission::where('username', $username)->exists());
      
      $data['password'] = Hash::make($data['password']);

      //file upload
      $source = new SourceController;
      if($request->hasFile('student_photo'))
      {
        $data['student_photo'] = $source->fileUpload($data['student_photo'], 'admission/photo/');
      }

      if($request->hasFile('student_signature'))
      {
        $data['student_signature'] = $source->fileUpload($data['student_signature'], 'admission/nid/');
      }

      try {

        $admission = Admission::create($data);
        
        $data['admission_id'] = $admission->id;

        //admission auth controller object
        $admission_auth = new AdmissionAuthController;
  
        //create admission authentication
        $token = $admission_auth->register($data);
  
        return response()->json([
          'admission'  => $admission,
          'token' => $token
        ]);
      }
      catch(\Exception $e)
      {
        return response()->json(['error' => $e->getMessage()]);
      }

      return response()->json([
        'message' => 'Registration failed!'
      ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $admission = Admission::find($id);
      return response()->json([
          'admission'  => $admission
      ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $data = $request->validate([
        'name_en' => 'required|string',
        'name_bn' => 'nullable|string',
        'name_ar' => 'nullable|string',
        'dob' => 'nullable|string',
        'birth_certificate_no' => 'nullable|string',
        'gender' => 'nullable|string',
        'height' => 'nullable|string',
        'weight' => 'nullable|string',
        'age' => 'nullable|string',
        'nationality' => 'nullable|string',
        'blood_group' => 'nullable|string',
        'identify_sign' => 'nullable|string',
        'present_village' => 'nullable|string',
        'present_post' => 'nullable|string',
        'present_upazilla' => 'nullable|string',
        'present_post_code' => 'nullable|string',
        'present_zilla' => 'nullable|string',
        'permanent_village' => 'nullable|string',
        'permanent_post' => 'nullable|string',
        'permanent_upazilla' => 'nullable|string',
        'permanent_zilla' => 'nullable|string',
        'permanent_post_code' => 'nullable|string',
        'father_name_bn' => 'nullable|string',
        'father_name_en' => 'nullable|string',
        'father_education' => 'nullable|string',
        'father_occupation' => 'nullable|string',
        'father_monthly_earning' => 'nullable|string',
        'father_mobile_no' => 'nullable|string',
        'father_nid_no' => 'nullable|string',
        'father_dob' => 'nullable|string',
        'mother_name_bn' => 'nullable|string',
        'mother_name_en' => 'nullable|string',
        'mother_education' => 'nullable|string',
        'mother_occupation' => 'nullable|string',
        'mother_monthly_earning' => 'nullable|string',
        'mother_mobile_no' => 'nullable|string',
        'mother_nid_no' => 'nullable|string',
        'mother_dob' => 'nullable|string',
        'guardian_name' => 'nullable|string',
        'guardian_student_relation' => 'nullable|string',
        'guardian_present_address' => 'nullable|string',
        'guardian_permanent_address' => 'nullable|string',
        'guardian_education' => 'nullable|string',
        'guardian_occupation' => 'nullable|string',
        'guardian_monthly_earning' => 'nullable|string',
        'guardian_mobile_no' => 'nullable|string',
        'guardian_nid_no' => 'nullable|string',
        'guardian_dob' => 'nullable|string',
        'class_name' => 'nullable|string',
        'session_name' => 'nullable|string',
        'division' => 'nullable|string',
        'previous_institute_name' => 'nullable|string',
        'sibling_details' => 'nullable|string',
        'student_photo' => 'nullable|image:mimes:jpg,jpeg,png,gif|max:1000',
        'student_signature' => 'nullable|image:mimes:jpg,jpeg,png,gif|max:1000',
        'application_fee' => 'nullable|string',
        'payment_tracking_id' => 'nullable|string',
        'username' => 'nullable|string',
        'password' => 'nullable|string',
      ]);

      $data['school_id'] = app('school')->id;
      $admission = Admission::find($id);
      $xphoto = public_path($admission->student_photo);
      $xsignature = public_path($admission->student_signature);

      //file upload
      $source = new SourceController;
      if($request->hasFile('student_photo'))
      {
        $data['student_photo'] = $source->fileUpload($data['student_photo'], 'admission/photo/');

        //delete existing photo
        if(File::exists($xphoto))
        {
          File::delete($xphoto);
        }
      }

      if($request->hasFile('student_signature'))
      {
        $data['student_signature'] = $source->fileUpload($data['student_signature'], 'admission/nid/');
        
        //delete existing photo
        if(File::exists($xsignature))
        {
          File::delete($xsignature);
        }
      }

      try {

        $admission = Admission::where('id', $id)->update($data);

        return response()->json([
            'admission'  => $admission,
            'message' => 'Admission data updated'
        ]);
      }
      catch(\Exception $e)
      {
        return $e->getMessage();
      }

      return response()->json([
        'message' => 'Unknow error'
      ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admission = Admission::find($id);
        $admission->delete();

        return response()->json([
          'admission' => $admission,
          'message' => 'Requested data successfully deleted '
        ], 200);
    }

    public function payments($admission)
    {
      $payments = Payment::where('admission_id', $admission)->get();
      return response()->json([
        'payments' => $payments
      ], 200);
    }

    public function admissionStudent($id)
    {
      $admission = Admission::find($id);
      $admission = $admission->toArray();
      unset($admission['id']);
      unset($admission['created_at']);
      unset($admission['updated_at']);
      
      try {
        $student = Student::create($admission);
        return response()->json([
          'student' => $student,
          'message' => 'Admission moved to the student.'
        ], 200);
      }
      catch(\Exception $e)
      {
        return $e->getMessage();
      }
    }
}
