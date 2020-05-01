<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrupocontas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupocontas', function (Blueprint $table) {
          $table->integer('id')->autoIncrement();
          $table->string('nome', 50);
          $table->enum('tipo', ['Receita', 'Despesa']);          

          $table->integer('user_id');
          $table->foreign('user_id')
          ->on('users')
          ->references('id')
          ->OnDelete('cascade');

          $table->boolean('status')->default(true);
          $table->timestamps();          

          $table->index(['nome', 'tipo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupocontas');
    }
}
