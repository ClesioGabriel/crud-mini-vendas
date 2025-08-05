<?php
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Livewire\Sales\Index;
use App\Livewire\Sales\Form;
use Livewire\Livewire;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    Customer::truncate();
    Product::truncate();
    Sale::truncate();
});

it('lists sales', function () {
    $customer = Customer::factory()->create();
    $sale = Sale::factory()->create(['customer_id' => $customer->id]);
    Livewire::test(Index::class)
        ->assertSee('Lista de Vendas')
        ->assertSee($customer->name);
});

it('creates sale with items', function () {
    $customer = Customer::factory()->create();
    $product = Product::factory()->create(['price' => 50]);
    Livewire::test(Form::class)
        ->set('customer_id', $customer->id)
        ->set('date', now()->format('Y-m-d'))
        ->set('items', [[
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => $product->price,
            'subtotal' => 100,
        ]])
        ->call('save')
        ->assertDispatched('sale-saved');
    $this->assertDatabaseHas('sales', ['customer_id' => $customer->id]);
});

it('validates customer and items', function () {
    Livewire::test(Form::class)
    ->set('customer_id', '')
    ->set('items', [['product_id' => '']])
    ->call('save')
    ->assertHasErrors(['customer_id', 'items.*.product_id']);
});
