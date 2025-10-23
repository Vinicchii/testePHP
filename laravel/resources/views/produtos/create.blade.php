@extends('layouts.app')

@section('title', 'Cadastrar Produto')

@section('content')
<div class="container">
    <h2>Novo Produto</h2>

    <form action="{{ route('produtos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="cod_barras" class="form-label">Código de Barras</label>
            <input type="text" name="cod_barras" class="form-control">
        </div>

        <div class="mb-3">
            <label for="valor_unitario" class="form-label">Valor Unitário</label>
            <input type="number" name="valor_unitario" class="form-control" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Produto</button>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
