<?php

namespace App\Http\Controllers\Conta;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContaRequest;
use App\Http\Requests\Contas as ContasReq;
use App\Models\{Grupoconta, Conta};
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
      if((new Conta())->store_c($req->all()))
        return redirect()->route('conta.index')
        ->with('success', 'A conta foi cadastrada com sucesso.');

      return redirect()->route('conta.index')
        ->with('error', 'A conta não foi cadastrada!');   
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

      $contaList = (new Conta())->search($req->all());
      $helper = new Helper();
      $grupocontas = Grupoconta::all();

      return view('admin.conta.show',compact('contaList', 
        'helper','grupocontas', 'contas'));
    }

    public function upgrade(ContasReq $req):object
    {
      $conta = Conta::find($req->id);
      $grupocontas = Grupoconta::all();

      return view('admin.conta.upgrade', 
             compact('conta', 'grupocontas'));  
    }

    public function update(ContasReq $req):object
    {
      $conta = Conta::find($req->id);
            
      try{
        $conta->fill($req->all());
        $conta->save();
      }catch(\Exception $e){
        return redirect()
        ->route('conta.show')
        ->with('error', 'A conta não foi Atualizada!');
      }

      return redirect()
        ->route('conta.show');        
    } 

    public function turn(ContasReq $req):object
    {
     (new Conta())->updateStatus($req->id);   
      
      return redirect()
      ->route('conta.show')
      ->with('success', 'A Conta foi atualizada');
    }

    public function destroy(ContasReq $req):object
    {
      if(Conta::destroy($req->id)):
        return redirect()
        ->route('conta.show')
        ->with('success', 'A conta foi excluída');     
      endif; 

      return redirect()
      ->route('conta.show')
      ->with('error', 'A conta não foi excluída');        
    }  

    public function saldo():object 
    {
      $dados = (new Conta())->movtosMonth(Date('Y'),Date('m'));
      $saldo = (new Conta())->getSaldo(Date('Y'), Date('m'));
      $helper = (new Helper());

      return view('conta.saldo', 
             compact('dados', 'saldo', 'helper'));            
    } 

    public function saldosearch(Request $req)
    {
      $data = explode('-', $req->data);
      $ano = $data[0];
      $mes = $data[1];

      $dados = (new Conta())->movtosMonth($ano, $mes);
      $saldo = (new Conta())->getSaldo($ano, $mes);
      $helper = (new Helper());

      return view('conta.saldo', 
             compact('dados', 'saldo', 'helper'));  
    }

    public function contasObrigatorias()
    {
       $contaList = (new Conta())->recuperaContas('Obrigatorio');
       $helper = (new Helper());
       
       return view('admin.conta.contasObrigatorias', 
        compact('contaList', 'helper'));
    }     
}
