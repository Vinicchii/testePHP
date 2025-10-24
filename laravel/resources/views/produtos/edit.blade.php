@extends('layouts.app')

@section('title', 'Editar Produto')

@section('content')
<div class="container">
    <h2>Editar Produto</h2>

    <form action="{{ route('produtos.update', $produto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome', $produto->nome) }}" required>
        </div>

        <div class="mb-3">
            <label for="cod_barras" class="form-label">EAN</label>
            <input type="text" name="cod_barras" class="form-control" value="{{ old('cod_barras', $produto->cod_barras) }}">
        </div>

        <div class="mb-3">
            <label for="valor_unitario" class="form-label">Valor Unitário</label>
            <input type="number" name="valor_unitario" class="form-control" step="0.01" value="{{ old('valor_unitario', $produto->valor_unitario) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
