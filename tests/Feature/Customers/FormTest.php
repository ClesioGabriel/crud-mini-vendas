<?php

use App\Models\Customer;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('pode criar um novo cliente', function () {
    Livewire::test('customers.form')
        ->set('name', 'Cliente Novo')
        ->set('email', 'cliente@novo.com')
        ->set('phone', '123456789')
        ->call('save')
        ->assertDispatched('customer-saved');

    $this->assertDatabaseHas('customers', [
        'name' => 'Cliente Novo',
        'email' => 'cliente@novo.com',
        'phone' => '123456789',
    ]);
});

test('pode atualizar um cliente existente', function () {
    $customer = Customer::factory()->create([
        'name' => 'Antigo Nome',
        'email' => 'antigo@email.com',
        'phone' => '9999',
    ]);

    Livewire::test('customers.form')
        ->call('setCustomer', $customer)
        ->set('name', 'Nome Atualizado')
        ->set('email', 'atualizado@email.com')
        ->set('phone', '8888')
        ->call('save')
        ->assertDispatched('customer-saved');

    $this->assertDatabaseHas('customers', [
        'id' => $customer->id,
        'name' => 'Nome Atualizado',
        'email' => 'atualizado@email.com',
        'phone' => '8888',
    ]);
});

test('validações são aplicadas corretamente', function () {
    Livewire::test('customers.form')
        ->set('name', '')
        ->set('email', 'email-invalido')
        ->call('save')
        ->assertHasErrors(['name', 'email']);
});

test('setCustomer atualiza as propriedades do componente', function () {
    $customer = Customer::factory()->create([
        'name' => 'João da Silva',
        'email' => 'joao@email.com',
        'phone' => '11999999999',
    ]);

    Livewire::test('customers.form')
        ->call('setCustomer', $customer)
        ->assertSet('name', 'João da Silva')
        ->assertSet('email', 'joao@email.com')
        ->assertSet('phone', '11999999999');
});
