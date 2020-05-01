<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovtocontas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('movtocontas', function (Blueprint $table) {
        $table->integer('id')->autoIncrement();          
        $table->enum('tipo', ['E', 'S', 'T']);
        $table->double('valor', 12,2)->default(0.0);
        $table->double('valor_acumulado', 12,2)->default(0.0);
                
        $table->integer('conta_id');
        $table->foreign('conta_id')
        ->references('id')->on('contas')->onDelete('cascade');
          
        $table->integer('user_id');          
        $table->foreign('user_id')
        ->references('id')->on('users')->onDelete('cascade');

        $table->date('data');

        $table->timestamps();
        
        $table->index(['data']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movtocontas');
    }
}
