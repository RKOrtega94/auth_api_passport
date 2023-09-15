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

            // Add more permissions as needed here
        ];

        // Create permissions for web and api guards
        foreach ($permissions as $permission) {
            /* Check if permission exist */
            if (\Spatie\Permission\Models\Permission::where('name', $permission)->first()) {
                continue;
            }
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }
    }
}
