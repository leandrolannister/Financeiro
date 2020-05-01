<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\{GrupoConta, MovtoConta};
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function grupoContas()
    {
      return $this->hasMany(GrupoConta::class);
    }

    public function movtoContas()
    {
      return $this->hasMany(MovtoConta::class);
    }

    public function update_u(array $dados): void
    {
      $user = self::find(auth()->user()->id);

      if(is_null($dados['password'])):
        unset($dados['password']);
      else:  
        $user->password = Hash::make($dados['password']);
      endif;
       
      $user->nome  = $dados['name'];
      $user->email = $dados['email'];
      $user->save();
    }
}
