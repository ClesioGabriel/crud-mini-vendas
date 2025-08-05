<?php

use App\Models\Customer;
use App\Livewire\Customers\Index;
use App\Livewire\Customers\Form;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists customers', function () {
    Customer::factory()->count(3)->create();

    Livewire::test(Index::class)
        ->assertSee('Clientes')
        ->assertSee(Customer::first()->name);
});

it('creates customer', function () {
    Livewire::test(Form::class)
        ->set('name', 'Nome Teste')
        ->set('email', 'teste@example.com')
        ->set('phone', '123456789')
        ->call('save')
        ->assertDispatched('customer-saved');

    $this->assertDatabaseHas('customers', [
        'email' => 'teste@example.com',
        'name' => 'Nome Teste',
        'phone' => '123456789',
    ]);
});

it('validates required fields', function () {
    Livewire::test(Form::class)
        ->set('name', '')
        ->set('email', '')
        ->call('save')
        ->assertHasErrors(['name', 'email']);
});
