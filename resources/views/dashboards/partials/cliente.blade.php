<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h3 class="text-xl font-bold mb-2">Bem-vindo(a) ao seu portal!</h3>
        <p class="mb-4">Aqui você pode acompanhar o andamento do seu sonho.</p>

        @if ($meuProjeto)
            <a href="{{ route('portal.projeto.show') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none">
                Ir para o Meu Projeto
            </a>
        @else
            <p>Seu projeto será criado em breve. Aguarde!</p>
        @endif
    </div>
</div>