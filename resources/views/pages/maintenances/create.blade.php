<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#8c8f8b] leading-tight">
            {{ __('Tambah Catatan Perawatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">

                    <h3 class="text-3xl font-extrabold text-gray-700 dark:text-gray-200 mb-8 border-b pb-4">Form Catatan
                        Perawatan</h3>

                    <form action="{{ route('perawatan.store') }}" method="POST">
                        @csrf

                        {{-- Dropdown Aset (dengan persiapan untuk Tom Select/Select2) --}}
                        <div class="mb-6">
                            <label for="asset_id"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Aset yang
                                Dirawat <span class="text-red-500">*</span></label>
                            <select name="asset_id" id="asset_id" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                       rounded-md shadow-sm p-3 transition ease-in-out duration-150 custom-select-scroll"> {{-- Tambahkan kelas kustom --}}
                                <option value="" disabled selected>Pilih Aset</option>
                                {{-- Value kosong untuk placeholder --}}
                                @foreach ($assets as $asset)
                                <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                    {{ $asset->name }} ({{ $asset->serial_number ?? 'N/A' }})
                                </option>
                                @endforeach
                            </select>
                            @error('asset_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tipe Perawatan --}}
                        <div class="mb-6">
                            <label for="type"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tipe Perawatan
                                <span class="text-red-500">*</span></label>
                            <select name="type" id="type" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                       rounded-md shadow-sm p-3 transition ease-in-out duration-150">
                                <option value="" disabled selected>Pilih Tipe Perawatan</option>
                                {{-- Tambah placeholder --}}
                                <option value="Servis Rutin" {{ old('type') == 'Servis Rutin' ? 'selected' : '' }}>
                                    Servis Rutin</option>
                                <option value="Perbaikan" {{ old('type') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan
                                </option>
                                <option value="Pengecekan" {{ old('type') == 'Pengecekan' ? 'selected' : '' }}>
                                    Pengecekan</option>
                                <option value="Kalibrasi" {{ old('type') == 'Kalibrasi' ? 'selected' : '' }}>Kalibrasi
                                </option>
                            </select>
                            @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Perawatan & Biaya --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6"> {{-- Gap lebih besar --}}
                            <div>
                                <label for="maintenance_date"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal
                                    Perawatan <span class="text-red-500">*</span></label>
                                <input type="date" name="maintenance_date" id="maintenance_date" required
                                    value="{{ old('maintenance_date', date('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                           rounded-md shadow-sm p-3 transition ease-in-out duration-150">
                                @error('maintenance_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="cost"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Biaya (Rp)
                                    <span class="text-red-500">*</span></label>
                                <input type="number" name="cost" id="cost" placeholder="0" required
                                    value="{{ old('cost', 0) }}" min="0" step="any"
                                    {{-- Tambah min dan step untuk angka --}} class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                           rounded-md shadow-sm p-3 transition ease-in-out duration-150">
                                @error('cost')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-6">
                            <label for="description"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Deskripsi
                                Pekerjaan <span class="text-red-500">*</span></label>
                            <textarea name="description" id="description" rows="4" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                       rounded-md shadow-sm p-3 transition ease-in-out duration-150"
                                placeholder="Contoh: Ganti oli mesin dan filter udara.">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jadwal Perawatan Berikutnya --}}
                        <div class="mb-8"> {{-- Margin bawah lebih besar --}}
                            <label for="next_maintenance_date"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jadwal
                                Perawatan Berikutnya (Opsional)</label>
                            <input type="date" name="next_maintenance_date" id="next_maintenance_date"
                                value="{{ old('next_maintenance_date') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                       rounded-md shadow-sm p-3 transition ease-in-out duration-150">
                            @error('next_maintenance_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-4"> {{-- Jarak antar tombol --}}
                            <a href="{{ route('perawatan.index') }}"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md
                                       text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm
                                       text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                                       transition duration-150 ease-in-out">
                                <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Simpan Catatan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk inisialisasi library dropdown dengan search/scroll --}}
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Tom Select untuk dropdown aset
        new TomSelect("#asset_id", {
            create: false, // Tidak mengizinkan membuat opsi baru
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: 'Pilih Aset...',
            maxOptions: 10, // Menentukan berapa banyak opsi yang terlihat sebelum scroll
        });

        // Opsional: Inisialisasi Tom Select untuk dropdown Tipe Perawatan juga, jika opsinya banyak
        new TomSelect("#type", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: 'Pilih Tipe Perawatan...',
            maxOptions: 10,
        });
    });
    </script>
    @endpush
</x-app-layout>