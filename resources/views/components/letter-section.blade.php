@props(['heading'])

<section>
    <h2 class="font-display text-2xl">{{ $heading }}</h2>
    <div class="mt-3">
        {{ $slot }}
    </div>
</section>
