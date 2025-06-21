<div class="w-64 h-screen bg-[#2c4155] text-gray-300 flex flex-col">
    {{-- BAGIAN LOGO (TETAP DIAM DI ATAS) --}}
    <div class="flex-shrink-0 p-4">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo-pelindo.png') }}" alt="Logo Perusahaan" class="w-auto h-12 mx-auto">
        </a>
    </div>

    {{-- BAGIAN NAVIGASI (AREA YANG BISA DI-SCROLL) --}}
    {{-- Tambahkan kelas `custom-scrollbar` di sini --}}
    <nav class="flex-1 px-4 pb-4 space-y-4 overflow-y-auto custom-scrollbar">

        {{-- Grup Menu Utama --}}
        <div>
            {{-- Menggunakan pt-4 untuk konsistensi jarak atas --}}
            <p class="pt-4 pb-2 text-xs text-gray-500 uppercase tracking-wider">Utama</p>
            <div class="space-y-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center py-2.5 px-4 rounded-lg relative transition-all duration-300 ease-in-out {{ request()->routeIs('dashboard') ? 'bg-sky-800 text-white font-semibold shadow-lg' : 'hover:bg-sky-800/50 hover:text-white' }}">
                    <span
                        class="absolute left-0 top-0 h-full w-1 rounded-r-full transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-sky-400' : 'bg-transparent' }}"></span>
                    <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('aset.index') }}"
                    class="flex items-center py-2.5 px-4 rounded-lg relative transition-all duration-300 ease-in-out {{ request()->routeIs(['aset.index', 'aset.create', 'aset.edit']) ? 'bg-sky-800 text-white font-semibold shadow-lg' : 'hover:bg-sky-800/50 hover:text-white' }}">
                    <span
                        class="absolute left-0 top-0 h-full w-1 rounded-r-full transition-all duration-300 {{ request()->routeIs(['aset.index', 'aset.create', 'aset.edit']) ? 'bg-sky-400' : 'bg-transparent' }}"></span>
                    <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <span>Manajemen Aset</span>
                </a>
            </div>
        </div>

        {{-- Grup Menu Operasional --}}
        <div>
            {{-- Hapus mt-4 dari sini, space-y-4 pada nav sudah cukup --}}
            <p class="px-4 pt-4 pb-2 text-xs text-gray-500 uppercase tracking-wider border-t border-gray-700/50">
                Operasional</p>
            <div class="space-y-2">
                <a href="{{ route('pinjam.index') }}"
                    class="flex items-center py-2.5 px-4 rounded-lg relative transition-all duration-300 ease-in-out {{ request()->routeIs('pinjam.*') ? 'bg-sky-800 text-white font-semibold shadow-lg' : 'hover:bg-sky-800/50 hover:text-white' }}">
                    <span
                        class="absolute left-0 top-0 h-full w-1 rounded-r-full transition-all duration-300 {{ request()->routeIs('pinjam.*') ? 'bg-sky-400' : 'bg-transparent' }}"></span>
                    <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.5 4.5 0 0 0-4.5-4.5H9a4.5 4.5 0 0 0-4.5 4.5v.742c0 1.141-.07 2.278-.214 3.403a4.5 4.5 0 0 0 2.25 4.225l.231.109a1.5 1.5 0 0 1 .83 1.332V18.75a1.5 1.5 0 0 1-1.5 1.5H3.75a1.5 1.5 0 0 1-1.5-1.5V18a2.25 2.25 0 0 1 2.25-2.25H6.75" />
                    </svg>
                    <span>Peminjaman</span>
                </a>
                <a href="{{ route('perawatan.index') }}"
                    class="flex items-center py-2.5 px-4 rounded-lg relative transition-all duration-300 ease-in-out {{ request()->routeIs('perawatan.*') ? 'bg-sky-800 text-white font-semibold shadow-lg' : 'hover:bg-sky-800/50 hover:text-white' }}">
                    <span
                        class="absolute left-0 top-0 h-full w-1 rounded-r-full transition-all duration-300 {{ request()->routeIs('perawatan.*') ? 'bg-sky-400' : 'bg-transparent' }}"></span>
                    <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.43.992a6.759 6.759 0 0 1 0 1.139c-.008.378.137.75.43.99l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.49l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.333.184-.582.496-.645.87l-.213 1.28c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-1.139c.008-.378-.137-.75-.43-.99l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.49l1.217.456c.355.133.75.072 1.076-.124.072-.044.146-.087.22-.128.332-.184.582-.496.644-.87l.213-1.281Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span>Perawatan</span>
                </a>
                @can('approve assets')
                <a href="{{ route('aset.approval') }}"
                    class="flex items-center py-2.5 px-4 rounded-lg relative transition-all duration-300 ease-in-out {{ request()->routeIs('aset.approval') ? 'bg-sky-800 text-white font-semibold shadow-lg' : 'hover:bg-sky-800/50 hover:text-white' }}">
                    <span
                        class="absolute left-0 top-0 h-full w-1 rounded-r-full transition-all duration-300 {{ request()->routeIs('aset.approval') ? 'bg-sky-400' : 'bg-transparent' }}"></span>
                    <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span>Persetujuan Aset</span>
                </a>
                @endcan
            </div>
        </div>

        {{-- Grup Menu Laporan --}}
        <div>
            {{-- Hapus mt-4 dari sini, space-y-4 pada nav sudah cukup --}}
            <p class="px-4 pt-4 pb-2 text-xs text-gray-500 uppercase tracking-wider border-t border-gray-700/50">Laporan
            </p>
            <div class="space-y-2">
                <a href="#"
                    class="flex items-center py-2.5 px-4 rounded-lg relative transition-all duration-300 ease-in-out hover:bg-sky-800/50 hover:text-white">
                    <span class="absolute left-0 top-0 h-full w-1 rounded-r-full bg-transparent"></span>
                    <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <span>Laporan Aset</span>
                </a>
            </div>
        </div>

        {{-- Grup Menu Administrasi --}}
        @role('admin')
        {{-- Hapus mt-4 dari sini, space-y-4 pada nav sudah cukup --}}
        <p class="px-4 pt-4 pb-2 text-xs text-gray-500 uppercase tracking-wider border-t border-gray-700/50">
            Administrasi</p>
        <div class="space-y-2">
            <a href="{{ route('kategori.index') }}"
                class="flex items-center py-2.5 px-4 rounded-lg relative transition-all duration-300 ease-in-out {{ request()->routeIs('kategori.*') ? 'bg-sky-800 text-white font-semibold shadow-lg' : 'hover:bg-sky-800/50 hover:text-white' }}">
                <span
                    class="absolute left-0 top-0 h-full w-1 rounded-r-full transition-all duration-300 {{ request()->routeIs('kategori.*') ? 'bg-sky-400' : 'bg-transparent' }}"></span>
                <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                </svg>
                <span>Kategori</span>
            </a>
            <a href="{{ route('lokasi.index') }}"
                class="flex items-center py-2.5 px-4 rounded-lg relative transition-all duration-300 ease-in-out {{ request()->routeIs('lokasi.*') ? 'bg-sky-800 text-white font-semibold shadow-lg' : 'hover:bg-sky-800/50 hover:text-white' }}">
                <span
                    class="absolute left-0 top-0 h-full w-1 rounded-r-full transition-all duration-300 {{ request()->routeIs('lokasi.*') ? 'bg-sky-400' : 'bg-transparent' }}"></span>
                <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                <span>Lokasi</span>
            </a>
            <a href="{{ route('users.index') }}"
                class="flex items-center py-2.5 px-4 rounded-lg relative transition-all duration-300 ease-in-out {{ request()->routeIs('users.*') ? 'bg-sky-800 text-white font-semibold shadow-lg' : 'hover:bg-sky-800/50 hover:text-white' }}">
                <span
                    class="absolute left-0 top-0 h-full w-1 rounded-r-full transition-all duration-300 {{ request()->routeIs('users.*') ? 'bg-sky-400' : 'bg-transparent' }}"></span>
                <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.53-2.475M15 19.128v-3.386m0 3.386v3.387m0-3.387a6.375 6.375 0 0 0-1.257-4.243M15 19.128V9.75A2.25 2.25 0 0 0 12.75 7.5h-3.75a2.25 2.25 0 0 0-2.25 2.25v9.375m7.5-3.375H5.625m7.5-3.375v-1.5a2.25 2.25 0 0 0-2.25-2.25H5.625a2.25 2.25 0 0 0-2.25 2.25v1.5m7.5 0v-1.5a2.25 2.25 0 0 0-2.25-2.25H5.625a2.25 2.25 0 0 0-2.25 2.25v1.5" />
                </svg>
                <span>Manajemen Pengguna</span>
            </a>
        </div>
        @endrole
    </nav>
</div>

{{-- Custom CSS untuk Scrollbar --}}
<style>
/* For Webkit browsers (Chrome, Safari, Edge) */
.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
    /* Lebar scrollbar */
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #3a5068;
    /* Warna track scrollbar */
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #5d748f;
    /* Warna thumb scrollbar */
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #6f86a0;
    /* Warna thumb saat hover */
}

/* For Firefox */
.custom-scrollbar {
    scrollbar-width: thin;
    /* "auto" or "thin" */
    scrollbar-color: #5d748f #3a5068;
    /* thumb color track color */
}
</style>