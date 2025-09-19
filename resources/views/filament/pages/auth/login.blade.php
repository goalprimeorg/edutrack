<x-filament-panels::page.simple>
    <x-filament-panels::form
        wire:submit="authenticate"
        class="space-y-6"
    >
        {{-- Heading --}}
        <div class="text-center">
        

       
        </div>

        {{-- Email + Password --}}
        {{ $this->form }}

        {{-- Submit --}}
        <x-filament::button type="submit" class="w-full">
            {{ __('Login') }}
        </x-filament::button>
    </x-filament-panels::form>

    {{-- Extra Login Buttons --}}
    <div class="mt-8 text-center space-y-4">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Other user types:
        </p>

        <div class="flex justify-center space-x-3">
    {{-- Emis Head Login --}}
    <a href="{{ url('/emisHead/login') }}"
       class="inline-block px-4 py-2 rounded-lg bg-orange-600 text-green-500 text-sm font-semibold shadow hover:bg-orange-700 transition">
        👨‍🏫 Emis Head Login
    </a>

    {{-- Emis Officer Login --}}
    <a href="{{ url('emis/login') }}"
       class="inline-block px-4 py-2 rounded-lg bg-purple-700 text-green-500 text-sm font-semibold shadow hover:bg-purple-800 transition">
        🏫 Emis Officer Login
    </a>

    {{-- Partners Login --}}
    <a href="{{ url('partner/login') }}"
       class="inline-block px-4 py-2 rounded-lg bg-purple-700 text-green-500 text-sm font-semibold shadow hover:bg-purple-800 transition">
        🏫 Partners Login
    </a>
</div>

{{-- Footer with Partner Logos --}}
    <div class="mt-10 border-t pt-6">
        <h3 class="text-center text-sm text-gray-500 font-semibold mb-4">
            Our Partners
        </h3>
        <div class="flex flex-wrap justify-center items-center gap-6">
            <img src="{{ asset('partner1.png') }}" alt="Partner 1" class="h-10 object-contain">
        </div>
    </div>

    {{-- Powered By Text --}}
        <p class="text-center text-xs text-gray-400 mt-2">
            Powered By: <span class="font-semibold text-gray-600">GOALPrime Organization Nigeria</span>
        </p>
    </div>
</x-filament-panels::page.simple>
