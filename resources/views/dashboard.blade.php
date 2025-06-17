<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bom dia, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::user()->role === 'admin')
                @include('dashboards.partials.admin')
            @elseif(Auth::user()->role === 'designer')
                @include('dashboards.partials.designer')
            @elseif(Auth::user()->role === 'cliente')
                {{-- Para clientes, o controller já redireciona, mas podemos ter um fallback --}}
                @include('dashboards.partials.cliente')
            @endif
        </div>
    </div>
</x-app-layout>