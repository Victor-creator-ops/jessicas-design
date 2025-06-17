<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projeto: <span class="font-normal">{{ $projeto->nome }}</span>
            </h2>
            <div>
                @can('update', $projeto)
                    <a href="{{ route('projetos.edit', $projeto) }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                        Editar Projeto
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- COLUNA DA ESQUERDA: Detalhes, Horas e Feed de Comentários --}}
                <div class="lg:col-span-1 space-y-8">
                    <!-- Detalhes do Projeto -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4">Detalhes</h3>
                        <div class="space-y-2 text-sm">
                            <p><strong>Cliente:</strong> {{ $projeto->cliente->user->name }}</p>
                            <p><strong>Fase Atual:</strong> {{ $projeto->faseAtual->nome }}</p>
                        </div>
                        <form action="{{ route('projetos.avancarFase', $projeto) }}" method="POST" class="mt-4">
                            @csrf
                            <x-primary-button class="w-full justify-center">Avançar Fase</x-primary-button>
                        </form>
                    </div>

                    <!-- NOVO: Feed de Comentários -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4">Feed de Comentários</h3>
                            <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                                {{-- A view agora usa a variável $todosOsComentarios --}}
                                @forelse ($todosOsComentarios as $comentario)
                                    <div class="text-sm">
                                        <p class="font-semibold">{{ $comentario->user->name }} <span
                                                class="text-gray-400 font-normal">comentou em
                                                {{ $comentario->created_at->format('d/m/Y H:i') }}</span></p>
                                        <p class="bg-gray-50 p-3 rounded-md mt-1">{{ $comentario->conteudo }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">Nenhum comentário ainda.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- COLUNA DA DIREITA: Arquivos e Registro de Horas --}}
                <div class="lg:col-span-2 space-y-8">
                    <!-- Gerenciamento de Arquivos -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4">Gerenciamento de Arquivos</h3>
                        <div class="bg-gray-50 p-4 rounded-lg border mb-6">
                            <h4 class="font-semibold text-gray-800 mb-2">Enviar Novo Arquivo</h4>
                            <form action="{{ route('projetos.arquivos.store', $projeto) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <input type="text" name="nome_conceitual"
                                    placeholder="Nome do Arquivo (Ex: Planta Baixa)"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    required>
                                <input type="file" name="arquivo"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    required>
                                <x-primary-button>Enviar</x-primary-button>
                            </form>
                        </div>
                        <!-- Lista de versões de arquivos -->
                        <div class="space-y-6">
                            @forelse ($projeto->arquivos as $arquivo)
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $arquivo->nome_conceitual }}</h4>
                                    <ul class="mt-2 border rounded-md divide-y">
                                        @foreach ($arquivo->versoes as $versao)
                                            <li class="p-3 flex justify-between items-center text-sm">
                                                <div><span class="font-bold">V{{ $versao->versao }}</span> <span
                                                        class="text-gray-500">por {{ $versao->uploader->name }}</span></div>
                                                <div><span
                                                        class="px-2 py-1 text-xs font-semibold rounded-full @if($versao->status == 'aprovada') bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">{{ ucfirst($versao->status) }}</span>
                                                    <a href="{{ route('versoes.download', $versao) }}"
                                                        class="text-blue-600 hover:underline ml-4">Download</a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @empty
                                <p class="text-gray-500">Nenhum arquivo enviado.</p>
                            @endforelse
                        </div>
                    </div>
                    <!-- Registro de Horas -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4">Registro de Horas</h3>
                        {{-- Formulário e Lista de Horas --}}
                        <!-- Registro de Horas -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4">Registro de Horas</h3>
                            <form action="{{ route('projetos.horas.store', $projeto) }}" method="POST"
                                class="space-y-4">
                                @csrf
                                <input type="number" name="horas_gastas" placeholder="Horas"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    step="0.5" required>
                                <input type="text" name="descricao_atividade" placeholder="Descrição da atividade"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    required>
                                <input type="hidden" name="data" value="{{ date('Y-m-d') }}">
                                <x-primary-button>Registrar</x-primary-button>
                            </form>
                            <div class="mt-6">
                                <h4 class="font-semibold text-gray-800">Horas Registradas</h4>
                                <ul class="mt-2 divide-y text-sm text-gray-600">
                                    @forelse ($projeto->registrosHoras as $registro)
                                        <li class="py-2"><strong>{{ $registro->horas_gastas }}h</strong> por
                                            <strong>{{ $registro->designer->user->name }}</strong>:
                                            {{ $registro->descricao_atividade }}
                                        </li>
                                    @empty
                                        <li class="py-2">Nenhuma hora registrada.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>