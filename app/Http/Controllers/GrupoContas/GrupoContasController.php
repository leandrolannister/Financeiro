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

      try{
      	Grupoconta::create($dados);
      }catch(\Exception $e){
         return redirect()->route('grupocontas.index')
         ->with('error', 'A Conta não foi cadastrada!');
      }

      return redirect()->route('grupocontas.index')
      ->with('success', "Conta cadastrada com sucesso.");
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
      $grupo = Grupoconta::find($req->id);

      try{
        $grupo->fill($req->all());
        $grupo->save();
      }catch(\Exception $e){
        return redirect()
        ->route('grupocontas.show')
        ->with('error', 'Grupo de Conta Não foi Atualizado!');
      }

      return redirect()
        ->route('grupocontas.show')
        ->with('success', 'Grupo de Conta Atualizado');
    }

    public function turn(Request $req):object
    {
      (new Grupoconta())->updateStatus($req->id);

       return redirect()
        ->route('grupocontas.show')
        ->with('success', 'Grupo de Conta Atualizado');
    }

    public function destroy(Request $req):object
    {
      if(Grupoconta::destroy($req->id)):
        return redirect()
        ->route('grupocontas.show')
        ->with('success', 'Grupo de Conta foi excluído');  
      endif; 

      return redirect()
      ->route('grupocontas.show')
      ->with('error', 'Grupo de Conta não foi excluído');
    }    
}
