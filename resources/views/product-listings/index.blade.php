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
                                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between gap-3">
                                        <p class="text-xs text-gray-500">Kontak: {{ $listing->contact_info }}</p>

                                        @if ($listing->whatsapp_url)
                                            <a href="{{ $listing->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-green-500 hover:bg-green-600 text-white text-xs font-semibold transition-colors"
                                               aria-label="Chat WhatsApp tentang {{ $listing->title }}">
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                Chat
                                            </a>
                                        @endif
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
