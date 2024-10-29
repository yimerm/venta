<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradafacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradafacturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->integer('proveedor')->unsigned();
            $table->integer('total_factura')->unsigned();
            $table->string('pago')->nullable();
            $table->string('fecha_ingreso')->nullable();
            $table->string('fecha_pago')->nullable();
            $table->string('slug_entradafactura')->unique();
            $table->string('estado');
            $table->string('proceso');
            $table->string('nom_user');
            $table->timestamps();
        });

        Schema::table('entradafacturas', function(Blueprint $table)
        {
            $table->foreign('proveedor')->references('id')->on('proveedors')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entradafacturas');
    }
}
