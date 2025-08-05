<?php
use App\Livewire\Dashboard\Index;
use Livewire\Livewire;
use Illuminate\Support\Facades\Config;

it('renders dashboard', function () {
    Livewire::test(Index::class)
    ->assertSee('Clientes');
});
