<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;


class Grupoconta extends Model
{
  protected $fillable = ['nome', 'tipo', 'stauts', 
                         'classificacao', 'user_id'];
  
  protected $perPage = 8;

  public function user(): object
  {
    return $this->belongsTo(User::class);
  }

  public function contas(): object
  {
    return $this->hasMany(Conta::class);
  }

  public function listar(): object
  {
    return $this::query()->orderBy('id')->paginate();
  }

  public function store_g(array $dados):bool
  {
    try{
      $this::create($dados);
    }catch(\Exception $e){
      return false;
    }
    return true;

  }

  public function setNomeAttribute($nome)
  {
    $this->attributes['nome'] = mb_strtoupper($nome);
  }

  public function search($nome): object
  {
    if(empty($nome))
      return $this->listar();

    $grupos =
      Grupoconta::where('nome', 'like', '%'.$nome.'%')
      ->paginate($this->perPage);

    return $grupos;
  }

  public function updateStatus($grupoconta_id): void
  {
    $g = $this::find($grupoconta_id);
    $g->status ? $g->status = false
               : $g->status = true;
    $g->save();

    return;
  }
}
