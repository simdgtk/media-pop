<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD', 'ChangeMe123!');

        $admin = User::where('email', $email)->first();
        if ($admin) {
            $admin->is_admin = true;
            $admin->save();
            return;
        }

        $admin = User::create([
            'name' => env('ADMIN_NAME', 'Administrator'),
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $admin->is_admin = true;
        $admin->save();
    }
}
