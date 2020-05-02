<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\{Conta,Movtoconta, Painel};
use Illuminate\Http\Request;

class PaineisController extends Controller
{
  private $receita;

  public function __construct()
  {
     $this->receita = (new Conta())->receita(Date('Y'), Date('m'));
  }

  public function show()
  {
    $movtos = (new Movtoconta())->show();
    $contas = Conta::all();

    return view('painel.show', compact('movtos', 'contas'));
  }

  public function meta()
  {
    $parametros = $this->getParametros();
    $valorAnual = $this->getValorAnual();

    return view('painel.consumo', 
      compact('parametros', 'valorAnual'));    
  }

  public function getParametros()
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

  public function getValorAnual()
  {
    $anual = [
      'receita' => (new Painel())->recuperaReceita(Date("Y")),
      'despesa' => (new Painel())->recuperaDespesa(Date("Y")) 
    ];
    return $anual;       
  }
}
