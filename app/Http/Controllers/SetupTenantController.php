<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;

class SetupTenantController extends Controller
{
  public function create()
  {
      $tenant = Tenant::create([
          'id' => 'school1',
          'name' => 'School One',
      ]);

      $tenant->domains()->create([
          'domain' => 'school1.com',
      ]);

      return response()->json([
          'status' => 'Tenant created',
          'tenant' => $tenant->id,
      ]);
  }
}
