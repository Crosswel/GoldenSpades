<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Encomendas -->
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">As minhas encomendas</h3>
            @forelse ($orders as $order)
                <p>Encomenda #{{ $order->id }} - Estado: {{ $order->status }}</p>
            @empty
                <p>Sem encomendas.</p>
            @endforelse
        </div>

        <!-- Favoritos -->
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Artigos Favoritos</h3>
            @forelse ($favorites as $fav)
                <p>{{ $fav->name }}</p>
            @empty
                <p>Sem favoritos.</p>
            @endforelse
        </div>

        <!-- Atualizar Perfil -->
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Dados de Perfil</h3>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                        Morada
                    </label>
                    <input type="text" name="address" value="{{ old('address', $user->profile->address ?? '') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                        Telemóvel
                    </label>
                    <input type="text" name="phone" value="{{ old('phone', $user->profile->phone ?? '') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" />
                </div>

                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Atualizar
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
