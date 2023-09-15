<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'super-admin',
            'admin',
            'manager',
            'doctor',
            'user',
        ];

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::create(['name' => $role]);
        }

        // Assign permissions to roles

        // Super admin
        $superAdmin = \Spatie\Permission\Models\Role::findByName('super-admin');

        // Asign all permissions to super admin 'api' guard
        $permissions = \Spatie\Permission\Models\Permission::all();
        $superAdmin->syncPermissions($permissions);
    }
}
