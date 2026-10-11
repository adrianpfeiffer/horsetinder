<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $breed->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">Origin: {{ $breed->origin_country }}</p>
                <p class="mt-2 text-gray-700">{{ $breed->description }}</p>
            </div>

            <h3 class="mt-10 mb-4 text-lg font-semibold text-gray-800">{{ $breed->name }} horses</h3>

            @if ($horses->isEmpty())
                <p class="text-gray-600">No horses of this breed yet.</p>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($horses as $horse)
                        <x-horse-card :horse="$horse" />
                    @endforeach
                </div>
            @endif

            <a href="{{ route('breeds.index') }}" class="mt-6 inline-block text-sm text-indigo-600 hover:underline">← Back to all breeds</a>
        </div>
    </div>
</x-app-layout>
