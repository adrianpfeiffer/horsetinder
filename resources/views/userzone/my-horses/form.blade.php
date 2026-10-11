<div>
    <x-breeze.input-label for="name" value="Name" />
    <x-breeze.text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $horse->name)" autofocus />
    <x-breeze.input-error class="mt-2" :messages="$errors->get('name')" />
</div>

<div>
    <x-breeze.input-label for="breed_id" value="Breed" />
    <select id="breed_id" name="breed_id" class="mt-1 block w-full rounded-md border border-gray-400 px-2 py-1">
        <option value="">Choose a breed</option>
        @foreach ($breeds as $breed)
            <option value="{{ $breed->id }}" @selected(old('breed_id', $horse->breed_id) == $breed->id)>{{ $breed->name }}</option>
        @endforeach
    </select>
    <x-breeze.input-error class="mt-2" :messages="$errors->get('breed_id')" />
</div>

<div>
    <x-breeze.input-label for="gender" value="Gender" />
    <select id="gender" name="gender" class="mt-1 block w-full rounded-md border border-gray-400 px-2 py-1">
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
    <select id="discipline" name="discipline" class="mt-1 block w-full rounded-md border border-gray-400 px-2 py-1">
        <option value="">Choose a discipline</option>
        @foreach (App\Models\Horse::DISCIPLINES as $discipline)
            <option value="{{ $discipline }}" @selected(old('discipline', $horse->discipline) === $discipline)>{{ ucfirst($discipline) }}</option>
        @endforeach
    </select>
    <x-breeze.input-error class="mt-2" :messages="$errors->get('discipline')" />
</div>

<div>
    <x-breeze.input-label for="city" value="City" />
    <x-breeze.text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $horse->city)" />
    <x-breeze.input-error class="mt-2" :messages="$errors->get('city')" />
</div>

<div>
    <x-breeze.input-label for="bio" value="Bio (optional)" />
    <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full rounded-md border border-gray-400 px-2 py-1">{{ old('bio', $horse->bio) }}</textarea>
    <x-breeze.input-error class="mt-2" :messages="$errors->get('bio')" />
</div>
