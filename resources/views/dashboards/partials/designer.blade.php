<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-xl font-bold mb-4">Meus Projetos Atribuídos</h3>
        <ul class="divide-y divide-gray-200">
            @forelse ($meusProjetos as $projeto)
                <li class="py-3">
                    <a href="{{ route('projetos.show', $projeto) }}" class="text-blue-600 hover:underline font-semibold">
                        {{ $projeto->nome }}
                    </a>
                    <p class="text-sm text-gray-600">Cliente: {{ $projeto->cliente->user->name }} | Status:
                        {{ $projeto->faseAtual->nome }}
                    </p>
                </li>
            @empty
                <p>Você ainda não foi atribuído a nenhum projeto.</p>
            @endforelse
        </ul>
    </div>
</div>