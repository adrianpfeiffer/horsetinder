<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Breeds
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($breeds as $breed)
                    <a href="{{ route('breeds.show', $breed) }}" class="block rounded-lg bg-white p-6 shadow-sm transition hover:shadow-md">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $breed->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $breed->origin_country }}</p>
                        <p class="mt-4 text-sm text-gray-600">{{ $breed->horses_count }} {{ Str::plural('horse', $breed->horses_count) }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
