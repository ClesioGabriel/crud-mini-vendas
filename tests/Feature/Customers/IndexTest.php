<?php

use App\Models\Customer;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('renderiza a view com clientes', function () {
    Customer::factory()->count(3)->create();

    Livewire::test('customers.index')
        ->assertStatus(200)
        ->assertSee('Clientes');
});

test('abre modal de criação com campos limpos', function () {
    Livewire::test('customers.index')
        ->call('create')
        ->assertSet('showFormModal', true)
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('phone', '')
        ->assertSet('selectedCustomer', null);
});

test('edita cliente e preenche os campos corretamente', function () {
    $customer = Customer::factory()->create([
        'name' => 'Editável',
        'email' => 'edit@cliente.com',
        'phone' => '99887766',
    ]);

    Livewire::test('customers.index')
        ->call('edit', $customer)
        ->assertSet('showFormModal', true)
        ->assertSet('name', 'Editável')
        ->assertSet('email', 'edit@cliente.com')
        ->assertSet('phone', '99887766')
        ->assertSet('selectedCustomer.id', $customer->id);
});

test('deleta cliente e dispara notificação', function () {
    $customer = Customer::factory()->create();

    Livewire::test('customers.index')
        ->call('delete', $customer)
        ->assertDispatched('notify', 'Cliente excluído com sucesso!');

    $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
});

test('fecha modal e reseta cliente ao chamar closeFormModal', function () {
    $customer = Customer::factory()->create();

    Livewire::test('customers.index')
        ->set('showFormModal', true)
        ->set('selectedCustomer', $customer)
        ->call('closeFormModal')
        ->assertSet('showFormModal', false)
        ->assertSet('selectedCustomer', null);
});
