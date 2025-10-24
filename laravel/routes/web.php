<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PedidoController;

use App\Http\Controllers\ClienteController;

use App\Http\Controllers\ProdutoController;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('pedidos', PedidoController::class);

Route::resource('clientes', ClienteController::class);

Route::resource('produtos', ProdutoController::class);

