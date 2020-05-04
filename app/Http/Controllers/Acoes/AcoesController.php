<?php

namespace App\Http\Controllers\Acoes;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcoesReq;
use App\Http\Requests\ValidateId;
use App\Http\Requests\AcoesUpdate;  
use Illuminate\Http\Request;

use App\Models\{Acoes};
use App\Service\Helper;

class AcoesController extends Controller
{
    public function index()
    {
       $acoesList = Acoes::query()->orderBy('dt_compra', 'desc')
       ->paginate();
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
        ->with('success', 'A Ação foi cadastrada com sucesso');

        return redirect()->route('acoes.create')
        ->with('error', 'A ação não foi cadastrada');  
    }

    public function upgrade(ValidateId $req)
    {
       $acao = Acoes::find($req->id);
       return view('admin.acoes.upgrade', compact('acao'));
    }

    public function update(AcoesUpdate $req)
    {
       if((new Acoes())->update_a($req->except('_token')))
         return redirect()->route('acoes.index')
         ->with('success', 'A Ação foi atualizado com sucesso');

       return redirect()->route('acoes.create')
        ->with('error', 'A ação não foi atualizada');    
    }

    public function destroy(ValidateId $req)
    {
       if(Acoes::destroy($req->id))
         return redirect()->route('acoes.index')
         ->with('success', 'A Ação foi deletado com sucesso');

       return redirect()->route('acoes.create')
        ->with('error', 'A Ação não foi deletada');    
    }
}
