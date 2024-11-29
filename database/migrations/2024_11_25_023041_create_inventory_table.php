<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Tipo de herramienta
            $table->string('part_number'); // Número de parte
            $table->string('name'); // Nombre de la herramienta
            $table->integer('quantity')->default(0); // Cantidad disponible
            $table->text('comment')->nullable(); // Comentario opcional
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory');
    }
}
