<?php

use App\Models\Product;
use App\Livewire\Products\Show;
use Livewire\Livewire;

it('renders the show component with product data', function () {
    $product = Product::factory()->create([
        'name' => 'Produto Exemplo',
        'price' => 45,
        'description' => 'Descrição qualquer',
    ]);

    Livewire::test(Show::class, ['product' => $product])
        ->assertStatus(200)
        ->assertSet('product', $product)
        ->assertSee($product->name)
        ->assertSee((string) $product->price)
        ->assertSee($product->description);
});

it('dispatches closeViewModal event when closing', function () {
    $product = Product::factory()->create();

    Livewire::test(Show::class, ['product' => $product])
        ->call('closeModal')
        ->assertDispatched('closeViewModal');
});
