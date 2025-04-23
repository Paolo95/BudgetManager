<x-layout>
    <x-slot name="title">Cambia Password</x-slot>

    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">Cambia Password</h2>
            <p class="mb-4">Inserisci la tua password attuale e quella nuova</p>
        </header>

        @if(session('message'))
            <p class="text-green-500 text-sm text-center mb-4">{{ session('message') }}</p>
        @endif

        <form method="POST" action="/change_password">
            @csrf

            <div class="mb-6">
                <label for="current_password" class="inline-block text-lg mb-2">Password attuale</label>
                <input type="password" name="current_password" class="border border-gray-200 rounded p-2 w-full" required />

                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="new_password" class="inline-block text-lg mb-2">Nuova Password</label>
                <input type="password" name="new_password" class="border border-gray-200 rounded p-2 w-full" required />

                @error('new_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="new_password_confirmation" class="inline-block text-lg mb-2">Conferma Nuova Password</label>
                <input type="password" name="new_password_confirmation" class="border border-gray-200 rounded p-2 w-full" required />
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    Aggiorna Password
                </button>
            </div>

            <div class="text-center">
                <a href="/dashboard/home" class="text-laravel underline">Torna alla dashboard</a>
            </div>
        </form>
    </x-card>
</x-layout>
