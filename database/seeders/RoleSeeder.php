<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $guard = 'api';

        Role::firstOrCreate(['name' => 'school-admin', 'guard_name' => $guard]);
        Role::firstOrCreate(['name' => 'teacher', 'guard_name' => $guard]);
        Role::firstOrCreate(['name' => 'student', 'guard_name' => $guard]);
        
        Role::create([
          'name' => 'student',
          'school_id' => app('school')->id,
        ]);      
    }
}
