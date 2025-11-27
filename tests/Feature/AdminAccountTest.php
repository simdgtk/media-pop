<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_non_admin_user_by_default(): void
    {
        $user = User::factory()->create();

        $this->assertFalse(
            (bool) $user->is_admin,
            'Newly created users via registration/factory should not be admins by default'
        );
    }

    public function test_admin_seeder_creates_admin_user(): void
    {
        $this->seed(AdminUserSeeder::class);

        $admin = User::where('email', env('ADMIN_EMAIL', 'admin@example.com'))->first();

        $this->assertNotNull($admin);
        $this->assertTrue((bool) $admin->is_admin);
    }
}
