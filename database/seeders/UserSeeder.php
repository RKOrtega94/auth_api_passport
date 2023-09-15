<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin (required)
        $this->command->info('Requires super admin user to be created.');
        $this->command->info('Enter the following details:');

        $userFirstName = $this->command->ask('Super-admin first name?:', 'John');
        $userLastName = $this->command->ask('Super-admin last name?:', 'Doe');
        $dni = $this->command->ask('Super-admin DNI?:', null);
        $phone = $this->command->ask('Super-admin phone?:', null);
        $address = $this->command->ask('Super-admin address?:', null);
        $email = $this->command->ask('Super-admin email?:', 'super-admin@email.com');
        $password = $this->command->ask('Super-admin password?:', 'password');

        $user = User::create([
            'name' => $userFirstName,
            'lastName' => $userLastName,
            'dni' => $dni,
            'phone' => $phone,
            'address' => $address,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $user->assignRole('super-admin');

        $this->command->info('Super admin user created successfully.');

        // Create admin (optional)
        $this->command->info('Do you want to create an admin user?');
        $this->command->info('Enter the following details:');
        $createAdmin = $this->command->confirm('Create admin user?', false);

        if ($createAdmin) {
            $userFirstName = $this->command->ask('Admin first name?:', 'John');
            $userLastName = $this->command->ask('Admin last name?:', 'Doe');
            $dni = $this->command->ask('Admin DNI?:', null);
            $phone = $this->command->ask('Admin phone?:', null);
            $address = $this->command->ask('Admin address?:', null);
            $email = $this->command->ask('Admin email?:', 'admin@email.com');
            $password = $this->command->ask('Admin password?:', 'password');

            $user = User::create([
                'name' => $userFirstName,
                'lastName' => $userLastName,
                'dni' => $dni,
                'phone' => $phone,
                'address' => $address,
                'email' => $email,
                'password' => bcrypt($password),
            ]);

            $user->assignRole('admin');

            $this->command->info('Admin user created successfully.');
        } else {
            $this->command->info('Admin user not created.');
        }

        // Create manager (optional)
        $this->command->info('Do you want to create a manager user?');

        $createManager = $this->command->confirm('Create manager user?', false);

        if ($createManager) {
            $userFirstName = $this->command->ask('Manager first name?:', 'John');
            $userLastName = $this->command->ask('Manager last name?:', 'Doe');
            $dni = $this->command->ask('Manager DNI?:', null);
            $phone = $this->command->ask('Manager phone?:', null);
            $address = $this->command->ask('Manager address?:', null);
            $email = $this->command->ask('Manager email?:', 'manager@email.com');
            $password = $this->command->ask('Manager password?:', 'password');

            $user = User::create([
                'name' => $userFirstName,
                'lastName' => $userLastName,
                'dni' => $dni,
                'phone' => $phone,
                'address' => $address,
                'email' => $email,
                'password' => bcrypt($password),
            ]);
        } else {
            $this->command->info('Manager user not created.');
        }

        // Create random doctors (optional)
        $this->command->info('Do you want to create random doctors?');
        $createDoctors = $this->command->confirm('Create random doctors?', false);

        if ($createDoctors) {
            $quantity = $this->command->ask('How many doctors do you want to create?', 10);

            // Create random doctors
            User::factory()->count($quantity)->create()->each(function ($user) {
                $user->assignRole('doctor');
            });

        } else {
            $this->command->info('Random doctors not created.');
        }

        // Create random users (optional)
        $this->command->info('Do you want to create random users?');
        $createUsers = $this->command->confirm('Create random users?', false);

        if ($createUsers) {
            $quantity = $this->command->ask('How many users do you want to create?', 10);

            // Create random users
            User::factory()->count($quantity)->create()->each(function ($user) {
                $user->assignRole('user');
            });

        } else {
            $this->command->info('Random users not created.');
        }
    }
}
