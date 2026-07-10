@props(['id', 'name', 'label', 'value' => ''])

<div>
    <label for="{{ $id }}" class="block text-sm font-medium mb-2">
        {{ $label }}
    </label>

    <div class="relative">

        <input id="{{ $id }}" type="password" name="{{ $name }}" value="{{ old($name, $value) }}"
            {{ $attributes->merge([
                'class' => 'w-full border border-gray-300 rounded-xl px-4 py-3 pr-12
                            focus:outline-none focus:border-blue-500 focus:ring-2
                            focus:ring-blue-200 transition',
            ]) }}>

        <button type="button" onclick="togglePassword('{{ $id }}', this)"
            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-[#00529C] transition">

            {{-- Mata Terbuka --}}
            <svg class="eye-open w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0" />

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5
                    c4.478 0 8.268 2.943 9.542 7
                    -1.274 4.057-5.064 7-9.542 7
                    -4.477 0-8.268-2.943-9.542-7z" />

            </svg>

            {{-- Mata Tertutup --}}
            <svg class="eye-close hidden w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19
                    c-4.478 0-8.268-2.943-9.542-7
                    a9.956 9.956 0 012.293-3.95" />

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.228 6.228A9.956 9.956 0 0112 5
                    c4.478 0 8.268 2.943 9.542 7
                    a9.97 9.97 0 01-4.132 5.411" />

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />

            </svg>

        </button>

    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-500">
            {{ $message }}
        </p>
    @enderror

</div>
