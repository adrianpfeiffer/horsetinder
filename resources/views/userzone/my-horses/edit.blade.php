<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit {{ $horse->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('my.horses.update', $horse) }}" enctype="multipart/form-data" class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
                @csrf
                @method('PUT')

                <div class="space-y-6 p-6 sm:p-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Horse profile</h3>
                        <p class="mt-1 text-sm text-gray-500">Changes are visible to other owners right away.</p>
                    </div>

                    @include('userzone.my-horses.form')

                    <div>
                        <input type="hidden" name="is_active" value="0">
                        <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-gray-200 p-4 hover:bg-gray-50">
                            <input type="checkbox" name="is_active" value="1" class="mt-1 rounded border-gray-300 text-indigo-600" @checked(old('is_active', $horse->is_active))>
                            <span>
                                <span class="block text-sm font-medium text-gray-900">Show this horse when others browse</span>
                                <span class="block text-sm text-gray-500">Untick to hide the profile. Only you can still see it.</span>
                            </span>
                        </label>
                        <x-breeze.input-error class="mt-2" :messages="$errors->get('is_active')" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 border-t border-gray-100 bg-gray-50 px-6 py-4 sm:px-8">
                    <a href="{{ route('my.horses.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Cancel</a>
                    <x-breeze.primary-button>Save changes</x-breeze.primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
