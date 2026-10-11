<x-app-layout>
    <div class="bg-gradient-to-b from-pink-50 to-gray-100">
        <div class="max-w-5xl mx-auto px-4 py-20 text-center sm:px-6 lg:px-8">
            <p class="text-6xl">🐴❤️🐴</p>
            <h1 class="mt-6 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">Neigh</h1>
            <p class="mt-4 text-xl text-gray-600">Tinder for horses. Find the perfect riding buddy, paddock pal or partner for your horse.</p>

            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('horses.index') }}" class="rounded-md bg-pink-600 px-6 py-3 text-sm font-semibold text-white hover:bg-pink-500">Browse horses</a>
                @guest
                    <a href="{{ route('register') }}" class="rounded-md bg-white px-6 py-3 text-sm font-semibold text-gray-900 ring-1 ring-gray-300 hover:bg-gray-50">Sign up your horse</a>
                @else
                    <a href="{{ route('my.horses.index') }}" class="rounded-md bg-white px-6 py-3 text-sm font-semibold text-gray-900 ring-1 ring-gray-300 hover:bg-gray-50">My horses</a>
                @endguest
            </div>

            <p class="mt-8 text-sm text-gray-500">{{ $horseCount }} horses looking for friends · {{ $matchCount }} matches so far</p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
        <h2 class="text-center text-2xl font-semibold text-gray-900">How it works</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-3">
            <div class="rounded-xl bg-white p-6 text-center shadow-sm ring-1 ring-gray-900/5">
                <p class="text-3xl">📝</p>
                <p class="mt-3 font-semibold text-gray-900">1. Add your horses</p>
                <p class="mt-1 text-sm text-gray-500">Create a profile with a photo, breed, discipline and city.</p>
            </div>
            <div class="rounded-xl bg-white p-6 text-center shadow-sm ring-1 ring-gray-900/5">
                <p class="text-3xl">❤️</p>
                <p class="mt-3 font-semibold text-gray-900">2. Like other horses</p>
                <p class="mt-1 text-sm text-gray-500">Browse horses and like them on behalf of one of yours.</p>
            </div>
            <div class="rounded-xl bg-white p-6 text-center shadow-sm ring-1 ring-gray-900/5">
                <p class="text-3xl">🎉</p>
                <p class="mt-3 font-semibold text-gray-900">3. It's a match!</p>
                <p class="mt-1 text-sm text-gray-500">When they like you back, you both get each other's email.</p>
            </div>
        </div>

        @if ($newestHorses->isNotEmpty())
            <h2 class="mt-16 text-center text-2xl font-semibold text-gray-900">Newest horses</h2>
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($newestHorses as $horse)
                    <x-horse-card :horse="$horse" />
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
