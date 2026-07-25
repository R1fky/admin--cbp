<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-slate-800 antialiased">

    <div class="flex min-h-screen flex-col md:flex-row">
        <!-- Sidebar Desktop -->
        <aside class="hidden md:flex w-64 bg-[#0B1A40] text-white flex-col shadow-xl border-r border-[#1E293B]/20">

            <!-- Logo -->
            <div class="p-6 border-b border-[#1E293B]">
                <div class="flex flex-col items-center text-center">
                    <img src="{{ asset('images/BIlogo.png') }}" class="w-20 h-20 object-contain mb-3 drop-shadow-md" alt="Logo BI">
                    <h1 class="font-bold text-sm tracking-wide text-white uppercase leading-5">
                        Kelola Media
                    </h1>
                    <p class="text-xs text-[#C5A85C] font-semibold mt-1 uppercase tracking-wider">
                        CBP Rupiah Admin
                    </p>
                </div>
            </div>

            <!-- Menu -->
            <nav class="flex-1 p-4 space-y-1.5">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white font-semibold border-l-4 border-[#C5A85C] shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                    </svg>
                    <span class="text-sm">Dashboard</span>
                </a>

                <a href="{{ route('lomba.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ (request()->routeIs('lomba.*') || request()->routeIs('registration.*')) ? 'bg-white/10 text-white font-semibold border-l-4 border-[#C5A85C] shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.477 3.477 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.477 3.477 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.477 3.477 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.477 3.477 0 013.138-3.138z"></path>
                    </svg>
                    <span class="text-sm">Engagement</span>
                </a>

                <a href="{{ route('berita.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('berita.*') ? 'bg-white/10 text-white font-semibold border-l-4 border-[#C5A85C] shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <span class="text-sm">Entertainment</span>
                </a>

                <a href="{{ route('edukasi.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ (request()->routeIs('edukasi.*') || request()->routeIs('edukasi-video.*')) ? 'bg-white/10 text-white font-semibold border-l-4 border-[#C5A85C] shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="text-sm">Education</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-[#1E293B]">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-2 bg-[#CF1A25]/90 hover:bg-[#CF1A25] text-white py-2.5 rounded-xl text-sm font-semibold transition shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Header Mobile -->
        <header class="md:hidden sticky top-0 z-50 bg-[#0B1A40] text-white shadow-lg">
            <div class="flex items-center justify-between p-4">
                <button id="openSidebar" class="text-2xl font-bold text-slate-200 hover:text-white">
                    ☰
                </button>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/BIlogo.png') }}" class="w-10 h-10 object-contain" alt="Logo">
                    <div>
                        <h1 class="font-bold text-sm leading-tight text-white uppercase tracking-wide">
                            Kelola Media
                        </h1>
                        <p class="text-[10px] text-[#C5A85C] uppercase tracking-wider font-semibold">
                            CBP Rupiah Admin
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
            class="fixed top-0 left-0 h-full w-72 bg-[#0B1A40] text-white transform -translate-x-full transition-transform duration-300 z-50 shadow-2xl flex flex-col">
            <!-- Header -->
            <div class="p-6 border-b border-[#1E293B] flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-white uppercase tracking-wide text-sm">
                        CBP Rupiah Admin
                    </h2>
                    <p class="text-[#C5A85C] text-xs font-semibold uppercase tracking-wider mt-1">
                        Bank Indonesia
                    </p>
                </div>
                <button id="closeSidebar" class="text-3xl text-slate-300 hover:text-white">
                    &times;
                </button>
            </div>
            <!-- Menu -->
            <nav class="p-4 space-y-1.5 flex-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white font-semibold border-l-4 border-[#C5A85C]' : 'text-slate-300 hover:bg-white/5' }}">
                    <span class="text-lg">📊</span>
                    <span class="text-sm">Dashboard</span>
                </a>
                <a href="{{ route('lomba.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl {{ (request()->routeIs('lomba.*') || request()->routeIs('registration.*')) ? 'bg-white/10 text-white font-semibold border-l-4 border-[#C5A85C]' : 'text-slate-300 hover:bg-white/5' }}">
                    <span class="text-lg">🏆</span>
                    <span class="text-sm">Engagement</span>
                </a>
                <a href="{{ route('berita.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('berita.*') ? 'bg-white/10 text-white font-semibold border-l-4 border-[#C5A85C]' : 'text-slate-300 hover:bg-white/5' }}">
                    <span class="text-lg">📰</span>
                    <span class="text-sm">Entertainment</span>
                </a>
                <a href="{{ route('edukasi.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl {{ (request()->routeIs('edukasi.*') || request()->routeIs('edukasi-video.*')) ? 'bg-white/10 text-white font-semibold border-l-4 border-[#C5A85C]' : 'text-slate-300 hover:bg-white/5' }}">
                    <span class="text-lg">📖</span>
                    <span class="text-sm">Education</span>
                </a>
            </nav>
            <!-- Logout -->
            <div class="p-4 border-t border-[#1E293B]">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-2 bg-[#CF1A25] py-2.5 rounded-xl text-sm font-semibold hover:bg-[#b0131d] transition">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Content -->
        <main class="flex-1 pb-24 md:pb-0 min-h-screen flex flex-col">

            <!-- Navbar -->
            <header class="bg-white border-b border-slate-200/80 px-6 md:px-8 py-4 sticky top-0 z-30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/cbplogo.png') }}" class="w-12 h-12 md:w-14 md:h-14 object-contain"
                            alt="Logo CBP">
                        <div>
                            <h2 class="text-lg md:text-xl font-bold text-slate-800 tracking-tight">
                                @yield('page-title')
                            </h2>
                            <p class="text-xs text-slate-500 font-medium">
                                Dashboard Administrator
                            </p>
                        </div>
                    </div>

                    {{-- Admin Dropdown --}}
                    <div x-data="{ open: false }" class="relative text-right">
                        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none bg-slate-50 hover:bg-slate-100/80 px-3 py-2 rounded-xl border border-slate-200/60 transition text-left cursor-pointer">
                            <div class="hidden sm:block">
                                <span class="block font-semibold text-xs text-slate-800">
                                    {{ Auth::user()->name }}
                                </span>
                                <span class="block text-[10px] text-slate-400 font-medium uppercase tracking-wider">
                                    Administrator
                                </span>
                            </div>
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 font-bold text-sm flex items-center justify-center shadow-inner border border-blue-100">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2.5 w-52 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 text-slate-700 text-sm font-medium transition">
                                <svg class="w-4 h-4 text-[#C5A85C]" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5.121 17.804A9 9 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Profil Saya</span>
                            </a>
                            <div class="border-t border-slate-100"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 hover:bg-red-50 text-red-600 text-sm font-medium transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1" />
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </header>

            <!-- Page Content -->
            <section class="px-6 py-6 md:px-8 flex-1">
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>

