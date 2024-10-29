<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nespera');
            $table->integer('nfactura')->nullable();
            $table->string('modo_pago')->nullable();
            $table->string('total_factura')->nullable();
            $table->string('pago_con')->nullable();
            $table->string('saldo_efectivo')->nullable();
            $table->string('codigo_cliente')->nullable();
            $table->string('usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
