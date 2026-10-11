<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add a horse
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('my.horses.store') }}" enctype="multipart/form-data" class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
                @csrf

                <div class="space-y-6 p-6 sm:p-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">New horse profile</h3>
                        <p class="mt-1 text-sm text-gray-500">Other owners will see this profile when they browse horses.</p>
                    </div>

                    @include('userzone.my-horses.form', ['horse' => new App\Models\Horse])
                </div>

                <div class="flex items-center justify-end gap-4 border-t border-gray-100 bg-gray-50 px-6 py-4 sm:px-8">
                    <a href="{{ route('my.horses.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Cancel</a>
                    <x-breeze.primary-button>Add horse</x-breeze.primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
