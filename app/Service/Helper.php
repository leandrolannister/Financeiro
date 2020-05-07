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

  public function calcularLucroAcoes($compra, $quantidade, $venda)
  :float
  {
     $total_compra = $compra * $quantidade;
     $total_venda = $venda * $quantidade;

     return $total_venda - $total_compra;  
  }

  public function calcularPorcentagemAcoes($compra, $quantidade, 
    $venda):float
  {
    $despesaCorretagem = 5.10;

    $total_compra = $compra * $quantidade - $despesaCorretagem;
    $total_venda = $venda * $quantidade;

    if($total_venda > $total_compra)
      return number_format(
        100 - ($total_compra / $total_venda) * 100,2,'.',',');

    return number_format(
      100 - ($total_venda / $total_compra) * 100,2,'.',',');
  }

  public function calcularSaldoTesouro($venda, $compra): float
  {
     return number_format($venda - $compra);         
  }

  public function recuperaData(array $dados):array
  {
    $result = array_map(function($dados){
      return ['ano' => substr($dados, 0,4),
              'mes' => substr($dados, 6,7)];      
    }, $dados);

    return $result['data'];       
  }  

}
