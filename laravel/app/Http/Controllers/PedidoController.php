<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\ItemPedido;

class PedidoController extends Controller
{

    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'itens' => function($query) {
            $query->with('produto');
        }])->findOrFail($id);

        return view('pedidos.show', compact('pedido'));
    }

    public function index(Request $request)
    {
        $query = Pedido::with('cliente', 'itens.produto');

        // Filters
        if ($request->filled('numero_pedido')) {
            $query->where('numero_pedido', $request->get('numero_pedido'));
        }

        // Allow filtering by cliente_id (strong) or by cliente name (fallback)
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->get('cliente_id'));
        } elseif ($request->filled('cliente')) {
            $cliente = $request->get('cliente');
            $query->whereHas('cliente', function ($q) use ($cliente) {
                $q->where('nome', 'like', "%{$cliente}%");
            });
        }

        if ($request->filled('dt_pedido')) {
            $query->whereDate('dt_pedido', $request->get('dt_pedido'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Sorting
        $allowedSorts = ['id', 'numero_pedido', 'dt_pedido', 'status', 'valor_total', 'cliente'];
        $sort = $request->get('sort', 'numero_pedido');
        $direction = strtolower($request->get('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        if ($sort === 'cliente') {
            // order by cliente.nome - join to support ordering
            $query->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
                ->orderBy('clientes.nome', $direction)
                ->select('pedidos.*');
        } elseif (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        }

        $pedidos = $query->paginate(20)->withQueryString();

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $produtos = Produto::all();
        return view('pedidos.create', compact('clientes', 'produtos'));
    }

    public function store(Request $request)
    {

        $ultimoNumero = Pedido::max('numero_pedido');
        $numeroPedido = $ultimoNumero ? $ultimoNumero + 1 : 1000;

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'dt_pedido' => 'required|date',
            'status' => 'required|in:Em Aberto,Pago,Cancelado',
            'produtos' => 'required|array',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
        ]);

        $valorTotal = 0;

        foreach ($request->produtos as $item) {
            $produto = Produto::find($item['produto_id']);
            $valorTotal += $item['quantidade'] * $produto->valor_unitario;
        }

        $pedido = Pedido::create([
            'numero_pedido' => $numeroPedido,
            'cliente_id' => $request->cliente_id,
            'dt_pedido' => $request->dt_pedido,
            'status' => $request->status,
            'valor_total' => $valorTotal,
        ]);

        foreach ($request->produtos as $item) {
            $produto = Produto::find($item['produto_id']);
            $pedido->itens()->create([
                'produto_id' => $produto->id,
                'quantidade' => $item['quantidade'],
                'valor_unitario' => $produto->valor_unitario,
            ]);
        }

        return redirect()->route('pedidos.index')->with('success', 'Pedido cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $pedido = Pedido::with('itens.produto')->findOrFail($id);
        $clientes = Cliente::all();
        $produtos = Produto::all();

        return view('pedidos.edit', compact('pedido', 'clientes', 'produtos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_pedido' => 'required|integer',
            'cliente_id' => 'required|exists:clientes,id',
            'dt_pedido' => 'required|date',
            'status' => 'required|in:Em Aberto,Pago,Cancelado',
            'produtos' => 'required|array',
            'produtos.*.produto_id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'produtos.*.valor_unitario' => 'required|numeric|min:0',
        ]);

        $pedido = Pedido::findOrFail($id);

        $valorTotal = 0;
        foreach ($request->produtos as $item) {
            $valorTotal += $item['quantidade'] * $item['valor_unitario'];
        }

        $pedido->update([
            'numero_pedido' => $request->numero_pedido,
            'cliente_id' => $request->cliente_id,
            'dt_pedido' => $request->dt_pedido,
            'status' => $request->status,
            'valor_total' => $valorTotal,
        ]);

        // Remove itens antigos
        $pedido->itens()->delete();

        // Adiciona novos itens
        foreach ($request->produtos as $item) {
            $pedido->itens()->create([
                'produto_id' => $item['produto_id'],
                'quantidade' => $item['quantidade'],
                'valor_unitario' => $item['valor_unitario'],
            ]);
        }

        return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado com sucesso!');
    }


    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->itens()->delete(); // Remove os itens primeiro
        $pedido->delete(); // Depois remove o pedido

        return redirect()->route('pedidos.index')->with('success', 'Pedido excluído com sucesso!');
    }

}
