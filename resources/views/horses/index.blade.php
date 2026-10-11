<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Browse horses
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($horses->isEmpty())
                <p class="text-gray-600">No horses to show yet.</p>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($horses as $horse)
                        <x-horse-card :horse="$horse" />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $horses->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
