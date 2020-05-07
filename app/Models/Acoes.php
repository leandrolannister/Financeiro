<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acoes extends Model
{
    protected $fillable = ['papel', 'quantidade', 'compra', 
                           'venda', 'dt_compra', 'dt_venda'];
    protected $perPage = 10;                       

    public function store_a(array $dados): bool
    {
      try{
        $dados['dt_venda'] = Date("Y-m-d");
        $dados['venda'] = $dados['compra'];

    	$this::create($dados);
      }catch(\Exception $e){
        return false;    		
      }

      return true;
    } 

    public function update_a(array $dados): bool
    {
      try{
        $acoes = $this::find($dados['id']);
        $acoes->fill($dados);
        $acoes->save();
      }catch(\Exception $e){
        return false;
      }

      return true;
    }                     
}
