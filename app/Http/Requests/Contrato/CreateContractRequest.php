<?php

namespace App\Http\Requests\Contrato;

use Illuminate\Foundation\Http\FormRequest;

class CreateContractRequest extends FormRequest
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
            'data.anoCompra' => 'required|int|min:4',
            'data.anoContrato' =>  'required|int|min:4',
            'data.categoriaProcessoId' =>  'required|int',
            'data.cnpjCompra' =>  'required|string|max:14',
            'data.cod_fornecedor' =>  'required',
            'data.cod_pregao' =>  'required',
            'data.codigoUnidade' =>  'required',
            'data.dataAssinatura' =>  'required',
            'data.dataVigenciaFim' =>  'required',
            'data.dataVigenciaInicio' =>  'required',
            'data.niFornecedor' =>  'required',
            'data.nomeRazaoSocialFornecedor' =>  'required',
            'data.numeroContratoEmpenho' =>  'required|string',
            'data.numeroParcelas' =>  'required|int',
            'data.objetoContrato' =>  'required|string',
            'data.processo' =>  'required|string',
            'data.receita' =>  'required|boolean',
            'data.sequencialCompra' =>  'required|int',
            'data.tipoContratoId' =>  'required|int',
            'data.tipoPessoaFornecedor' =>  'required|string|min:2',
            'data.valorAcumulado' =>  'nullable|numeric',
            'data.valorGlobal' =>  'required|numeric',
            'data.valorInicial' =>  'required|numeric',
            'data.valorParcela' =>  'required|numeric'
        ];
    }

    public function messages(): array
    {
        return [
            'data.anoCompra.required' => 'Informe o ano da compra',
            'data.anoCompra.int' => 'O ano da compra deve ser inteiro',
            'data.anoCompra.min' => 'O ano da compra deve ter 4 caracteres',
            'data.anoContrato.required' =>  'Informe o ano do contrato',
            'data.anoContrato.int' =>  'O ano do contrato deve ser inteiro',
            'data.anoContrato.min' =>  'O ano do contrato de ter 4 caracteres',
            'data.categoriaProcessoId.required' =>  'Informe a categoria do processo',
            'data.categoriaProcessoId.int' =>  'A Categoria do processo deve ser inteiro',
            'data.cnpjCompra.required' =>  'Informe o CNPJ do Orgão',
            'data.cnpjCompra.string' =>  'O CNPJ do orgão deve ser uma string',
            'data.cnpjCompra.max' =>  'O CNPJ do orgão deve ter no máximo 14 caracteres',
            'data.cod_fornecedor.required' =>  'Informe o código do fornecedor',
            'data.cod_pregao.required' =>  'Informe o código do processo',
            'data.codigoUnidade.required' =>  'Informe o código da unidade',
            'data.dataAssinatura.required' =>  'Informe a data de assinatura do contrato',
            'data.dataVigenciaFim.required' =>  'Informe a data fim da vigência do contrato',
            'data.dataVigenciaInicio.required' =>  'Informe a data do início de vigência do contrato ',
            'data.niFornecedor.required' =>  'Informe o documento do fornecedor',
            'data.nomeRazaoSocialFornecedor.required' =>  'Informe a razão social do fornecedor',
            'data.numeroContratoEmpenho.required' =>  'Informe o número do contrato',
            'data.numeroContratoEmpenho.string' =>  'O número do contrato deve ser string',
            'data.numeroParcelas.required' => 'Informe o número de parcelas',
            'data.numeroParcelas.int' =>  'O número de parcelas deve ser inteiro',
            'data.objetoContrato.required' =>  'Informe o objeto do contrato',
            'data.objetoContrato.string' => 'O objeto do contrato deve ser string',
            'data.processo.required' =>  'Informe o processo',
            'data.processo.string' =>  'O processo deve ser string',
            'data.receita.required' =>  'Informe a se é receita ou não',
            'data.receita.boolean' =>  'A receita deve ser booleano',
            'data.sequencialCompra.required' =>  'Informe o sequencial da compra',
            'data.sequencialCompra.int' =>  'O sequencial da compra deve ser inteiro',
            'data.tipoContratoId.required' =>  'Informe o tipo de contrato',
            'data.tipoContratoId.int' =>  'O tipo de contrato deve ser inteiro',
            'data.tipoPessoaFornecedor.required' =>  'Informe o tipo de pessoa do fornecedor',
            'data.tipoPessoaFornecedor.string' =>  'O tipo de pessoa do fornecedor deve ser string',
            'data.tipoPessoaFornecedor.min' =>  'O tipo de pessoa do fornecedor deve ter 2 caracteres',
            'data.valorAcumulado.numeric' =>  'O valor acumulado deve ser do tipo float',
            'data.valorGlobal.required' =>  'Informe o valor global',
            'data.valorGlobal.numeric' =>  'O valor global deve ser do tipo float',
            'data.valorInicial.required' =>  'Informe o valor inicial',
            'data.valorInicial.numeric' =>  'O valor inicial deve ser do tipo float',
            'data.valorParcela.required' =>  'Informe o valor da parcela',
            'data.valorParcela.numeric' =>  'O valor da parcela deve ser do tipo float'
        ];
    }
}
