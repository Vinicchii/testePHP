@extends('layouts.app')

@section('title', 'Detalhes do Cliente')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detalhes do Cliente</h2>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informações do Cliente</h5>
            <dl class="row">
                <dt class="col-sm-3">Nome:</dt>
                <dd class="col-sm-9">{{ $cliente->nome ?? '—' }}</dd>

                <dt class="col-sm-3">CPF:</dt>
                <dd class="col-sm-9">{{ $cliente->cpf }}</dd>

                <dt class="col-sm-3">Email:</dt>
                <dd class="col-sm-9">{{ $cliente->email ?? '—' }}</dd>
            </dl>
        </div>
    </div>

    <h3>Histórico de Pedidos</h3>
    @if($cliente->pedidos->isEmpty())
        <p>Este cliente ainda não realizou nenhum pedido.</p>
    @else
        @foreach($cliente->pedidos as $pedido)
            <div class="card mb-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pedido #{{ $pedido->numero_pedido }}</h5>
                        <span class="badge bg-{{ $pedido->status === 'Em Aberto' ? 'warning' : ($pedido->status === 'Pago' ? 'success' : 'danger') }}">
                            {{ $pedido->status }}
                        </span>
                    </div>
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
                                <td class="fw-bold">R$ {{ number_format($pedido->itens->sum(function($item) {
                                    return $item->quantidade * $item->valor_unitario;
                                }), 2, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
