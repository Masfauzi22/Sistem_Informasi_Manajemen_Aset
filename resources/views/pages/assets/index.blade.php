<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#8c8f8b] leading-tight">
            {{ __('Manajemen Aset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Daftar Aset Perusahaan</h3>
                        {{-- Tombol Tambah diamankan dengan permission 'create assets' --}}
                        @can('create assets')
                        <a href="{{ route('aset.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Tambah Aset
                        </a>
                        @endcan
                    </div>

                    <div class="mb-4">
                        <form action="{{ route('aset.index') }}" method="GET">
                            <div class="relative">
                                <input type="text" name="search" placeholder="Cari aset berdasarkan nama..."
                                    class="w-full pl-10 pr-4 py-2 border rounded-lg text-gray-900"
                                    value="{{ request('search') }}">
                                <div class="absolute top-0 left-0 inline-flex items-center p-2">
                                    <svg class="w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-md">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 ...">No</th>
                                    <th class="px-6 py-3 ...">Nama Aset</th>
                                    <th class="px-6 py-3 ...">Kategori</th>
                                    <th class="px-6 py-3 ...">Lokasi</th>
                                    <th class="px-6 py-3 ...">No. Seri</th>
                                    <th class="px-6 py-3 ...">Harga</th>
                                    <th class="px-6 py-3 ...">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($assets as $asset)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 ...">
                                        {{ $loop->iteration + ($assets->currentPage() - 1) * $assets->perPage() }}</td>
                                    <td class="px-6 py-4 ...">{{ $asset->name }}</td>
                                    <td class="px-6 py-4 ...">{{ $asset->category->name }}</td>
                                    <td class="px-6 py-4 ...">{{ $asset->location->name }}</td>
                                    <td class="px-6 py-4 ...">{{ $asset->serial_number ?? '-' }}</td>
                                    <td class="px-6 py-4 ...">Rp
                                        {{ number_format($asset->purchase_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">

                                        {{-- PERUBAHAN DI SINI: Izin dibuat lebih spesifik --}}
                                        @can('edit assets')
                                        <a href="{{ route('aset.edit', $asset) }}"
                                            class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded text-xs">Edit</a>
                                        @endcan

                                        @can('delete assets')
                                        <form action="{{ route('aset.destroy', $asset) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs ml-2"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus aset ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center ...">Data tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $assets->appends(['search' => request('search')])->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>