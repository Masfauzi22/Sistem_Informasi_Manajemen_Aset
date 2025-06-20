<div class="w-64 min-h-screen bg-[#2c4155] text-gray-300 p-4 flex flex-col">
    <div class="mb-10 px-4">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo-pelindo.png') }}" alt="Logo Perusahaan" class="w-auto h-12 mx-auto">
        </a>
    </div>

    <nav class="flex-grow">
        {{-- Grup Menu Utama --}}
        <p class="px-4 pt-4 pb-2 text-xs text-gray-500 uppercase tracking-wider">Utama</p>
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

        {{-- Grup Menu Operasional & Persetujuan --}}
        {{-- Grup ini akan berisi Peminjaman dan Persetujuan Aset --}}
        <p class="px-4 pt-6 pb-2 text-xs text-gray-500 uppercase tracking-wider border-t border-gray-700/50 mt-4">
            Operasional
        </p>
        <div class="space-y-2">
            {{-- LINK PEMINJAMAN --}}
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

            {{-- Menu Persetujuan, hanya untuk yang punya izin --}}
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

        {{-- Grup Menu Administrasi (Hanya untuk Role Admin) --}}
        @role('admin')
        <p class="px-4 pt-6 pb-2 text-xs text-gray-500 uppercase tracking-wider border-t border-gray-700/50 mt-4">
            Administrasi
        </p>
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