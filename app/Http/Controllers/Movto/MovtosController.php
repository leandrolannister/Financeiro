<?php

namespace App\Http\Controllers\Movto;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateId;
use Illuminate\Http\Request;
use App\Models\{Conta, Movtoconta, GrupoConta};
use App\Service\Helper;

class MovtosController extends Controller
{
   public function contas():object
   {
      $contaList = (new Movtoconta())->listarConta();
      $grupoList = (new Movtoconta())->listarGrupo();
      $helper = new Helper();

      return view('movto.conta',
      	compact('contaList', 'helper', 'grupoList'));
   }

   public function search(Request $req):object
   {
      $contas = $req->except('_token');

      $contaList = (new Movtoconta)->search($req->all());
      $grupoList = (new Movtoconta())->listarGrupo();
      $helper = new Helper();

      return view('movto.conta',
      	compact('contaList', 'helper','grupoList', 'contas'));
   }

   public function deposito(Request $req):object
   {
     return 
     
     (new Movtoconta())->store_m($req->except('_token'))

     ? (new Helper())->mensagem('movto.conta', 'success', 
                                'Lançamento com sucesso efetuado.')  

     : (new Helper())->mensagem('movto.conta', 'error', 
                       'Lançamento não foi efetuado!');
   }   

   public function searchForLancamento(Request $req):object
   {
     $movtos = (new Movtoconta())
     ->searchForLancamento($req->except('_token'));

     $contas = Conta::all();
     $grupos = GrupoConta::all();

     $movto = $req->except('_token');
     $saldo = (new Movtoconta())
     ->recuperaSaldoGrupo($req->all(), date('m'));
     

     return view('painel.show', compact('movtos', 'contas',
                                        'movto', 'grupos', 'saldo'));
   }

   public function destroy(ValidateId $req):object
   {
      return Movtoconta::destroy($req->id)

      ? (new Helper())->mensagem('movto.show', 'success', 
                               'Lançamento excluído.')  

      : (new Helper())->mensagem('movto.show', 'error', 
                              'Lançamento não foi excluído!');
   }
}
