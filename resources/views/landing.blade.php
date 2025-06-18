<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Aset Pelindo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Menambahkan Font Awesome untuk ikon (opsional, jika masih ingin ikon di tombol) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Animasi Fade-in umum */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeIn 0.8s ease-out forwards;
        }

        /* Hover state untuk tombol yang lebih halus */
        .btn-minimal {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
        }
        .btn-minimal:hover {
            transform: translateY(-2px); /* Slight lift */
        }
        /* Hover untuk tombol login utama */
        .btn-primary-minimal:hover {
            background-color: #2563eb; /* Biru lebih gelap */
        }
        /* Hover untuk tombol register/secondary */
        .btn-secondary-minimal:hover {
            background-color: #374151; /* Abu-abu lebih gelap */
            color: #e5e7eb; /* Teks sedikit lebih terang */
            border-color: #4b5563; /* Border sedikit lebih gelap */
        }
    </style>
</head>
<body class="antialiased bg-gray-950 text-white font-inter"> {{-- Menggunakan warna latar belakang yang sangat gelap --}}
    <div class="relative min-h-screen flex flex-col">

        {{-- HEADER / NAVIGASI --}}
        <nav class="relative z-10 w-full p-6 flex justify-end items-center">
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="btn-minimal btn-primary-minimal inline-block bg-blue-600 text-white font-medium py-2 px-6 rounded-lg text-sm shadow-md">
                    <i class="fas fa-sign-in-alt mr-1"></i> Login
                </a>
                <a href="{{ route('register') }}" class="btn-minimal btn-secondary-minimal inline-block bg-transparent border border-gray-600 text-gray-300 font-medium py-2 px-6 rounded-lg text-sm shadow-md">
                    <i class="fas fa-user-plus mr-1"></i> Register
                </a>
            </div>
        </nav>

        {{-- KONTEN UTAMA (Tengah Halaman) --}}
        <main class="relative z-0 flex flex-1 items-center justify-center p-6 md:p-8">
            <div class="text-center max-w-2xl mx-auto"> {{-- Menghilangkan card transparan untuk kesan lebih bersih --}}
                
                {{-- Logo dengan animasi --}}
                <div class="fade-in-up" style="animation-delay: 0.2s;">
                    {{-- Ganti logo jika ada versi monokrom atau yang lebih minimalis --}}
                    <img src="{{ asset('images/logo-pelindo.png') }}" alt="Logo Pelindo" class="w-auto h-28 md:h-32 mx-auto mb-10 opacity-90">
                </div>

                {{-- Judul dengan animasi --}}
                <div class="fade-in-up" style="animation-delay: 0.4s;">
                    <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold mb-4 tracking-tight text-white leading-tight">
                        Sistem Manajemen Aset
                    </h1>
                </div>

                {{-- Sub-judul dengan animasi --}}
                <div class="fade-in-up" style="animation-delay: 0.6s;">
                    <p class="text-lg md:text-xl text-gray-400 mb-12 px-4 md:px-0 font-light max-w-xl mx-auto">
                        Transformasi manajemen aset Pelindo menjadi lebih **terintegrasi, efisien, dan andal**
                        melalui teknologi digital terdepan.
                    </p>
                </div>
            </div>
        </main>

        {{-- Footer / credit --}}
        <footer class="relative z-10 text-gray-600 text-sm text-center p-4 fade-in-up" style="animation-delay: 0.8s;">
            <p>&copy; {{ date('Y') }} Pelindo. All Rights Reserved.</p>
        </footer>
    </div>
</body>
</html>