<?php

namespace App\Http\Controllers\Acoes;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcoesReq;
use App\Http\Requests\AcoesUpgrade;
use App\Http\Requests\AcoesUpdate;  
use Illuminate\Http\Request;

use App\Models\{Acoes};
use App\Service\Helper;

class AcoesController extends Controller
{
    public function index()
    {
       $acoesList = Acoes::all();
       $helper = (new Helper());

       return view('admin.acoes.index', 
        compact('acoesList', 'helper'));
    }

    public function create()
    {
      return view('admin.acoes.create');
    }

    public function store(AcoesReq $req)
    {
      if((new Acoes())->store_a($req->except('_token')))
        return redirect()->route('acoes.index')
        ->with('success', 'O Papel foi cadastrada com sucesso');

        return redirect()->route('acoes.create')
        ->with('error', 'A ação não foi cadastrada');  
    }

    public function upgrade(AcoesUpgrade $req)
    {
       $acao = Acoes::find($req->id);
       return view('admin.acoes.upgrade', compact('acao'));
    }

    public function update(AcoesUpdate $req)
    {
       if((new Acoes())->update_a($req->except('_token')))
         return redirect()->route('acoes.index')
         ->with('success', 'O Papel foi atualizado com sucesso');

       return redirect()->route('acoes.create')
        ->with('error', 'A ação não foi atualizada');    
    }
}
