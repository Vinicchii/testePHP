@extends('layouts.app')

@section('title', 'Editar Pedido')

@section('content')
<div class="container">
    <h2>Editar Pedido</h2>

    <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" class="form-select" required>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $pedido->cliente_id == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="numero_pedido" class="form-label">Número do Pedido</label>
            <input type="number" name="numero_pedido" class="form-control" value="{{ old('numero_pedido', $pedido->numero_pedido) }}" required>
        </div>

        <div class="mb-3">
            <label for="dt_pedido" class="form-label">Data do Pedido</label>
            <input type="date" name="dt_pedido" class="form-control" value="{{ old('dt_pedido', $pedido->dt_pedido->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                @foreach(['Em Aberto', 'Pago', 'Cancelado'] as $status)
                    <option value="{{ $status }}" {{ $pedido->status == $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <h5>Produtos do Pedido</h5>
        <div id="produtos-container">
            @foreach($pedido->itens as $index => $item)
                <div class="row mb-2">
                    <div class="col-md-6">
                        <select name="produtos[{{ $index }}][produto_id]" class="form-select" required>
                            @foreach($produtos as $produto)
                                <option value="{{ $produto->id }}" {{ $item->produto_id == $produto->id ? 'selected' : '' }}>
                                    {{ $produto->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="produtos[{{ $index }}][quantidade]" class="form-control" value="{{ $item->quantidade }}" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="produtos[{{ $index }}][valor_unitario]" class="form-control" step="0.01" value="{{ $item->valor_unitario }}" required>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
