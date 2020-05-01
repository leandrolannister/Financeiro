<?php

use Illuminate\Database\Seeder;
use App\Models\Movtoconta;

class MovtocontaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Movtoconta::create([
	    'tipo' => 'E',
	    'valor' => 100,
	    'total_anterior' => 0,
	    'total_atual' => 100,
	    'conta_id' => 1,
	    'user_id' => 1,
	    'data' => date('Y-m-d')	
	  ]);
    }
}
