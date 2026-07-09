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
                    Engagement
                </a>

                <a href="{{ route('berita.index') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    Entertainment
                </a>
                <a href="{{ route('edukasi.index') }}" class="block px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    Education
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
        <header class="md:hidden sticky top-0 z-50 bg-blue-900 text-white">
            <div class="flex items-center justify-between p-4">
                <button id="openSidebar" class="text-3xl font-bold">
                    ☰
                </button>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/BIlogo.png') }}" class="w-12 h-12 object-contain" alt="Logo">
                    <div>
                        <h1 class="font-bold leading-tight">
                            Kelola Media CBP
                        </h1>
                        <p class="text-xs text-blue-200">
                            Admin Panel
                        </p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 hidden z-40">
        </div>

        <!-- Sidebar Mobile -->
        <aside id="mobileSidebar"
            class="fixed top-0 left-0 h-full w-72 bg-blue-900 text-white transform -translate-x-full transition-transform duration-300 z-50">
            <!-- Header -->
            <div class="p-6 border-b border-blue-800 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-lg">
                        Admin Panel
                    </h2>
                    <p class="text-blue-200 text-sm">
                        Kelola Media CBP
                    </p>
                </div>
                <button id="closeSidebar" class="text-3xl">
                    ×
                </button>
            </div>
            <!-- Menu -->
            <nav class="p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="block rounded-lg px-4 py-3 hover:bg-blue-800">
                    📊 Dashboard
                </a>
                <a href="{{ route('lomba.index') }}" class="block rounded-lg px-4 py-3 hover:bg-blue-800">
                    🏆 Engagement
                </a>
                <a href="{{ route('berita.index') }}" class="block rounded-lg px-4 py-3 hover:bg-blue-800">
                    📰 Entertainment
                </a>
                <a href="{{ route('edukasi.index') }}" class="block rounded-lg px-4 py-3 hover:bg-blue-800">
                    📰 Education
                </a>
            </nav>
            <!-- Logout -->
            <div class="absolute bottom-0 w-full p-4 border-t border-blue-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full rounded-lg bg-red-500 py-2 hover:bg-red-600">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

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
    <script>
        const openBtn = document.getElementById("openSidebar");
        const closeBtn = document.getElementById("closeSidebar");

        const sidebar = document.getElementById("mobileSidebar");
        const overlay = document.getElementById("sidebarOverlay");

        openBtn.addEventListener("click", () => {
            sidebar.classList.remove("-translate-x-full");
            overlay.classList.remove("hidden");
        });

        function closeSidebar() {
            sidebar.classList.add("-translate-x-full");
            overlay.classList.add("hidden");
        }

        closeBtn.addEventListener("click", closeSidebar);

        overlay.addEventListener("click", closeSidebar);
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
</body>

</html>
