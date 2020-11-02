<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Service\Helper;
use DB;

class Painel extends Model
{ 
   protected $perPage = 8;

   public function recuperaConsumo(string $meta, int $ano, 
                                   int $mes):float
   {
      $query = DB::select("
        SELECT c.classificacao, SUM(c.valor) as valor
          FROM(SELECT `g`.`classificacao` AS `classificacao`,
                     `m`.`data` AS `data`, SUM(`m`.`valor`) AS `valor`
                FROM ((`grupocontas` `g`
                JOIN `contas` `c` ON (`c`.`grupoconta_id` = `g`.`id`))
                JOIN `movtocontas` `m` ON (`m`.`conta_id` = `c`.`id`))
                GROUP BY `g`.`classificacao`, `m`.`data`) AS c
        WHERE classificacao = '$meta'
        AND YEAR(data) = $ano
        AND MONTH(data) = $mes
        GROUP BY classificacao");

      foreach($query as $valor):
      	if(isset($valor->valor))
      	  return $valor->valor;         
      endforeach;

      return 0;
   }

   public function recuperaReceita(int $ano):float
   {
      $query = DB::SELECT("
        SELECT SUM(r.Valor) AS Valor
        FROM(
           SELECT `m`.`data` AS `data`,
           SUM(`m`.`valor`) AS `Valor`
           FROM ((`grupocontas` `g`
           JOIN `contas` `c` ON (`c`.`grupoconta_id` = `g`.`id`))
           JOIN `movtocontas` `m` ON (`m`.`conta_id` = `c`.`id`))
           WHERE `g`.`tipo` = 'Receita'
           GROUP BY `m`.`data`, `g`.`tipo`) AS R
        WHERE YEAR(R.data) = $ano;");

      return Helper::recuperaValor($query);     
   }

   public function recuperaDespesa(int $ano):float
   {
     $query = DB::SELECT("
        SELECT SUM(r.Valor) AS Valor
        FROM(
           SELECT `m`.`data` AS `data`,
           SUM(`m`.`valor`) AS `Valor`
           FROM ((`grupocontas` `g`
           JOIN `contas` `c` ON (`c`.`grupoconta_id` = `g`.`id`))
           JOIN `movtocontas` `m` ON (`m`.`conta_id` = `c`.`id`))
           WHERE `g`.`tipo` = 'Despesa'
           GROUP BY `m`.`data`, `g`.`tipo`) AS R
        WHERE YEAR(R.data) = $ano;");  

      return Helper::recuperaValor($query);
   }

   public function rankingContas():object
   {
      $query = DB::table('movtocontas as m')
      ->join('contas as c', 'c.id', 'm.conta_id')
      ->join('grupoContas as g', 'g.id', 'c.grupoConta_id')
      ->select('c.nome', DB::raw('sum(m.valor) AS valor'))
      ->where('g.tipo', 'Despesa')
      ->groupBy('c.nome')
      ->orderBy('valor', 'desc')
      ->paginate($this->perPage);

      return $query;
  }
  
  public function searchRanking(int $ano, int $mes):object
  {
    $query = DB::table('movtocontas as m')
    ->join('contas as c', 'c.id', 'm.conta_id')
    ->join('grupoContas as g', 'g.id', 'c.grupoConta_id')
    ->select('c.nome', DB::raw('sum(m.valor) AS valor'))
    ->where(DB::raw('YEAR(m.data)'), $ano)
    ->where(DB::raw('MONTH(m.data)'), $mes)
    ->where('g.tipo', 'Despesa')
    ->groupBy('c.nome')
    ->orderBy('valor', 'desc')
    ->paginate($this->perPage);

    return $query;
  }

  public function graficoGeral():array
  {
    $query = DB::table('movtocontas as m')
    ->join('contas as c', 'c.id', 'm.conta_id')
    ->join('grupoContas as g', 'g.id', 'c.grupoConta_id')
    ->select('c.nome', DB::raw('sum(m.valor) AS valor'))
    ->where('g.tipo', 'Despesa')
    ->groupBy('c.nome')
    ->orderBy('valor', 'desc')
    ->get()
    ->toArray();

    return $query;      
  }

  public function graficoPerido(int $ano, int $mes):array
  {       
    $query = DB::table('movtocontas as m')
    ->join('contas as c', 'c.id', 'm.conta_id')
    ->join('grupoContas as g', 'g.id', 'c.grupoConta_id')
    ->select('c.nome', DB::raw('sum(m.valor) AS valor'))
    ->where('g.tipo', 'Despesa')
    ->where(DB::raw('YEAR(m.data)'), $ano)
    ->where(DB::raw('MONTH(m.data)'), $mes)
    ->groupBy('c.nome')
    ->orderBy('valor', 'desc')
    ->get()
    ->toArray();

    return $query;      
  }
}
