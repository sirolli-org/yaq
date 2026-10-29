<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/panel', function () {
        return view('panel');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('usuarios.index');
        Route::get('/crear', [UserController::class, 'create'])->name('usuarios.create');
        Route::post('/', [UserController::class, 'store'])->name('usuarios.store');
        Route::patch('/{user}/estado', [UserController::class, 'toggleEstado'])->name('usuarios.estado');
    });
});

Route::resource('productos', ProductoController::class)->except('show');
