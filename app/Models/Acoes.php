<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acoes extends Model
{
    protected $fillable = ['papel', 'quantidade', 'compra', 'venda',
                           'dt_compra', 'dt_venda'];

    public function store_a(array $dados): bool
    {
    	try{
    		
            $dados['dt_venda'] = Date("Y-m-d");
            $dados['venda'] = $dados['compra'];

    		$this::create($dados);
    	}catch(\Exception $e)
    	{
    	  dd($e);
    	  return false;    		
    	}

    	return true;
    } 

    public function upgrade(array $dados): bool
    {
        try{
            $acoes = $this::find($dados['id']);
            $acoes->venda = $dados['venda'];
            $acoes->save();
        }catch(\Exception $e){
            return false;
        }

        return true;
    }                     
}
