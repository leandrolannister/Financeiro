<?php

namespace App\Http\Controllers\Tesouro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TesouroRequest;
use App\Http\Requests\TesouroReqAll;
use App\Http\Requests\ValidateId;
use App\Models\Tesouro;
use App\Service\Helper;

class TesourosController extends Controller
{
    public function index()
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

    public function store(TesouroRequest $req):object
    { 
      if((new Tesouro())->store_t($req->except(['_token'])))
         return redirect()->route('tesouro.index')
         ->with('success', 'O papel cadastrado com sucesso.');

      return redirect()->route('tesouro.index')
      ->with('error', 'O papel não foi cadastrado!');   	
    }

    public function upgrade(ValidateId $req):object
    {
      $papel = Tesouro::find($req->id);
           
      return view('admin.tesouro.upgrade', 
      	compact('papel')); 
    }

    public function update(TesouroReqAll $req):object
    {
       if((new Tesouro())->update_t($req->all()))
         return redirect()->route('tesouro.index')
         ->with('success', 'O papel foi atualizado com sucesso.');

       return redirect()->route('tesouro.index')
         ->with('error', 'O papel não foi atualizado!');	   	
    }

    public function destroy(ValidateId $req):object
    {
       if(Tesouro::destroy($req->id))
         return redirect()->route('tesouro.index')
         ->with('success', 'O papel foi deletado com sucesso.');

       return redirect()->route('tesouro.index')
         ->with('error', 'O papel não foi deletado!');      
    }
}
