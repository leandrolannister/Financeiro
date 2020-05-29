<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\User;
use DB;

class Movtoconta extends Model
{
  protected $fillable = ['tipo', 'valor', 
  'valor_acumulado','conta_id', 'user_id', 
  'comentario', 'data'];

  protected $perPage = 7;

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

  public function search(array $dados):object
  {    
    $query = function($dados){
      
      if(isset($dados['nome']))
        return Conta::query()
        ->where('nome', 'like', '%'.$dados['nome'].'%')
        ->where('status', 1)
        ->paginate($this->perPage); 

      if(isset($dados['grupoconta_id']))
        return Conta::query()
        ->where('grupoconta_id', $dados['grupoconta_id'])
        ->where('status', 1)
        ->paginate();

      if(empty($dados['nome']) and 
         empty($dados['grupoconta_id']))
           return Conta::query()
           ->where('id', '>', 0)
           ->where('status', 1)
           ->paginate();
    };

    return $query($dados);
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
    $query = function($dados){
      if(isset($dados['grupo_id']))
        return 
        $movtos = DB::table('grupoContas as g')
        ->join('contas as c', 'c.grupoconta_id', 'g.id')
        ->join('movtocontas as m', 'm.conta_id', 'c.id')
        ->select('c.nome as conta_id', 'm.valor', 
                 'm.valor_acumulado', 'm.data', 'm.id', 'm.comentario')
        ->where('g.id', $dados['grupo_id'])
        ->paginate($this->perPage);  

      if(isset($dados['conta_id']))
        return 
        $movtos = $this::where('conta_id', $dados['conta_id'])
        ->orderBy('valor_acumulado', 'desc')->paginate(); 

      if(isset($dados['data'])) 
        return
        $movtos = $this::where('data', $dados['data'])
        ->orderBy('valor_acumulado', 'desc')->paginate();
        
      return 
        $movtos = $this::query()->orderBy('id', 'desc')
        ->paginate(); 
     };

     return $query($dados);
  }

  public function procuraMovtoConta(int $conta_id):bool
  {
    $query = $this->where('conta_id', $conta_id)->get()->first();

    return isset($query) ? true : false;
  } 

  public function procuraMovtoGrupo(int $grupo_id):bool
  {
    $query = DB::table('grupoContas as g')
    ->join('contas as c', 'c.grupoconta_id', 'g.id')
    ->join('movtocontas as m', 'm.conta_id', 'c.id')
    ->select('g.id')
    ->where('g.id', $grupo_id)
    ->get()->first();

    return isset($query) ? true : false;
  }

  public function recuperaSaldoGrupo(array $dados, int $mesRef)
  :?object
  {
    $query = function($dados, $mesRef){
       if(isset($dados['grupo_id']))
         return
         $saldo = DB::table('grupoContas as g')
         ->join('contas as c', 'c.grupoconta_id', 'g.id')
         ->join('movtocontas as m', 'm.conta_id', 
          'c.id')
         ->select(DB::raw('FORMAT(SUM(m.valor),2) as total'))
         ->where('g.id', $dados['grupo_id'])
         ->where(DB::raw('MONTH(m.data)'), $mesRef)
         ->groupBy('g.id') 
         ->get();
    };

    return $query($dados, $mesRef);
  } 
}
