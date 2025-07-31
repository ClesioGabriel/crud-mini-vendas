<?php
use App\Models\Customer;
use App\Http\Livewire\Customers\Index;
use App\Http\Livewire\Customers\Form;
use Livewire\Livewire;
use Illuminate\Support\Facades\Config;

beforeEach(fn () => Customer::truncate());

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
        ->assertEmitted('customer-saved');
    $this->assertDatabaseHas('customers', ['email' => 'teste@example.com']);
});

it('validates required fields', function () {
    Livewire::test(Form::class)
        ->set('name', '')
        ->set('email', '')
        ->call('save')
        ->assertHasErrors(['name', 'email']);
});
