<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    /**
     * Exibe uma lista de todos os clientes.
     */
    public function index()
    {
        $clientes = Cliente::with('user')->latest()->paginate(15);
        return view('admin.clientes.index', compact('clientes'));
    }

    /**
     * Mostra o formulário para criar um novo cliente.
     */
    public function create()
    {
        return view('admin.clientes.create');
    }


    /**
     * Salva um novo cliente e seu usuário associado.
     */
    /**
     * Salva um novo cliente e seu usuário associado.
     */
    public function store(Request $request)
    {
        // Torna o campo cpf_cnpj obrigatório na validação
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:' . User::class],
            'telefone' => ['nullable', 'string', 'max:20'],
            'cpf_cnpj' => ['required', 'string', 'max:20'],
            'endereco' => ['nullable', 'string'],
        ]);

        // Usa o CPF/CNPJ como a senha de primeiro acesso
        $senhaTemporaria = $request->cpf_cnpj;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($senhaTemporaria),
            'role' => 'cliente',
        ]);

        $user->cliente()->create($request->only('telefone', 'cpf_cnpj', 'endereco'));

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente cadastrado com sucesso! A senha de primeiro acesso é o CPF/CNPJ informado.');
    }

    /**
     * Mostra o formulário para editar um cliente existente.
     */
    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    /**
     * Atualiza os dados de um cliente no banco de dados.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($cliente->user_id)],
            'telefone' => ['nullable', 'string', 'max:20'],
            'endereco' => ['nullable', 'string'],
        ]);

        $cliente->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $cliente->update($request->only('telefone', 'endereco'));

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove um cliente do banco de dados (ação a ser implementada no futuro).
     */
    public function destroy(Cliente $cliente)
    {
        // Lógica para deletar o usuário associado e o cliente
        $cliente->user->delete(); // O cascade na migration deve cuidar do resto.

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }

    public function show()
    {
        $clienteId = auth()->user()->cliente->id;

        // Carrega o projeto com todos os relacionamentos necessários de uma só vez
        $projeto = \App\Models\Projeto::where('cliente_id', $clienteId)
            ->with([
                'faseAtual',
                'arquivos.versoes.uploader' // Carrega todos os arquivos, todas as suas versões e quem fez o upload
            ])
            ->firstOrFail();

        $this->authorize('view', $projeto);

        return view('portal.show', compact('projeto'));
    }
}
