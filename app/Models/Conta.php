<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Service\Helper;
use DB;

class Conta extends Model
{
  protected $fillable = ['nome', 'status', 'grupoconta_id', 
                         'tipo'];
  protected $perPage = 8;

  public function grupoConta(): object
  {
    return $this->belongsTo(Grupoconta::class);
  }

  public function movtoContas(): object
  {
    return $this->hasMany(Movtoconta::class);
  }

  public function setNomeAttribute($nome)
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

  public function listar(): object
  {
    return $this->query()->orderby('id')
           ->paginate($this->perPage);
  }

  public function search(array $conta): object
  {
    $dados = $this->query()
    ->where('id', '>=', 1)->paginate();

    switch ($conta) {
      case isset($conta['nome']):
        $dados = $this->query()
        ->where('nome', 'like', '%'.$conta['nome'].'%')
        ->paginate($this->perPage);
      break;

      case isset($conta['grupoconta']):
        $dados = $this->query()
        ->where('grupoconta_id', $conta['grupoconta'])
        ->paginate($this->perPage);
      break;
     }

     return $dados;
  }

  public function updateStatus($conta_id): void
  {
    $c = $this::find($conta_id);
    $c->status ? $c->status = false
               : $c->status = true;
    $c->save();

    return;
  }

  public function movtosMonth(int $ano, int $mes):array
  {
    $movtos = DB::select("
      SELECT grupo, tipo, total, data 
      FROM vw_lancamentoContas 
      WHERE year(data) = $ano
      AND month(data) = $mes");

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
      SELECT SUM(valor) FROM vw_ReceitasTotal
      WHERE YEAR(data) = $ano
      AND MONTH(data) = $mes");

    $total = Helper::recuperaValor($query);

    return $total;
  }

  public function despesa(int $ano, int $mes):float
  {
    $query = DB::select("
      SELECT SUM(valor) FROM vw_DespesasTotal
      WHERE YEAR(data) = $ano
      AND MONTH(data) = $mes");

    $total = Helper::recuperaValor($query);

    return $total;
  }

  public function recuperaContas(string $tipo):object
  {
    $contas = DB::table('contas')
    ->leftjoin('movtocontas', 'movtocontas.conta_id', 
                              'contas.id')
    ->select('contas.nome', 'contas.status', 'contas.tipo',
             'movtocontas.valor', 'movtocontas.data')
    ->where('contas.tipo', $tipo)
    ->whereOr(DB::raw('month(movtocontas.data)'), 5)
    ->orderby('contas.nome')
    ->paginate();

    return $contas;
  }
}
