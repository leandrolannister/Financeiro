<?php

namespace App\Http\Controllers\GrupoContas;

use App\Http\Controllers\Controller;
use App\Http\Requests\GrupoContasRequest;
use App\Models\Grupoconta;
use Illuminate\Http\Request;
use App\Service\Helper;


class GrupoContasController extends Controller
{
    public function index():object
    {
      $user = auth()->user();
     
      return view('admin.grupocontas.index', 
        compact('user'));
    }

    public function store(GrupoContasRequest $req):object
    {
      $dados = $req->all();
      $dados['user_id'] = auth()->user()->id;

      if((new Grupoconta())->store_g($req->except('_token')))
        return redirect()->route('grupocontas.index')
        ->with('success', "Conta cadastrada com sucesso.");  

      return redirect()->route('grupocontas.index')
      ->with('error', 'A Conta não foi cadastrada!');
           
    }

    public function show():object
    {
      $grupocontasList = (new Grupoconta())->listar();

      $helper = (new Helper());

      return view('admin.grupocontas.show',
        compact('grupocontasList', 'helper'));
    }

    public function search(Request $req):object
    {
      $grupos = $req->except('_token');

      $grupocontasList = (new Grupoconta())->search($req->nome);

      $grupoconta = (new Grupoconta());

      $helper = (new Helper());

      return view('admin.grupocontas.show',
        compact('grupocontasList', 'grupoconta', 
                'grupos', 'helper'));
    }

    public function upgrade(Request $req):object
    {
      $grupo = Grupoconta::find($req->grupoconta_id);

      return view('admin.grupocontas.upgrade',
              compact('grupo'));
    }

    public function update(Request $req):object
    {
      if((new Grupoconta())->update_g($req)):
        return redirect()
        ->route('grupocontas.show')
        ->with('success', 'Grupo de Conta Atualizado.');
      endif;

      return redirect()
        ->route('grupocontas.show')
        ->with('error', 'Grupo de Conta Não foi Atualizado!');
    }

    public function turn(Request $req):object
    {
      if((new Grupoconta())->updateStatus($req->id)):
        return redirect()
        ->route('grupocontas.show')
        ->with('success', 'Grupo de Conta Atualizado.');
      endif;

      return redirect()
        ->route('grupocontas.show')
        ->with('error', 'Grupo não foi Atualizado!');
    }

    public function destroy(Request $req):object
    {
      if(Grupoconta::destroy($req->id)):
        return redirect()
        ->route('grupocontas.show')
        ->with('success', 'Grupo de Conta foi excluído.');  
      endif; 

      return redirect()
      ->route('grupocontas.show')
      ->with('error', 'Grupo de Conta não foi excluído!');
    }    
}
