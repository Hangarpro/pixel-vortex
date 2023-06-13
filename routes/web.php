<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DesignController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');


Route::middleware(['auth'])->group(function() {

    //DESIGNS - DISEÑOS
    Route::get('/home', [DesignController::class, 'index'])->name('home');
    Route::get('/design', [DesignController::class,'create'])->name('design.create');
    Route::post('/design', [DesignController::class,'store'])->name('design.store');
    Route::get('/design/{id}/edit', [DesignController::class,'edit'])->name('design.edit');
    Route::put('/design/{id}', [DesignController::class,'update'])->name('design.update');
    Route::delete('/design/{id}', [DesignController::class,'destroy'])->name('design.delete');

});

// USERS - USUARIOS
Route::post('/user', [UserController::class,'store'])->name('user.store');
Route::put('/user/{id}', [UserController::class,'update'])->name('user.update');
Route::get('/user/{id}/delete', [UserController::class,'destroy'])->name('user.destroy');

