<?php

namespace App\Http\Requests\Contrato;

use Illuminate\Foundation\Http\FormRequest;

class PostDocumentContractRequest extends FormRequest
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
            'contrato' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'processo.required' => 'Informe o código do processo',
            'contrato.required' => 'Informe o sequencial do contrato',
        ];
    }
}
