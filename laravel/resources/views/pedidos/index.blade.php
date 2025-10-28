@extends('layouts.app')

@section('title', 'Lista de Pedidos')

@section('content')
<div class="container">
    <h2>Pedidos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pedidos.create') }}" class="btn btn-success mb-3">+ Novo Pedido</a>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="text" name="numero_pedido" class="form-control" placeholder="N.º Pedido" value="{{ request('numero_pedido') }}">
        </div>
        <div class="col-auto">
            <input type="text" name="cliente" class="form-control" placeholder="Cliente" value="{{ request('cliente') }}">
        </div>
        <div class="col-auto">
            <input type="date" name="dt_pedido" class="form-control" value="{{ request('dt_pedido') }}">
        </div>
        <div class="col-auto">
            <select name="status" class="form-select">
                <option value="">Todos</option>
                <option value="Em Aberto" {{ request('status')=='Em Aberto' ? 'selected' : '' }}>Em Aberto</option>
                <option value="Pago" {{ request('status')=='Pago' ? 'selected' : '' }}>Pago</option>
                <option value="Cancelado" {{ request('status')=='Cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" type="submit">Filtrar</button>
            <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">Limpar</a>
        </div>
    </form>

    @if($pedidos->isEmpty())
        <p>Nenhum pedido cadastrado ainda.</p>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th><a
                    class="text-white text-decoration-none"
                    href="{{ request()->fullUrlWithQuery(['sort' => 'numero_pedido', 'direction' => (request('sort')=='numero_pedido' && request('direction')=='asc') ? 'desc' : 'asc']) }}">N.º Pedido</a></th>

                    <th><a
                    class="text-white text-decoration-none"
                    href="{{ request()->fullUrlWithQuery(['sort' => 'cliente', 'direction' => (request('sort')=='cliente' && request('direction')=='asc') ? 'desc' : 'asc']) }}">Cliente</a></th>

                    <th><a
                    class="text-white text-decoration-none"
                    href="{{ request()->fullUrlWithQuery(['sort' => 'dt_pedido', 'direction' => (request('sort')=='dt_pedido' && request('direction')=='asc') ? 'desc' : 'asc']) }}">Data</a></th>

                    <th><a
                    class="text-white text-decoration-none"
                    href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => (request('sort')=='status' && request('direction')=='asc') ? 'desc' : 'asc']) }}">Status</a></th>

                    <th><a
                    class="text-white text-decoration-none"
                    href="{{ request()->fullUrlWithQuery(['sort' => 'valor_total', 'direction' => (request('sort')=='valor_total' && request('direction')=='asc') ? 'desc' : 'asc']) }}">Total</a></th>

                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->numero_pedido }}</td>
                        <td>
                            @if($pedido->cliente)
                                <a class="text-black" href="{{ route('clientes.show', $pedido->cliente->id) }}">{{ $pedido->cliente->nome }}</a>
                            @else
                                &mdash;
                            @endif
                        </td>
                        <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                        <td>{{ $pedido->status }}</td>
                        <td>R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-info btn-sm me-2">Detalhes</a>
                                <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-warning btn-sm me-2">Editar</a>
                                <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" onsubmit="return confirm('Excluir este pedido?');">
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
            .pagination .page-link { padding: .25rem .5rem; font-size: .9rem; }
        </style>
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">
                @if($pedidos->total())
                    Mostrando {{ $pedidos->firstItem() }} a {{ $pedidos->lastItem() }} de {{ $pedidos->total() }} resultados
                @endif
            </div>
            <div>
                {{ $pedidos->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
@endsection
