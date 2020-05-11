<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\{Conta,Movtoconta, Painel};
use App\Http\Requests\Painel\PainelSearch;
use Illuminate\Http\Request;
use App\Service\Helper;

class PaineisController extends Controller
{
  private $receita;

  public function __construct()
  {
     $this->receita = (new Conta())
     ->receita(Date('Y'), Date('m'));
  }

  public function show():object
  {
    $movtos = (new Movtoconta())->show();
    $contas = Conta::all();

    return view('painel.show', compact('movtos', 'contas'));
  }

  public function meta():object
  {
    $parametros = $this->getParametros();
    $valorAnual = $this->getValorAnual();

    return view('painel.consumo', 
      compact('parametros', 'valorAnual'));    
  }

  public function getParametros():array
  {
     $parametros = [

      'Consumo' => [
        'limite' => $this->receita * 0.60,
        'porcentagem' => '60%',
        'gastos' => $this->getConsumo('Consumo')
      ],

      'Diversao' => [
        'limite' => $this->receita * 0.10,
        'porcentagem' => '10%',
        'gastos' => $this->getConsumo('Diversao')
      ],

      'Curso' => [
        'limite' => $this->receita * 0.05,
        'porcentagem' => '5%',
        'gastos' => $this->getConsumo('Cursos')
      ],   
    ];
    
    return $parametros;   	
  }

  public function getConsumo(string $meta):float
  {
     $valor = (new Painel())
     ->recuperaConsumo($meta, Date("Y"), Date("m"));

     return $valor;
  }

  public function getValorAnual():array
  {
    $anual = [
      'receita' => (new Painel())->recuperaReceita(Date("Y")),
      'despesa' => (new Painel())->recuperaDespesa(Date("Y")) 
    ];

    return $anual;       
  }

  public function ranking():object
  {
    $contasList = 
      (new Painel())->rankingContas(date('Y'), date('m'));

    return view('painel.ranking', compact('contasList'));    
  }

  public function search(PainelSearch $req):object
  {
    $dadosReq = $req->except('_token');
    $data = (new Helper())->recuperaData($dadosReq);
    
    $contasList = (new Painel())->searchRanking(
    $data['ano'], $data['mes']);

    return view('painel.ranking', 
      compact('contasList', 'dadosReq'));
  }

  public function grafico():object
  {
    $dados = (new Painel())->graficoGeral();
   
    return view('painel.grafico', compact('dados'));  
  }

  public function graficoPeriodo(Request $req)
  {
    if(is_null($req->data))
      return $this->grafico();

    $data = 
      (new Helper())->recuperaData($req->except('_token'));

    $dados = (new Painel())
    ->graficoPerido($data['ano'],$data['mes']);

    return view('painel.grafico', compact('dados'));    
  }
}
