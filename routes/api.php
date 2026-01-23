<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use \Stancl\Tenancy\Middleware\PreventAccessFromTenantDomains::class;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::controller(AdmissionController::class)->group(function ()
{
  Route::post('/admission', 'admission');
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

    // Route::middleware(['tenant.domain'])->group(function ()
    // {
    //   Route::get('/school/profile', SchoolController::class);
    //   Route::post('/admission', AdmissionController::class);
    // });
  
});