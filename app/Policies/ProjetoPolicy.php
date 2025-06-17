<?php

namespace App\Policies;

use App\Models\Projeto;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjetoPolicy
{
    /**
     * Permissão "master". Admins podem fazer tudo.
     */
    public function before(User $user, string $ability): ?bool
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
        // Apenas a equipe (admin ou designer) pode ver a lista de projetos.
        return $user->role === 'admin' || $user->role === 'designer';
    }

    /**
     * Determina se o usuário pode ver os detalhes de um projeto específico.
     */
    public function view(User $user, Projeto $projeto): bool
    {
        // Se for cliente, só pode ver o seu próprio projeto.
        if ($user->role === 'cliente') {
            return $user->cliente && $projeto->cliente_id === $user->cliente->id;
        }

        // Se for designer, verifica se ele está associado ao projeto.
        if ($user->role === 'designer') {
            return $user->designer && $projeto->designers->contains($user->designer);
        }

        // A regra 'before' já liberou o admin.
        return false;
    }

    /**
     * Determina se o usuário pode criar novos projetos.
     */
    public function create(User $user): bool
    {
        // Apenas o administrador pode cadastrar um novo projeto.
        return $user->role === 'admin';
    }

    /**
     * Determina se o usuário pode atualizar um projeto.
     */
    public function update(User $user, Projeto $projeto): bool
    {
        // CORREÇÃO: Um designer só pode editar um projeto se estiver atribuído a ele.
        if ($user->role === 'designer') {
            // Garante que o usuário tem um perfil de designer e que este perfil está na coleção de designers do projeto.
            return $user->designer && $projeto->designers->contains($user->designer);
        }

        return false; // Nega para qualquer outra role, pois o admin já foi tratado no 'before'.
    }

    /**
     * Determina se o usuário pode deletar um projeto.
     */
    public function delete(User $user, Projeto $projeto): bool
    {
        // Apenas o administrador tem permissão. A regra 'before' já garante isso.
        return false;
    }
}
