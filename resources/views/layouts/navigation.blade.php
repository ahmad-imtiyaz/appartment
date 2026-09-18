@php
    $role = auth()->user()->role ?? 'guest';
@endphp

@if (in_array($role, ['admin', 'pekerja']))
    {{-- ============================================================
        SIDEBAR — untuk admin & pekerja
    ============================================================ --}}
    <div x-data="{ sidebarOpen: false }">

        {{-- Mobile top bar --}}
        <div class="lg:hidden flex items-center justify-between bg-[#16231F] px-4 py-3">
            <a href="{{ route($role === 'admin' ? 'admin.dashboard' : 'worker.tasks.index') }}" class="flex items-center gap-2">
                <x-application-logo class="h-7 w-auto fill-current text-white" />
                <span class="text-white font-semibold text-sm">Bersih.id</span>
            </a>
            <button @click="sidebarOpen = true" class="text-[#A9B8B0] hover:text-white p-2 -mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" class="h-6 w-6">
                    <line x1="3" y1="5.5" x2="17" y2="5.5" />
                    <line x1="3" y1="10" x2="17" y2="10" />
                    <line x1="3" y1="14.5" x2="17" y2="14.5" />
                </svg>
            </button>
        </div>

        {{-- Backdrop (mobile) --}}
        <div x-show="sidebarOpen" x-cloak
             x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-black/40 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 flex flex-col bg-[#16231F] transform transition-transform duration-200 ease-in-out lg:translate-x-0"
        >
            {{-- Brand --}}
            <div class="flex items-center justify-between px-5 h-16 border-b border-white/10 shrink-0">
                <a href="{{ route($role === 'admin' ? 'admin.dashboard' : 'worker.tasks.index') }}" class="flex items-center gap-2.5">
                    <x-application-logo class="h-7 w-auto fill-current text-white" />
                    <span class="text-white font-semibold text-[15px] tracking-tight">Bersih.id</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-[#A9B8B0] hover:text-white p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" class="h-5 w-5">
                        <line x1="5" y1="5" x2="15" y2="15" />
                        <line x1="15" y1="5" x2="5" y2="15" />
                    </svg>
                </button>
            </div>

            {{-- Nav groups --}}
            @php
                $iconPaths = [
                    'home'       => '<path d="M3 9.5 10 4l7 5.5V16a1 1 0 0 1-1 1h-3.5v-4.5h-5V17H4a1 1 0 0 1-1-1V9.5Z" />',
                    'clipboard'  => '<rect x="5" y="4" width="10" height="13" rx="1.2" /><path d="M8 4V3.2A1.2 1.2 0 0 1 9.2 2h1.6A1.2 1.2 0 0 1 12 3.2V4" /><line x1="7.5" y1="9" x2="12.5" y2="9" /><line x1="7.5" y1="12" x2="12.5" y2="12" />',
                    'check'      => '<rect x="5" y="4" width="10" height="13" rx="1.2" /><path d="M8 4V3.2A1.2 1.2 0 0 1 9.2 2h1.6A1.2 1.2 0 0 1 12 3.2V4" /><polyline points="7.5,10.8 9,12.3 12.5,8.8" />',
                    'users'      => '<circle cx="7.3" cy="7" r="2.3" /><path d="M3 16c0-2.5 2-4 4.3-4s4.3 1.5 4.3 4" /><circle cx="14" cy="8" r="1.8" /><path d="M13 16c0-1.8 1.2-3.2 3-3.6" />',
                    'banknotes'  => '<rect x="2.5" y="6" width="15" height="8" rx="1.2" /><circle cx="10" cy="10" r="2" />',
                    'tag'        => '<path d="M10 3 3 10l6 6 7-7V3h-6Z" /><circle cx="12.5" cy="5.5" r="0.8" fill="currentColor" stroke="none" />',
                    'sparkles'   => '<path d="M10 3v3M10 14v3M3 10h3M14 10h3M5.5 5.5l1.8 1.8M12.7 12.7l1.8 1.8M14.5 5.5l-1.8 1.8M7.3 12.7l-1.8 1.8" />',
                    'cloud'      => '<path d="M6 14h8a3 3 0 0 0 .3-6 4.5 4.5 0 0 0-8.6-1A3.5 3.5 0 0 0 6 14Z" />',
                    'card'       => '<rect x="2.5" y="5" width="15" height="10" rx="1.5" /><line x1="2.5" y1="8.3" x2="17.5" y2="8.3" />',
                    'shop'       => '<path d="M4 7h12l-1 9.5a1 1 0 0 1-1 .9H6a1 1 0 0 1-1-.9L4 7Z" /><path d="M7 7V5.5a3 3 0 0 1 6 0V7" />',
                ];

                $navGroups = $role === 'admin' ? [
                    'Utama' => [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
                    ],
                    'Operasional' => [
                        ['route' => 'admin.service-requests.index', 'label' => 'Service Request', 'icon' => 'clipboard'],
                        ['route' => 'admin.workers.index', 'label' => 'Pekerja', 'icon' => 'users'],
                        ['route' => 'admin.topups.index', 'label' => 'Top Up', 'icon' => 'banknotes'],
                    ],
                    'Harga layanan' => [
                        ['route' => 'admin.laundry-pricings.index', 'label' => 'Laundry', 'icon' => 'tag'],
                        ['route' => 'admin.cleaning-pricings.index', 'label' => 'Cleaning', 'icon' => 'sparkles'],
                        ['route' => 'admin.ac-pricings.index', 'label' => 'AC', 'icon' => 'cloud'],
                    ],
                    'Lainnya' => [
                        ['route' => 'admin.payment-methods.index', 'label' => 'Payment Method', 'icon' => 'card'],
                        ['route' => 'admin.product-listings.index', 'label' => 'Jual-Beli', 'icon' => 'shop'],
                        ['route' => 'admin.coin-settings.index', 'label' => 'Setting Koin', 'icon' => 'banknotes'],
                    ],
                ] : [
                    'Utama' => [
                        ['route' => 'worker.tasks.index', 'label' => 'Tugas Saya', 'icon' => 'check'],
                    ],
                ];
            @endphp

            <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-6">
                @foreach ($navGroups as $groupLabel => $items)
                    <div>
                        <p class="px-2.5 mb-1.5 text-xs text-[#6E7D75]">{{ $groupLabel }}</p>
                        <div class="space-y-0.5">
                            @foreach ($items as $item)
                                @php
                                    // Cocokkan berdasarkan grup route (mis. "admin.service-requests")
                                    // supaya sub-halaman seperti .show, .assign, dll tetap dianggap aktif —
                                    // bukan hanya action .index yang tercantum di menu.
                                    $activeGroup = \Illuminate\Support\Str::beforeLast($item['route'], '.');
                                    $active = request()->routeIs($activeGroup . '.*') || request()->routeIs($item['route']);
                                @endphp
                                <a href="{{ route($item['route']) }}"
                                   class="group relative flex items-center gap-3 rounded-md px-2.5 py-2 text-[13.5px] transition-colors
                                          {{ $active ? 'bg-[#24382F] text-white' : 'text-[#A9B8B0] hover:bg-white/5 hover:text-white' }}">
                                    @if ($active)
                                        <span class="absolute left-0 top-1.5 bottom-1.5 w-0.5 rounded-full bg-[#5FA98A]"></span>
                                    @endif
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none"
                                         stroke="{{ $active ? '#5FA98A' : 'currentColor' }}" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"
                                         class="h-[18px] w-[18px] shrink-0">
                                        {!! $iconPaths[$item['icon']] !!}
                                    </svg>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>

            {{-- User footer --}}
            <div class="border-t border-white/10 p-4 shrink-0">
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="h-8 w-8 rounded-full bg-[#5FA98A]/20 flex items-center justify-center text-[#5FA98A] text-xs font-semibold shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-[13px] text-white truncate leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[11.5px] text-[#6E7D75] leading-tight">{{ ucfirst($role) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{ route($role === 'admin' ? 'admin.profile.edit' : 'worker.profile.edit') }}"
                       class="flex-1 flex items-center gap-1.5 rounded-md px-2 py-1.5 text-[12.5px] text-[#A9B8B0] hover:bg-white/5 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" class="h-4 w-4">
                            <circle cx="10" cy="7" r="3" />
                            <path d="M4 17c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5" />
                        </svg>
                        Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-1.5 rounded-md px-2 py-1.5 text-[12.5px] text-[#A9B8B0] hover:bg-white/5 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                <path d="M8 4H4.8A1.8 1.8 0 0 0 3 5.8v8.4A1.8 1.8 0 0 0 4.8 16H8" />
                                <path d="M12 13l4-3-4-3" />
                                <line x1="16" y1="10" x2="7.5" y2="10" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>
    </div>
@else
    {{-- ============================================================
        TOP NAV — tetap seperti semula, untuk guest
    ============================================================ --}}
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('guest.service-requests.index') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        </a>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        @php
                            $navItems = [
                                ['route' => 'guest.service-requests.index', 'label' => 'Service Request'],
                                ['route' => 'guest.topups.index', 'label' => 'Top Up'],
                                ['route' => 'guest.balance', 'label' => 'Saldo'],
                                ['route' => 'product-listings.index', 'label' => 'Jual-Beli'],
                            ];
                        @endphp
                        @foreach ($navItems as $item)
                            <x-nav-link :href="route($item['route'])" :active="request()->routeIs($item['route'] . '*')">
                                {{ $item['label'] }}
                            </x-nav-link>
                        @endforeach
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-2 px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    Guest
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('guest.profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                @foreach ($navItems as $item)
                    <x-responsive-nav-link :href="route($item['route'])" :active="request()->routeIs($item['route'] . '*')">
                        {{ $item['label'] }}
                    </x-responsive-nav-link>
                @endforeach
            </div>
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('guest.profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </nav>
@endif
