<?php
use App\Models\Product;
use App\Http\Livewire\Products\Index;
use App\Http\Livewire\Products\Form;
use Livewire\Livewire;
use Illuminate\Support\Facades\Config;

beforeEach(fn () => Product::truncate());

it('lists products', function () {
    Product::factory()->count(3)->create();
    Livewire::test(Index::class)
        ->assertSee('Produtos')
        ->assertSee(Product::first()->name);
});

it('creates product', function () {
    Livewire::test(Form::class)
        ->set('name', 'Produto Teste')
        ->set('price', 100)
        ->set('description', 'Descrição')
        ->call('save')
        ->assertEmitted('product-saved');
    $this->assertDatabaseHas('products', ['name' => 'Produto Teste']);
});

it('validates required fields', function () {
    Livewire::test(Form::class)
        ->set('name', '')
        ->set('price', '')
        ->call('save')
        ->assertHasErrors(['name', 'price']);
});
