@php
    $fieldClasses = 'mt-1 block w-full rounded-md border border-gray-400 px-2 py-1 shadow-xs focus:border-indigo-500 focus:ring-indigo-500';
@endphp

<div class="grid gap-6 sm:grid-cols-2">
    <div>
        <x-breeze.input-label for="name" value="Name" />
        <x-breeze.text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $breed->name)" autofocus />
        <x-breeze.input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div>
        <x-breeze.input-label for="origin_country" value="Country of origin" />
        <x-breeze.text-input id="origin_country" name="origin_country" type="text" class="mt-1 block w-full" :value="old('origin_country', $breed->origin_country)" />
        <x-breeze.input-error class="mt-2" :messages="$errors->get('origin_country')" />
    </div>

    <div class="sm:col-span-2">
        <x-breeze.input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="5" class="{{ $fieldClasses }}">{{ old('description', $breed->description) }}</textarea>
        <x-breeze.input-error class="mt-2" :messages="$errors->get('description')" />
    </div>
</div>
