<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\UsuarioUpdate;
use App\User;
use App\Service\Helper;

class UsuariosController extends Controller
{
    public function index():object 
    {
       $user = auth()->user();

       return view('admin.usuario.index', compact('user'));
    }

    public function update(UsuarioUpdate $req):object
    {       
      return (new User())->update_u($req->all())

      ? (new Helper())->mensagem('usuario.index', 'success', 
                               'Usuário cadastrado.')  

      : (new Helper())->mensagem('usuario.index', 'error', 
                              'Usuário não foi cadastrado');
    }
}
