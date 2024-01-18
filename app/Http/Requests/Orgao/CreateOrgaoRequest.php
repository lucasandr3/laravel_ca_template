<?php

namespace App\Http\Requests\Orgao;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrgaoRequest extends FormRequest
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
            'cnpj' => ['required'],
            'razaoSocial' => ['string', 'required'],
            'poderId' => ['string', 'max:1', 'required'],
            'esferaId' => ['string', 'max:1', 'required']
        ];
    }

    public function messages(): array
    {
        return [
            'cnpj.required' => 'Informe o CNPJ do Orgão',
            'razaoSocial.string' => 'A razão social deve ser string',
            'razaoSocial.required' => 'Informe a razão social do orgão',
            'poderId.string' => 'O Poder deve ser string',
            'poderId.max' => 'O tamanho máximo permitido e 1 caractere',
            'poderId.required' => 'Informe o poder do orgão',
            'esferaId.string' => 'A esfera deve ser string',
            'esferaId.max' => 'O tamanho máximo permitido e 1 caractere',
            'esferaId.required' => 'Informe o esfera do orgão',
        ];
    }
}
