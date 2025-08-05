<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Cadeira Gamer',
            'price' => 799.90,
            'description' => 'Cadeira ergonômica com apoio ajustável.'
        ]);

        Product::create([
            'name' => 'Notebook Dell',
            'price' => 3599.00,
            'description' => 'Notebook Dell com processador i7 e 16GB RAM.'
        ]);

        Product::create([
            'name' => 'Teclado Mecânico',
            'price' => 299.00,
            'description' => 'Teclado mecânico branco.'
        ]);

        Product::create([
            'name' => 'Mouse Gamer',
            'price' => 159.90,
            'description' => 'Mouse gamer com alta precisão.'
        ]);

        Product::create([
            'name' => 'Monitor 27"',
            'price' => 1299.00,
            'description' => 'Monitor 27" Full HD com 144Hz.'
        ]);
    }
}
