<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Service\Helper;
use DB;

class Conta extends Model
{
  protected $fillable = ['nome', 'status', 
                         'grupoconta_id', 'tipo'];
  protected $perPage = 8;

  public function grupoConta(): object
  {
    return $this->belongsTo(Grupoconta::class);
  }

  public function movtoContas(): object
  {
    return $this->hasMany(Movtoconta::class);
  }

  public function setNomeAttribute($nome):void
  {
    $this->attributes['nome'] = mb_strtolower($nome);
  }

  public function store_c(array $dados): bool
  {
    try{
      $this::create($dados);
    }catch(\Exception $e){
      return false;
    }
    
    return true;
  }

  public function update_c(Object $dados): bool
  {
    try{
      $conta = $this::find($dados['id']); 
      $conta->fill($dados->all());
      $conta->save();
    }catch(\Exception $e){
      return false;
    } 

    return true;
  }

  public function listar(): object
  {
    return $this->query()->orderby('id')
           ->paginate($this->perPage);
  }

  public function search(array $dados): object
  {
    $query = function($dados){  
      if(isset($dados['nome']))
        return $this->query()
        ->where('nome', 'like', '%'.$dados['nome'].'%')
        ->paginate($this->perPage);
       
      if(isset($dados['grupoconta']))
        return $this->query()
        ->where('grupoconta_id', $dados['grupoconta'])
        ->paginate($this->perPage);
       
      return $this->query()->where('id', '>=', 1)->paginate();
     };

     return $query($dados);    
  }

  public function updateStatus($conta_id):bool
  {
    $c = $this::find($conta_id);
    try{
      $c->status ? $c->status = false
                 : $c->status = true;
      $c->save();
    }catch(\Exception $e){
      return false;
    }  

    return true;
  }

  public function movtosMonth(int $ano, int $mes):array
  {
    $movtos = DB::select("
      SELECT m.grupo, m.tipo, m.total, m.data
      FROM(SELECT `g`.`nome` AS `grupo`,
                  `g`.`tipo` AS `tipo`,
                  SUM(`m`.`valor`) AS `total`,
                  `m`.`data` AS `data`
           FROM ((`grupocontas` `g`
           JOIN `contas` `c` ON (`c`.`grupoconta_id` = `g`.`id`))
           JOIN `movtocontas` `m` ON (`m`.`conta_id` = `c`.`id`))
           GROUP BY `g`.`nome`,  `g`.`tipo`, `m`.`data`) AS m
      WHERE year(m.data) = $ano
      AND month(m.data) = $mes;");  

    return $movtos;
  }

  public function getSaldo(int $ano, int $mes):float
  {
    $saldo =
      $this->receita($ano, $mes) - $this->despesa($ano, $mes);

    return $saldo;
  }

  public function receita(int $ano, int $mes):float
  {
    $query = DB::select("
      SELECT
        m.data AS data, SUM(m.valor) AS Valor
      FROM ((grupocontas g
      JOIN contas c ON (c.grupoconta_id = g.id))
  
      JOIN movtocontas m ON (m.conta_id = c.id))
      WHERE g.tipo = 'Receita'
      AND YEAR(m.data) = $ano
      AND MONTH(m.data) = $mes
      GROUP BY m.data, g.tipo");

      $total = Helper::recuperaValor($query);

    return $total;
  }

  public function despesa(int $ano, int $mes):float
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
        WHERE YEAR(R.data) = $ano
        AND MONTH(R.data) = $mes");   

    $total = Helper::recuperaValor($query);

    return $total;
  }

  public function recuperaContas(string $tipo,
    string $mes):array {

    $contas = DB::select("
    SELECT c.nome, c.status, c.tipo, 
      
      (select m.valor from movtocontas AS m 
       where m.conta_id = c.id AND 
       MONTH(m.data) = $mes limit 1) AS valor,
       
      (select m.data from movtocontas AS m 
       where m.conta_id = c.id AND 
       MONTH(m.data) = $mes limit 1) AS data

    FROM contas as c
    WHERE c.tipo = '{$tipo}'");

    return $contas;
  }



  public function procuraGrupo(int $grupoconta_id)
  :bool{
    $query = $this::where('grupoconta_id', $grupoconta_id)
    ->get()->first();

    return isset($query) ? true : false;  
  }
}
