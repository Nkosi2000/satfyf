<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'slindokuhleatlehang22009757@gmail.com';

        if (User::query()->where('email', $email)->exists()) {
            $this->command?->info("Admin user already exists: {$email}");

            return;
        }

        $password = Str::password(16);

        User::factory()->admin()->create([
            'name' => 'SATFYF Admin',
            'email' => $email,
            'password' => $password,
        ]);

        $this->command?->info('Admin user created.');
        $this->command?->warn("Email: {$email}");
        $this->command?->warn("Password: {$password}");
        $this->command?->warn('Log in at /admin/login and change this password immediately — it will not be shown again.');
    }
}
