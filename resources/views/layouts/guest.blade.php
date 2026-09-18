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

                    <a href="{{ route('product-listings.index') }}"
                       class="flex flex-col items-center justify-center py-2.5 gap-1 {{ request()->routeIs('product-listings.*') ? 'text-indigo-600' : 'text-gray-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('product-listings.*') ? 2 : 1.5 }}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v11.25a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25V7.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5.25V4.5a3 3 0 016 0v.75M9 12h6m-6 3.75h4.5" />
                        </svg>
                        <span class="text-[11px] font-medium">Jual Beli</span>
                    </a>

                    <a href="{{ route('guest.profile.edit') }}"
   class="flex flex-col items-center justify-center py-2.5 gap-1 {{ request()->routeIs('guest.profile.*') ? 'text-indigo-600' : 'text-gray-400' }}">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ request()->routeIs('guest.profile.*') ? 2 : 1.5 }}">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
    </svg>
    <span class="text-[11px] font-medium">Profil</span>
</a>

                </div>
             </nav>

          @stack('scripts')

         </div>
     </body>
 </html>
