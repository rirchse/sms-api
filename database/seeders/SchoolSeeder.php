<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      School::factory()->create([
        'name' => 'School One',
        'domain' => 'school1.com',
        'active' => true
      ]);
    }
}
