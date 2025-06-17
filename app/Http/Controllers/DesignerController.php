<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Designer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DesignerController extends Controller
{
    /**
     * Exibe uma lista de todos os designers.
     */
    public function index()
    {
        $designers = Designer::with('user')->latest()->paginate(15);
        return view('admin.designers.index', compact('designers'));
    }

    /**
     * Mostra o formulário para criar um novo designer.
     */
    public function create()
    {
        return view('admin.designers.create');
    }

    /**
     * Salva um novo designer no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'cargo' => ['required', 'string', 'max:255'],
            'custo_hora' => ['required', 'numeric', 'min:0'],
        ]);

        // Define a senha padrão para "senha123"
        $senhaPadrao = 'senha123';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($senhaPadrao),
            'role' => 'designer',
        ]);

        $user->designer()->create($request->only('cargo', 'custo_hora'));

        // Atualiza a mensagem de sucesso para refletir a nova senha padrão.
        return redirect()->route('admin.designers.index')->with('success', 'Designer cadastrado com sucesso! A senha padrão de primeiro acesso é "senha123".');
    }

    /**
     * Mostra o formulário para editar um designer existente.
     */
    public function edit(Designer $designer)
    {
        return view('admin.designers.edit', compact('designer'));
    }

    /**
     * Atualiza os dados de um designer no banco de dados.
     */
    public function update(Request $request, Designer $designer)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($designer->user_id)],
            'cargo' => ['required', 'string', 'max:255'],
            'custo_hora' => ['required', 'numeric', 'min:0'],
        ]);

        $designer->user->update($request->only('name', 'email'));
        $designer->update($request->only('cargo', 'custo_hora'));

        return redirect()->route('admin.designers.index')->with('success', 'Designer atualizado com sucesso!');
    }

    /**
     * Remove um designer do banco de dados.
     */
    public function destroy(Designer $designer)
    {
        $designer->user->delete(); // O cascade na migration deve cuidar do resto.
        return redirect()->route('admin.designers.index')->with('success', 'Designer excluído com sucesso!');
    }
}
