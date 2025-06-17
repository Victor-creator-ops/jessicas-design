<x-app-layout>
    {{-- Cabeçalho da Página --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kanban de Projetos
            </h2>
            <div>
                @can('create', App\Models\Projeto::class)
                    <a href="{{ route('projetos.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Cadastrar Novo Projeto
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    {{-- Corpo Principal da Página do Kanban --}}
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div id="kanban-board" class="flex space-x-4 overflow-x-auto pb-4">

                {{-- Loop para criar uma coluna para cada Fase (RF03) --}}
                @foreach ($fases as $fase)
                    {{-- Adicionamos o atributo data-fase-id para o JavaScript saber o ID da coluna --}}
                    <div class="bg-gray-200 rounded-lg p-3 w-80 md:w-96 flex-shrink-0">
                        <h3 class="font-bold text-lg mb-4 text-gray-700">{{ $fase->nome }}</h3>
                        
                        {{-- O atributo 'data-fase-id' é crucial para a lógica do drag-and-drop --}}
                        <div class="kanban-column space-y-4 min-h-[500px]" data-fase-id="{{ $fase->id }}">
                            @if (isset($projetos[$fase->nome]))
                                @foreach ($projetos[$fase->nome] as $projeto)
                                    {{-- O atributo 'data-projeto-id' é crucial para a lógica do drag-and-drop --}}
                                    <div class="kanban-card bg-white rounded-lg shadow-md p-4 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 cursor-grab active:cursor-grabbing" 
                                         data-projeto-id="{{ $projeto->id }}">
                                        
                                        <a href="{{ route('projetos.show', $projeto) }}">
                                            <h4 class="font-bold text-lg text-gray-900 pointer-events-none">{{ $projeto->nome }}</h4>
                                            <p class="text-sm text-gray-600 mt-1 pointer-events-none">{{ $projeto->cliente->user->name }}</p>
                                        </a>

                                        <div class="flex items-center justify-between mt-4 pointer-events-none">
                                            <div class="flex -space-x-2">
                                                @foreach($projeto->designers as $designer)
                                                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" 
                                                         src="{{ $designer->foto_perfil_path ?? 'https://ui-avatars.com/api/?name='.urlencode($designer->user->name).'&background=random' }}" 
                                                         alt="Avatar de {{ $designer->user->name }}"
                                                         title="{{ $designer->user->name }}">
                                                @endforeach
                                            </div>
                                            <span class="px-2 py-1 text-xs font-semibold text-white rounded-full" style="background-color: {{ $projeto->cor_tema ?? '#6B7280' }};">
                                                Projeto
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Script para a funcionalidade de Drag and Drop --}}
    {{-- 1. Importa a biblioteca SortableJS via CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Pega todas as colunas do Kanban
            const columns = document.querySelectorAll('.kanban-column');

            columns.forEach(column => {
                new Sortable(column, {
                    group: 'kanban', // Permite mover cards entre colunas com o mesmo grupo
                    animation: 150,
                    ghostClass: 'bg-blue-100', // Estilo do "fantasma" do card sendo arrastado

                    // Função que é chamada quando um card é solto em uma nova coluna
                    onEnd: function (evt) {
                        const card = evt.item; // O card que foi movido
                        const newColumn = evt.to; // A coluna onde o card foi solto

                        const projetoId = card.dataset.projetoId;
                        const novaFaseId = newColumn.dataset.faseId;
                        
                        // Pega o token CSRF do meta tag para segurança
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        // Envia os dados para o backend para salvar a mudança
                        fetch(`/projetos/${projetoId}/update-fase`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                fase_id: novaFaseId
                            })
                        }).then(response => {
                            if (!response.ok) {
                                // Se der erro, você pode reverter o movimento ou mostrar uma mensagem
                                console.error('Falha ao atualizar o status do projeto.');
                                alert('Ocorreu um erro ao salvar a alteração.');
                            }
                            return response.json();
                        }).then(data => {
                            console.log(data.message); // Exibe a mensagem de sucesso no console
                        }).catch(error => {
                            console.error('Erro de rede:', error);
                            alert('Ocorreu um erro de rede.');
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>
