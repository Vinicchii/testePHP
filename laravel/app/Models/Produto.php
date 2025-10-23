<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'cod_barras',
        'valor_unitario'
    ];

    public function itens()
{
    return $this->hasMany(ItemPedido::class);
}
}
