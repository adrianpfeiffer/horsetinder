@php
    $matchedHorse = session('matched_horse_id') ? $myHorses->firstWhere('id', session('matched_horse_id')) : null;

    $backUrl = url()->previous(route('horses.index'));

    if ($backUrl === url()->current()) {
        $backUrl = route('horses.index');
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $horse->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <p class="mb-6 rounded-md bg-green-50 p-4 text-sm text-green-800">{{ session('status') }}</p>
            @endif

            @unless ($horse->is_active)
                <p class="mb-6 rounded-md bg-yellow-50 p-4 text-sm text-yellow-800">
                    This horse is hidden from browsing. Only its owner and admins can see this profile.
                </p>
            @endunless

            <div class="overflow-hidden rounded-lg bg-white shadow-sm md:flex">
                <x-horse-photo :horse="$horse" class="h-72 w-full md:h-auto md:w-1/2" />

                <div class="p-6 md:w-1/2">
                    <h3 class="text-2xl font-semibold text-gray-900">{{ $horse->name }}</h3>
                    <p class="text-gray-600">📍 {{ $horse->city }}</p>

                    <dl class="mt-6 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">Breed</dt>
                            <dd class="font-medium text-gray-900">
                                <a href="{{ route('breeds.show', $horse->breed) }}" class="text-indigo-600 hover:underline">{{ $horse->breed->name }}</a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Age</dt>
                            <dd class="font-medium text-gray-900">{{ $horse->birth_date->age }} years</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Gender</dt>
                            <dd class="font-medium text-gray-900">{{ ucfirst($horse->gender) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Discipline</dt>
                            <dd class="font-medium text-gray-900">{{ ucfirst($horse->discipline) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Owner</dt>
                            <dd class="font-medium text-gray-900">{{ $horse->owner->name }}</dd>
                        </div>
                    </dl>

                    @if ($horse->bio)
                        <p class="mt-6 text-gray-700">{{ $horse->bio }}</p>
                    @endif

                    <div class="mt-8 border-t border-gray-100 pt-6">
                        @guest
                            <p class="text-sm text-gray-600">
                                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:underline">Log in</a> to like {{ $horse->name }} with one of your horses.
                            </p>
                        @else
                            @if ($horse->user_id === auth()->id())
                                <p class="text-sm text-gray-600">This is your horse.</p>
                            @elseif ($myHorses->isEmpty())
                                <p class="text-sm text-gray-600">
                                    <a href="{{ route('my.horses.create') }}" class="font-medium text-indigo-600 hover:underline">Add a horse</a> first, then you can like {{ $horse->name }}.
                                </p>
                            @else
                                @foreach ($myLikes as $like)
                                    <form method="POST" action="{{ route('likes.destroy', $like) }}" class="mb-2 flex items-center justify-between gap-2 text-sm">
                                        @csrf
                                        @method('DELETE')
                                        <span class="text-pink-700">❤️ {{ $like->horse->name }} likes {{ $horse->name }}</span>
                                        <button type="submit" class="text-gray-500 hover:text-red-600 hover:underline">Undo</button>
                                    </form>
                                @endforeach

                                @if ($myHorsesThatCanLike->isNotEmpty())
                                    <form method="POST" action="{{ route('likes.store', $horse) }}" class="mt-4">
                                        @csrf
                                        <x-breeze.input-label for="horse_id" value="Like as" />
                                        <div class="mt-1 flex gap-2">
                                            <select id="horse_id" name="horse_id" class="block w-full rounded-md border border-gray-400 px-2 py-1 shadow-xs focus:border-indigo-500 focus:ring-indigo-500">
                                                @foreach ($myHorsesThatCanLike as $myHorse)
                                                    <option value="{{ $myHorse->id }}" @selected(old('horse_id') == $myHorse->id)>{{ $myHorse->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="inline-flex shrink-0 items-center gap-1 rounded-md bg-pink-600 px-4 py-2 text-sm font-semibold text-white hover:bg-pink-500">
                                                ❤️ Like
                                            </button>
                                        </div>
                                        <x-breeze.input-error class="mt-2" :messages="$errors->get('horse_id')" />
                                    </form>
                                @endif
                            @endif
                        @endguest
                    </div>
                </div>
            </div>

            <a href="{{ $backUrl }}" class="mt-6 inline-block text-sm text-indigo-600 hover:underline">← Back</a>
        </div>
    </div>

    @if ($matchedHorse)
        <x-match-overlay :my-horse="$matchedHorse" :their-horse="$horse" />
    @endif
</x-app-layout>
