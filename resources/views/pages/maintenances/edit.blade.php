<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#8c8f8b] leading-tight">
            {{ __('Edit Catatan Perawatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">

                    <h3 class="text-3xl font-extrabold text-gray-700 dark:text-gray-200 mb-8 border-b pb-4">Form Edit
                        Perawatan untuk: {{ $perawatan->asset->name }}</h3>

                    <form action="{{ route('perawatan.update', $perawatan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Dropdown Aset (Read-only) --}}
                        <div class="mb-6">
                            <label for="asset_id"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Aset yang
                                Dirawat</label>
                            <select name="asset_id" id="asset_id" readonly disabled
                                {{-- Tambah readonly dan disabled --}} class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-400 {{-- Warna abu-abu untuk disabled --}}
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                       rounded-md shadow-sm p-3 cursor-not-allowed"> {{-- Cursor not-allowed --}}
                                <option value="{{ $perawatan->asset_id }}" selected>{{ $perawatan->asset->name }}
                                    ({{ $perawatan->asset->serial_number ?? 'N/A' }})</option>
                            </select>
                            {{-- Jika Anda tetap ingin mengirim asset_id, gunakan hidden input --}}
                            <input type="hidden" name="asset_id" value="{{ $perawatan->asset_id }}">
                        </div>

                        {{-- Tipe Perawatan --}}
                        <div class="mb-6">
                            <label for="type"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tipe Perawatan
                                <span class="text-red-500">*</span></label>
                            <select name="type" id="type" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                       rounded-md shadow-sm p-3 transition ease-in-out duration-150 custom-select-scroll">
                                {{-- Tambahkan kelas kustom --}}
                                <option value="" disabled>Pilih Tipe Perawatan</option>
                                <option value="Servis Rutin"
                                    {{ (old('type', $perawatan->type) == 'Servis Rutin') ? 'selected' : '' }}>Servis
                                    Rutin</option>
                                <option value="Perbaikan"
                                    {{ (old('type', $perawatan->type) == 'Perbaikan') ? 'selected' : '' }}>Perbaikan
                                </option>
                                <option value="Pengecekan"
                                    {{ (old('type', $perawatan->type) == 'Pengecekan') ? 'selected' : '' }}>Pengecekan
                                </option>
                                <option value="Kalibrasi"
                                    {{ (old('type', $perawatan->type) == 'Kalibrasi') ? 'selected' : '' }}>Kalibrasi
                                </option>
                            </select>
                            @error('type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Perawatan & Biaya --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                            <div>
                                <label for="maintenance_date"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal
                                    Perawatan <span class="text-red-500">*</span></label>
                                <input type="date" name="maintenance_date" id="maintenance_date" required
                                    value="{{ old('maintenance_date', \Carbon\Carbon::parse($perawatan->maintenance_date)->format('Y-m-d')) }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
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
                                    value="{{ old('cost', $perawatan->cost) }}" min="0" step="any" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
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
                                placeholder="Contoh: Ganti oli mesin dan filter udara.">{{ old('description', $perawatan->description) }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jadwal Perawatan Berikutnya --}}
                        <div class="mb-8">
                            <label for="next_maintenance_date"
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jadwal
                                Perawatan Berikutnya (Opsional)</label>
                            <input type="date" name="next_maintenance_date" id="next_maintenance_date"
                                value="{{ old('next_maintenance_date', $perawatan->next_maintenance_date ? \Carbon\Carbon::parse($perawatan->next_maintenance_date)->format('Y-m-d') : '') }}"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                       rounded-md shadow-sm p-3 transition ease-in-out duration-150">
                            @error('next_maintenance_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-4">
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
                                Update Catatan
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
        // Tom Select untuk dropdown Tipe Perawatan (Opsional, hanya jika opsinya banyak)
        new TomSelect("#type", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: 'Pilih Tipe Perawatan...',
            maxOptions: 10,
        });

        // Catatan: Dropdown asset_id dibuat readonly/disabled, sehingga tidak perlu Tom Select di sini.
        // Jika Anda ingin tetap menampilkan data asset_id di TomSelect tanpa bisa diubah,
        // Anda perlu menyesuaikan inisialisasi TomSelect agar menjadi mode "single item, locked".
        // Contoh:
        // var assetSelect = new TomSelect("#asset_id", {
        //     create: false,
        //     placeholder: 'Pilih Aset...',
        // });
        // assetSelect.disable(); // Ini akan membuat dropdown TomSelect tidak bisa diinteraksi
    });
    </script>
    @endpush
</x-app-layout>