<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editando Cliente: {{ $cliente->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                {{-- Formulário de Edição --}}
                <form action="{{ route('admin.clientes.update', $cliente) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT') {{-- Informa ao Laravel que esta é uma requisição de atualização --}}

                    <!-- Nome Completo -->
                    <div>
                        <x-input-label for="name" value="Nome Completo" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $cliente->user->name)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- E-mail -->
                    <div>
                        <x-input-label for="email" value="E-mail" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                            :value="old('email', $cliente->user->email)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <!-- Telefone -->
                    <div>
                        <x-input-label for="telefone" value="Telefone" />
                        <x-text-input id="telefone" name="telefone" type="text" class="mt-1 block w-full"
                            :value="old('telefone', $cliente->telefone)" />
                    </div>

                    <!-- Endereço -->
                    <div>
                        <x-input-label for="endereco" value="Endereço" />
                        <textarea id="endereco" name="endereco"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            rows="3">{{ old('endereco', $cliente->endereco) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('admin.clientes.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                            Cancelar
                        </a>
                        <x-primary-button>
                            Salvar Alterações
                        </x-primary-button>
                    </div>
                </form>

                {{-- Seção de Exclusão do Cliente --}}
                <div class="border-t mt-8 pt-6">
                    <h3 class="text-lg font-medium text-red-700">Excluir Cliente</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Uma vez que um cliente é excluído, todos os seus dados, incluindo o seu login no portal e a
                        associação com projetos, serão permanentemente removidos. Esta ação não pode ser desfeita.
                    </p>

                    {{-- O formulário de exclusão é separado para segurança --}}
                    <form action="{{ route('admin.clientes.destroy', $cliente) }}" method="POST" class="mt-4"
                        onsubmit="return confirm('Tem certeza absoluta que deseja excluir este cliente?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Excluir Cliente Permanentemente
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>