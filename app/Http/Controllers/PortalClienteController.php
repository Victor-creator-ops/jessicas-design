<?php

namespace App\Http\Controllers;

// Importa a classe Controller base
use App\Http\Controllers\Controller;

// Outras importações necessárias
use App\Models\VersaoArquivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Garante que a classe "extends Controller"
class PortalClienteController extends Controller
{
    /**
     * Mostra a página principal do projeto para o cliente logado.
     */
    public function show()
    {
        $clienteId = Auth::user()->cliente->id;

        $projeto = \App\Models\Projeto::where('cliente_id', $clienteId)
            ->with('faseAtual', 'arquivos.ultimaVersao')
            ->firstOrFail();

        $this->authorize('view', $projeto); // Verifica a permissão

        return view('portal.show', compact('projeto'));
    }

    /**
     * Processa a aprovação de uma versão de arquivo pelo cliente.
     */
    public function approveVersion(VersaoArquivo $versao)
    {
        // Garante que o cliente logado pode aprovar esta versão
        $this->authorize('approve', $versao);

        $versao->status = 'aprovada';
        $versao->save();

        // Lógica futura aqui (avançar fase, etc)

        return back()->with('success', 'Versão aprovada com sucesso! O projeto avançará para a próxima fase.');
    }

    /**
     * Processa a solicitação de alteração do cliente.
     */
    public function requestChange(Request $request, VersaoArquivo $versao)
    {
        // Garante que o cliente pode solicitar alteração nesta versão
        $this->authorize('requestChange', $versao);

        $request->validate(['comentarios' => 'required|string|min:10']);

        $versao->status = 'reprovada';
        $versao->save();

        $versao->comentarios()->create([
            'user_id' => Auth::id(),
            'conteudo' => $request->comentarios,
        ]);

        return back()->with('info', 'Solicitação de alteração enviada. A equipe já foi notificada.');
    }
}