<?php

namespace Tests\Feature\Sales;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaleItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_sale()
    {
        $sale = Sale::factory()->create();
        $item = SaleItem::factory()->create([
            'sale_id' => $sale->id,
        ]);

        $this->assertInstanceOf(Sale::class, $item->sale);
        $this->assertEquals($sale->id, $item->sale->id);
    }

    /** @test */
    public function it_belongs_to_a_product()
    {
        $product = Product::factory()->create();
        $item = SaleItem::factory()->create([
            'product_id' => $product->id,
        ]);

        $this->assertInstanceOf(Product::class, $item->product);
        $this->assertEquals($product->id, $item->product->id);
    }
}
