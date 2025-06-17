<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cadastrar Novo Designer
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('admin.designers.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Nome Completo -->
                    <div>
                        <x-input-label for="name" value="Nome Completo" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- E-mail -->
                    <div>
                        <x-input-label for="email" value="E-mail (Login)" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Cargo -->
                        <div>
                            <x-input-label for="cargo" value="Cargo" />
                            <x-text-input id="cargo" name="cargo" type="text" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('cargo')" />
                        </div>
                        <!-- Custo/Hora -->
                        <div>
                            <x-input-label for="custo_hora" value="Custo por Hora (R$)" />
                            <x-text-input id="custo_hora" name="custo_hora" type="number" step="0.01"
                                class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('custo_hora')" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            Cadastrar Designer
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>