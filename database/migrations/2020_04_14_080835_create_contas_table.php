<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('contas', function (Blueprint $table) {
        $table->integer('id')->autoIncrement();
        $table->string('nome', 50);
        //$table->double('valor',12,2)->default(0);        

        $table->integer('grupoconta_id');
        $table->foreign('grupoconta_id')
        ->on('grupocontas')
        ->references('id')
        ->OnDelete('cascade');
        
        $table->boolean('status')->default(true);
        $table->timestamps();

        $table->index(['nome']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contas');
    }
}
