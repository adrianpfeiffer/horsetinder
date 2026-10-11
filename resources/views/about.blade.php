<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            About Neigh
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-6 rounded-xl bg-white p-6 text-gray-700 shadow-sm ring-1 ring-gray-900/5 sm:p-8">
                <p>
                    <strong>Neigh is Tinder for horses.</strong> Owners create profiles for their horses and browse
                    the horses of other owners, looking for a riding buddy, a paddock pal or a partner.
                </p>

                <div>
                    <h3 class="font-semibold text-gray-900">How matching works</h3>
                    <p class="mt-2">
                        You like another horse on behalf of one of your own horses. When that horse likes one of yours back,
                        it's a match, and both owners see each other's email on their Matches page, so you can get in touch.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900">Hidden horses</h3>
                    <p class="mt-2">
                        Not looking right now? Hide your horse in its settings. It disappears from browsing until you show it again.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900">Breeds</h3>
                    <p class="mt-2">
                        Every horse has a breed. The list of <a href="{{ route('breeds.index') }}" class="text-indigo-600 hover:underline">breeds</a>
                        is managed by our admins.
                    </p>
                </div>

                <p class="text-sm text-gray-500">Neigh is a university project, built with Laravel.</p>
            </div>
        </div>
    </div>
</x-app-layout>
