<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTesouroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tesouros', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('nome');
            $table->double('compra', 12,2);
            $table->double('venda', 12,2);
            $table->date('dt_compra');
            $table->enum('tipo', ['Reserva', 'Curso',  
                                  'Bens', 'Aposentadoria']);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('tesouros');
    }
}
