<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use App\Models\Product;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    $adminRole = Role::create(['name' => 'admin']);
    $userRole = Role::create(['name' => 'user']);

    Permission::create(['name' => 'create product']);
    Permission::create(['name' => 'edit product', ])

    $adminRole->givePermissionTo(['create product', 'edit product', 'delete product', 'update product', 'view product']);
    $userRole->givePermissionTo(['create product', 'view product']);

    $user = User::create([
        'name' => 'Matt',
        'email' => 'matt@gmail.com',
        'password' => bcrypt('password'),
    ]);
    $user->assignRole('admin');

    $admin = User::create([
        'name' => 'admin',
        'email' => 'admin@admin.com',
        'password', bcrypt('password')
    ]);
    $admin->assignRole('admin');


    $category = Category::create([
        'name' => 'Electronics'
    ]);

    $product = Product::create([
        'name' => 'computer',
        'quantity' => 100,
        'price' => 1500,
        'category_id' => $category->id,
        'user_id' => $userRole->id,
    ]);
    }
}
