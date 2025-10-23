<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PedidoController;

use App\Http\Controllers\ClienteController;

use App\Http\Controllers\ProdutoController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('pedidos', PedidoController::class);

Route::resource('clientes', ClienteController::class);

Route::resource('produtos', ProdutoController::class);

