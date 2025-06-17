<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bem-vindo(a) ao portal do seu sonho, {{ Auth::user()->name }}!
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                {{-- Detalhes Principais do Projeto --}}
                <div class="border-b pb-6 mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $projeto->nome }}</h3>
                    <p class="mt-1 text-gray-600">Status atual: <span
                            class="font-semibold">{{ $projeto->faseAtual->nome }}</span></p>
                </div>

                {{-- Seção de Avaliação --}}
                <div class="mb-8">
                    <h4 class="text-xl font-bold text-gray-800">Arquivo para sua avaliação</h4>
                    @php
                        // Procura pela primeira versão pendente em todos os arquivos do projeto
                        $versaoPendente = $projeto->arquivos->flatMap->versoes->firstWhere('status', 'pendente');
                    @endphp

                    @if($versaoPendente)
                        <div class="mt-4 border-2 border-blue-500 bg-blue-50 rounded-lg p-6">
                            {{-- Container para alinhar detalhes e botão de download --}}
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-lg">{{ $versaoPendente->arquivo->nome_conceitual }} -
                                        v{{ $versaoPendente->versao }}</p>
                                    <p class="text-sm text-gray-500">Enviada em:
                                        {{ $versaoPendente->created_at->format('d/m/Y') }}</p>
                                </div>
                                <a href="{{ route('versoes.download', $versaoPendente) }}"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                    Download
                                </a>
                            </div>

                            {{-- Botões de Ação para Aprovar ou Solicitar Alteração --}}
                            <div class="mt-6 flex flex-col sm:flex-row sm:space-x-4 space-y-3 sm:space-y-0">
                                <form action="{{ route('portal.versoes.approve', $versaoPendente) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full sm:w-auto px-6 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700">Aprovar
                                        e Avançar</button>
                                </form>
                                <div x-data="{ open: false }">
                                    <button @click="open = !open" type="button"
                                        class="w-full sm:w-auto px-6 py-3 bg-transparent border border-gray-400 text-gray-700 font-bold rounded-lg hover:bg-gray-100">Solicitar
                                        Alteração</button>
                                    <div x-show="open" x-cloak
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                                        @click.away="open = false">
                                        <div class="bg-white rounded-lg p-6 max-w-lg w-full">
                                            <h5 class="font-bold text-lg mb-4">Solicitar Alteração</h5>
                                            <form action="{{ route('portal.versoes.requestChange', $versaoPendente) }}"
                                                method="POST">
                                                @csrf
                                                <textarea name="comentarios" class="w-full border-gray-300 rounded-lg"
                                                    rows="5" placeholder="Por favor, descreva aqui todas as alterações..."
                                                    required></textarea>
                                                <div class="mt-4 flex justify-end space-x-3">
                                                    <button type="button" @click="open = false"
                                                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">Cancelar</button>
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-blue-600 text-white rounded-md">Enviar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="mt-4 text-gray-500 bg-gray-50 p-4 rounded-md">Nenhum novo arquivo para avaliação no
                            momento.</p>
                    @endif
                </div>

                {{-- Histórico de Versões para este arquivo --}}
                <div class="mt-8 border-t pt-8">
                    <h4 class="text-xl font-bold text-gray-800">Histórico de versões anteriores</h4>
                    <div class="mt-4">
                        <ul class="border rounded-md divide-y">
                            @php
                                // Pega todas as versões que não estão pendentes e ordena da mais nova para a mais antiga
                                $versoesAnteriores = $projeto->arquivos->flatMap->versoes->where('status', '!=', 'pendente')->sortByDesc('created_at');
                            @endphp
                            @forelse ($versoesAnteriores as $versao)
                                <li class="p-3 flex justify-between items-center text-sm">
                                    <div>
                                        <span class="font-bold">{{ $versao->arquivo->nome_conceitual }} - Versão
                                            {{ $versao->versao }}</span>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full @if($versao->status == 'aprovada') bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">{{ ucfirst($versao->status) }}</span>
                                        <a href="{{ route('versoes.download', $versao) }}"
                                            class="text-blue-600 hover:underline">Download</a>
                                    </div>
                                </li>
                            @empty
                                <li class="p-3 text-sm text-gray-500">Ainda não há versões anteriores para este projeto.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>