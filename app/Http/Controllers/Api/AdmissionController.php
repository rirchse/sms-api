<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\AdmissionAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Admission;
use App\Models\User;

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
        'name' => 'required|string',
        'class_name' => 'required|string',
        'gender' => 'required|string',
        'dob' => 'required|string',
        'stay_type' => 'nullable|string',
        'father_name' => 'nullable|string',
        'mother_name' => 'nullable|string',
        'guardian_name' => 'nullable|string',
        'guardian_occupation' => 'nullable|string',
        'guardian_phone' => 'nullable|string',
        'guardian_email' => 'nullable|string',
        'upozilla' => 'nullable|string',
        'union_pourosova' => 'nullable|string',
        'ward' => 'nullable|string',
        'village_moholla' => 'nullable|string',
        'student_photo_path' => 'nullable|string',
        'birth_certificate_path' => 'nullable|string',
        'status' => 'nullable|string',
        'application_fee' => 'nullable|string',
        'payment_tracking_id' => 'nullable|string'
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
      
      $data['password'] = Hash::make(Str::random(6));
      $data['password_text'] = Str::random(6);

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
        'name' => 'required|string',
        'class_name' => 'required|string',
        'gender' => 'required|string',
        'dob' => 'required|string',
        'stay_type' => 'nullable|string',
        'father_name' => 'nullable|string',
        'mother_name' => 'nullable|string',
        'guardian_name' => 'nullable|string',
        'guardian_occupation' => 'nullable|string',
        'guardian_phone' => 'nullable|string',
        'guardian_email' => 'nullable|string',
        'upozilla' => 'nullable|string',
        'union_pourosova' => 'nullable|string',
        'ward' => 'nullable|string',
        'village_moholla' => 'nullable|string',
        'student_photo_path' => 'nullable|string',
        'birth_certificate_path' => 'nullable|string',
        'status' => 'nullable|string',
        'application_fee' => 'nullable|string',
        'payment_tracking_id' => 'nullable|string'
      ]);

      if(isset($data['_token']))
      {
        unset($data['_token']);
      }

      $data['school_id'] = app('school')->id;

      $admission = Admission::where('id', $id)->update($data);

      return response()->json([
          'admission'  => $admission
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
}
