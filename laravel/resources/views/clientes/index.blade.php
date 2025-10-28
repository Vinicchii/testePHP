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

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
        </div>
        <div class="col-auto">
            <input type="text" name="nome" class="form-control" placeholder="Nome" value="{{ request('nome') }}">
        </div>
        <div class="col-auto">
            <input type="text" name="cpf" class="form-control" placeholder="CPF" value="{{ request('cpf') }}">
        </div>
        <div class="col-auto">
            <input type="text" name="email" class="form-control" placeholder="Email" value="{{ request('email') }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" type="submit">Filtrar</button>
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">Limpar</a>
        </div>
    </form>

    @if($clientes->isEmpty())
        <p>Nenhum cliente cadastrado ainda.</p>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th><a
                    class="text-white text-decoration-none"
                    href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => (request('sort')=='id' && request('direction')=='asc') ? 'desc' : 'asc']) }}">#</a></th>
                    <th><a
                    class="text-white text-decoration-none"
                    href="{{ request()->fullUrlWithQuery(['sort' => 'nome', 'direction' => (request('sort')=='nome' && request('direction')=='asc') ? 'desc' : 'asc']) }}">Nome</a></th>
                    <th><a
                    class="text-white text-decoration-none"
                    href="{{ request()->fullUrlWithQuery(['sort' => 'cpf', 'direction' => (request('sort')=='cpf' && request('direction')=='asc') ? 'desc' : 'asc']) }}">CPF</a></th>
                    <th><a
                    class="text-white text-decoration-none"
                    href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => (request('sort')=='email' && request('direction')=='asc') ? 'desc' : 'asc']) }}">Email</a></th>
                    <th>Pedidos</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>
                            <a class="text-black" href="{{ route('clientes.show', $cliente->id) }}">{{ $cliente->nome ?? '—' }}</a>
                            <br>
                            <small><a class="text-black" href="{{ route('pedidos.index', ['cliente_id' => $cliente->id]) }}">Ver pedidos</a></small>
                        </td>
                        <td>{{ $cliente->cpf }}</td>
                        <td>{{ $cliente->email ?? '—' }}</td>
                        <td>{{ $cliente->pedidos->count() }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-info btn-sm me-2">Detalhes</a>
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');" class="d-flex">
                                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm me-2">Editar</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <style>
            /* smaller pagination buttons to avoid oversized <> controls */
            .pagination .page-link { padding: .25rem .5rem; font-size: .9rem; }
        </style>
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">
                @if($clientes->total())
                    Mostrando {{ $clientes->firstItem() }} a {{ $clientes->lastItem() }} de {{ $clientes->total() }} resultados
                @endif
            </div>
            <div>
                {{ $clientes->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
@endsection
