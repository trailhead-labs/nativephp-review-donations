@props(['title', 'intro' => null, 'og'])

<x-layout :title="$title" :description="$intro" :og="$og">
    <div class="mx-auto max-w-4xl px-4 sm:px-6">
        <article class="letter-sheet mt-4 overflow-hidden rounded-sm bg-sheet shadow-[0_18px_40px_-24px_rgb(39_45_72/0.45)]">
            <div class="airmail-strip"></div>

            <div class="px-6 py-10 sm:px-12 sm:py-14">
                <div class="flex items-start justify-between gap-6">
                    <h1 class="font-display text-4xl leading-tight sm:text-5xl">{{ $title }}</h1>
                    <x-love-stamp size="medium" class="w-16 shrink-0 rotate-6 sm:w-20" />
                </div>

                @if ($intro)
                    <p class="mt-5 max-w-[60ch] text-lg text-ink-soft">{{ $intro }}</p>
                @endif

                <div class="prose-letter mt-10 grid max-w-[65ch] gap-10">
                    {{ $slot }}

                    <p class="font-display text-xl leading-snug">With love,<br>the NativePHP community</p>
                </div>
            </div>
        </article>
    </div>
</x-layout>
