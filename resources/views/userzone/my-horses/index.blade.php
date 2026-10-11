<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My horses
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <p class="mb-6 rounded-md bg-green-50 p-4 text-sm text-green-800">{{ session('status') }}</p>
            @endif

            <div class="mb-6 flex justify-end">
                <a href="{{ route('my.horses.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Add horse
                </a>
            </div>

            @if ($horses->isEmpty())
                <p class="text-gray-600">You don't have any horses yet.</p>
            @else
                <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="px-6 py-3 font-medium">Name</th>
                                <th class="px-6 py-3 font-medium">Breed</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($horses as $horse)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $horse->name }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $horse->breed->name }}</td>
                                    <td class="px-6 py-4">
                                        @if ($horse->is_active)
                                            <span class="rounded-full bg-green-100 px-2 py-1 text-xs text-green-800">Active</span>
                                        @else
                                            <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs text-yellow-800">Hidden</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('horses.show', $horse) }}" class="text-indigo-600 hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
