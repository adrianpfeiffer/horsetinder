<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage horses
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <p class="mb-6 rounded-md bg-green-50 p-4 text-sm text-green-800">{{ session('status') }}</p>
            @endif

            <div class="overflow-x-auto rounded-lg bg-white shadow-sm">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-6 py-3 font-medium">Name</th>
                            <th class="px-6 py-3 font-medium">Owner</th>
                            <th class="px-6 py-3 font-medium">Breed</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($horses as $horse)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $horse->name }}</td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $horse->owner->name }}
                                    <span class="block text-xs text-gray-400">{{ $horse->owner->email }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $horse->breed->name }}</td>
                                <td class="px-6 py-4">
                                    @if ($horse->is_active)
                                        <span class="rounded-full bg-green-100 px-2 py-1 text-xs text-green-800">Active</span>
                                    @else
                                        <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs text-yellow-800">Hidden</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="{{ route('horses.show', $horse) }}" title="View" class="text-gray-500 hover:text-indigo-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                            <span class="sr-only">View</span>
                                        </a>
                                        <form method="POST" action="{{ route('admin.horses.destroy', $horse) }}" onsubmit="return confirm('Remove this horse profile? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Remove" class="text-gray-500 hover:text-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.443c0-1.022-.802-1.84-1.82-1.84h-4.32c-1.018 0-1.82.818-1.82 1.84v.443m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                                <span class="sr-only">Remove</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $horses->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
