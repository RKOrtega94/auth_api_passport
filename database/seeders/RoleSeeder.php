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
            'admin',
            'user',
        ];

        foreach ($roles as $role) {
            /* Check if role exist */
            if (\Spatie\Permission\Models\Role::where('name', $role)->first()) {
                continue;
            }
            \Spatie\Permission\Models\Role::create(['name' => $role]);
        }

        // Assign permissions to roles

        // Super admin
        $admin = \Spatie\Permission\Models\Role::findByName('admin');

        $permissions = \Spatie\Permission\Models\Permission::all();
        $admin->syncPermissions($permissions);

        // User
        $user = \Spatie\Permission\Models\Role::findByName('user');

        $permissions = [
            'read-user',
        ];

        $permissions = \Spatie\Permission\Models\Permission::whereIn('name', $permissions)->get();
        $user->syncPermissions($permissions);
    }
}
