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

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white flex flex-col">

            <!-- Logo -->
            <div class="p-6 border-b border-blue-800">

                <div class="flex items-center gap-3">

                    <img src="{{ asset('images/BIlogo.png') }}" class="w-12" alt="Logo BI">

                    <div>
                        <h1 class="font-bold">
                            Game Quiz BI
                        </h1>

                        <p class="text-xs text-blue-200">
                            Admin Panel
                        </p>
                    </div>

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

        <!-- Content -->
        <main class="flex-1">

            <!-- Navbar -->
            <header class="bg-white shadow px-8 py-4">

                <div class="flex justify-between items-center">

                    <h2 class="text-2xl font-bold text-gray-800">
                        @yield('page-title')
                    </h2>

                    <div class="text-right">

                        <p class="font-semibold">
                            {{ Auth::user()->name }}
                        </p>

                        <p class="text-sm text-gray-500">
                            Administrator
                        </p>

                    </div>

                </div>

            </header>

            <!-- Page -->
            <section class="p-8">
                @yield('content')
            </section>

        </main>

    </div>

</body>

</html>
