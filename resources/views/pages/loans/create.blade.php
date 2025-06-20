<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#8c8f8b] leading-tight">
            {{ __('Catat Peminjaman Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <h3 class="text-3xl font-extrabold text-gray-700 dark:text-gray-200 mb-8 border-b pb-4">Form
                        Peminjaman Aset</h3>

                    <form action="{{ route('pinjam.store') }}" method="POST">
                        @csrf

                        {{-- Dropdown Peminjam --}}
                        <div class="mb-6">
                            <label for="user_id"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Peminjam
                                <span class="text-red-500">*</span></label>
                            <select name="user_id" id="user_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                       rounded-md shadow-sm p-3 transition ease-in-out duration-150">
                                <option value="" disabled selected>Pilih Peminjam</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Dropdown Aset yang Tersedia (dengan persiapan untuk Tom Select/Select2) --}}
                        <div class="mb-6">
                            <label for="asset_id"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Aset yang
                                Dipinjam <span class="text-red-500">*</span></label>
                            <select name="asset_id" id="asset_id" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                       rounded-md shadow-sm p-3 transition ease-in-out duration-150 custom-select-scroll"> {{-- Tambahkan kelas kustom --}}
                                <option value="" disabled selected>Pilih Aset yang Tersedia</option>
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

                        {{-- Tanggal Pinjam & Jatuh Tempo --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                            <div>
                                <label for="loan_date"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal
                                    Pinjam <span class="text-red-500">*</span></label>
                                <input type="date" name="loan_date" id="loan_date"
                                    value="{{ old('loan_date', date('Y-m-d')) }}" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                           rounded-md shadow-sm p-3 transition ease-in-out duration-150">
                                @error('loan_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="due_date"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jatuh
                                    Tempo Pengembalian <span class="text-red-500">*</span></label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                           rounded-md shadow-sm p-3 transition ease-in-out duration-150">
                                @error('due_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-8">
                            <label for="notes"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Catatan
                                (Opsional)</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                       rounded-md shadow-sm p-3 transition ease-in-out duration-150">{{ old('notes') }}</textarea>
                            @error('notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-4">
                            <a href="{{ route('pinjam.index') }}"
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
                                Simpan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk inisialisasi library dropdown dengan search/scroll --}}
    @push('scripts')
    {{-- Contoh dengan Tom Select (Anda perlu menginstalnya via NPM dan mengcompile aset) --}}
    {{-- Contoh link CDN (tidak disarankan untuk produksi, hanya untuk demo cepat): --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet"> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script> --}}

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Tom Select untuk dropdown aset
        new TomSelect("#asset_id", {
            create: false, // Tidak mengizinkan membuat opsi baru
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: 'Pilih Aset yang Tersedia...',
            // Jika ingin menambahkan max item per halaman sebelum scroll muncul
            maxOptions: 10, // Menentukan berapa banyak opsi yang terlihat sebelum scroll
        });

        // Opsional: Jika ingin Tom Select juga di dropdown peminjam
        new TomSelect("#user_id", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: 'Pilih Peminjam...',
            maxOptions: 10,
        });
    });
    </script>
    @endpush
</x-app-layout>