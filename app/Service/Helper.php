<?php

namespace App\Service;
use Illuminate\Support\Carbon;
use App\Models\Grupoconta;

class Helper
{
  public function formatDate($dateTime)
  {
    return Carbon::parse($dateTime)->format('d/m/Y');
  }

  public function recuperaStatus(bool $status):string
  {
    if($status)
  	  return "Ativo";

  	return "Desativado";
  }

  public function recuperaNomeGrupo(int $grupoconta_id): string
  {
    $grupo = Grupoconta::where('id', $grupoconta_id)
             ->get()->first();

    return  $grupo->nome;
  }

  public static function recuperaValor(array $dados): float
  {
    foreach($dados as $valores):
      foreach($valores as $valor):
        if(isset($valor))
          return $valor;  
      endforeach; 
    endforeach; 

    return 0; 
  }
}
