@props(['horse'])

@if ($horse->photo_path)
    <img src="{{ asset('storage/'.$horse->photo_path) }}" alt="{{ $horse->name }}" {{ $attributes->merge(['class' => 'object-cover']) }}>
@else
    <div {{ $attributes->merge(['class' => 'flex items-center justify-center bg-amber-100 text-6xl']) }}>🐴</div>
@endif
