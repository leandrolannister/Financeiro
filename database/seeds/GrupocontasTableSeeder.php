<?php

use Illuminate\Database\Seeder;
use App\Models\Grupoconta;

class GrupocontasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Grupoconta::create([
         'nome'   => 'Renda',
         'tipo'   => 'Receita',
         'user_id' => 1         
       ]);       
    }
}
