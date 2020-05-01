<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acoes extends Model
{
    protected $fillable = ['papel', 'quantidade', 'compra', 'venda',
                           'dt_compra', 'dt_venda'];
}
