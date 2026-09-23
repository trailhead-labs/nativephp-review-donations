<x-layout>
    <div class="mx-auto max-w-6xl px-4 sm:px-6">

        {{-- The envelope: a letter from you to the maintainers. --}}
        <section class="airmail relative mt-4 bg-sheet shadow-[0_18px_40px_-24px_rgb(39_45_72/0.45)]" aria-labelledby="hero-title">
            <div class="grid gap-10 p-6 sm:p-10 md:grid-cols-[1fr_auto] md:gap-12 lg:p-14">
                <div>
                    <p class="pr-28 text-ink-soft md:pr-0">From you, with love</p>

                    <h1 id="hero-title" class="mt-8 max-w-[13ch] font-display text-[2.75rem] leading-[1.02] sm:text-6xl lg:text-7xl">Put your spare AI tokens to work on NativePHP</h1>

                    <p class="mt-7 max-w-[56ch] text-lg">You pay for a coding agent and probably don't use all of it. Copy one prompt, paste it into Claude Code or Codex, and your agent gives a real NativePHP issue or pull request a first look. It is a head start, not a verdict: the maintainers still decide, they just don't start from scratch.</p>

                    <div class="mt-9 flex flex-wrap gap-3">
                        <a href="#pick" class="rounded-lg bg-red px-6 py-3.5 text-lg font-bold text-on-red transition-colors hover:bg-red-ink">Pick a task</a>
                        <a href="{{ route('how-it-works') }}" class="rounded-lg border-2 border-ink px-6 py-3 text-lg font-bold transition-colors hover:bg-ink hover:text-sheet">How it works</a>
                    </div>
                </div>

                {{-- The stamp goes where a real one would: the top right corner. --}}
                <div class="absolute top-5 right-5 md:relative md:top-auto md:right-auto md:self-start">
                    <x-love-stamp class="w-20 rotate-3 sm:w-28 md:w-52" />
                    <x-postmark :waves="0.35" class="absolute top-10 -left-20 w-40 text-ink opacity-50 md:top-28 md:-left-32 md:w-80" />
                </div>
            </div>

            <div class="flex flex-wrap items-end justify-end gap-x-4 gap-y-2 border-t border-dashed border-rule px-6 py-6 sm:px-10 lg:px-14">
                <span class="text-ink-soft">To the maintainers of</span>
                {{-- NativePHP's own mark, on a printed address label so its dark navy stays legible. --}}
                <span class="block -rotate-1 rounded-sm bg-[#fcfcfe] px-4 py-3 shadow-[0_1px_3px_rgb(39_45_72/0.25)] ring-1 ring-rule">
                    <span class="block w-44 sm:w-52 [&_svg]:h-auto [&_svg]:w-full">{!! file_get_contents(resource_path('images/nativephp-light.svg')) !!}</span>
                    <span class="sr-only">NativePHP</span>
                </span>
            </div>
        </section>

        {{-- Three steps, in order. --}}
        <ol class="mt-20 grid gap-10 md:grid-cols-3 md:gap-8">
            @foreach ([
                ['Pick a task.', 'Review a pull request, diagnose an issue, or reproduce one on a simulator.'],
                ['Copy the prompt.', 'Choose how much to give. You see which models it uses and roughly how long it takes before you copy.'],
                ['Paste and walk away.', 'Your agent claims one item, does the work, shows you its report, and posts it when you say so.'],
            ] as [$lead, $text])
                <li class="grid grid-cols-[auto_1fr] gap-4">
                    <span class="font-display text-5xl leading-none text-red">{{ $loop->iteration }}</span>
                    <p class="max-w-[34ch]"><strong>{{ $lead }}</strong> {{ $text }}</p>
                </li>
            @endforeach
        </ol>

        <section id="pick" class="mt-24 scroll-mt-6">
            <x-picker />
        </section>
    </div>
</x-layout>
