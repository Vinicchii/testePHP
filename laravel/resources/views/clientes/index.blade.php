@extends('layouts.app')

@section('title', 'Lista de Clientes')

@section('content')
<div class="container">
    <h2>Clientes</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('clientes.create') }}" class="btn btn-success mb-3">+ Novo Cliente</a>

    @if($clientes->isEmpty())
        <p>Nenhum cliente cadastrado ainda.</p>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Email</th>
                    <th>Pedidos</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nome ?? '—' }}</td>
                        <td>{{ $cliente->cpf }}</td>
                        <td>{{ $cliente->email ?? '—' }}</td>
                        <td>{{ $cliente->pedidos->count() }}</td>
                        <td>
                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm me-2">Editar</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
