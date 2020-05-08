<?php

namespace App\Http\Controllers\Conta;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContaRequest;
use App\Http\Requests\ValidateId;
use App\Models\{Grupoconta, Conta, MovtoConta};
use Illuminate\Http\Request;
use App\Service\Helper;

class ContasController extends Controller
{
    public function index():object
    {
       $grupoContas = 
       Grupoconta::query()->orderBy('id', 'desc')->get();

       return view('admin.conta.index', compact('grupoContas'));
    }

    public function store(ContaRequest $req):object
    {
      return (new Conta())->store_c($req->except('_token'))

      ? (new Helper())->mensagem('conta.show', 'success', 
                                 'Conta cadastrada.')  

      : (new Helper())->mensagem('conta.show', 'error', 
                                 'A Conta não foi atualizada!');
    }

    public function show():object
    {
       $contaList = (new Conta())->listar();
       $helper = new Helper();
       $grupocontas = Grupoconta::all();
       
       return view('admin.conta.show', 
              compact('contaList', 'helper', 'grupocontas'));
    }

    public function search(Request $req):object
    {
      $contas = $req->except('_token');

      $contaList = (new Conta())->search($contas);
      $helper = new Helper();
      $grupocontas = Grupoconta::all();

      return view('admin.conta.show',compact('contaList', 
        'helper','grupocontas', 'contas'));
    }

    public function upgrade(ValidateId $req):object
    {
      $conta = Conta::find($req->id);
      $grupocontas = Grupoconta::all();

      return view('admin.conta.upgrade', 
             compact('conta', 'grupocontas'));  
    }    

    public function update(ValidateId $req):object
    {
      return  (new Conta())->update_c($req)

      ? (new Helper())->mensagem('conta.show', 'success', 
                                 'Conta atualizada.')  

      : (new Helper())->mensagem('conta.show', 'error', 
                                 'A Conta não foi atualizada!');
    } 

    public function turn(ValidateId $req):object
    {
      return (new Conta())->updateStatus($req->id)

      ? (new Helper())->mensagem('conta.show', 'success', 
                                 'Conta atualizada.')  

      : (new Helper())->mensagem('conta.show', 'error', 
                                 'Conta não foi atualizada!'); 
    }

    public function destroy(ValidateId $req):object
    {
      if((new MovtoConta())->procuraMovtoConta($req->id))
        
        return (new Helper())->mensagem('conta.show', 'error', 
        'Conta possui movimentos não pode ser excluída.');

      return $this->delete($req);
    }
    
    private function delete($conta):object
    {
      return Conta::destroy($req->id)

      ? (new Helper())->mensagem('conta.show', 'success', 
                                 'Conta excluída.')  

      : (new Helper())->mensagem('conta.show', 'error', 
                                 'A Conta não foi excluída!');
    }  

    public function saldo():object 
    {
      $dados = (new Conta())->movtosMonth(Date('Y'),Date('m'));
      $saldo = (new Conta())->getSaldo(Date('Y'), Date('m'));
      $helper = (new Helper());

      return view('conta.saldo', 
             compact('dados', 'saldo', 'helper'));            
    } 

    public function saldosearch(Request $req):object
    {
      $data = 
       (new Helper())->recuperaData($req->except('_token'));

      $dados = (new Conta())
      ->movtosMonth($data['ano'], $data['mes']);
      
      $saldo = (new Conta())
      ->getSaldo($data['ano'], $data['mes']);
      
      $helper = (new Helper());

      return view('conta.saldo', 
             compact('dados', 'saldo', 'helper'));  
    }

    public function contasObrigatorias():object
    {
       $contaList = (new Conta())->recuperaContas('Obrigatorio');
       $helper = (new Helper());
       
       return view('admin.conta.contasObrigatorias', 
        compact('contaList', 'helper'));
    }      
}
