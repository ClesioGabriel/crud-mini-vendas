<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $products = Product::all();

        for ($i = 0; $i < 5; $i++) {
            $customer = $customers->random();

            // sorteia de 1 a 3 produtos
            $count = $products->count();
            $numProducts = rand(1, min(3, $count));
            $selectedProducts = $products->random($numProducts);

            $total = 0;

            // cria a venda (sem total ainda)
            $sale = Sale::create([
                'customer_id' => $customer->id,
                'date' => now(),
                'total_amount' => 0, // vai atualizar depois
            ]);

            // cria os itens da venda
            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 5);
                $unit_price = $product->price;
                $subtotal = $quantity * $unit_price;

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unit_price,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            // atualiza o total da venda
            $sale->update(['total_amount' => $total]);
        }
    }
}
