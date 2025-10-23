@extends('layouts.app')

@section('title', 'Cadastrar Cliente')

@section('content')
<div class="container">
    <h2>Novo Cliente</h2>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control">
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" name="cpf" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Salvar Cliente</button>
    </form>
</div>
@endsection
