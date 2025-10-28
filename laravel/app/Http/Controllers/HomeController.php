<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cliente;

use App\Models\Produto;

use App\Models\Pedido;

class HomeController extends Controller
{

    public function index()
    {
        $faturamentoPago = Pedido::where('status', 'Pago')->sum('valor_total');
        $faturamentoEmAberto = Pedido::where('status', 'Em Aberto')->sum('valor_total');
        $faturamentoCancelado = Pedido::where('status', 'Cancelado')->sum('valor_total');
        $faturamentoPotencial = $faturamentoPago + $faturamentoEmAberto;
        $totalClientes = Cliente::count();
        $clientesComPedido = Cliente::has('pedidos')->count();
        $totalProdutos = Produto::count();

        $totalPedidos = Pedido::count();
        $pedidosEmAberto = Pedido::where('status', 'Em Aberto')->count();
        $pedidosPagos = Pedido::where('status', 'Pago')->count();
        $pedidosCancelados = Pedido::where('status', 'Cancelado')->count();

        $produtosComClientes = \App\Models\ItemPedido::with('produto')
            ->whereHas('pedido', function ($query) {
                $query->whereIn('status', ['Pago','Em Aberto']);
            })
            ->get()
            ->groupBy('produto_id')
            ->map(function ($itens) {
                return [
                    'nome' => $itens->first()->produto->nome ?? 'Produto desconhecido',
                    'quantidade' => $itens->sum('quantidade'),
                ];
            })
            ->sortByDesc('quantidade')
            ->take(3)
            ->values();

        return view('home.home', compact(
            'totalClientes',
            'clientesComPedido',
            'totalProdutos',
            'totalPedidos',
            'pedidosEmAberto',
            'pedidosPagos',
            'pedidosCancelados',
            'faturamentoPago',
            'faturamentoPotencial',
            'faturamentoCancelado',
            'produtosComClientes'
        ));
    }
}
