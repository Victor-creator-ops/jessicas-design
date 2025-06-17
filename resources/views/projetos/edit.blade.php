<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editando Projeto: {{ $projeto->nome }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">

                <form action="{{ route('projetos.update', $projeto) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT') {{-- Informa ao Laravel que esta é uma requisição de atualização --}}

                    <!-- Nome do Projeto -->
                    <div>
                        <x-input-label for="nome" value="Nome do Projeto" />
                        <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full" :value="old('nome', $projeto->nome)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('nome')" />
                    </div>

                    <!-- Descrição do Projeto -->
                    <div>
                        <x-input-label for="descricao" value="Breve Descrição" />
                        <textarea id="descricao" name="descricao"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            rows="3">{{ old('descricao', $projeto->descricao) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('descricao')" />
                    </div>

                    <!-- Selecionar Cliente e Designers -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="cliente_id" value="Cliente" />
                            <select name="cliente_id" id="cliente_id"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" @if($cliente->id == old('cliente_id', $projeto->cliente_id)) selected @endif>
                                        {{ $cliente->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="designers" value="Atribuir a Designer(s)" />
                            <select name="designers[]" id="designers" multiple
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                @foreach ($designers as $designer)
                                    <option value="{{ $designer->id }}" @if(in_array($designer->id, old('designers', $designersAssociados))) selected @endif>
                                        {{ $designer->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Mais campos do projeto poderiam ser adicionados aqui, como o de cobrança --}}

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('projetos.show', $projeto) }}"
                            class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                            Cancelar
                        </a>
                        <x-primary-button>
                            Salvar Alterações
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>