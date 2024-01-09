<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'manage-admins']);
        Permission::create(['name' => 'manage-users']);
        Permission::create(['name' => 'manage-items']);

        $superAdminRole = Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());

        $adminRole = Role::create(['name' => 'admin'])
            ->givePermissionTo(['manage-users', 'manage-items']);
    }
}
