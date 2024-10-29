<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolucionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolucions', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('nfactura')->nullable();
            $table->string('codigo_cliente')->nullable();
            $table->string('codigo_producto')->nullable();
            $table->string('nombre_producto')->nullable();
            $table->string('cantidades')->nullable(); 
            $table->string('precio')->nullable();
            $table->string('usuario')->nullable();
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
        Schema::dropIfExists('devolucions');
    }
}
