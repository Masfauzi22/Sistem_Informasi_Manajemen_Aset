<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#8c8f8b] leading-tight">
            {{ __('Manajemen Aset') }}
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

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-3xl font-extrabold text-gray-700 dark:text-gray-200">Daftar Aset Perusahaan</h3>
                        @can('create assets')
                        <a href="{{ route('aset.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Aset
                        </a>
                        @endcan
                    </div>

                    {{-- Search Form --}}
                    <div class="mb-4">
                        <form action="{{ route('aset.index') }}" method="GET">
                            <div class="relative flex items-center">
                                <input type="text" name="search" placeholder="Cari aset berdasarkan nama..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ request('search') }}">
                                <div class="absolute top-0 left-0 inline-flex items-center p-2 h-full">
                                    <svg class="w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                @if (request('search'))
                                <a href="{{ route('aset.index') }}"
                                    class="ml-2 px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition duration-150 ease-in-out">Reset</a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Gambar</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        No</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Nama Aset</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Kategori</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Lokasi</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($assets as $asset)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                    {{-- Kolom untuk Gambar --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($asset->image)
                                        <img src="{{ Storage::url($asset->image) }}" alt="{{ $asset->name }}"
                                            class="h-12 w-12 object-cover rounded-md">
                                        @else
                                        <div
                                            class="h-12 w-12 bg-gray-200 dark:bg-gray-700 rounded-md flex items-center justify-center text-xs text-gray-500 dark:text-gray-400">
                                            No Image
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $loop->iteration + ($assets->currentPage() - 1) * $assets->perPage() }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $asset->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $asset->category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $asset->location->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                        $statusClass = '';
                                        switch ($asset->status) {
                                        case 'Tersedia':
                                        $statusClass = 'bg-green-100 text-green-800 dark:bg-green-700
                                        dark:text-green-100';
                                        break;
                                        case 'Dipinjam':
                                        $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700
                                        dark:text-yellow-100';
                                        break;
                                        case 'Rusak':
                                        $statusClass = 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100';
                                        break;
                                        case 'Dalam Perbaikan':
                                        $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100';
                                        break;
                                        case 'Menunggu Persetujuan':
                                        $statusClass = 'bg-orange-100 text-orange-800 dark:bg-orange-700
                                        dark:text-orange-100';
                                        break;
                                        default:
                                        $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100';
                                        break;
                                        }
                                        @endphp
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            {{ $asset->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-2">
                                            {{-- Tombol Edit --}}
                                            @can('edit assets')
                                            <a href="{{ route('aset.edit', $asset->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L15.232 5.232z">
                                                    </path>
                                                </svg>
                                            </a>
                                            @endcan

                                            {{-- Tombol Hapus --}}
                                            @can('delete assets')
                                            <form action="{{ route('aset.destroy', $asset->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini? Ini akan juga menghapus gambar yang terkait.');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">Data aset
                                        tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $assets->appends(['search' => request('search')])->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>