<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\ItemPedido;

class PedidoController extends Controller
{

    public function index()
    {
        $pedidos = Pedido::with('cliente', 'itens.produto')->get();
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
        $request->validate([
            'numero_pedido' => 'required|integer',
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
            'numero_pedido' => $request->numero_pedido,
            'cliente_id' => $request->cliente_id,
            'dt_pedido' => $request->dt_pedido,
            'status' => $request->status,
            'valor_unitario' => $valorTotal,
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


}
