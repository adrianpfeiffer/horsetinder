@props(['horse'])

@if ($horse->photo_path)
    <img src="{{ asset('storage/'.$horse->photo_path) }}" alt="{{ $horse->name }}"
         onerror="this.hidden = true; this.nextElementSibling.hidden = false"
         {{ $attributes->merge(['class' => 'object-cover']) }}>
    <div hidden {{ $attributes->merge(['class' => 'flex items-center justify-center bg-amber-100 text-6xl']) }}>🐴</div>
@else
    <div {{ $attributes->merge(['class' => 'flex items-center justify-center bg-amber-100 text-6xl']) }}>🐴</div>
@endif
