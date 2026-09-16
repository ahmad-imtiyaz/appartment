<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Guest')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-200">

        <!-- Mobile app shell: max width, centered, full height -->
        <div class="max-w-md mx-auto min-h-screen bg-gray-50 relative flex flex-col shadow-xl">

            <!-- Header (opsional, per halaman) -->
            @hasSection('header')
                <header class="bg-white border-b border-gray-100 sticky top-0 z-20">
                    <div class="px-4 py-3">
                        @yield('header')
                    </div>
                </header>
            @endif

            <!-- Konten halaman, beri padding bawah supaya tidak ketutup navbar -->
            <main class="flex-1 pb-24">
                @yield('content')
            </main>

            <!-- Bottom Navigation Bar: fixed terhadap viewport, lebar dikunci sama seperti shell max-w-md -->
            <nav class="fixed bottom-0 left-0 right-0 mx-auto max-w-md bg-white border-t border-gray-200 shadow-[0_-2px_10px_rgba(0,0,0,0.05)] z-30">
                <div class="grid grid-cols-4">

                    <a href="{{ route('guest.home') }}"
                       class="flex flex-col items-center justify-center py-2.5 gap-1 {{ request()->routeIs('guest.home') ? 'text-indigo-600' : 'text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('guest.home') ? 2 : 1.5 }}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span class="text-[11px] font-medium">Home</span>
                    </a>

                    <a href="{{ route('guest.service-requests.index') }}"
                       class="flex flex-col items-center justify-center py-2.5 gap-1 {{ request()->routeIs('guest.service-requests.*') ? 'text-indigo-600' : 'text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('guest.service-requests.*') ? 2 : 1.5 }}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                        </svg>
                        <span class="text-[11px] font-medium">Jasa</span>
                    </a>

                    <a href="{{ route('guest.balance') }}"
                       class="flex flex-col items-center justify-center py-2.5 gap-1 {{ request()->routeIs('guest.balance') || request()->routeIs('guest.topups.*') ? 'text-indigo-600' : 'text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('guest.balance') || request()->routeIs('guest.topups.*') ? 2 : 1.5 }}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
                        </svg>
                        <span class="text-[11px] font-medium">Saldo</span>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="flex flex-col items-center justify-center py-2.5 gap-1 {{ request()->routeIs('profile.*') ? 'text-indigo-600' : 'text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('profile.*') ? 2 : 1.5 }}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span class="text-[11px] font-medium">Profil</span>
                    </a>

                </div>
            </nav>

        </div>
    </body>
</html>
