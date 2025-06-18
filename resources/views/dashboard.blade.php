<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#8c8f8b] leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="mb-6 flex justify-start space-x-2">
                <a href="{{ route('dashboard', ['period' => 'this_month']) }}"
                    class="px-4 py-2 rounded-md text-sm font-medium shadow-sm {{ ($period ?? 'all_time') == 'this_month' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    Bulan Ini
                </a>
                <a href="{{ route('dashboard', ['period' => 'this_year']) }}"
                    class="px-4 py-2 rounded-md text-sm font-medium shadow-sm {{ ($period ?? 'all_time') == 'this_year' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    Tahun Ini
                </a>
                <a href="{{ route('dashboard', ['period' => 'all_time']) }}"
                    class="px-4 py-2 rounded-md text-sm font-medium shadow-sm {{ ($period ?? 'all_time') == 'all_time' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    Sepanjang Waktu
                </a>
            </div>


            {{-- Kartu Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="relative bg-gradient-to-br from-blue-400 to-blue-600 text-white p-6 rounded-lg shadow-lg overflow-hidden">
                    <div class="absolute top-4 right-4 opacity-[.35]"><svg class="w-12 h-12"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg></div>
                    <div>
                        <h3 class="text-lg font-semibold">Total Aset</h3>
                        <p class="text-3xl font-bold mt-2">{{ $assetCount }}</p>
                    </div>
                </div>
                <div
                    class="relative bg-gradient-to-br from-green-400 to-green-600 text-white p-6 rounded-lg shadow-lg overflow-hidden">
                    <div class="absolute top-4 right-4 opacity-[.35]"><svg class="w-12 h-12"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75-.75v-.75M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5" />
                        </svg></div>
                    <div>
                        <h3 class="text-lg font-semibold">Total Nilai Aset</h3>
                        <p class="text-3xl font-bold mt-2">Rp {{ number_format($assetValue, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div
                    class="relative bg-gradient-to-br from-purple-400 to-purple-600 text-white p-6 rounded-lg shadow-lg overflow-hidden">
                    <div class="absolute top-4 right-4 opacity-[.35]"><svg class="w-12 h-12"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                        </svg></div>
                    <div>
                        <h3 class="text-lg font-semibold">Total Kategori</h3>
                        <p class="text-3xl font-bold mt-2">{{ $categoryCount }}</p>
                    </div>
                </div>
                <div
                    class="relative bg-gradient-to-br from-orange-400 to-orange-600 text-white p-6 rounded-lg shadow-lg overflow-hidden">
                    <div class="absolute top-4 right-4 opacity-[.35]"><svg class="w-12 h-12"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg></div>
                    <div>
                        <h3 class="text-lg font-semibold">Total Lokasi</h3>
                        <p class="text-3xl font-bold mt-2">{{ $locationCount }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Aset per Kategori</h3>
                        <div class="mx-auto w-full max-w-lg"><canvas id="assetByCategoryChart"></canvas></div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Aset per Status</h3>
                        <div class="mx-auto w-full max-w-lg"><canvas id="assetByStatusChart"></canvas></div>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">5 Aset Terbaru Ditambahkan</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="border-b-2 border-gray-200 dark:border-gray-700">
                                    <tr>
                                        <th class="py-2 px-4 text-left font-semibold">Nama Aset</th>
                                        <th class="py-2 px-4 text-left font-semibold">Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentAssets as $asset)
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <td class="py-2 px-4">{{ $asset->name }}</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">{{ $asset->category->name }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="py-4 px-4 text-center text-gray-500">Tidak ada aset baru.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Aset yang Perlu Perhatian</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="border-b-2 border-gray-200 dark:border-gray-700">
                                    <tr>
                                        <th class="py-2 px-4 text-left font-semibold">Nama Aset</th>
                                        <th class="py-2 px-4 text-left font-semibold">Lokasi</th>
                                        <th class="py-2 px-4 text-left font-semibold">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($attentionAssets as $asset)
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <td class="py-2 px-4">{{ $asset->name }}</td>
                                        <td class="py-2 px-4 text-sm text-gray-500">{{ $asset->location->name }}</td>
                                        <td class="py-2 px-4"><span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $asset->status == 'Rusak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">{{ $asset->status }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="py-4 px-4 text-center text-gray-500">Semua aset dalam
                                            kondisi baik.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
    const categoryCtx = document.getElementById('assetByCategoryChart');
    if (categoryCtx) {
        new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    label: 'Jumlah Aset',
                    data: @json($categoryData),
                    backgroundColor: ['rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 206, 86, 0.8)', 'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)', 'rgba(255, 159, 64, 0.8)'
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    }
    const statusCtx = document.getElementById('assetByStatusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: @json($statusLabels),
                datasets: [{
                    label: 'Jumlah Aset',
                    data: @json($statusData),
                    backgroundColor: ['rgba(75, 192, 192, 0.8)', 'rgba(255, 159, 64, 0.8)',
                        'rgba(255, 99, 132, 0.8)', 'rgba(153, 102, 255, 0.8)'
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    }
    </script>
    @endpush
</x-app-layout>