@extends('layouts.app')

@section('title', 'Detalhes do Pedido')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detalhes do Pedido #{{ $pedido->numero_pedido }}</h2>
        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informações do Pedido</h5>
            <dl class="row">
                <dt class="col-sm-3">Cliente:</dt>
                <dd class="col-sm-9">{{ $pedido->cliente->nome ?? '—' }}</dd>

                <dt class="col-sm-3">Data do Pedido:</dt>
                <dd class="col-sm-9">{{ $pedido->dt_pedido->format('d/m/Y') }}</dd>

                <dt class="col-sm-3">Status:</dt>
                <dd class="col-sm-9">
                    <span class="badge bg-{{ $pedido->status === 'Em Aberto' ? 'warning' : ($pedido->status === 'Pago' ? 'success' : 'danger') }}">
                        {{ $pedido->status }}
                    </span>
                </dd>

                <dt class="col-sm-3">CPF do Cliente:</dt>
                <dd class="col-sm-9">{{ $pedido->cliente->cpf }}</dd>

                <dt class="col-sm-3">Email do Cliente:</dt>
                <dd class="col-sm-9">{{ $pedido->cliente->email ?? '—' }}</dd>
            </dl>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Itens do Pedido</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor Unitário</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedido->itens as $item)
                        <tr>
                            <td>{{ $item->produto->nome }}</td>
                            <td>{{ $item->quantidade }}</td>
                            <td>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($item->quantidade * $item->valor_unitario, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total do Pedido:</td>
                        <td class="fw-bold">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
