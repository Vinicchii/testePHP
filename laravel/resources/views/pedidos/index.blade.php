@extends('layouts.app')

@section('title', 'Lista de Pedidos')

@section('content')
<div class="container">
    <h2>Pedidos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pedidos.create') }}" class="btn btn-success mb-3">+ Novo Pedido</a>

    @if($pedidos->isEmpty())
        <p>Nenhum pedido cadastrado ainda.</p>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>N.º Pedido</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->numero_pedido }}</td>
                        <td>{{ $pedido->cliente->nome ?? '—' }}</td>
                        <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                        <td>{{ $pedido->status }}</td>
                        <td>R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-warning btn-sm me-2">Editar</a>

                            <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Excluir este pedido?');">
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
