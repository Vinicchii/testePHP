@extends('layouts.app')

@section('title', 'Detalhes do Produto')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detalhes do Produto</h2>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informações do Produto</h5>
            <dl class="row">
                <dt class="col-sm-3">ID:</dt>
                <dd class="col-sm-9">{{ $produto->id }}</dd>

                <dt class="col-sm-3">Nome:</dt>
                <dd class="col-sm-9">{{ $produto->nome ?? '—' }}</dd>

                <dt class="col-sm-3">Código de Barras:</dt>
                <dd class="col-sm-9">{{ $produto->cod_barras ?? '—' }}</dd>

                <dt class="col-sm-3">Valor Unitário:</dt>
                <dd class="col-sm-9">R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</dd>

            </dl>
        </div>
    </div>

    <h3>Histórico de Vendas (por pedido)</h3>
    @if($produto->itens->isEmpty())
        <p>Nenhuma venda encontrada para este produto.</p>
    @else
        <table class="table table-striped mb-4">
            <thead>
                <tr>
                    <th>N.º Pedido</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produto->itens as $item)
                    <tr>
                        <td><a
                        class="text-black text-decoration-none"
                        href="{{ route('pedidos.show', $item->pedido->id) }}">#{{ $item->pedido->numero_pedido }}<i class="bi bi-box-arrow-up-right p-1"></a></i></td>
                        <td>{{ $item->pedido->cliente->nome ?? '—' }}</td>
                        <td>{{ optional($item->pedido->dt_pedido)->format('d/m/Y') }}</td>
                        <td>{{ $item->quantidade }}</td>
                        <td>R$ {{ number_format($item->quantidade * $item->valor_unitario, 2, ',', '.') }}</td>
                        <td>{{ $item->pedido->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Resumo por Cliente</h4>
        @php
            $byClient = $produto->itens->groupBy(function($i) { return $i->pedido->cliente->id ?? null; })->map(function($group) {
                $cliente = $group->first()->pedido->cliente ?? null;
                return [
                    'cliente' => $cliente,
                    'quantidade' => $group->sum('quantidade'),
                    'gasto' => $group->sum(function($i){ return $i->quantidade * $i->valor_unitario; })
                ];
            })->filter(function($v){ return $v['cliente'] !== null; });
        @endphp

        @if($byClient->isEmpty())
            <p>Nenhum cliente encontrado.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Quantidade Total Comprada</th>
                        <th>Gasto Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($byClient as $entry)
                        <tr>
                            <td>{{ $entry['cliente']->nome }}</td>
                            <td>{{ $entry['quantidade'] }}</td>
                            <td>R$ {{ number_format($entry['gasto'], 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('clientes.show', $entry['cliente']->id) }}" class="btn btn-info btn-sm">Ver Cliente</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif
</div>
@endsection
