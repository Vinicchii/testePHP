@extends('layouts.app')

@section('title', 'Lista de Produtos')

@section('content')
<div class="container">
    <h2>Produtos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('produtos.create') }}" class="btn btn-success mb-3">+ Novo Produto</a>

    @if($produtos->isEmpty())
        <p>Nenhum produto cadastrado ainda.</p>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>EAN</th>
                    <th>Valor Uni.</th>
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
                            <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-warning btn-sm me-2">Editar</a>

                            <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Excluir este produto?');">
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
