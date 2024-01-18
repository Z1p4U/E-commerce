<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            TagsSeeder::class,
            ProductSeeder::class,
            ItemSeeder::class,
            StockSeeder::class,
            VoucherSeeder::class,
        ]);
    }
}
