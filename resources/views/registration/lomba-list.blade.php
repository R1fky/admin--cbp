@extends('layouts.app')

@section('title', 'Daftar Peserta Lomba')
@section('page-title', 'Kelola Peserta Lomba')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse($lombas as $lomba)
            <div class="bg-white rounded-2xl shadow hover:shadow-xl transition duration-300 overflow-hidden">

                {{-- Header --}}
                <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-5 text-white">

                    <h2 class="text-xl font-bold">
                        {{ $lomba->title }}
                    </h2>

                    <p class="text-sm text-blue-100 mt-1">
                        {{ $lomba->release_date }}
                    </p>
                </div>

                {{-- Body --}}
                <div class="p-5">

                    <p class="text-gray-600 line-clamp-3">
                        {{ Str::limit(strip_tags($lomba->description), 100) }}
                    </p>

                    <div class="mt-6 flex justify-between items-center">

                        <div>

                            <p class="text-sm text-gray-500">
                                Jumlah Peserta
                            </p>

                            <p class="text-3xl font-bold text-blue-700">
                                {{ $lomba->registrations_count }}
                            </p>

                        </div>

                        @if ($lomba->status == 'ongoing')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                Sedang Berlangsung
                            </span>
                        @elseif($lomba->status == 'upcoming')
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">
                                Segera Dibuka
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                Ditutup
                            </span>
                        @endif

                    </div>

                    <a href="{{ route('registration.index', $lomba->id) }}"
                        class="mt-6 w-full inline-flex justify-center items-center rounded-xl bg-blue-600 hover:bg-blue-700 text-white py-3 font-semibold transition">

                        Lihat Peserta →

                    </a>

                </div>

            </div>

        @empty

            <div class="col-span-full">

                <div class="bg-white rounded-xl shadow p-10 text-center">

                    <p class="text-gray-500">
                        Belum ada lomba.
                    </p>

                </div>

            </div>
        @endforelse

    </div>

@endsection
