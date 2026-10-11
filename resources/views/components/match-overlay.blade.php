@props(['myHorse', 'theirHorse'])

<div x-data="{ open: true }"
     x-show="open"
     x-effect="document.body.classList.toggle('overflow-hidden', open)"
     x-on:keydown.escape.window="open = false"
     x-transition:leave="transition duration-300"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center overflow-hidden bg-gradient-to-br from-pink-600 via-rose-500 to-orange-400 p-4"
     role="dialog" aria-modal="true" aria-labelledby="match-title">

    <style>
        .match-left { animation: match-slide-left 0.7s cubic-bezier(0.2, 0.9, 0.3, 1.2) both; }
        .match-right { animation: match-slide-right 0.7s cubic-bezier(0.2, 0.9, 0.3, 1.2) both; }
        .match-heart { animation: match-pop 0.5s 0.6s both, match-beat 1.4s 1.2s infinite; }
        .match-title { animation: match-fade-up 0.6s 0.9s both; }
        .match-subtitle { animation: match-fade-up 0.6s 1.1s both; }
        .match-buttons { animation: match-fade-up 0.6s 1.3s both; }
        .match-float { position: absolute; bottom: -3rem; animation: match-float linear infinite both; }

        @keyframes match-slide-left { from { transform: translateX(-100vw) rotate(-25deg); } to { transform: none; } }
        @keyframes match-slide-right { from { transform: translateX(100vw) rotate(25deg); } to { transform: none; } }
        @keyframes match-pop { 0% { transform: scale(0); } 70% { transform: scale(1.5); } 100% { transform: scale(1); } }
        @keyframes match-beat { 0%, 100% { transform: scale(1); } 15% { transform: scale(1.2); } 30% { transform: scale(1); } 45% { transform: scale(1.12); } }
        @keyframes match-fade-up { from { opacity: 0; transform: translateY(1.5rem); } to { opacity: 1; transform: none; } }
        @keyframes match-float { 0% { transform: translateY(0) rotate(0); opacity: 0; } 10% { opacity: 0.8; } 100% { transform: translateY(-110vh) rotate(40deg); opacity: 0; } }

        @media (prefers-reduced-motion: reduce) {
            [class^="match-"], [class*=" match-"] { animation: none !important; }
            .match-float { display: none; }
        }
    </style>

    @foreach (range(1, 16) as $i)
        <span class="match-float" aria-hidden="true"
              style="left: {{ ($i * 37) % 100 }}%; font-size: {{ 1 + ($i % 3) * 0.6 }}rem; animation-duration: {{ 4 + $i % 4 }}s; animation-delay: {{ ($i % 6) * 0.5 }}s;">
            {{ ['❤️', '💕', '💖', '🐴'][$i % 4] }}
        </span>
    @endforeach

    <div class="relative text-center" x-on:click.outside="open = false">
        <h2 id="match-title" class="match-title text-5xl font-extrabold italic tracking-tight text-white drop-shadow-lg sm:text-6xl">
            It's a match!
        </h2>
        <p class="match-subtitle mt-3 text-lg text-white/90">
            {{ $myHorse->name }} and {{ $theirHorse->name }} like each other.
        </p>

        <div class="mt-10 flex items-center justify-center">
            <div class="match-left">
                <x-horse-photo :horse="$myHorse" class="size-32 rounded-full text-6xl shadow-2xl ring-4 ring-white sm:size-44" />
            </div>
            <div class="match-heart z-10 -mx-5 text-6xl drop-shadow-lg sm:text-7xl">❤️</div>
            <div class="match-right">
                <x-horse-photo :horse="$theirHorse" class="size-32 rounded-full text-6xl shadow-2xl ring-4 ring-white sm:size-44" />
            </div>
        </div>

        <div class="match-buttons mt-12 flex flex-col items-center justify-center gap-3 sm:flex-row">
            <a href="{{ route('matches.index') }}#match-{{ $myHorse->id }}-{{ $theirHorse->id }}"
               class="rounded-full bg-white px-8 py-3 font-semibold text-pink-600 shadow-lg transition hover:scale-105">
                💌 Show contact
            </a>
            <button type="button" x-on:click="open = false"
                    class="rounded-full border-2 border-white px-8 py-3 font-semibold text-white transition hover:bg-white/10">
                Keep browsing
            </button>
        </div>
    </div>
</div>
