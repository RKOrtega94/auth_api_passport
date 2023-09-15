<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Manage users
            'create-user',
            'read-user',
            'update-user',
            'delete-user',

            // Manage roles
            'create-role',
            'read-role',
            'update-role',
            'delete-role',
            'assign-role',

            // Manage clinics
            'create-clinic',
            'read-clinic',
            'update-clinic',
            'delete-clinic',

            // Manage contracts
            'create-contract',
            'read-contract',
            'update-contract',
            'delete-contract',
            'sign-contract',

            // Manage suppliers
            'create-supplier',
            'read-supplier',
            'update-supplier',
            'delete-supplier',

            // Manage products
            'create-product',
            'read-product',
            'update-product',
            'delete-product',

        ];

        // Create permissions for web and api guards
        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }
    }
}
