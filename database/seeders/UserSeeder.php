<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('You have run --seeder. Let\'s add data to our database');

        $this->command->info('Creating admin user');

        $name = $this->command->ask('Admin name?:', 'Admin');
        $email = $this->command->ask('Admin email?:', 'admin@email.com');
        $phone = $this->command->ask('Admin phone?:', '123456789');
        $password = $this->command->ask('Admin password?:', 'password');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make($password),
        ]);

        $user->assignRole('admin');

        $this->command->info('Admin user created successfully.');

        // Show admin credentials
        $this->command->info('Email: ' . $email);
        $this->command->info('Password: ' . $password);

        /* Ask if want to create random users */
        $createUsers = $this->command->confirm('Do you want to create random users?', false);

        if ($createUsers) {
            $quantity = $this->command->ask('How many users do you want to create?', 10);

            // Create random users
            User::factory()->count($quantity)->create()->each(function ($user) {
                $user->assignRole('user');
            });

            $this->command->info('Random users created successfully.');
        } else {
            $this->command->info('Random users not created.');
        }

        $this->command->info('All done!');
    }
}
