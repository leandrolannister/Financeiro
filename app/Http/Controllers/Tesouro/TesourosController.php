<?php

namespace App\Http\Controllers\Tesouro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Tesouro\TesouroStore;
use App\Http\Requests\Tesouro\TesouroUpdate;
use App\Http\Requests\ValidateId;
use App\Models\Tesouro;
use App\Service\Helper;

class TesourosController extends Controller
{
    public function index():object
    {
       $tesourosList = (new Tesouro())->list();
       $helper = (new Helper());

       return view('admin.tesouro.index', 
       	compact('tesourosList', 'helper'));
    }

    public function create():object
    {
       return view('admin.tesouro.create');
    }

    public function store(TesouroStore $req):object
    { 
      return (new Tesouro())
      ->store_t($req->except(['_token']))

      ? (new Helper())->mensagem('tesouro.index', 'success', 
                                 'Papel cadastrado.')  

      : (new Helper())->mensagem('tesouro.index', 'error', 
                              'Papel não foi cadastrado!');
    }

    public function upgrade(int $id):object
    {
      $papel = Tesouro::find($id);
           
      return view('admin.tesouro.upgrade', 
      	compact('papel')); 
    }

    public function update(TesouroUpdate $req):object
    {
      return (new Tesouro())->update_t($req->except('_token'))

      ? (new Helper())->mensagem('tesouro.index', 'success', 
                               'Papel atualizado.')  

      : (new Helper())->mensagem('tesouro.index', 'error', 
                              'Papel não foi atualizado!');
    }

    public function destroy(ValidateId $req):object
    {
      return Tesouro::destroy($req->id)

      ? (new Helper())->mensagem('tesouro.index', 'success', 
                               'Papel excluído.')  

      : (new Helper())->mensagem('tesouro.index', 'error', 
                              'Papel não foi excluído!');
    }
}
