<?php

namespace App\Http\Requests\Orgao;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrgaoRequest extends FormRequest
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
            'cnpj' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'cnpj.required' => 'Informe o CNPJ do orgão',
            'cnpj.string' => 'O CNPJ deve ser string'
        ];
    }
}
