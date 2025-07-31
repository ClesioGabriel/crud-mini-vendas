<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Rotas públicas (guest)
Route::middleware('guest')->group(function () {
    Volt::route('register', 'auth.register')->name('register');
    Volt::route('login', 'auth.login')->name('login');
    Volt::route('forgot-password', 'auth.forgot-password')->name('password.request');
    Volt::route('reset-password/{token}', 'auth.reset-password')->name('password.reset');
});

// Rotas autenticadas
Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')->name('verification.notice');
    Volt::route('confirm-password', 'auth.confirm-password')->name('password.confirm');
});
