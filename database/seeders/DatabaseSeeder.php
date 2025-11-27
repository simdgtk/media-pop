<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin using env vars (ADMIN_EMAIL / ADMIN_PASSWORD) or defaults
        // Only seed a default admin in non-production environments so we don't
        // accidentally create admin credentials on a production deploy.
        if (! app()->environment('production')) {
            $this->call(\Database\Seeders\AdminUserSeeder::class);
        }

        // Keep a regular test user as before
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
