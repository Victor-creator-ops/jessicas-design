<?php

// Este arquivo controla o envio de arquivos para os projetos. 
// Ele valida, salva e organiza os arquivos enviados pelos usuários. 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArquivoController extends Controller
{
    /** 
     * Salva um novo arquivo e sua primeira versão para um projeto. 
     */
    public function store(Request $request, Projeto $projeto)
    {
        // 1. Autoriza: verifica se o usuário pode atualizar o projeto 
        $this->authorize('update', $projeto);

        // 2. Valida os dados enviados pelo formulário 
        $validated = $request->validate([
            'nome_conceitual' => 'required|string|max:255',
            'arquivo' => 'required|file|mimes:pdf,dwg,jpg,png,zip|max:20480', // Max 20MB 
        ]);

        // 3. Salva o arquivo na pasta privada do projeto 
        $path = $request->file('arquivo')->store('projetos/' . $projeto->id, 'private');

        // 4. Cria ou encontra o "container" do arquivo (ex: "Planta Baixa") 
        $arquivo = $projeto->arquivos()->firstOrCreate(
            ['nome_conceitual' => $validated['nome_conceitual']],
            ['fase_id' => $projeto->fase_id] // Associa à fase atual do projeto 
        );

        // 5. Cria a nova versão do arquivo 
        $versao = $arquivo->versoes()->create([
            'user_id' => Auth::id(),
            'versao' => $arquivo->versoes()->count() + 1, // Incrementa a versão 
            'path_arquivo' => $path,
            'status' => 'pendente', // Nova versão sempre começa como pendente 
        ]);

        // Aqui você pode adicionar a notificação para o cliente (RF07) 

        // 6. Redireciona de volta para a página do projeto com uma mensagem de sucesso 
        return back()->with('success', "Versão {$versao->versao} de '{$arquivo
            ->nome_conceitual}'enviada com sucesso!");
    }
}
