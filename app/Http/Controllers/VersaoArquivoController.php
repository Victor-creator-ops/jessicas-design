<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VersaoArquivo;
use Illuminate\Support\Facades\Storage;

class VersaoArquivoController extends Controller
{
    /**
     * Processa o download seguro de uma versão de arquivo.
     */
    public function download(VersaoArquivo $versao)
    {
        // Autoriza o download usando a Policy que acabamos de criar.
        $this->authorize('download', $versao);

        // Verifica se o arquivo realmente existe no disco privado para evitar erros.
        if (!Storage::disk('private')->exists($versao->path_arquivo)) {
            abort(404, 'Arquivo não encontrado.');
        }

        // Constrói o caminho completo e absoluto para o arquivo.
        $caminhoAbsoluto = storage_path('app/private/' . $versao->path_arquivo);

        // Retorna a resposta de download usando o helper, que é mais explícito para o editor.
        return response()->download($caminhoAbsoluto);
    }
}
