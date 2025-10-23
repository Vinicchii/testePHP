<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_pedido');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->date('dt_pedido');
            $table->enum('status', ['Em Aberto', 'Pago', 'Cancelado'])->default('Em Aberto');
            $table->decimal('valor_total', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
