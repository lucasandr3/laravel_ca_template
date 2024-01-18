<?php

namespace App\Http\Requests\Unidade;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnidadeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codigoUnidade' => ['required', 'int'],
            'nomeUnidade' => ['required', 'string'],
            'codigoIBGE' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'codigoUnidade.required' => 'Informe o código da unidade compradora.',
            'codigoUnidade.int' => 'Informe o código deve ser um número inteiro.',
            'nomeUnidade.required' => 'Informe o nome da unidade.',
            'nomeUnidade.string' => 'O nome da unidade deve ser uma string',
            'codigoIBGE.required' => 'Informe o código do IBGE da unidade'
        ];
    }
}
