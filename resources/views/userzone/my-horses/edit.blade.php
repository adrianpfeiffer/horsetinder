<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit {{ $horse->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('my.horses.update', $horse) }}" class="space-y-6 rounded-lg bg-white p-6 shadow-sm">
                @csrf
                @method('PUT')

                @include('userzone.my-horses.form')

                <div>
                    <input type="hidden" name="is_active" value="0">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $horse->is_active))>
                        Show this horse when others browse
                    </label>
                    <x-breeze.input-error class="mt-2" :messages="$errors->get('is_active')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-breeze.primary-button>Save changes</x-breeze.primary-button>
                    <a href="{{ route('my.horses.index') }}" class="text-sm text-gray-600 hover:underline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
