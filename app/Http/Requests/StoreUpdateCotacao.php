<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateCotacao extends FormRequest
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
            'uf'                    => 'required',
            'porcentual_cotacao'    => 'required',
            'valor_extra'           => 'required',
            'transportadora_id'     => 'required',

        ];
    }

    public function messages()
    {
        return [
            "uf.required"                   =>"O campo uf não pode ficar vazio",
            "porcentual_cotacao.required"  =>"O campo porcentual_cotacao não pode ficar vazio",
            "valor_extra.required"          =>"O campo valor_extra não pode ficar vazio",
            "transportadora_id.required"    =>"O campo transportadora_id não pode ficar vazio",

        ];
    }
}

/**
 * Antes era assim
 * 'transportadora_id'     => ['required', 'exists:transportadoras, id'],
 * 'uf'                    => ['required', "unique:cotacao_fretes, {$id}, id"],
 * 'uf'                    => ['required', "unique:cotacao_fretes"],
 * 'transportadora_id'     => ['required', "unique:cotacao_fretes"],
 */
