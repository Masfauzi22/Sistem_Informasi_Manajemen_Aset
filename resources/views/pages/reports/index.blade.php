<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#8c8f8b] leading-tight">
            {{ __('Pusat Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">

                    @if (session('error'))
                    <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-200">
                        {{ session('error') }}
                    </div>
                    @endif

                    <h3 class="text-3xl font-extrabold text-gray-700 dark:text-gray-200 mb-8 border-b pb-4">Generate
                        Laporan Aset</h3>

                    <form action="{{ route('laporan.generate') }}" method="GET" target="_blank">
                        <div class="space-y-6">
                            {{-- Pilihan Jenis Laporan --}}
                            <div>
                                <label for="report_type"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jenis
                                    Laporan <span class="text-red-500">*</span></label>
                                <select id="report_type" name="report_type" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm p-3 transition ease-in-out duration-150">
                                    <option value="" disabled selected>Pilih Jenis Laporan</option>
                                    <option value="all_assets"
                                        {{ old('report_type') == 'all_assets' ? 'selected' : '' }}>Laporan Inventaris
                                        Aset Lengkap</option>
                                    <option value="loan_history"
                                        {{ old('report_type') == 'loan_history' ? 'selected' : '' }}>Laporan Riwayat
                                        Peminjaman</option>
                                    <option value="maintenance_history"
                                        {{ old('report_type') == 'maintenance_history' ? 'selected' : '' }}>Laporan
                                        Riwayat Perawatan</option>
                                </select>
                                @error('report_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Filter Tanggal --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="start_date"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Dari
                                        Tanggal (Opsional)</label>
                                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm p-3 transition ease-in-out duration-150">
                                    @error('start_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="end_date"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Sampai
                                        Tanggal (Opsional)</label>
                                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm p-3 transition ease-in-out duration-150">
                                    @error('end_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-8 pt-5 border-t border-gray-200 dark:border-gray-700/50">
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    Generate & View PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>