<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Designer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DesignerController extends Controller
{
    public function index()
    {
        $designers = Designer::with('user')->latest()->paginate(15);
        return view('admin.designers.index', compact('designers'));
    }

    public function create()
    {
        return view('admin.designers.create');
    }

    public function store(Request $request)
    {
        // Valida os dados enviados pelo formulário
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'cargo' => ['required', 'string', 'max:255'],
            'custo_hora' => ['required', 'numeric', 'min:0'],
        ]);

        // Define a senha padrão
        $senhaPadrao = 'senha123';

        // Cria o usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($senhaPadrao),
            'role' => 'designer',
        ]);

        // Cria o designer vinculado ao usuário
        $user->designer()->create($request->only('cargo', 'custo_hora'));

        return redirect()->route('admin.designers.index')->with(
            'success', 
            'Designer cadastrado com sucesso! A senha padrão de primeiro acesso é "senha123".'
        );
    }

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

    public function edit(Designer $designer)
    {
        return view('admin.designers.edit', compact('designer'));
    }

    public function destroy(Designer $designer)
    {
        $designer->user->delete();
        return redirect()->route('admin.designers.index')->with('success', 'Designer excluído com sucesso!');
    }
}
