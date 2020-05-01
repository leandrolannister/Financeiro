<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
use App\User;

class UsuariosController extends Controller
{
    public function index():object 
    {
       $user = auth()->user();

       return view('admin.usuario.index', compact('user'));
    }

    public function update(UsuarioRequest $req):object
    {       
      try{
       (new User())->update_u($req->all());
      }catch(\Exception $e){
        return redirect()->route('usuario.index')
        ->with('error', 'Usuário não foi atualizado');
      } 
      
      return redirect()->route('usuario.index')
      ->with('success', 'Usuário atualizado com sucesso');      
    }
}
