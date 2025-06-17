<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProjetoRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     * Apenas o administrador pode cadastrar um novo projeto.
     */
    public function authorize(): bool
    {
        // Acessa o usuário logado e verifica sua 'role'
        return Auth::user()->role === 'admin';
    }

    /**
     * Obtém as regras de validação que se aplicam à requisição.
     * Estas regras são baseadas nos campos definidos no Requisito Funcional RF02.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'cliente_id' => 'required|exists:clientes,id',
            'designers' => 'required|array',
            'designers.*' => 'exists:designers,id',

            // Regras atualizadas para cobrança
            'modalidade_cobranca' => 'required|string|in:valor_fechado,m2,horas',
            'valor_contrato' => 'required|numeric|min:0',

            // Novos campos (opcionais, validados se presentes)
            'area_m2' => 'nullable|numeric|min:0',
            'pacote_horas' => 'nullable|numeric|min:0',

            // Campos antigos que permanecem
            'data_inicio' => 'sometimes|required|date',
            'cor_tema' => 'nullable|string|max:7',
        ];
    }
}
