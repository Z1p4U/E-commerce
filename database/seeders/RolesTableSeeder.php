<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);

        $manageUsersPermission = Permission::where('name', 'manage-users')->first();
        $manageAdminPermission = Permission::where('name', 'manage-admins')->first();

        // Assign permissions to roles
        $superAdminRole->givePermissionTo($manageUsersPermission, $manageAdminPermission);
        $adminRole->givePermissionTo($manageUsersPermission);
    }
}
