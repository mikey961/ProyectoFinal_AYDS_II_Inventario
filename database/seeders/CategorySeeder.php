<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories= [
            [
                'name' => 'Electronicos',
                'description' => 'Articulos electrónicos'
            ],
            [
                'name' => 'Ropa',
                'description' => 'Articulos de ropa'
            ],
            [
                'name' => 'Alimentos',
                'description' => 'Articulos de alimentacion'
            ],
            [
                'name' => 'Hogar',
                'description' => 'Articulos para el hogar'
            ],
            [
                'name' => 'Deportes',
                'description' => 'Articulos deportivos'
            ],
            [
                'name' => 'Juguetes',
                'description' => 'Articulos de jugueteria'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
