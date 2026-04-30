<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Sklad;
use Livewire\Volt\Volt;

//Route::view('/', 'welcome');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('index');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    Route::get('/sklad', Sklad::class)->name('sklad');
    
    Route::get('/orders', Sklad::class)->name('orders');
    
//    Route::get('/neworder', function () {
//        return view('livewire.pages.orders.create-order');
//    })->name('neworder');
    
    Volt::route('neworder', 'pages.orders.create-order')
        ->name('neworder');
    
});

require __DIR__.'/auth.php';
