<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <a href="{{ route('berita.index') }}" class="text-blue-500 hover:text-blue-600">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
            </a>
        </nav>

        <!-- Article -->
        <article class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b">
                <div class="flex items-center text-sm text-gray-500 mb-3">
                    <i class="fas fa-calendar mr-2"></i>
                    {{ $berita->created_at->format('d F Y, H:i') }} WIB
                    <span class="mx-3">•</span>
                    <i class="fas fa-user mr-2"></i>
                    {{ $berita->penulis }}
                </div>
                
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">{{ $berita->judul }}</h1>
                
                <!-- Share Buttons -->
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">Bagikan:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                       target="_blank" class="text-blue-600 hover:text-blue-800">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" 
                       target="_blank" class="text-blue-400 hover:text-blue-600">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . request()->url()) }}" 
                       target="_blank" class="text-green-600 hover:text-green-800">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Image -->
            <div class="p-6">
                <img src="{{ Storage::url($berita->foto) }}" alt="{{ $berita->judul }}" 
                     class="w-full h-64 md:h-96 object-cover rounded-lg">
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="prose max-w-none">
                    <p class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $berita->konten }}</p>
                </div>
            </div>

            <!-- Admin Actions -->
            @if(auth()->user()->isAdmin())
                <div class="p-6 bg-yellow-50 border-t">
                    <div class="flex items-center justify-between">
                        <span class="text-yellow-800 font-medium">
                            <i class="fas fa-crown mr-2"></i>Panel Admin
                        </span>
                        <div class="flex space-x-3">
                            <a href="{{ route('berita.edit', $berita) }}" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                            <form action="{{ route('berita.destroy', $berita) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm"
                                        onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                    <i class="fas fa-trash mr-2"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </article>

        <!-- Related Articles -->
        @php
            $relatedArticles = App\Models\Berita::where('id', '!=', $berita->id)->latest()->take(3)->get();
        @endphp
        
        @if($relatedArticles->count() > 0)
            <div class="mt-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Berita Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($relatedArticles as $related)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                            <img src="{{ Storage::url($related->foto) }}" alt="{{ $related->judul }}" 
                                 class="w-full h-32 object-cover rounded-t-lg">
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2 text-sm">
                                    <a href="{{ route('berita.show', $related) }}" class="hover:text-blue-600">
                                        {{ Str::limit($related->judul, 50) }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-xs mb-2">{{ Str::limit($related->konten, 80) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">{{ $related->created_at->format('d M Y') }}</span>
                                    <a href="{{ route('berita.show', $related) }}" class="text-blue-500 text-xs">Baca →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
