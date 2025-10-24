@extends('layouts.app')

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
    <h2>Novo Pedido</h2>

    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" class="form-select" required>
                <option value="">Selecione</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nome }} ({{ $cliente->cpf }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="dt_pedido" class="form-label">Data do Pedido</label>
            <input type="datetime-local" name="dt_pedido" class="form-control" required>
        </div>

        <h4>Produtos</h4>
        <div id="produtos-container">
            <div class="produto-item mb-3">
                <select name="produtos[0][produto_id]" class="form-select" required>
                    <option value="">Selecione um produto</option>
                    @foreach($produtos as $produto)
                        <option value="{{ $produto->id }}">{{ $produto->nome }} - R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</option>
                    @endforeach
                </select>
                <input type="number" name="produtos[0][quantidade]" class="form-control mt-2" placeholder="Quantidade" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="Em Aberto">Em Aberto</option>
                <option value="Pago">Pago</option>
                <option value="Cancelado">Cancelado</option>
            </select>
        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="adicionarProduto()">+ Adicionar Produto</button>

        <button type="submit" class="btn btn-primary">Salvar Pedido</button>
        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
let produtoIndex = 1;

function adicionarProduto() {
    const container = document.getElementById('produtos-container');
    const novoProduto = document.createElement('div');
    novoProduto.classList.add('produto-item', 'mb-3');
    novoProduto.innerHTML = `
        <select name="produtos[${produtoIndex}][produto_id]" class="form-select" required>
            <option value="">Selecione um produto</option>
            @foreach($produtos as $produto)
                <option value="{{ $produto->id }}">{{ $produto->nome }} - R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</option>
            @endforeach
        </select>
        <input type="number" name="produtos[${produtoIndex}][quantidade]" class="form-control mt-2" placeholder="Quantidade" required>
    `;
    container.appendChild(novoProduto);
    produtoIndex++;
}
</script>
@endsection
