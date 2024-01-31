<?php

namespace App\Http\Requests\Contrato;

use Illuminate\Foundation\Http\FormRequest;

class DeleteContractRequest extends FormRequest
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
            'processo' => 'required',
            'sequencialContrato' => 'required',
            'justificativa' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'processo.required' => 'Informe o processo',
            'sequencialContrato.required' => 'Informe o contrato',
            'justificativa.required' => 'Informe a justificativa',
        ];
    }
}
