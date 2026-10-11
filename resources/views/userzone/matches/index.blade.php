<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Matches
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($matches->isEmpty())
                <div class="rounded-xl bg-white p-10 text-center shadow-sm ring-1 ring-gray-900/5">
                    <p class="text-4xl">💔</p>
                    <p class="mt-4 font-medium text-gray-900">No matches yet</p>
                    <p class="mt-1 text-sm text-gray-500">When a horse you liked likes one of your horses back, it shows up here.</p>
                    <a href="{{ route('horses.index') }}" class="mt-6 inline-block text-sm font-medium text-indigo-600 hover:underline">Browse horses</a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($matches as $match)
                        <div class="flex flex-col gap-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-900/5 sm:flex-row sm:items-center">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('horses.show', $match->horse) }}">
                                    <x-horse-photo :horse="$match->horse" class="size-16 rounded-full text-3xl" />
                                </a>
                                <span class="text-2xl">❤️</span>
                                <a href="{{ route('horses.show', $match->targetHorse) }}">
                                    <x-horse-photo :horse="$match->targetHorse" class="size-16 rounded-full text-3xl" />
                                </a>
                            </div>

                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $match->horse->name }} & {{ $match->targetHorse->name }}</p>
                                <p class="text-sm text-gray-500">{{ $match->targetHorse->name }} belongs to {{ $match->targetHorse->owner->name }}</p>
                            </div>

                            <a href="mailto:{{ $match->targetHorse->owner->email }}" class="inline-flex items-center gap-2 rounded-md bg-pink-600 px-4 py-2 text-sm font-semibold text-white hover:bg-pink-500">
                                ✉️ {{ $match->targetHorse->owner->email }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
