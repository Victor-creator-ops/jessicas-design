<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroHorasController extends Controller
{
    /**
     * Salva um novo registro de horas para um projeto.
     * Este método corresponde à rota: projetos.horas.store
     */
    public function store(Request $request, Projeto $projeto)
    {
        $user = Auth::user();
        $designerId = null;

        // 1. Autorização: Verifica se o usuário é um admin ou um designer.
        if ($user->role === 'admin') {
            // Se for admin, precisamos encontrar um perfil de designer para associar as horas.
            // Uma abordagem comum é pegar o primeiro designer da equipe.
            // Se não houver designers, o admin não pode registrar horas desta forma.
            $primeiroDesigner = \App\Models\Designer::first();
            if (!$primeiroDesigner) {
                // Retorna com um erro se não houver nenhum designer no sistema.
                return back()->withErrors(['geral' => 'Não é possível registrar horas como admin pois não há designers cadastrados no sistema.']);
            }
            $designerId = $primeiroDesigner->id;

        } elseif ($user->role === 'designer' && $user->designer) {
            // Se for designer, pega o ID do seu próprio perfil.
            $designerId = $user->designer->id;
        } else {
            // Se não for nem admin nem designer, nega o acesso.
            abort(403, 'Apenas membros da equipe podem registrar horas.');
        }

        // 2. Validação: Garante que os dados enviados são válidos.
        $validated = $request->validate([
            'horas_gastas' => ['required', 'numeric', 'min:0.1'],
            'data' => ['required', 'date'],
            'descricao_atividade' => ['required', 'string', 'max:255'],
        ]);

        // 3. Lógica de Negócio: Cria o registro no banco de dados.
        $projeto->registrosHoras()->create([
            'designer_id' => $designerId, // Usa o ID que definimos acima.
            'horas_gastas' => $validated['horas_gastas'],
            'data' => $validated['data'],
            'descricao_atividade' => $validated['descricao_atividade'],
        ]);

        // 4. Resposta: Redireciona de volta para a página do projeto com uma mensagem de sucesso.
        return back()->with('success', 'Horas registradas com sucesso!');
    }
}
