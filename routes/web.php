<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Customers\Index as CustomersIndex;
use App\Livewire\Products\Index as ProductsIndex;
use App\Livewire\Sales\Index as SalesIndex;

// Dashboard - componente Livewire
Route::get('/dashboard', DashboardIndex::class)->name('dashboard');

// Clientes
Route::get('/customers', CustomersIndex::class)->name('customers.index');

// Produtos
Route::get('/products', ProductsIndex::class)->name('products.index');

// Vendas
Route::get('/sales', SalesIndex::class)->name('sales.index');

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';