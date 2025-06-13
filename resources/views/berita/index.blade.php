<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Portal Berita</h1>
                    <p class="text-gray-600">Berita terkini dan terpercaya</p>
                </div>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('berita.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-plus mr-2"></i>Tambah Berita
                    </a>
                @endif
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- News Grid -->
        @if($beritas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($beritas as $berita)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                        <!-- Image -->
                        <div class="relative">
                            <img src="{{ Storage::url($berita->foto) }}" alt="{{ $berita->judul }}" 
                                 class="w-full h-48 object-cover rounded-t-lg">
                            @if(auth()->user()->isAdmin())
                                <div class="absolute top-2 right-2 flex space-x-1">
                                    <a href="{{ route('berita.edit', $berita) }}" 
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-full text-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('berita.destroy', $berita) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full text-sm"
                                                onclick="return confirm('Hapus berita ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $berita->created_at->format('d M Y') }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-user mr-1"></i>
                                {{ $berita->penulis }}
                            </div>
                            
                            <h3 class="font-semibold text-gray-800 mb-2 hover:text-blue-600 transition">
                                <a href="{{ route('berita.show', $berita) }}">{{ $berita->judul }}</a>
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($berita->konten, 100) }}</p>
                            
                            <a href="{{ route('berita.show', $berita) }}" 
                               class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                                Baca selengkapnya →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $beritas->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-newspaper text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Berita</h3>
                <p class="text-gray-500 mb-6">Mulai dengan menambahkan berita pertama</p>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('berita.create') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        <i class="fas fa-plus mr-2"></i>Tambah Berita
                    </a>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
