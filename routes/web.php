<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Products\Index;
use App\Livewire\Products\Show;
use App\Livewire\Customers\Index as CustomersIndex;


Route::get('/products', Index::class)->middleware(['auth'])->name('products.index');

Route::get('/customers', CustomersIndex::class)->middleware(['auth'])->name('customers.index');


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';