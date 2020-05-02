<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acoes', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('papel', 15);
            $table->integer('quantidade');
            $table->double('compra', 12,2)->default(0);
            $table->double('venda', 12,2)->default(0);
            $table->date('dt_compra');
            $table->date('dt_venda');
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
        Schema::dropIfExists('acoes');
    }
}
