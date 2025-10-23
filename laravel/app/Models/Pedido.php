<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Cliente;
use App\Models\ItemPedido;
use App\Models\Produto;
use App\Models\Pedido;

class Pedido extends Model
{
    protected $fillable = [
        'numero_pedido',
        'cliente_id',
        'dt_pedido',
        'status',
        'valor_total'
        ];

        public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

        public function itens()
    {
        return $this->hasMany(ItemPedido::class);
    }

}
