<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProjetoRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     * Apenas admin e designers podem atualizar um projeto.
     */
    public function authorize(): bool
    {
        // Usamos a Policy que já criamos.
        // O Laravel pega o projeto da rota automaticamente.
        return $this->user()->can('update', $this->route('projeto'));
    }

    /**
     * Obtém as regras de validação que se aplicam à requisição.
     * 'sometimes' significa: valide apenas se este campo estiver presente na requisição.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'sometimes|required|string',
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'designers' => 'sometimes|required|array',
            'designers.*' => 'exists:designers,id',
            'modalidade_cobranca' => 'sometimes|required|string|max:100',
            'valor_contrato' => 'sometimes|required|numeric|min:0',
            'data_inicio' => 'sometimes|required|date',
            'cor_tema' => 'nullable|string|max:7',
        ];
    }
}
