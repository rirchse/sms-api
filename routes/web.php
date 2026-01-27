<?php

use App\Http\Controllers\SetupTenantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/_setup-tenant', [SetupTenantController::class, 'create']);