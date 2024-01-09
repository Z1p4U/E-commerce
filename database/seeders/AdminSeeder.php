<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Admin::factory()->create([
            "name" => "Super Admin",
            "email" => "superadmin@gmail.com",
            "phone" => "09121121122",
            "password" => Hash::make("asdffdsa"),
        ]);

        $superAdminRole = Role::where('name', 'super-admin')->first();
        $superAdmin->assignRole($superAdminRole);


        $admin = Admin::factory()->create([
            "name" => "Admin",
            "email" => "admin@gmail.com",
            "phone" => "09121121122",
            "password" => Hash::make("asdffdsa"),
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $admin->assignRole($adminRole);

        // You can assign multiple roles if needed, for example:
        // $superSuperAdmin->assignRole([$adminRole, $superAdminRole]);

    }
}
