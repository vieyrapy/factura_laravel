<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('descripcion');
            $table->integer('stock_actual');
            $table->integer('stock_minimo');
            $table->integer('precio_venta');
            $table->integer('precio_compra');
            $table->float('iva');
            $table->unsignedBigInteger('categoria_producto_id');
            $table->foreign('categoria_producto_id')->references('id')->on('categoria_productos');
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
        Schema::dropIfExists('productos');
    }
}
