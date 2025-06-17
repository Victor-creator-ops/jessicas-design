<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 bg-cover bg-center"
        style="background-image: url('https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?q=80&w=1974&auto=format&fit=crop')">

        <div>
            <a href="/" class="text-4xl font-extrabold text-white" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">
                JESSICA'S DESIGN
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white/50 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>