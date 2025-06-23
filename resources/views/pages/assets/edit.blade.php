<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#8c8f8b] leading-tight">
            {{ __('Edit Aset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">

                    {{-- Notifikasi Sukses/Error --}}
                    @if (session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-200">
                        {{ session('error') }}
                    </div>
                    @endif

                    <h3 class="text-3xl font-extrabold text-gray-700 dark:text-gray-200 mb-8 border-b pb-4">Form Edit
                        Aset: <span class="text-indigo-600 dark:text-indigo-400">{{ $aset->name }}</span></h3>

                    {{-- PERUBAHAN PENTING: tambahkan enctype="multipart/form-data" untuk upload file --}}
                    <form action="{{ route('aset.update', $aset) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama Aset --}}
                        <div class="mb-4">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama
                                Aset <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $aset->name) }}" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Dropdown Kategori --}}
                        <div class="mb-4">
                            <label for="category_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Kategori <span
                                    class="text-red-500">*</span></label>
                            <select name="category_id" id="category_id" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Pilih Kategori
                                </option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $aset->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Dropdown Lokasi --}}
                        <div class="mb-4">
                            <label for="location_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Lokasi <span
                                    class="text-red-500">*</span></label>
                            <select name="location_id" id="location_id" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" disabled {{ old('location_id') ? '' : 'selected' }}>Pilih Lokasi
                                </option>
                                @foreach ($locations as $location)
                                <option value="{{ $location->id }}"
                                    {{ old('location_id', $aset->location_id) == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('location_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- TAMPILKAN GAMBAR SAAT INI & FIELD UPLOAD BARU --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Gambar Saat
                                Ini</label>
                            @if ($aset->image)
                            <img src="{{ Storage::url($aset->image) }}" alt="{{ $aset->name }}"
                                class="h-32 w-auto object-cover rounded-md mb-2 border border-gray-300 dark:border-gray-600">
                            <label class="flex items-center text-sm text-gray-700 dark:text-gray-200 mt-2">
                                <input type="checkbox" name="clear_image" value="1"
                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Hapus gambar ini</span>
                            </label>
                            @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada gambar yang diunggah.</p>
                            @endif
                            <label for="image"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1 mt-4">Ganti
                                Gambar (Opsional)</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                            " />
                            @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nomor Seri --}}
                        <div class="mb-4">
                            <label for="serial_number"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nomor
                                Seri (Opsional)</label>
                            <input type="text" name="serial_number" id="serial_number"
                                value="{{ old('serial_number', $aset->serial_number) }}"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('serial_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Beli & Harga Beli --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="purchase_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tanggal
                                    Beli <span class="text-red-500">*</span></label>
                                <input type="date" name="purchase_date" id="purchase_date"
                                    value="{{ old('purchase_date', $aset->purchase_date) }}" required
                                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('purchase_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="purchase_price"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Harga Beli
                                    (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" name="purchase_price" id="purchase_price"
                                    value="{{ old('purchase_price', $aset->purchase_price) }}" required min="0"
                                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('purchase_price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Status <span
                                    class="text-red-500">*</span></label>
                            <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="Tersedia"
                                    {{ old('status', $aset->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Dipinjam"
                                    {{ old('status', $aset->status) == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="Rusak" {{ old('status', $aset->status) == 'Rusak' ? 'selected' : '' }}>
                                    Rusak</option>
                                <option value="Dalam Perbaikan"
                                    {{ old('status', $aset->status) == 'Dalam Perbaikan' ? 'selected' : '' }}>Dalam
                                    Perbaikan</option>
                                <option value="Menunggu Persetujuan"
                                    {{ old('status', $aset->status) == 'Menunggu Persetujuan' ? 'selected' : '' }}>
                                    Menunggu Persetujuan</option>
                                <option value="Ditolak"
                                    {{ old('status', $aset->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Deskripsi
                                (Opsional)</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $aset->description) }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('aset.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Batal</a>
                            <button type="submit"
                                class="ms-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Update
                                Aset</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>