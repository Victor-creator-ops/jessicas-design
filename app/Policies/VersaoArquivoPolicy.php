<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VersaoArquivo;

class VersaoArquivoPolicy
{
    /**
     * Permissão "master". Admins podem fazer tudo.
     * Esta função é verificada antes de qualquer outra na policy.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null; // Deixa as outras regras decidirem
    }

    /**
     * Regra central que verifica se um usuário tem ligação com o projeto do arquivo.
     */
    private function canInteract(User $user, VersaoArquivo $versao): bool
    {
        $projeto = $versao->arquivo->projeto;

        // Regra para o Designer: ele pode interagir se estiver no projeto.
        if ($user->role === 'designer') {
            return $user->designer && $projeto->designers->contains($user->designer);
        }

        // Regra para o Cliente: ele pode interagir se o projeto for dele.
        if ($user->role === 'cliente') {
            return $user->cliente && $projeto->cliente_id === $user->cliente->id;
        }

        return false;
    }

    /**
     * Determina se o usuário pode baixar a versão do arquivo.
     */
    public function download(User $user, VersaoArquivo $versao): bool
    {
        // Qualquer pessoa ligada ao projeto (cliente ou designer) pode baixar.
        return $this->canInteract($user, $versao);
    }

    /**
     * Determina se o usuário pode aprovar a versão do arquivo.
     */
    public function approve(User $user, VersaoArquivo $versao): bool
    {
        // Apenas o cliente do projeto pode aprovar.
        return $user->role === 'cliente' && $this->canInteract($user, $versao);
    }

    /**
     * Determina se o usuário pode solicitar alteração na versão do arquivo.
     */
    public function requestChange(User $user, VersaoArquivo $versao): bool
    {
        // Apenas o cliente do projeto pode solicitar alterações.
        return $this->canInteract($user, $versao);
    }
}
