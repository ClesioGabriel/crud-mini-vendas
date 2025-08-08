<?php

use App\Models\Sale;
use App\Models\Customer;
use App\Livewire\Sales\Show;
use Livewire\Livewire;

beforeEach(function () {
    Customer::truncate();
    Sale::truncate();
});

it('renders the show component with sale data', function () {
    $customer = Customer::factory()->create(['name' => 'João']);
    $sale = Sale::factory()->create([
        'customer_id' => $customer->id,
        'date' => '1994-08-14',
    ]);

    Livewire::test(Show::class, ['sale' => $sale])
        ->assertSee('João')
        ->assertSee('14/08/1994'); 
});
