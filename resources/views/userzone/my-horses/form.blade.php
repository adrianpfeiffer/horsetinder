@php
    $fieldClasses = 'mt-1 block w-full rounded-md border border-gray-400 px-2 py-1 shadow-xs focus:border-indigo-500 focus:ring-indigo-500';
@endphp

<div class="grid gap-6 sm:grid-cols-2">
    <div class="sm:col-span-2" x-data="{ preview: @js($horse->photo_path ? asset('storage/'.$horse->photo_path) : null) }">
        <x-breeze.input-label for="photo" value="Photo (optional)" />
        <label for="photo" class="mt-1 flex cursor-pointer flex-col items-center justify-center gap-2 rounded-lg border-2 border-dashed border-gray-300 p-6 text-center transition hover:border-indigo-400 hover:bg-indigo-50">
            <img x-show="preview" :src="preview" alt="Photo preview" class="h-40 w-40 rounded-md object-cover">
            <svg x-show="! preview" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
            <span class="text-sm font-medium text-indigo-600" x-text="preview ? 'Choose a different photo' : 'Upload a photo'">Upload a photo</span>
            <span class="text-xs text-gray-500">JPG, PNG or WebP · max 5 MB</span>
        </label>
        <input id="photo" name="photo" type="file" accept="image/*" class="sr-only"
               @change="if ($event.target.files[0]) preview = URL.createObjectURL($event.target.files[0])">
        <x-breeze.input-error class="mt-2" :messages="$errors->get('photo')" />
    </div>

    <div>
        <x-breeze.input-label for="name" value="Name" />
        <x-breeze.text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $horse->name)" autofocus />
        <x-breeze.input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div>
        <x-breeze.input-label for="city" value="City" />
        <x-breeze.text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $horse->city)" />
        <x-breeze.input-error class="mt-2" :messages="$errors->get('city')" />
    </div>

    <div>
        <x-breeze.input-label for="breed_id" value="Breed" />
        <select id="breed_id" name="breed_id" class="{{ $fieldClasses }}">
            <option value="">Choose a breed</option>
            @foreach ($breeds as $breed)
                <option value="{{ $breed->id }}" @selected(old('breed_id', $horse->breed_id) == $breed->id)>{{ $breed->name }}</option>
            @endforeach
        </select>
        <x-breeze.input-error class="mt-2" :messages="$errors->get('breed_id')" />
    </div>

    <div>
        <x-breeze.input-label for="gender" value="Gender" />
        <select id="gender" name="gender" class="{{ $fieldClasses }}">
            <option value="">Choose a gender</option>
            @foreach (App\Models\Horse::GENDERS as $gender)
                <option value="{{ $gender }}" @selected(old('gender', $horse->gender) === $gender)>{{ ucfirst($gender) }}</option>
            @endforeach
        </select>
        <x-breeze.input-error class="mt-2" :messages="$errors->get('gender')" />
    </div>

    <div>
        <x-breeze.input-label for="birth_date" value="Birth date" />
        <x-breeze.text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $horse->birth_date?->format('Y-m-d'))" />
        <x-breeze.input-error class="mt-2" :messages="$errors->get('birth_date')" />
    </div>

    <div>
        <x-breeze.input-label for="discipline" value="Discipline" />
        <select id="discipline" name="discipline" class="{{ $fieldClasses }}">
            <option value="">Choose a discipline</option>
            @foreach (App\Models\Horse::DISCIPLINES as $discipline)
                <option value="{{ $discipline }}" @selected(old('discipline', $horse->discipline) === $discipline)>{{ ucfirst($discipline) }}</option>
            @endforeach
        </select>
        <x-breeze.input-error class="mt-2" :messages="$errors->get('discipline')" />
    </div>

    <div class="sm:col-span-2">
        <x-breeze.input-label for="bio" value="Bio (optional)" />
        <textarea id="bio" name="bio" rows="4" class="{{ $fieldClasses }}" placeholder="What makes this horse special?">{{ old('bio', $horse->bio) }}</textarea>
        <x-breeze.input-error class="mt-2" :messages="$errors->get('bio')" />
    </div>
</div>
