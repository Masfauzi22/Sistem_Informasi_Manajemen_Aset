<div class="w-64 min-h-screen bg-[#2c4155] text-white p-4 flex flex-col">
    <div class="mb-10 px-4">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo-pelindo.png') }}" alt="Logo Perusahaan" class="w-auto h-12 mx-auto">
        </a>
    </div>

    <nav class="flex-grow">
        {{-- Menu yang bisa dilihat semua orang --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('aset.index') }}"
            class="flex items-center mt-2 py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('aset.*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
            </svg>
            <span>Manajemen Aset</span>
        </a>

        {{-- GRUP MENU UNTUK ADMIN --}}
        @role('admin')
        <p class="px-4 pt-4 pb-2 text-xs text-gray-400 uppercase tracking-wider">Administrasi</p>

        <a href="{{ route('kategori.index') }}"
            class="flex items-center mt-2 py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('kategori.*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
            </svg>
            <span>Kategori</span>
        </a>
        <a href="{{ route('lokasi.index') }}"
            class="flex items-center mt-2 py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('lokasi.*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
            </svg>
            <span>Lokasi</span>
        </a>
        <a href="{{ route('users.index') }}"
            class="flex items-center mt-2 py-2.5 px-4 rounded-lg transition duration-200 {{ request()->routeIs('users.*') ? 'bg-blue-600' : 'hover:bg-blue-700' }}">
            <svg class="w-6 h-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.53-2.475M15 19.128v-3.386m0 3.386v3.387m0-3.387a6.375 6.375 0 0 0-1.257-4.243M15 19.128V9.75A2.25 2.25 0 0 0 12.75 7.5h-3.75a2.25 2.25 0 0 0-2.25 2.25v9.375m7.5-3.375H5.625m7.5-3.375v-1.5a2.25 2.25 0 0 0-2.25-2.25H5.625a2.25 2.25 0 0 0-2.25 2.25v1.5m7.5 0v-1.5a2.25 2.25 0 0 0-2.25-2.25H5.625a2.25 2.25 0 0 0-2.25 2.25v1.5" />
            </svg>
            <span>Manajemen Pengguna</span>
        </a>
        @endrole
    </nav>
</div>