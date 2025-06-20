<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#8c8f8b] leading-tight">
            {{ __('Manajemen Peminjaman') }}
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
                        <h3 class="text-2xl font-extrabold text-gray-700 dark:text-gray-200">Riwayat Peminjaman Aset
                        </h3>
                        <a href="{{ route('pinjam.create') }}"
                            class="inline-flex items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" />
                            </svg>
                            Catat Peminjaman Baru
                        </a>
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
                                        Peminjam</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Tgl Pinjam</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Jatuh Tempo</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Tgl Kembali</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @forelse ($loans as $loan)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $loan->asset->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $loan->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($loan->status == 'Dipinjam') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                @elseif($loan->status == 'Dikembalikan') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 @endif">
                                            {{ $loan->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        {{-- Tombol Kembalikan hanya muncul jika status 'Dipinjam' --}}
                                        @if($loan->status == 'Dipinjam')
                                        <form action="{{ route('pinjam.return', $loan) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="inline-block bg-teal-600 hover:bg-teal-700 text-white font-bold py-1 px-3 rounded text-xs transition duration-150 ease-in-out"
                                                onclick="return confirm('Konfirmasi pengembalian aset ini?')">
                                                Kembalikan
                                            </button>
                                        </form>
                                        @endif

                                        {{-- Tombol Hapus hanya muncul untuk yang punya izin --}}
                                        @can('delete loans')
                                        <form action="{{ route('pinjam.destroy', $loan) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs ml-2"
                                                onclick="return confirm('Anda yakin ingin menghapus riwayat peminjaman ini? Aksi ini tidak bisa dibatalkan.')">
                                                Hapus
                                            </button>
                                        </form>
                                        @endcan

                                        {{-- Jika tidak ada aksi yang bisa dilakukan --}}
                                        @if($loan->status != 'Dipinjam' && !auth()->user()->can('delete loans'))
                                        <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-6 py-8 text-center text-lg text-gray-500 dark:text-gray-400">
                                        Belum ada data peminjaman yang tercatat.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $loans->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>