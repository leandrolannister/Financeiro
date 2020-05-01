<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Service\Helper;
use DB;

class Painel extends Model
{
   public function recuperaConsumo(string $meta, int $ano, int $mes)
   :float
   {
      $query = 
      DB::select("
         SELECT classificacao, data, valor 
         FROM vw_calculoMetas
         WHERE classificacao = '$meta'
         AND YEAR(data) = $ano
         AND MONTH(data) = $mes");

      foreach($query as $valor):
      	if(isset($valor->valor))
      	  return $valor->valor;         
      endforeach;

      return 0;
   }

   public function recuperaReceita(int $ano):float
   {
     $query = DB::select("
      SELECT SUM(valor) FROM vw_ReceitasTotal
      WHERE YEAR(data) = $ano");

     return Helper::recuperaValor($query);     
  }

  public function recuperaDespesa(int $ano):float
  {
    $query = DB::select("
      SELECT SUM(valor) FROM vw_DespesasTotal
      WHERE YEAR(data) = $ano");

    return Helper::recuperaValor($query);
  }
}
