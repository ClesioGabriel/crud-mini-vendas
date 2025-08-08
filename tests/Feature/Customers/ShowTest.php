<?php

use App\Livewire\Customers\Show;
use App\Models\Customer;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('renderiza a view com dados do cliente', function () {
    $customer = Customer::factory()->create([
        'name' => 'Cliente Teste',
        'email' => 'teste@email.com',
        'phone' => '123456789',
    ]);

    Livewire::test(Show::class, ['customer' => $customer])
        ->assertStatus(200)
        ->assertViewHas('customer', function ($c) use ($customer) {
            return $c->id === $customer->id;
        });
});

test('closeModal dispara o evento closeViewModal', function () {
    $customer = Customer::factory()->create();

    Livewire::test(Show::class, ['customer' => $customer])
        ->call('closeModal')
        ->assertDispatched('closeViewModal');
});
