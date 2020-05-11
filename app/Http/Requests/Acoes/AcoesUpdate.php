<?php

namespace App\Http\Requests\Acoes;

use Illuminate\Foundation\Http\FormRequest;

class AcoesUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      return [
        'id' => 'required|numeric',    
        'papel'  => 'required',
        'compra' => 'required|numeric',
        'quantidade' => 'required|numeric',
        'dt_compra' => 'required'
      ];
    }
}
