<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdmissionUser;

class AdmissionAuthController extends Controller
{
    public function register($data)
    {
        $school = app('school');

        $user = AdmissionUser::create([
            'school_id' => $school->id,
            'admission_id' => $data['admission_id'],
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => bcrypt($data['password_text']),
        ]);

        $token = $user->createToken('admission-token')->plainTextToken;
        return $token;
    }

    public function login(Request $request)
    {
        $school = app('school');

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = AdmissionUser::where('school_id', $school->id)
            ->where('username', $request->username)
            ->first();

        if (! $user || ! \Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('admission-token')->plainTextToken;

        //static for test
        $user['role'] = 'student';

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
}