<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cliente;


class ClienteController extends Controller
{

    public function index()
    {
    $clientes = Cliente::with('pedidos')->get();
    return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'nullable|string|max:100',
            'cpf' => 'required|digits:11|unique:clientes,cpf',
            'email' => 'nullable|email|max:100',
        ]);

        Cliente::create($request->all());

        return redirect()->route('pedidos.create')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nome' => 'nullable|string|max:100',
            'cpf' => 'required|digits:11|unique:clientes,cpf,' . $cliente->id,
            'email' => 'nullable|email|max:100',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }


    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);

        // Verifica se o cliente tem pedidos antes de excluir
        if ($cliente->pedidos()->exists()) {
            return redirect()->route('clientes.index')->with('error', 'Não é possível excluir um cliente com pedidos.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }

}
