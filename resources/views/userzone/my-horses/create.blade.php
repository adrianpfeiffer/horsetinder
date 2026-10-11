<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add a horse
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('my.horses.store') }}" class="space-y-6 rounded-lg bg-white p-6 shadow-sm">
                @csrf

                @include('userzone.my-horses.form', ['horse' => new App\Models\Horse])

                <div class="flex items-center gap-4">
                    <x-breeze.primary-button>Add horse</x-breeze.primary-button>
                    <a href="{{ route('my.horses.index') }}" class="text-sm text-gray-600 hover:underline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
