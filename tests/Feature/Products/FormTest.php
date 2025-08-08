<?php

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Livewire\Products\Form as ProductForm;
use App\Livewire\Sales\Form as SaleForm;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

uses(RefreshDatabase::class);

it('renders the form component', function () {
    Livewire::test(ProductForm::class)
        ->assertStatus(200);
});

it('creates a new product successfully', function () {
    Livewire::test(ProductForm::class)
        ->set('name', 'Produto Teste')
        ->set('price', 100)
        ->set('description', 'Descrição de teste')
        ->call('save')
        ->assertDispatched('product-saved');

    expect(Product::where('name', 'Produto Teste')->exists())->toBeTrue();

    $this->assertDatabaseHas('products', [
        'name' => 'Produto Teste',
        'price' => 100,
        'description' => 'Descrição de teste',
    ]);
});

it('updates an existing product successfully', function () {
    $product = Product::factory()->create([
        'name' => 'Produto Antigo',
        'price' => 50,
        'description' => 'Descrição antiga',
    ]);

    Livewire::test(ProductForm::class, ['product' => $product])
        ->set('name', 'Produto Atualizado')
        ->set('price', 75)
        ->set('description', 'Nova descrição')
        ->call('save')
        ->assertDispatched('product-saved');

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Produto Atualizado',
        'price' => 75,
        'description' => 'Nova descrição',
    ]);
});

it('validates required fields', function () {
    Livewire::test(ProductForm::class)
        ->set('name', '')
        ->set('price', '')
        ->call('save')
        ->assertHasErrors(['name' => 'required', 'price' => 'required']);
});

it('sets product data via event', function () {
    $product = Product::factory()->create();

    Livewire::test(ProductForm::class)
        ->dispatch('set-product', $product)
        ->assertSet('name', $product->name)
        ->assertSet('price', $product->price)
        ->assertSet('description', $product->description);
});

it('sets sale data correctly via setSale()', function () {
    $customer = Customer::factory()->create();
    $product = Product::factory()->create(['price' => 20]);

    $sale = Sale::factory()->create([
        'customer_id' => $customer->id,
        'date' => now()->format('Y-m-d'),
    ]);

    $item = SaleItem::factory()->create([
        'sale_id' => $sale->id,
        'product_id' => $product->id,
        'quantity' => 3,
        'unit_price' => 20,
        'subtotal' => 60,
    ]);

    Livewire::test(SaleForm::class)
        ->call('setSale', $sale)
        ->assertSet('customer_id', $customer->id)
        ->assertSet('date', \Carbon\Carbon::parse($sale->date)->format('Y-m-d'))
        ->assertSet('items.0.product_id', $item->product_id)
        ->assertSet('items.0.quantity', $item->quantity)
        ->assertSet('items.0.unit_price', $item->unit_price)
        ->assertSet('items.0.subtotal', $item->subtotal);
});
