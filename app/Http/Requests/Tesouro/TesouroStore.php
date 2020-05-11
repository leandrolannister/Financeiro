<?php

namespace App\Http\Requests\Tesouro;

use Illuminate\Foundation\Http\FormRequest;

class TesouroStore extends FormRequest
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
         'nome' => 'required',
         'compra' => 'required|numeric',
         'venda' => 'required|numeric',
         'dt_compra' => 'required'
       ];
    }
}
