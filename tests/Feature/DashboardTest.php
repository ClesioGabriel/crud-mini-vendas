<?php
use App\Http\Livewire\Dashboard;
use Livewire\Livewire;
use Illuminate\Support\Facades\Config;

it('renders dashboard', function () {
    Livewire::test(Dashboard::class)->assertStatus(200);
});
