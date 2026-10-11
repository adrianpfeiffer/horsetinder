<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $breed->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Origin: {{ $breed->origin_country }}</p>
                        <p class="mt-2 text-gray-700">{{ $breed->description }}</p>
                    </div>
                    <a href="{{ route('admin.breeds.edit', $breed) }}" class="shrink-0 text-sm font-medium text-indigo-600 hover:underline">Edit</a>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <h3 class="border-b border-gray-100 px-6 py-4 font-semibold text-gray-900">
                    {{ $breed->horses->count() }} {{ Str::plural('horse', $breed->horses->count()) }}
                </h3>

                @if ($breed->horses->isEmpty())
                    <p class="px-6 py-4 text-sm text-gray-500">No horses of this breed yet.</p>
                @else
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-6 py-3 font-medium">Name</th>
                                <th class="px-6 py-3 font-medium">Owner</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($breed->horses as $horse)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $horse->name }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $horse->owner->name }}</td>
                                    <td class="px-6 py-4">
                                        @if ($horse->is_active)
                                            <span class="rounded-full bg-green-100 px-2 py-1 text-xs text-green-800">Active</span>
                                        @else
                                            <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs text-yellow-800">Hidden</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <a href="{{ route('admin.breeds.index') }}" class="inline-block text-sm text-indigo-600 hover:underline">← Back to breeds</a>
        </div>
    </div>
</x-app-layout>
