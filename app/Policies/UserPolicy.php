<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determina se o usuário pode criar novos usuários.
     */
    public function create(User $user): bool
    {
        // Apenas usuários com a role 'admin' podem criar novos usuários.
        return $user->role === 'admin';
    }

    // Você pode adicionar outras regras aqui no futuro (view, update, delete)
}