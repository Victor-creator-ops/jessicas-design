<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles  // Este parâmetro recebe todos os papéis permitidos na rota.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pega o usuário que está autenticado na sessão.
        $user = $request->user();

        // 1. Verifica se existe um usuário logado e se o papel dele está na lista de papéis permitidos.
        // Os papéis são definidos nos requisitos: 'admin', 'designer', 'cliente'. 
        if ($user && in_array($user->role, $roles)) {
            // 2. Se o usuário tem um dos papéis permitidos, deixa a requisição continuar para o controller.
            return $next($request);
        }

        // 3. Se o usuário não está logado ou não tem o papel correto, bloqueia o acesso.
        // A função abort() interrompe a requisição e mostra uma página de erro.
        // 403 significa "Forbidden" (Acesso Proibido).
        abort(403, 'ACESSO NÃO AUTORIZADO.');
    }
}