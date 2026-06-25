<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100">

    <div class="min-h-screen flex items-center justify-center p-6">

        <div class="w-full max-w-5xl bg-white rounded-3xl overflow-hidden shadow-2xl grid md:grid-cols-2">

            <!-- Left Side -->
            <div class="bg-[#1C3281] text-white flex flex-col justify-center items-center p-12">

                <img src="{{ asset('images/BIlogo.png') }}" alt="Logo BI" class="w-32 mb-8">

                <h1 class="font-heading text-5xl font-bold mb-4">
                    Admin Panel
                </h1>

                <p class="font-subheading text-lg text-blue-100 text-center">
                    Game Quiz Bank Indonesia
                </p>

            </div>

            <!-- Right Side -->
            <div class="flex items-center justify-center p-10">

                <div class="w-full max-w-md">

                    <h2 class="font-heading text-4xl text-[#1C3281] mb-2">
                        Selamat Datang
                    </h2>

                    <p class="font-body text-gray-500 mb-8">
                        Silakan masuk untuk mengelola sistem Game Quiz Bank Indonesia.
                    </p>

                    @if ($errors->any())
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
                            <p class="font-subheading text-[#CF1A25]">
                                {{ $errors->first() }}
                            </p>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/login') }}">
                        @csrf

                        <div class="mb-5">
                            <label class="font-subheading block mb-2 text-gray-700">
                                Email
                            </label>

                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="Masukkan email"
                                class="w-full rounded-xl border border-gray-300 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[#1C3281]"
                                required>
                        </div>

                        <div class="mb-8">
                            <label class="font-subheading block mb-2 text-gray-700">
                                Password
                            </label>

                            <input type="password" name="password" placeholder="Masukkan password"
                                class="w-full rounded-xl border border-gray-300 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[#1C3281]"
                                required>
                        </div>

                        <button type="submit"
                            class="w-full rounded-xl bg-[#1C3281] py-3 text-white font-subheading font-semibold hover:opacity-90 transition">
                            Masuk
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
