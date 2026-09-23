@props(['title' => null, 'description' => null, 'og' => 'home'])

@php
    $description ??= 'Donate your spare AI tokens to NativePHP. Copy one prompt, and your coding agent gives a real issue or pull request a first look.';
    $card = config("og.cards.$og");

    // GitHub Pages serves every page as a folder, so the final URL ends in a slash.
    $pageUrl = rtrim(url()->current(), '/').'/';
    $imageAlt = "{$card['title']}. The Review Donations share card, with airmail envelopes and a heart stamp.";
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ $description }}">
        <meta name="color-scheme" content="light dark">

        <title>{{ $title ? "$title, Review Donations" : 'Review Donations for NativePHP' }}</title>

        <link rel="canonical" href="{{ $pageUrl }}">

        {{-- Share cards, rendered from resources/views/og with `php artisan og:generate`. --}}
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Review Donations">
        <meta property="og:url" content="{{ $pageUrl }}">
        <meta property="og:title" content="{{ $card['title'] }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:image" content="{{ asset("og/$og.png") }}">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="{{ $imageAlt }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $card['title'] }}">
        <meta name="twitter:description" content="{{ $description }}">
        <meta name="twitter:image" content="{{ asset("og/$og.png") }}">
        <meta name="twitter:image:alt" content="{{ $imageAlt }}">

        <link rel="icon" href="data:image/svg+xml,{{ rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><rect width="32" height="32" rx="4" fill="#d2343c"/><text x="16" y="23" font-family="Georgia,serif" font-weight="700" font-size="17" text-anchor="middle" fill="#fcfcfe">&lt;3</text></svg>') }}">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-sans text-[17px] leading-relaxed antialiased">
        <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-3 focus:left-3 focus:z-50 focus:bg-sheet focus:px-3 focus:py-2">Skip to content</a>

        <header class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-5 sm:px-6">
            <a href="{{ route('home') }}" class="group flex items-center gap-3">
                <x-love-stamp size="small" class="w-9 -rotate-6 transition-transform group-hover:rotate-0" />
                <span class="font-display text-xl sm:text-2xl">Review Donations</span>
            </a>

            <x-agent-switch />
        </header>

        <main id="main">
            {{ $slot }}
        </main>

        <footer class="mt-24">
            <div class="airmail-strip"></div>

            <div class="mx-auto grid max-w-6xl gap-8 px-4 py-12 sm:px-6 md:grid-cols-[1fr_auto]">
                <div class="max-w-[46ch]">
                    <p class="font-display text-2xl leading-snug">Open source runs on small kindnesses. This one fits in your clipboard.</p>
                    <p class="mt-4 text-sm text-ink-soft">Not affiliated with any AI vendor. Run by the NativePHP community.</p>
                    <x-trailhead class="mt-5" />
                </div>

                <nav aria-label="More about Review Donations">
                    <ul class="grid gap-2 text-ink-soft">
                        @foreach (['how-it-works' => 'How it works', 'setup' => 'Set up your machine', 'maintainers' => 'For maintainers', 'faq' => 'Questions'] as $name => $label)
                            <li><a class="underline decoration-rule underline-offset-4 hover:text-ink hover:decoration-red" href="{{ route($name) }}">{{ $label }}</a></li>
                        @endforeach
                        <li><a class="underline decoration-rule underline-offset-4 hover:text-ink hover:decoration-red" href="{{ config('donations.repository') }}" target="_blank" rel="noopener">Contribute on GitHub</a></li>
                    </ul>
                </nav>
            </div>
        </footer>
    </body>
</html>
