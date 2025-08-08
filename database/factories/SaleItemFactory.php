<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleItemFactory extends Factory
{
    protected $model = SaleItem::class;

    public function definition(): array
    {
        $product = Product::factory()->create(); // garante produto válido
        $quantity = $this->faker->numberBetween(1, 5);
        $unit_price = $product->price ?? $this->faker->randomFloat(2, 10, 100);
        $subtotal = $unit_price * $quantity;

        return [
            'sale_id'    => Sale::factory(), // para uso em conjunto
            'product_id' => $product->id,
            'quantity'   => $quantity,
            'unit_price' => $unit_price,
            'subtotal'   => $subtotal,
        ];
    }
}
