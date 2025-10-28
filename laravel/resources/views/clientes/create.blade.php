@extends('layouts.app')

@section('title', 'Cadastrar Cliente')

@section('content')

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <h2>Novo Cliente</h2>

    <div id="cliente-errors" class="alert alert-danger d-none"></div>
    <form id="form-cliente" action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control">
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" name="cpf" class="form-control">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Salvar Cliente</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/validation/cliente.js') }}"></script>
@endsection
