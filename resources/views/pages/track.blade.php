@php($option = config("donations.tracks.$track"))

<x-layout :title="$option['name']" :description="$option['intro']" :og="'tracks-'.$track">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="mt-4 max-w-[62ch]">
            <h1 class="font-display text-5xl leading-tight sm:text-6xl">{{ $option['name'] }}</h1>
            <p class="mt-5 text-lg">{{ $option['intro'] }}</p>
        </div>

        <section class="mt-16">
            <x-picker :track="$track" />
        </section>
    </div>
</x-layout>
