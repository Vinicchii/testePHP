@extends('layouts.app')

@section('title', 'Cadastrar Produto')

@section('content')
<div class="container">
    <h2>Novo Produto</h2>

    <div id="produto-errors" class="alert alert-danger d-none"></div>
    <form id="form-produto" action="{{ route('produtos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" >
        </div>

        <div class="mb-3">
            <label for="cod_barras" class="form-label">EAN (Código de Barras)</label>
            <input type="text" name="cod_barras" minlength="13" maxlength="13"  class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="valor_unitario" class="form-label">Valor Unitário</label>
            <input type="number" name="valor_unitario" class="form-control" step="0.01" >
        </div>

        <button type="submit" class="btn btn-primary">Salvar Produto</button>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/validation/produto.js') }}"></script>
@endsection


