<?php

use Illuminate\Database\Seeder;
use App\Models\Conta;

class ContaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conta::create([
          'nome' => 'Salario',
          'valor' => 50,
          'grupoConta_id' => 1	
        ]);
    }
}
