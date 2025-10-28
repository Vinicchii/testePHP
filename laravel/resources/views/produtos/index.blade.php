@extends('layouts.app')

@section('title', 'Lista de Produtos')

@section('content')
<div class="container">
    <h2>Produtos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('produtos.create') }}" class="btn btn-success mb-3">+ Novo Produto</a>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
        </div>
        <div class="col-auto">
            <input type="text" name="nome" class="form-control" placeholder="Nome" value="{{ request('nome') }}">
        </div>
        <div class="col-auto">
            <input type="text" name="cod_barras" class="form-control" placeholder="EAN" value="{{ request('cod_barras') }}">
        </div>
        <div class="col-auto">
            <input type="text" name="valor_unitario" class="form-control" placeholder="Valor" value="{{ request('valor_unitario') }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" type="submit">Filtrar</button>
            <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Limpar</a>
        </div>
    </form>

    @if($produtos->isEmpty())
        <p>Nenhum produto cadastrado ainda.</p>
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
                    href="{{ request()->fullUrlWithQuery(['sort' => 'cod_barras', 'direction' => (request('sort')=='cod_barras' && request('direction')=='asc') ? 'desc' : 'asc']) }}">EAN</a></th>

                    <th><a
                    class="text-white text-decoration-none"
                    href="{{ request()->fullUrlWithQuery(['sort' => 'valor_unitario', 'direction' => (request('sort')=='valor_unitario' && request('direction')=='asc') ? 'desc' : 'asc']) }}">Valor Uni.</a></th>

                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produtos as $produto)
                    <tr>
                        <td>{{ $produto->id }}</td>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->cod_barras ?? '—' }}</td>
                        <td>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('produtos.show', $produto->id) }}" class="btn btn-info btn-sm me-2">Detalhes</a>
                                <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-warning btn-sm me-2">Editar</a>
                                <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" onsubmit="return confirm('Excluir este produto?');">
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
                @if($produtos->total())
                    Mostrando {{ $produtos->firstItem() }} a {{ $produtos->lastItem() }} de {{ $produtos->total() }} resultados
                @endif
            </div>
            <div>
                {{ $produtos->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
@endsection
