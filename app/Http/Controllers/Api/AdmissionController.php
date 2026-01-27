<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admission;
use App\Models\User;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

      $data['school_id'] = app('school')->id;

      $admission = Admission::create($data);

      return response()->json([
          'admission'  => $admission
      ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
