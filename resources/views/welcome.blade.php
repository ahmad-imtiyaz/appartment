<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Apartemen Services') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen">
            <!-- Hero Section -->
            <section class="bg-gradient-to-b from-indigo-600 to-indigo-800 text-white py-20 px-4">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">Layanan Jasa Apartemen</h1>
                    <p class="text-xl md:text-2xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                        Kelola pengajuan laundry, cleaning, AC service, dan maintenance & repair dengan mudah. Terintegrasi dengan sistem saldo dan top up.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-indigo-50 transition-colors">
                                Login
                            </a>
                        @endif
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                                Daftar Sebagai Penyewa
                            </a>
                        @endif
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="py-16 px-4 bg-white">
                <div class="max-w-7xl mx-auto">
                    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Fitur Utama</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Service Request -->
                        <div class="bg-gray-50 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                            <div class="w-16 h-16 mx-auto mb-4 bg-indigo-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Pengajuan Jasa</h3>
                            <p class="text-gray-600">Ajukan laundry, cleaning, AC service, maintenance & repair dengan foto kerusakan dan detail lengkap.</p>
                        </div>

                        <!-- Balance & Top Up -->
                        <div class="bg-gray-50 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                            <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Saldo & Top Up</h3>
                            <p class="text-gray-600">Sistem saldo terintegrasi, top up via transfer bank atau QRIS dengan verifikasi admin.</p>
                        </div>

                        <!-- Tracking -->
                        <div class="bg-gray-50 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                            <div class="w-16 h-16 mx-auto mb-4 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tracking Real-time</h3>
                            <p class="text-gray-600">Pantau status pengajuan: pending → assigned → in_progress → completed. Notifikasi otomatis ke pekerja.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- How it Works -->
            <section class="py-16 px-4 bg-gray-50">
                <div class="max-w-7xl mx-auto">
                    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Alur Pengajuan Jasa</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        @foreach([
                            ['step' => '1', 'title' => 'Ajukan', 'desc' => 'Pilih jasa, isi catatan, upload foto (khusus maintenance)'],
                            ['step' => '2', 'title' => 'Assign', 'desc' => 'Admin assign pekerja yang tersedia'],
                            ['step' => '3', 'title' => 'Kerjakan', 'desc' => 'Pekerja ACC, kerjakan, upload foto hasil'],
                            ['step' => '4', 'title' => 'Selesai', 'desc' => 'Saldo terpotong otomatis, beri feedback'],
                        ] as $item)
                            <div class="relative bg-white rounded-xl p-6 text-center border border-gray-100">
                                @if ($loop->index < 3)
                                    <div class="absolute top-8 right-0 w-full h-0.5 bg-gray-200 hidden md:block"></div>
                                @endif
                                <div class="w-14 h-14 mx-auto mb-4 bg-indigo-600 text-white rounded-full flex items-center justify-center text-2xl font-bold">
                                    {{ $item['step'] }}
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $item['title'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $item['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- CTA -->
            <section class="py-16 px-4 bg-indigo-600 text-white">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-3xl font-bold mb-4">Siap Memulai?</h2>
                    <p class="text-indigo-100 mb-8">Daftar sekarang dan kelola layanan apartemen Anda dengan mudah.</p>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-indigo-50 transition-colors inline-block">
                            Daftar Gratis
                        </a>
                    @endif
                </div>
            </section>

            <!-- Footer -->
            <footer class="bg-gray-900 text-gray-400 py-8 px-4">
                <div class="max-w-7xl mx-auto text-center">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Apartemen Services') }}. All rights reserved.</p>
                    <p class="text-sm mt-2">Laravel v{{ Illuminate\Foundation\Application::VERSION }} | PHP v{{ PHP_VERSION }}</p>
                </div>
            </footer>
        </div>
    </body>
</html>