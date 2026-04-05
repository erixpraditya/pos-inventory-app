<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $now = Carbon::now();

        Category::insert([
            [
                'name' => 'Makanan',
                'slug' => 'makanan',
                'description' => 'Makanan',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Minuman',
                'slug' => 'minuman',
                'description' => 'Minuman',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        Product::insert([
            [
                'code' => '10010110',
                'name' => 'Pop ice',
                'category_slug' => 'minuman',
                'price' => 5000,
                'stock' => 100,
                'image' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'code' => '21222554',
                'name' => 'Indomie',
                'category_slug' => 'makanan',
                'price' => 5000,
                'stock' => 100,
                'image' => null,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
