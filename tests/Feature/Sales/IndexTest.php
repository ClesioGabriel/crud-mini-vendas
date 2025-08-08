<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Livewire\Sales\Show;
use App\Livewire\Sales\Index; // ✅ Importação correta adicionada
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    Customer::truncate();
    Sale::truncate();
});

it('lists sales', function () {
    $customer = Customer::factory()->create();
    $sale = Sale::factory()->create(['customer_id' => $customer->id]);

    Livewire::test(Index::class)
        ->assertSee('Lista de Vendas')
        ->assertSee($customer->name);
});

it('deletes a sale and dispatches notification', function () {
    $customer = Customer::factory()->create();
    $sale = Sale::factory()->create(['customer_id' => $customer->id]);

    Livewire::test(Index::class)
        ->call('delete', $sale)
        ->assertDispatched('notify', 'Venda excluída com sucesso!');

    $this->assertDatabaseMissing('sales', ['id' => $sale->id]);
});

it('opens and closes modals', function () {
    Livewire::test(Index::class)
        ->call('create')
        ->assertSet('showFormModal', true)
        ->call('closeFormModal')
        ->assertSet('showFormModal', false);

    $customer = Customer::factory()->create();
    $sale = Sale::factory()->create(['customer_id' => $customer->id]);

    Livewire::test(Index::class)
        ->call('view', $sale)
        ->assertSet('showViewModal', true)
        ->call('closeViewModal')
        ->assertSet('showViewModal', false);
});

it('opens edit modal with selected sale', function () {
    $sale = Sale::factory()->create();

    Livewire::test(Index::class)
        ->call('edit', $sale)
        ->assertSet('selectedSale.id', $sale->id)
        ->assertSet('showFormModal', true);
});
