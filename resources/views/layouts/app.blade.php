<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen flex-col md:flex-row">
        <!-- Sidebar Desktop -->
        <aside class="hidden md:flex w-64 bg-blue-900 text-white flex-col">

            <!-- Logo -->
            <div class="p-6 border-b border-blue-800">

                <div class="flex flex-col items-center text-center">

                    <img src="{{ asset('images/BIlogo.png') }}" class="w-24 h-24 object-contain mb-4" alt="Logo BI">

                    <h1 class="font-bold text-sm leading-5">
                        Kelola Media
                        <br>
                        Cinta Bangga Paham Rupiah
                    </h1>

                    <p class="text-xs text-blue-200 mt-2">
                        Admin Panel
                    </p>

                </div>

            </div>

            <!-- Menu -->
            <nav class="flex-1 p-4 space-y-2">

                <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    Dashboard
                </a>

                <a href="{{ route('lomba.index') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    Kelola Lomba
                </a>

                <a href="{{ route('berita.index') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    Kelola Berita
                </a>

                <a href="{{ route('registration.lomba') }}"
                    class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    Pendaftaran Lomba
                </a>

            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-blue-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full bg-red-500 hover:bg-red-600 py-2 rounded-lg">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Header Mobile -->
        <div class="md:hidden sticky top-0 z-50 bg-blue-900 text-white p-4 shadow-lg">
            <div class="flex items-center justify-between">

                <!-- Logo -->
                <img src="{{ asset('images/BIlogo.png') }}" class="w-16 h-16 object-contain" alt="Logo BI">

                <!-- Teks -->
                <div class="text-right">
                    <h1 class="font-bold text-lg leading-tight">
                        Kelola Media CBP
                    </h1>

                    <p class="text-sm text-blue-200">
                        Admin Panel
                    </p>
                </div>

            </div>
        </div>

        <!-- Content -->
        <main class="flex-1 pb-24 md:pb-0">

            <!-- Navbar -->
            <header class="bg-white shadow-lg rounded-2xl mx-4 mt-4 px-8 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/cbplogo.png') }}" class="w-16 h-16 md:w-20 md:h-20 object-contain"
                            alt="Logo CBP">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">
                                @yield('page-title')
                            </h2>
                            <p class="text-sm text-gray-500">
                                Dashboard Administrator
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Administrator
                        </p>
                    </div>
                </div>

            </header>

            <!-- Page -->
            <section class="px-4 py-6 md:px-8">
                @yield('content')
            </section>

        </main>

    </div>
    <!-- Bottom Navigation Mobile -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg z-50">

        <div class="grid grid-cols-4 h-16">

            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center text-sm">

                📊
                <span>Dashboard</span>

            </a>

            <a href="{{ route('lomba.index') }}" class="flex flex-col items-center justify-center text-sm">

                🏆
                <span>Lomba</span>

            </a>

            <a href="{{ route('berita.index') }}" class="flex flex-col items-center justify-center text-sm">

                📰
                <span>Berita</span>

            </a>

            <a href="{{ route('registration.lomba') }}" class="flex flex-col items-center justify-center text-sm">

                📋
                <span>Pendaftaran Lomba</span>

            </a>

            <form action="{{ route('logout') }}" method="POST" class="flex items-center justify-center">

                @csrf

                <button class="flex flex-col items-center justify-center text-red-500 text-sm">

                    🚪
                    <span>Logout</span>

                </button>

            </form>

        </div>

    </nav>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
</body>

</html>
