{{-- Ações Principais do Administrador --}}
<div class="flex flex-col sm:flex-row sm:justify-end sm:space-x-3 space-y-3 sm:space-y-0 mb-6">
    <a href="{{ route('admin.clientes.create') }}"
        class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
        </svg>
        Novo Cliente
    </a>
    <a href="{{ route('admin.designers.create') }}"
        class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Novo Designer
    </a>
    <a href="{{ route('projetos.create') }}"
        class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
        </svg>
        Novo Projeto
    </a>
</div>

{{-- Visão Macro: Cards com os indicadores-chave (RF06) --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card: Projetos Ativos -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Projetos Ativos</h3>
        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $projetosAtivosCount ?? 0 }}</p>
    </div>

    <!-- Card: Valor Total em Contratos -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Valor em Contratos</h3>
        <p class="mt-1 text-3xl font-semibold text-gray-900">R$
            {{ number_format($valorTotalContratos ?? 0, 2, ',', '.') }}</p>
    </div>

    <!-- Card: Aguardando Aprovação -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Aguardando Aprovação</h3>
        <p class="mt-1 text-3xl font-semibold text-yellow-600">{{ $projetosAguardandoAprovacao->count() ?? 0 }}</p>
    </div>
</div>

{{-- Seção de Gestão e Acompanhamento --}}
<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

    <!-- Lista: Projetos que precisam de atenção -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Projetos que precisam de atenção</h3>
            <div class="max-h-64 overflow-y-auto">
                <ul class="divide-y divide-gray-200">
                    @forelse ($projetosAguardandoAprovacao ?? [] as $projeto)
                        <li class="py-3">
                            <a href="{{ route('projetos.show', $projeto) }}" class="text-blue-600 hover:underline">
                                {{ $projeto->nome }}
                            </a>
                            <p class="text-sm text-gray-500">Cliente: {{ $projeto->cliente->user->name }}</p>
                        </li>
                    @empty
                        <li class="py-3 text-sm text-gray-500">Nenhum projeto aguardando aprovação.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Tabela: Carga de Trabalho da Equipe -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Carga de Trabalho da Equipe</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Designer</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Projetos Ativos
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($cargaTrabalhoDesigners ?? [] as $designer)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $designer->user->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ $designer->projetos_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-3 whitespace-nowrap text-center text-sm text-gray-500">Nenhum
                                    designer cadastrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>