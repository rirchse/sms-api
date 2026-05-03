<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AdmissionAuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;

Route::middleware(['school'])->group(function ()
{
  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/login', [AuthController::class, 'login']);

  Route::get('/school/profile', [SchoolController::class, 'profile']);

  Route::prefix('admission')->group(function()
  {
    Route::post('/', [AdmissionController::class, 'store']);
    Route::controller(AdmissionAuthController::class)->group(function()
    {
      Route::post('/register', 'register');
      Route::post('/login', 'login');
    });
    
    Route::middleware('auth:admission')->group(function()
    {
      Route::get('/profile', function()
      {
        return auth()->user();
      });
      
      Route::controller(AdmissionController::class)->group(function ()
      {
        Route::put('/admission/{id}', 'update');
        Route::get('/payments/{admission}', 'payments');
      });

      Route::controller(PaymentController::class)->group(function()
      {
        Route::post('/payment', 'store');
      });
    });
  });

  Route::middleware('auth:sanctum')->group(function ()
  {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('admin')->group(function()
    {
      Route::get('/profile', function (Request $request) {
        return $request->user();
      });

      Route::apiResource('admission', AdmissionController::class);

      Route::controller(AdmissionController::class)->group(function()
      {
        Route::get('/admission-student/{admission}', 'admissionStudent');
      });

      Route::apiResource('/payment', PaymentController::class);
      Route::apiResource('/student', StudentController::class);
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

// cache clear
Route::get('reboot', function ()
{
  Artisan::call('cache:clear');
  Artisan::call('view:clear');
  Artisan::call('route:clear');
  Artisan::call('config:clear');
  Artisan::call('view:clear');
  return response()->json([
    'message' => 'Application cache cleared!'
  ]);
});