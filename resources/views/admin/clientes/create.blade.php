<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cadastrar Novo Cliente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('admin.clientes.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Nome Completo -->
                    <div>
                        <x-input-label for="name" value="Nome Completo" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')"
                            required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- E-mail -->
                    <div>
                        <x-input-label for="email" value="E-mail (Login do Portal)" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                            :value="old('email')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Telefone com Máscara -->
                        <div>
                            <x-input-label for="telefone" value="Telefone" />
                            <x-text-input id="telefone" name="telefone" type="text" class="mt-1 block w-full"
                                :value="old('telefone')" />
                        </div>

                        <!-- CPF/CNPJ com Máscara -->
                        <div>
                            {{-- Texto do label atualizado e campo marcado como 'required' --}}
                            <x-input-label for="cpf_cnpj" value="CPF/CNPJ (será a senha de 1º acesso)" />
                            <x-text-input id="cpf_cnpj" name="cpf_cnpj" type="text" class="mt-1 block w-full"
                                :value="old('cpf_cnpj')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('cpf_cnpj')" />
                        </div>
                    </div>

                    <!-- Endereço -->
                    <div>
                        <x-input-label for="endereco" value="Endereço" />
                        <textarea id="endereco" name="endereco"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            rows="3">{{ old('endereco') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            Cadastrar Cliente
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script para aplicar as máscaras --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Máscara para Telefone (aceita celular e fixo)
            const phoneEl = document.getElementById('telefone');
            const phoneMask = new IMask(phoneEl, {
                mask: [
                    { mask: '(00) 0000-0000' },
                    { mask: '(00) 00000-0000' }
                ]
            });

            // Máscara para CPF/CNPJ
            const CpfCnpjEl = document.getElementById('cpf_cnpj');
            const CpfCnpjMask = new IMask(CpfCnpjEl, {
                mask: [
                    {
                        mask: '000.000.000-00',
                        maxLength: 11
                    },
                    {
                        mask: '00.000.000/0000-00'
                    }
                ]
            });
        });
    </script>
</x-app-layout>