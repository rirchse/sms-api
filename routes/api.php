<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SchoolController;
use App\Http\Controllers\Api\AdmissionController;

Route::middleware(['school'])->group(function ()
{
  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/login', [AuthController::class, 'login']);

  Route::get('/school/profile', [SchoolController::class, 'profile']);

  Route::apiResource('admission', AdmissionController::class);
  Route::controller(AdmissionController::class)->group(function ()
  {
    // Route::post('/admission', 'store');
  });

  Route::middleware('auth:sanctum')->group(function ()
  {
      Route::post('/logout', [AuthController::class, 'logout']);

      Route::get('/me', function (Request $request) {
          return $request->user();
      });

      Route::middleware(['auth:sanctum', 'role:admin'])->group(function ()
      {
        Route::get('/admin/dashboard', fn () => 'Admin only');
      });
      
      Route::middleware(['auth:sanctum', 'permission:view users'])->get(
        '/users',
        fn () => 'Users list'
      );
    
  });
});