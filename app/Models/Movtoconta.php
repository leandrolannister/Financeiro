<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\User;

class Movtoconta extends Model
{
  protected $fillable = ['tipo', 'valor', 'valor_acumulado',
  'conta_id', 'user_id', 'data'];

  protected $perPage = 8;

  public function conta():object
  {
    return $this->belongsTo(Conta::class);
  }

  public function user():object
  {
    return $this->belongsTo(User::class);
  }

  public function listarConta():object
  {
  	$contas = Conta::where('status', 1)->orderBy('tipo')
  	->paginate($this->perPage);

  	return $contas;
  }

  public function listarGrupo():object
  {
     $grupos = Grupoconta::where('status', 1)->get();

     return $grupos;
  }

  public function search(array $contas):object
  {
    $dados = Conta::query()
    ->where('id', '>=', 1)
    ->where('status', 1)
    ->paginate();

    switch ($contas) {

      case isset($contas['nome']):
        $dados = Conta::query()
        ->where('nome', 'like', '%'.$contas['nome'].'%')
        ->where('status', 1)
        ->paginate($this->perPage);
      break;

      case isset($contas['grupoconta_id']):
        $dados = Conta::query()
        ->where('grupoconta_id', $contas['grupoconta_id'])
        ->where('status', 1)
        ->paginate();
      break;
    }

    return $dados;
  }

  public function store_m(array $movto):bool
  {
    try{
      
      if($movto['valor'] < 1)
        throw new \Exception();

      if(empty(Conta::find($movto['conta_id'])))
        throw new \Exception();  

      $movto['tipo'] = 'E';

      $movto['valor_acumulado'] =
      $this->ultimoLancamento($movto['conta_id']);

      $movto['valor_acumulado'] += $movto['valor'];
      $movto['user_id'] = auth()->user()->id;
      $movto['data'] = date('Y-m-d');

      $this::create($movto);
    }catch(\Exception $e){
      return false;
    }

    return true;
  }

  private function ultimoLancamento(int $conta_id):float
  {
    $dado = Movtoconta::where('conta_id', $conta_id)
    ->where('user_id', auth()->user()->id)
    ->get()->last();

    return (float) $dado['valor'];
  }

  public function show(): object
  {
    $dados = $this::query()->orderBy('id', 'desc')
    ->with('conta')->paginate();

    return $dados;
  }

  public function getTipoAttribute():string
  {
    switch ($this->attributes['tipo']) {
      case 'E':
        return "Entrada";
        break;

      case 'S':
        return "Saída";
        break;

      case 'T':
        return "Transferência";
        break;
    }
  }

  public function getContaIdAttribute():string
  {
    $conta = Conta::find($this->attributes['conta_id']);

    return $conta->nome;
  }

  public function getUserIdAttribute():string
  {
    $user = User::find($this->attributes['user_id']);

    return $user->nome;
  }

  public function getDataAttribute():string
  {
    return Carbon::parse(
    $this->attributes['data'])->format('d/m/Y');
  }

  public function searchForLancamento(array $dados):object
  {
     $movtos = $this::query()->orderBy('id', 'desc')
     ->paginate();

     switch($dados){
      case isset($dados['conta_id']):
        $movtos =
        $this::where('conta_id', $dados['conta_id'])
        ->orderBy('valor_acumulado', 'desc')->paginate();
        break;

      case isset($dados['data']):
        $movtos =
        $this::where('data', $dados['data'])
        ->orderBy('valor_acumulado', 'desc')->paginate();
        break;
     }

     return $movtos;
  }  
}
