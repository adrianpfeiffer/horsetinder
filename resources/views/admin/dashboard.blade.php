<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-5">
                @foreach ($stats as $label => $count)
                    <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                        <p class="text-sm text-gray-500">{{ $label }}</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $count }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <a href="{{ route('admin.breeds.index') }}" class="block rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5 hover:bg-gray-50">
                    <p class="font-semibold text-gray-900">Manage breeds →</p>
                    <p class="mt-1 text-sm text-gray-500">Add, edit and delete the breeds owners can choose from.</p>
                </a>
                <a href="{{ route('admin.horses.index') }}" class="block rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5 hover:bg-gray-50">
                    <p class="font-semibold text-gray-900">Manage horses →</p>
                    <p class="mt-1 text-sm text-gray-500">See all horse profiles, also hidden ones, and remove them.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
