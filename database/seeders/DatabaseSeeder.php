<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Mikey Cerdas',
            'email' => 'mcerdas1804@gmail.com',
            'password' => bcrypt('mikey123')
        ]);

        $this->call([
            IdentitySeeder::class,
            CategorySeeder::class,
            WarehouseSeeder::class
        ]);

        Supplier::factory(20)->create();
        Customer::factory(50)->create();
        Product::factory(100)->create();
    }
}
