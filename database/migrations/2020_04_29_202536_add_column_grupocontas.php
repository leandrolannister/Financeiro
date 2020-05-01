<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnGrupocontas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grupocontas', function(Blueprint $table){
           $table->enum('classificacao', 
            ['Consumo', 'Diversao', 'Cursos', 'Lucro'])
            ->default('Consumo')
            ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grupocontas', function(Blueprint $table){
          $table->dropColumn('classificacao');
        });
    }
}
