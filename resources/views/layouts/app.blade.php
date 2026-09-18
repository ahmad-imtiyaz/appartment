<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        @php
            $hasSidebar = in_array(auth()->user()->role ?? 'guest', ['admin', 'pekerja']);
        @endphp

        <div class="min-h-screen bg-[#F6F5F1]">

            <!-- Navigation -->
            @include('layouts.navigation')

            <div class="{{ $hasSidebar ? 'lg:pl-64' : '' }}">

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white border-b border-[#E4E1D9]">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>

            </div>
        </div>
    </body>
</html>
