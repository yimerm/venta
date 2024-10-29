<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioproductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarioproductos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo_factura');
            $table->string('codigo_producto');
            $table->string('nombre_producto');
            $table->string('precio_ini');
            $table->string('porcentaje');
            $table->string('promocion');
            $table->string('cantidades');
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
        Schema::dropIfExists('inventarioproductos');
    }
}
