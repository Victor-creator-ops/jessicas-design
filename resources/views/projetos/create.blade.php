<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cadastrar Novo Projeto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">

                {{-- O formulário agora é controlado pelo Alpine.js para a lógica dinâmica --}}
                <form action="{{ route('projetos.store') }}" method="POST" class="space-y-6" x-data="{ 
                          modalidade: 'valor_fechado', 
                          area_m2: 0, 
                          preco_m2: 210, 
                          pacote_horas: 0, 
                          preco_hora: 290, 
                          valor_contrato: 0,
                          get valorCalculado() {
                              if (this.modalidade === 'm2') {
                                  return (this.area_m2 * this.preco_m2).toFixed(2);
                              }
                              if (this.modalidade === 'horas') {
                                  return (this.pacote_horas * this.preco_hora).toFixed(2);
                              }
                              return this.valor_contrato;
                          }
                      }">
                    @csrf

                    {{-- Campos de Nome e Descrição --}}
                    <div>
                        <x-input-label for="nome" value="Nome do Projeto" />
                        <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full" :value="old('nome')"
                            required autofocus />
                    </div>
                    <div>
                        <x-input-label for="descricao" value="Breve Descrição" />
                        <textarea id="descricao" name="descricao"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            rows="3">{{ old('descricao') }}</textarea>
                    </div>

                    {{-- Selecionar Cliente e Designers --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="cliente_id" value="Cliente" />
                            {{-- CORREÇÃO: Loop para preencher os clientes --}}
                            <select name="cliente_id" id="cliente_id"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">Selecione um cliente</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="designers" value="Atribuir a Designer(s)" />
                            {{-- CORREÇÃO: Loop para preencher os designers --}}
                            <select name="designers[]" id="designers" multiple
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                @foreach ($designers as $designer)
                                    <option value="{{ $designer->id }}">{{ $designer->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="border-t pt-6 space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Detalhes de Cobrança</h3>

                        <!-- Modalidade de Cobrança -->
                        <div>
                            <x-input-label for="modalidade_cobranca" value="Modalidade de Cobrança" />
                            <select name="modalidade_cobranca" id="modalidade_cobranca" x-model="modalidade"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                <option value="valor_fechado">Valor Fechado (Escopo Fixo)</option>
                                <option value="m2">Por Metro Quadrado (m²)</option>
                                <option value="horas">Por Pacote de Horas</option>
                            </select>
                        </div>

                        <!-- Campos que aparecem condicionalmente -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Campo para m² --}}
                            <div x-show="modalidade === 'm2'" x-transition>
                                <x-input-label for="area_m2" value="Área (m²)" />
                                <x-text-input id="area_m2" name="area_m2" type="number" x-model.number="area_m2"
                                    class="mt-1 block w-full" />
                            </div>
                            {{-- Campo para Horas --}}
                            <div x-show="modalidade === 'horas'" x-transition>
                                <x-input-label for="pacote_horas" value="Pacote de Horas" />
                                <x-text-input id="pacote_horas" name="pacote_horas" type="number"
                                    x-model.number="pacote_horas" class="mt-1 block w-full" />
                            </div>
                        </div>

                        <!-- Valor do Contrato -->
                        <div>
                            <x-input-label for="valor_contrato" value="Valor Final do Contrato (R$)" />
                            {{-- CORREÇÃO: Substituímos <x-text-input> por <input> para evitar o erro de compilação --}}
                                <input id="valor_contrato" name="valor_contrato" type="number" step="0.01"
                                    :value="valorCalculado" :readonly="modalidade !== 'valor_fechado'"
                                    x-model.number="valor_contrato"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    :class="{ 'bg-gray-100': modalidade !== 'valor_fechado' }" />
                        </div>
                    </div>

                    {{-- Campos de Data e Cor --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
                        <div>
                            <x-input-label for="data_inicio" value="Data de Início" />
                            <x-text-input id="data_inicio" name="data_inicio" type="date" class="mt-1 block w-full"
                                :value="old('data_inicio')" />
                        </div>
                        <div>
                            <x-input-label for="cor_tema" value="Cor Tema do Projeto" />
                            <x-text-input id="cor_tema" name="cor_tema" type="color" class="mt-1 block w-full h-10"
                                :value="old('cor_tema', '#4f46e5')" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            Salvar Projeto
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>