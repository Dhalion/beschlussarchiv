<div class="bg-slate-100 rounded-lg px-5 w-fit mx-auto mt-10">
    <h2 class="text-2xl pt-4 text-center">
        Login
    </h2>

    {{-- session flashes --}}
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-5 flex flex-col"
            role="alert">
            <strong class="font-bold">Fehler!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <x-form wire:submit.prevent="login" class="flex gap-y-2 p-5">
        <x-input type="email" label="E-Mail" id="email" wire:model="email" />
        @error('email')
            <span>{{ $message }}</span>
        @enderror
        <x-input type="password" label="Passwort" id="password" wire:model="password" />
        @error('password')
            <span>{{ $message }}</span>
        @enderror
        <x-button type="submit" label="Login" class="btn-primary btn-sm mt-3" />

        <a href="{{ route('admin.login.keycloak') }}" label="Rote Tools SSO" icon="o-key"
            class="btn-outline btn-sm mt-3">
            Rote Tools SSO
        </a>
    </x-form>
</div>
