<?php

namespace App\Policies;

use App\Models\Projeto;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjetoPolicy
{
    /**
     * Permissão "master". Admins podem fazer tudo.
     * Esta função é verificada antes de qualquer outra na policy.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }

        return null; // Deixa as outras regras decidirem
    }

    /**
     * Determina se o usuário pode ver a lista de todos os projetos (ex: no Kanban).
     */
    public function viewAny(User $user): bool
    {
        // Apenas a equipe (admin ou designer) pode ver a lista de todos os projetos. 
        return $user->role === 'admin' || $user->role === 'designer';
    }

    /**
     * Determina se o usuário pode ver os detalhes de um projeto específico.
     */
    public function view(User $user, Projeto $projeto): bool
    {
        // O cliente só pode ver o seu próprio projeto. 
        if ($user->role === 'cliente') {
            return $user->cliente->id === $projeto->cliente_id;
        }

        // A equipe (designer) pode ver os projetos.
        // A regra 'before' já liberou o admin.
        return $user->role === 'designer';
    }

    /**
     * Determina se o usuário pode criar novos projetos.
     */
    public function create(User $user): bool
    {
        // Apenas o administrador pode cadastrar um novo projeto. 
        // A regra 'before' já cobre isso, mas é bom deixar explícito.
        return $user->role === 'admin';
    }

    /**
     * Determina se o usuário pode atualizar um projeto.
     */
    public function update(User $user, Projeto $projeto): bool
    {
        // A equipe (admin ou designer) pode atualizar o projeto (ex: mover no kanban). 
        // A regra 'before' já liberou o admin.
        return $user->role === 'designer';
    }

    /**
     * Determina se o usuário pode deletar um projeto.
     */
    public function delete(User $user, Projeto $projeto): bool
    {
        // Apenas o administrador tem permissão total para ações destrutivas. 
        // A regra 'before' já garante isso.
        return $user->role === 'admin';
    }

    /**
     * Determina se o usuário pode restaurar um projeto deletado (Soft Deletes).
     */
    public function restore(User $user, Projeto $projeto): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determina se o usuário pode deletar permanentemente um projeto.
     */
    public function forceDelete(User $user, Projeto $projeto): bool
    {
        return $user->role === 'admin';
    }
}