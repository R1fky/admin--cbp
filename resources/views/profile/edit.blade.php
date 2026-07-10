@extends('layouts.app')

@section('page-title', 'Profil Saya')

@section('content')

    <div class="max-w-5xl mx-auto">

        @if (session('success'))
            <div id="toastSuccess"
                class="fixed top-5 right-5 z-50 bg-white border-l-4 border-green-500 shadow-xl rounded-xl px-5 py-4 min-w-[320px]">
                <div class="flex items-start gap-3">
                    <div class="bg-green-100 p-2 rounded-full">
                        ✅
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-800">
                            Berhasil
                        </h4>
                        <p class="text-gray-600 text-sm">
                            {{ session('success') }}
                        </p>
                    </div>
                    <button onclick="document.getElementById('toastSuccess').remove()"
                        class="text-gray-400 hover:text-gray-600">
                        ✕
                    </button>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toastSuccess');

                    if (toast) {
                        toast.style.transition = 'all .5s ease';
                        toast.style.transform = 'translateX(100%)';
                        toast.style.opacity = '0';

                        setTimeout(() => toast.remove(), 500);
                    }
                }, 4000);
            </script>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid lg:grid-cols-3 gap-8">

                {{-- Sidebar --}}
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">

                    <div
                        class="w-24 h-24 mx-auto rounded-full bg-blue-100 flex items-center justify-center text-4xl font-bold text-blue-600">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <h2 class="mt-5 text-xl font-bold text-gray-800">
                        {{ Auth::user()->name }}
                    </h2>

                    <p class="text-gray-500">
                        Administrator
                    </p>

                    <div class="mt-6 border-t pt-6">

                        <p class="text-sm text-gray-500">
                            Email
                        </p>

                        <p class="font-medium break-all">
                            {{ Auth::user()->email }}
                        </p>

                    </div>

                </div>

                {{-- Form --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Informasi Akun --}}
                    <div class="bg-white rounded-2xl shadow-lg p-8">

                        <h3 class="text-xl font-bold text-gray-800 mb-6">
                            Informasi Akun
                        </h3>

                        <div class="space-y-6">

                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Nama Lengkap
                                </label>

                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3
           focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200
           transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">
                                    Email
                                </label>

                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                            </div>

                        </div>

                    </div>

                    {{-- Password --}}
                    <div class="bg-white rounded-2xl shadow-lg p-8">

                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            Keamanan Akun
                        </h3>

                        <p class="text-sm text-gray-500 mb-6">
                            Kosongkan apabila tidak ingin mengganti password.
                        </p>

                        <div class="space-y-6">

                            <x-password-input id="current_password" name="current_password" label="Password Lama" />

                            <x-password-input id="password" name="password" label="Password Baru" />

                            <x-password-input id="password_confirmation" name="password_confirmation"
                                label="Konfirmasi Password" />

                        </div>

                    </div>

                    <div class="flex items-center justify-between">

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-3 text-gray-700 font-medium shadow-sm hover:bg-gray-100 transition">

                            {{-- Icon Arrow Left --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

                            </svg>

                            <span>Kembali</span>

                        </a>

                        {{-- Tombol Simpan --}}
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-[#00529C] px-6 py-3 text-white font-semibold shadow-lg hover:bg-[#003F78] transition">

                            {{-- Icon Save --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />

                            </svg>

                            <span>Simpan Perubahan</span>

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>


    <script>
        function togglePassword(id, button) {

            const input = document.getElementById(id);

            const openEye = button.querySelector('.eye-open');
            const closeEye = button.querySelector('.eye-close');

            if (input.type === 'password') {
                input.type = 'text';
                openEye.classList.add('hidden');
                closeEye.classList.remove('hidden');
            } else {
                input.type = 'password';
                openEye.classList.remove('hidden');
                closeEye.classList.add('hidden');
            }
        }
    </script>

@endsection
