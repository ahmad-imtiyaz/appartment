<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Info Jual-Beli') }}
        </h2>
    </x-slot>

    <div class="py-4 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            @if ($listings->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="mt-3 text-lg">Belum ada info jual-beli</p>
                    <p class="text-sm">Silakan cek kembali nanti</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($listings as $listing)
                        <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                            @if ($listing->image)
                                <a href="{{ Storage::url($listing->image) }}" target="_blank">
                                    <img src="{{ Storage::url($listing->image) }}" alt="{{ $listing->title }}" class="w-full h-48 object-cover">
                                </a>
                            @else
                                <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-semibold text-gray-900 text-lg">{{ $listing->title }}</h3>
                                    @if ($listing->category)
                                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">{{ $listing->category }}</span>
                                    @endif
                                </div>
                                
                                @if ($listing->price)
                                    <p class="text-xl font-bold text-indigo-600 mb-2">Rp{{ number_format($listing->price, 0, ',', '.') }}</p>
                                @endif
                                
                                @if ($listing->description)
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-3">{{ $listing->description }}</p>
                                @endif
                                
                                @if ($listing->contact_info)
                                    <div class="pt-3 border-t border-gray-100">
                                        <p class="text-xs text-gray-500">Kontak: {{ $listing->contact_info }}</p>
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                {{ $listings->links() }}
            @endif
        </div>
    </div>
</x-app-layout>