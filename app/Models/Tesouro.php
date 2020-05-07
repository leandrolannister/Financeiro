<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tesouro extends Model
{
    protected $fillable = ['nome', 'compra', 'venda', 'dt_compra',
						   'tipo', 'status'];
	protected $perPage = 10;
	
	public function list():object
	{
	  return $this::query()->orderBy('tipo')->paginate();
	}

	public function getStatusAttribute(): string
	{
	  if($this->attributes['status'])
	    return "Ativo";
		  
	  return "Desativado";  	
	}


	public function store_t(array $dados):bool
	{
	  try{
	    $this::create($dados);
	  }catch(\Exception $e){
	    return false;
	  }
	  return true;
	}

	public function update_t(array $dados):bool
	{
	  try{
	    $tesouro = $this::find($dados['id']);
		$tesouro->fill($dados);
		$tesouro->save();
	  }catch(\Exception $e){
	    return false;
	  }
	  
	  return true;
	}
}
