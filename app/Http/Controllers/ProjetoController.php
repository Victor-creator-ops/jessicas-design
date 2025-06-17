<?php

namespace App\Http\Controllers;

// Importa a classe Controller base, que dá acesso ao método authorize()
use App\Http\Controllers\Controller;

// Importa os Models e Form Requests necessários
use App\Models\Projeto;
use App\Models\Fase;
use App\Models\Cliente;
use App\Models\Designer;
use App\Http\Requests\StoreProjetoRequest;
use App\Http\Requests\UpdateProjetoRequest;
use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\VersaoArquivo;

// A correção é garantir que a classe "extends Controller"
class ProjetoController extends Controller
{
    /**
     * Exibe o quadro Kanban com todos os projetos.
     */
    public function kanban()
    {
        $this->authorize('viewAny', Projeto::class);

        $user = auth()->user();
        $query = Projeto::query(); // Inicia uma nova busca por projetos

        // Se o utilizador for um designer, filtra para mostrar apenas os seus projetos.
        if ($user->role === 'designer') {
            $query->whereHas('designers', function ($q) use ($user) {
                $q->where('designers.id', $user->designer->id);
            });
        }

        // O administrador continua a ver todos os projetos.
        // A busca continua a partir daqui.
        $projetos = $query->with('designers.user', 'cliente.user', 'faseAtual')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('faseAtual.nome');

        $fases = Fase::orderBy('ordem')->get();

        return view('projetos.kanban', compact('projetos', 'fases'));
    }

    /**
     * Exibe a página de detalhes de um projeto para a equipe.
     */
    public function show(Projeto $projeto)
    {
        $this->authorize('view', $projeto);

        // Carrega os relacionamentos necessários para a página
        $projeto->load('designers.user', 'cliente.user', 'faseAtual', 'arquivos.versoes.uploader', 'registrosHoras.designer.user');

        // 1. Busca os comentários feitos diretamente no projeto
        $comentariosDoProjeto = $projeto->comentarios;

        // 2. Busca os comentários feitos nas versões dos arquivos do projeto
        $comentariosDasVersoes = Comentario::whereHasMorph(
            'comentavel',
            [VersaoArquivo::class],
            function ($query) use ($projeto) {
                $query->whereHas('arquivo', function ($q) use ($projeto) {
                    $q->where('projeto_id', $projeto->id);
                });
            }
        )->get();

        // 3. Une as duas coleções e ordena pela data de criação
        $todosOsComentarios = $comentariosDoProjeto->merge($comentariosDasVersoes)->sortByDesc('created_at');

        // 4. Envia os dados para a view
        return view('projetos.show', compact('projeto', 'todosOsComentarios'));
    }

    /**
     * Mostra o formulário para criar um novo projeto.
     */
    public function create()
    {
        // Garante que apenas usuários autorizados possam criar projetos.
        $this->authorize('create', Projeto::class);

        // Busca todos os clientes e designers no banco de dados.
        $clientes = Cliente::with('user')->get();
        $designers = Designer::with('user')->get();

        // Retorna a view e passa as listas de clientes e designers para ela.
        return view('projetos.create', compact('clientes', 'designers'));
    }

    /**
     * Salva um novo projeto no banco de dados.
     */
    public function store(StoreProjetoRequest $request)
    {
        // A autorização e validação são feitas pelo StoreProjetoRequest
        $validatedData = $request->validated();

        $projeto = new Projeto($validatedData);
        $projeto->fase_id = Fase::orderBy('ordem')->first()->id; // Começa na primeira fase
        $projeto->save();

        $projeto->designers()->attach($validatedData['designers']);

        return redirect()->route('projetos.kanban')->with('success', 'Projeto cadastrado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um projeto existente.
     */
    public function edit(Projeto $projeto)
    {
        $this->authorize('update', $projeto);
        $clientes = Cliente::with('user')->get();
        $designers = Designer::with('user')->get();
        $designersAssociados = $projeto->designers->pluck('id')->toArray();

        return view('projetos.edit', compact('projeto', 'clientes', 'designers', 'designersAssociados'));
    }

    /**
     * Atualiza um projeto existente no banco de dados.
     */
    public function update(UpdateProjetoRequest $request, Projeto $projeto)
    {
        // A autorização e validação são feitas pelo UpdateProjetoRequest
        $projeto->update($request->validated());

        if ($request->has('designers')) {
            $projeto->designers()->sync($request->designers);
        }

        return redirect()->route('projetos.show', $projeto)->with('success', 'Projeto atualizado com sucesso!');
    }

    /**
     * Exclui um projeto do banco de dados.
     */
    public function destroy(Projeto $projeto)
    {
        $this->authorize('delete', $projeto);
        $projeto->delete();
        return redirect()->route('projetos.kanban')->with('success', 'Projeto excluído com sucesso.');
    }

    /**
     * Move o projeto para a próxima fase no Kanban.
     */
    public function avancarFase(Projeto $projeto)
    {
        $this->authorize('update', $projeto);

        $faseAtual = $projeto->faseAtual;
        $proximaFase = Fase::where('ordem', '>', $faseAtual->ordem)->orderBy('ordem')->first();

        if ($proximaFase) {
            $projeto->fase_id = $proximaFase->id;
            $projeto->save();
            return back()->with('success', 'Projeto avançado para a fase: ' . $proximaFase->nome);
        }

        return back()->with('info', 'O projeto já está na última fase.');
    }

    /**
     * Atualiza a fase de um projeto, geralmente via drag-and-drop do Kanban.
     */
    public function updateFase(Request $request, Projeto $projeto)
    {
        // 1. Autorização: Verifica se o usuário pode atualizar este projeto
        $this->authorize('update', $projeto);

        // 2. Validação: Garante que o fase_id enviado é válido
        $request->validate([
            'fase_id' => 'required|exists:fases,id'
        ]);

        // 3. Lógica de Negócio: Atualiza a fase do projeto no banco de dados
        $projeto->fase_id = $request->fase_id;
        $projeto->save(); // O Observer de Log de Atividade será acionado aqui, se configurado

        // 4. Resposta: Retorna uma confirmação em formato JSON para o JavaScript
        return response()->json([
            'success' => true,
            'message' => 'Fase do projeto atualizada com sucesso!'
        ]);
    }

}
