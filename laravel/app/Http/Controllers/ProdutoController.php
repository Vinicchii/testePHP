<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produto;

class ProdutoController extends Controller
{
    public function show($id)
    {
        $produto = Produto::with(['itens.pedido.cliente'])->findOrFail($id);

        return view('produtos.show', compact('produto'));
    }

    public function index(Request $request)
    {
        $query = Produto::query();

        if ($request->filled('id')) {
            $query->where('id', $request->get('id'));
        }

        if ($request->filled('nome')) {
            $query->where('nome', 'like', "%{$request->get('nome')}%"
            );
        }

        if ($request->filled('cod_barras')) {
            $query->where('cod_barras', 'like', "%{$request->get('cod_barras')}%");
        }

        if ($request->filled('valor_unitario')) {
            $query->where('valor_unitario', $request->get('valor_unitario'));
        }

        $allowedSorts = ['id', 'nome', 'cod_barras', 'valor_unitario'];
        $sort = $request->get('sort', 'id');
        $direction = strtolower($request->get('direction', 'asc')) === 'desc' ? 'desc' : 'asc';
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        }

        $produtos = $query->paginate(20)->withQueryString();
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
            'cod_barras' => 'nullable|string|max:100',
            'valor_unitario' => 'required|numeric|min:0',

        ]);

        Produto::create($request->all());

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:100',
            'cod_barras' => 'nullable|string|max:100',
            'valor_unitario' => 'required|numeric|min:0',
        ]);

        $produto->update($request->all());

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);

        // Verifica se o produto está vinculado a algum item de pedido
        if ($produto->itens()->exists()) {
            return redirect()->route('produtos.index')->with('error', 'Não é possível excluir um produto vinculado a pedidos.');
        }

        $produto->delete();

        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
}
