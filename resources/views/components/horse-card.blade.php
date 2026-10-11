@props(['horse'])

<a href="{{ route('horses.show', $horse) }}" class="block overflow-hidden rounded-lg bg-white shadow-sm transition hover:shadow-md">
    <x-horse-photo :horse="$horse" class="h-48 w-full" />

    <div class="p-4">
        <div class="flex items-baseline justify-between gap-2">
            <h3 class="text-lg font-semibold text-gray-900">{{ $horse->name }}</h3>
            <span class="text-sm text-gray-500">{{ $horse->birth_date->age }} years</span>
        </div>
        <p class="text-sm text-gray-600">{{ $horse->breed->name }} · {{ ucfirst($horse->gender) }}</p>
        <p class="mt-2 text-sm text-gray-500">📍 {{ $horse->city }} · {{ ucfirst($horse->discipline) }}</p>
    </div>
</a>
