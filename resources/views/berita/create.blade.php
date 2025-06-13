<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tulis Berita Baru</h1>
            <p class="text-gray-600">Bagikan informasi terkini</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Judul -->
                <div class="mb-6">
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-heading mr-2 text-blue-500"></i>Judul Berita
                    </label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Masukkan judul berita...">
                    @error('judul')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penulis -->
                <div class="mb-6">
                    <label for="penulis" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-blue-500"></i>Penulis
                    </label>
                    <input type="text" name="penulis" id="penulis" value="{{ old('penulis', auth()->user()->name) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Nama penulis">
                    @error('penulis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto -->
                <div class="mb-6">
                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-image mr-2 text-blue-500"></i>Foto Berita
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition">
                        <input type="file" name="foto" id="foto" class="hidden" accept="image/*" onchange="previewImage(this)">
                        <div id="upload-area" onclick="document.getElementById('foto').click()" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-gray-600">Klik untuk upload foto</p>
                            <p class="text-sm text-gray-500">PNG, JPG, GIF (max 2MB)</p>
                        </div>
                        <div id="image-preview" class="hidden">
                            <img id="preview-img" src="" alt="Preview" class="max-w-full h-48 object-cover rounded-lg mx-auto">
                            <p class="text-sm text-gray-600 mt-2">Klik untuk mengganti foto</p>
                        </div>
                    </div>
                    @error('foto')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konten -->
                <div class="mb-6">
                    <label for="konten" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-2 text-blue-500"></i>Konten Berita
                    </label>
                    <textarea name="konten" id="konten" rows="8" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Tulis konten berita di sini...">{{ old('konten') }}</textarea>
                    @error('konten')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-between">
                    <a href="{{ route('berita.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i>Simpan Berita
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('upload-area').classList.add('hidden');
                    document.getElementById('image-preview').classList.remove('hidden');
                    document.getElementById('preview-img').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
