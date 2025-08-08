<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Livewire\Sales\Form;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('mounts with existing sale', function () {
    $customer = Customer::factory()->create();
    $product = Product::factory()->create(['price' => 10]);
    $sale = Sale::factory()->create(['customer_id' => $customer->id]);
    SaleItem::factory()->create([
        'sale_id' => $sale->id,
        'product_id' => $product->id,
        'quantity' => 2,
        'unit_price' => 10,
        'subtotal' => 20,
    ]);

    Livewire::test(Form::class, ['sale' => $sale])
        ->assertSet('customer_id', $customer->id)
        ->assertSet('date', $sale->date)
        ->assertSet('items.0.product_id', $product->id);
});

it('mounts with new sale', function () {
    Livewire::test(Form::class)
        ->assertSet('items', [])
        ->assertSet('date', now()->format('Y-m-d'));
});

it('adds and removes items', function () {
    $component = Livewire::test(Form::class)
        ->call('addItem')
        ->assertCount('items', 1)
        ->call('removeItem', 0)
        ->assertCount('items', 0);
});

it('updates an existing sale with new items', function () {
    $customer = Customer::factory()->create();
    $productOld = Product::factory()->create(['price' => 20]);
    $productNew = Product::factory()->create(['price' => 40]);

    $sale = Sale::factory()->create(['customer_id' => $customer->id]);
    SaleItem::factory()->create([
        'sale_id' => $sale->id,
        'product_id' => $productOld->id,
        'quantity' => 1,
        'unit_price' => 20,
        'subtotal' => 20,
    ]);

    Livewire::test(Form::class, ['sale' => $sale])
        ->set('customer_id', $customer->id)
        ->set('date', now()->format('Y-m-d'))
        ->set('items', [
            ['product_id' => $productNew->id, 'quantity' => 2, 'unit_price' => 40, 'subtotal' => 80],
        ])
        ->call('save')
        ->assertDispatched('sale-saved');

    expect(Sale::count())->toBe(1);
    expect(SaleItem::count())->toBe(1);
    expect(SaleItem::first()->product_id)->toBe($productNew->id);
    expect(SaleItem::first()->subtotal)->toBe(80);
});


it('updates items and recalculates totals', function () {
    $product = Product::factory()->create(['price' => 15]);

    Livewire::test(Form::class)
        ->set('items', [
            ['product_id' => $product->id, 'quantity' => 2]
        ])
        ->assertSet('items.0.unit_price', 15)
        ->assertSet('items.0.subtotal', 30)
        ->assertSet('total_amount', 30);
});


it('saves a new sale with items', function () {
    $customer = Customer::factory()->create();
    $product = Product::factory()->create(['price' => 50]);

    Livewire::test(Form::class)
        ->set('customer_id', $customer->id)
        ->set('date', now()->format('Y-m-d'))
        ->set('items', [
            ['product_id' => $product->id, 'quantity' => 1, 'unit_price' => 50, 'subtotal' => 50],
        ])
        ->call('save')
        ->assertDispatched('sale-saved');

    expect(Sale::count())->toBe(1);
    expect(SaleItem::count())->toBe(1);
});
