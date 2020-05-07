<?php

namespace App\Http\Controllers\GrupoContas;

use App\Http\Controllers\Controller;
use App\Http\Requests\GrupoContasRequest;
use App\Models\{Grupoconta, Movtoconta, Conta};
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

      return (new Grupoconta())->store_g($req->except('_token'))

      ? (new Helper())->mensagem('grupocontas.index', 'success', 
                                 'Grupo cadastrado.')  

      : (new Helper())->mensagem('grupocontas.index', 'error', 
                                 'Grupo não foi cadastrado!');
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
        compact('grupocontasList', 'grupoconta','grupos', 
                'helper'));
    }

    public function upgrade(Request $req):object
    {
      $grupo = Grupoconta::find($req->grupoconta_id);

      return view('admin.grupocontas.upgrade',
              compact('grupo'));
    }

    public function update(Request $req):object
    {
      return (new Grupoconta())->update_g($req)

      ? (new Helper())->mensagem('grupocontas.show', 'success', 
                                 'Grupo atualizado.')  

      : (new Helper())->mensagem('grupocontas.show', 'error', 
                                 'Grupo não foi atualizado!');
    }

    public function turn(Request $req):object
    {
      return (new Grupoconta())->updateStatus($req->id)

      ? (new Helper())->mensagem('grupocontas.show', 'success', 
                                 'Grupo atualizado.')  

      : (new Helper())->mensagem('grupocontas.show', 'error', 
                                 'Grupo não foi atualizado!');
    }

    public function destroy(Request $req):object
    {
      if((new Movtoconta())->procuraMovtoGrupo($req->id))
        
        return (new Helper())->mensagem('grupocontas.show', 
        'error', 'Grupo possui contas com movimento não pode ser excluído!'); 
      
      if((new Conta())->procuraGrupo($req->id))
        return (new Helper())->mensagem('grupocontas.show', 
        'error', 'Grupo possui contas vinculadas não pode ser excluído!');

        return $this->delete($req);
     }
     
     private function delete($grupo):object
     {
       return Grupoconta::destroy($req->id)

       ? (new Helper())->mensagem('grupocontas.show', 'success', 
                                  'Grupo excluído.')  

       : (new Helper())->mensagem('grupocontas.show', 'error', 
                                  'Grupo não foi excluído!');
     } 
       
}
