<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jessica's Design - Design de Interiores</title>

    <!-- Fontes (Poppins) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Adiciona a fonte Poppins como padrão */
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Efeito de scroll suave */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Cabeçalho e Navegação -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-gray-800">
                JESSICA'S DESIGN
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="#sobre" class="text-gray-600 hover:text-indigo-600">Sobre</a>
                <a href="#portfolio" class="text-gray-600 hover:text-indigo-600">Portfólio</a>
                <a href="#contato" class="text-gray-600 hover:text-indigo-600">Contato</a>
            </div>
            <a href="{{ route('login') }}" class="hidden md:inline-block px-5 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition-colors">
                Acessar Portal
            </a>
            <!-- Botão de Menu para Mobile -->
            <button id="mobile-menu-button" class="md:hidden text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </nav>
        <!-- Menu Mobile -->
        <div id="mobile-menu" class="md:hidden hidden px-6 pb-4 space-y-2">
            <a href="#sobre" class="block text-gray-600 hover:text-indigo-600">Sobre</a>
            <a href="#portfolio" class="block text-gray-600 hover:text-indigo-600">Portfólio</a>
            <a href="#contato" class="block text-gray-600 hover:text-indigo-600">Contato</a>
            {{-- CORREÇÃO: O botão no menu mobile também foi atualizado --}}
            <a href="{{ route('login') }}" class="block mt-2 px-5 py-2 bg-indigo-600 text-white rounded-lg shadow text-center">Acessar Portal</a>
        </div>
    </header>

    <!-- Seção Principal (Hero) -->
    <main>
        <section class="h-[60vh] md:h-[80vh] bg-cover bg-center flex items-center" style="background-image: url('https://images.unsplash.com/photo-1618220179428-22790b461013?q=80&w=2127&auto=format&fit=crop');">
            <div class="container mx-auto px-6 text-center">
                <div class="bg-black bg-opacity-40 p-8 rounded-lg inline-block">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight">Transformando espaços, <br> realizando sonhos.</h1>
                    <p class="text-lg text-gray-200 mt-4 max-w-2xl mx-auto">Design de interiores que reflete sua personalidade, une beleza, funcionalidade e alto padrão.</p>
                </div>
            </div>
        </section>

        <!-- Seção Sobre e Curiosidades -->
        <section id="sobre" class="py-20 bg-white">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold mb-4">A Essência do Nosso Trabalho</h2>
                <p class="text-gray-600 max-w-3xl mx-auto mb-12">Acreditamos que um projeto vai muito além da estética. Ele deve realizar sonhos e tornar o dia a dia mais prático, confortável e inspirador. Cada ambiente é pensado com sensibilidade e atenção aos detalhes, a partir de uma escuta cuidadosa das suas necessidades.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div class="p-6">
                        <svg class="w-16 h-16 mx-auto mb-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-xl font-semibold mb-2">15 Anos de Experiência</h3>
                        <p class="text-gray-500">Uma década e meia de dedicação, aprimorando a arte de criar espaços únicos e funcionais.</p>
                    </div>
                    <div class="p-6">
                        <svg class="w-16 h-16 mx-auto mb-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        <h3 class="text-xl font-semibold mb-2">Design Exclusivo</h3>
                        <p class="text-gray-500">Cada projeto é uma obra de arte, criada sob medida para refletir a sua identidade e estilo de vida.</p>
                    </div>
                    <div class="p-6">
                        <svg class="w-16 h-16 mx-auto mb-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.085a2 2 0 00-1.736.97l-3.468 5.73a1 1 0 00.233 1.372l3.5 2.5a1 1 0 001.444-.414l.278-.616m7-10l-3.5-7m0 0l-3.5 7"></path></svg>
                        <h3 class="text-xl font-semibold mb-2">Satisfação Garantida</h3>
                        <p class="text-gray-500">Nosso maior prêmio é a sua felicidade. Acompanhamos cada detalhe para garantir um resultado impecável.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Seção Portfólio -->
        <section id="portfolio" class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">
                <h2 class="text-4xl font-bold text-center mb-12">Projetos que Inspiram</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Card de Projeto 1 -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1556020685-ae41abfc9365?q=80&w=1974&auto=format&fit=crop" alt="[Imagem de uma sala de estar moderna]" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold mb-2">Residência no Lago</h3>
                            <p class="text-gray-600">Um apartamento de 120m² para um jovem casal, com um design industrial que une sofisticação e conforto.</p>
                        </div>
                    </div>
                    <!-- Card de Projeto 2 -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1616046229478-9901c5536a45?q=80&w=2080&auto=format&fit=crop" alt="[Imagem de um quarto aconchegante]" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold mb-2">Suíte Master Aconchego</h3>
                            <p class="text-gray-600">Um refúgio urbano que utiliza texturas naturais e iluminação suave para criar uma atmosfera de paz e tranquilidade.</p>
                        </div>
                    </div>
                    <!-- Card de Projeto 3 -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1617806118233-18e1de247200?q=80&w=1974&auto=format&fit=crop" alt="[Imagem de uma cozinha gourmet]" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold mb-2">Cozinha Gourmet Integrada</h3>
                            <p class="text-gray-600">Funcionalidade e elegância se encontram neste espaço, projetado para ser o coração da casa e o palco de grandes momentos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Rodapé -->
    <footer id="contato" class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-4">Vamos conversar sobre o seu projeto?</h2>
            <p class="text-gray-400 mb-8">Entre em contato e vamos transformar seu espaço juntos.</p>
            <p class="text-lg font-semibold">contato@jessicasdesign.com</p>
            <p class="text-lg text-gray-300">(19) 99999-8888</p>
            <p class="text-sm text-gray-500 mt-10">&copy; {{ date('Y') }} Jessica's Design. Todos os direitos reservados.</p>
        </div>
    </footer>
    
    <script>
        // Script para o menu mobile
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
