<?php

namespace App\Providers;

use App\Models\Projeto;
use App\Models\User; // <-- Adicione esta linha
use App\Policies\ProjetoPolicy;
use App\Policies\UserPolicy; // <-- Adicione esta linha
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Projeto::class => ProjetoPolicy::class,
        User::class => UserPolicy::class,
        \App\Models\VersaoArquivo::class => \App\Policies\VersaoArquivoPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
