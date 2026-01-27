<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Seeders\SchoolSeeder;
use Illuminate\Database\Seeders\RoleSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      $this->call([
        \Database\Seeders\SchoolSeeder::class,
        \Database\Seeders\RoleSeeder::class
      ]);

      // User::factory(10)->create();

      User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
      ]);
    }
}
