<?php

use App\Livewire\Products\Index;
use App\Models\Product;
use Livewire\Livewire;

beforeEach(function () {
    $this->product = Product::factory()->create([
        'name' => 'Test Product',
        'price' => 123.45,
        'description' => 'Product description here.',
    ]);
});

it('renders the index component', function () {
    Livewire::test(Index::class)
        ->assertStatus(200)
        ->assertSee('Test Product');
});

it('opens the form modal when creating', function () {
    Livewire::test(Index::class)
        ->call('create')
        ->assertSet('showFormModal', true)
        ->assertSet('selectedProduct', null)
        ->assertSet('name', '')
        ->assertSet('price', '')
        ->assertSet('description', '');
});

it('opens the form modal with data when editing', function () {
    Livewire::test(Index::class)
        ->call('edit', $this->product)
        ->assertSet('showFormModal', true)
        ->assertSet('selectedProduct.id', $this->product->id)
        ->assertSet('name', $this->product->name)
        ->assertSet('price', $this->product->price)
        ->assertSet('description', $this->product->description);
});

it('resets form fields', function () {
    Livewire::test(Index::class)
        ->set('name', 'Test')
        ->set('price', '999.99')
        ->set('description', 'Test description')
        ->call('resetFormFields')
        ->assertSet('name', '')
        ->assertSet('price', '')
        ->assertSet('description', '');
});

it('opens the view modal with selected product', function () {
    Livewire::test(Index::class)
        ->call('view', $this->product)
        ->assertSet('showViewModal', true)
        ->assertSet('selectedProduct.id', $this->product->id);
});

it('closes the view modal', function () {
    Livewire::test(Index::class)
        ->set('showViewModal', true)
        ->set('selectedProduct', $this->product)
        ->call('closeViewModal')
        ->assertSet('showViewModal', false)
        ->assertSet('selectedProduct', null);
});

it('closes the form modal', function () {
    Livewire::test(Index::class)
        ->set('showFormModal', true)
        ->set('selectedProduct', $this->product)
        ->call('closeFormModal')
        ->assertSet('showFormModal', false)
        ->assertSet('selectedProduct', null);
});

it('deletes a product', function () {
    Livewire::test(Index::class)
        ->call('delete', $this->product);

    expect(Product::find($this->product->id))->toBeNull();
});
