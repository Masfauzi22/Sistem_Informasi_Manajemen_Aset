<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#8c8f8b] leading-tight">
            {{ __('Manajemen Perawatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                        <h3 class="text-2xl font-extrabold text-gray-700 dark:text-gray-200">Riwayat Perawatan Aset</h3>
                        @can('create assets') {{-- Menggunakan izin yang sama dengan tambah aset --}}
                        <a href="{{ route('perawatan.create') }}"
                            class="inline-flex items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" />
                            </svg>
                            Tambah Catatan Perawatan
                        </a>
                        @endcan
                    </div>

                    <div class="overflow-x-auto border border-gray-300 rounded-lg shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Nama Aset</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Tipe Perawatan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Biaya</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Jadwal Berikutnya</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @forelse ($maintenances as $maintenance)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $maintenance->asset->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($maintenance->type == 'Perbaikan') bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100
                                                @else bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 @endif">
                                            {{ $maintenance->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($maintenance->maintenance_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">Rp
                                        {{ number_format($maintenance->cost ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $maintenance->next_maintenance_date ? \Carbon\Carbon::parse($maintenance->next_maintenance_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        @can('edit maintenances')
                                        <a href="{{ route('perawatan.edit', $maintenance) }}"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Edit</a>
                                        @endcan
                                        @can('delete maintenances')
                                        <form action="{{ route('perawatan.destroy', $maintenance) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 ml-2"
                                                onclick="return confirm('Anda yakin ingin menghapus catatan perawatan ini?')">Hapus</button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-6 py-8 text-center text-lg text-gray-500 dark:text-gray-400">
                                        Belum ada data perawatan yang tercatat.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $maintenances->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>