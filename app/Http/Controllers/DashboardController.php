<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Prepara os dados e exibe o dashboard apropriado para o usuário.
     */
    public function index(): View
    {
        $user = Auth::user();
        $viewData = []; // Um array para guardar os dados que enviaremos para a view.

        // Prepara os dados com base no papel (role) do usuário
        switch ($user->role) {
            case 'admin':
                // Query base para projetos que não estão finalizados
                $projetosAtivosQuery = Projeto::where('status', '!=', 'Finalizado');

                // Prepara todos os dados que a Jessica solicitou
                $viewData['projetosAtivosCount'] = $projetosAtivosQuery->count();
                $viewData['valorTotalContratos'] = $projetosAtivosQuery->sum('valor_contrato');
                $viewData['projetosAguardandoAprovacao'] = Projeto::whereHas('arquivos.versoes', function ($query) {
                    $query->where('status', 'pendente');
                })->get();
                $viewData['cargaTrabalhoDesigners'] = Designer::with('user')->withCount([
                    'projetos' => function ($query) {
                        $query->where('status', '!=', 'Finalizado');
                    }
                ])->get();
                break;

            case 'designer':
                $viewData['meusProjetos'] = $user->designer->projetos()->with('cliente.user')->get();
                break;

            case 'cliente':
                $viewData['meuProjeto'] = $user->cliente?->projetos()->latest()->first();
                break;
        }

        // Retorna a view principal 'dashboard' e passa todos os dados preparados.
        return view('dashboard', $viewData);
    }
}
