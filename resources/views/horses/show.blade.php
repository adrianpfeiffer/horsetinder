<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $horse->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @unless ($horse->is_active)
                <p class="mb-6 rounded-md bg-yellow-50 p-4 text-sm text-yellow-800">
                    This horse is hidden. Only you can see this profile.
                </p>
            @endunless

            <div class="overflow-hidden rounded-lg bg-white shadow-sm md:flex">
                <x-horse-photo :horse="$horse" class="h-72 w-full md:h-auto md:w-1/2" />

                <div class="p-6 md:w-1/2">
                    <h3 class="text-2xl font-semibold text-gray-900">{{ $horse->name }}</h3>
                    <p class="text-gray-600">📍 {{ $horse->city }}</p>

                    <dl class="mt-6 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">Breed</dt>
                            <dd class="font-medium text-gray-900">{{ $horse->breed->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Age</dt>
                            <dd class="font-medium text-gray-900">{{ $horse->birth_date->age }} years</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Gender</dt>
                            <dd class="font-medium text-gray-900">{{ ucfirst($horse->gender) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Discipline</dt>
                            <dd class="font-medium text-gray-900">{{ ucfirst($horse->discipline) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Owner</dt>
                            <dd class="font-medium text-gray-900">{{ $horse->owner->name }}</dd>
                        </div>
                    </dl>

                    @if ($horse->bio)
                        <p class="mt-6 text-gray-700">{{ $horse->bio }}</p>
                    @endif
                </div>
            </div>

            <a href="{{ route('horses.index') }}" class="mt-6 inline-block text-sm text-indigo-600 hover:underline">← Back to all horses</a>
        </div>
    </div>
</x-app-layout>
