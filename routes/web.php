<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DesignController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'welcome'])->name('/');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function() {
    Route::get('/home', [DesignController::class, 'index'])->name('home');
    Route::get('/design', [DesignController::class,'create'])->name('design.create');
    Route::post('/design', [DesignController::class,'store'])->name('design.store');
    Route::get('/design/{id}/edit', [DesignController::class,'edit'])->name('design.edit');
    Route::put('/design/{id}', [DesignController::class,'update'])->name('design.update');
    Route::delete('/design/{id}', [DesignController::class,'destroy'])->name('design.delete');
});

