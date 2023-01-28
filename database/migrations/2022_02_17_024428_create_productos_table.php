<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('nombre_prod', 35)->nullable();
            $table->string('nombre_img', 30)->nullable();
            $table->integer('existencia')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('marca', 35)->nullable();
            $table->string('categoria', 40)->nullable();
            $table->float('precio');
            $table->string('usuario', 10);
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