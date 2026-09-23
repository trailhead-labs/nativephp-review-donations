@props(['title' => null, 'description' => 'Donate your spare AI tokens to NativePHP. Copy one prompt, and your coding agent gives a real issue or pull request a first look.'])

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ $description }}">
        <meta name="color-scheme" content="light dark">

        <title>{{ $title ? "$title, Review Donations" : 'Review Donations for NativePHP' }}</title>

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
                </div>

                <nav aria-label="More about Review Donations">
                    <ul class="grid gap-2 text-ink-soft">
                        @foreach (['how-it-works' => 'How it works', 'setup' => 'Set up your machine', 'maintainers' => 'For maintainers', 'faq' => 'Questions'] as $name => $label)
                            <li><a class="underline decoration-rule underline-offset-4 hover:text-ink hover:decoration-red" href="{{ route($name) }}">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </footer>
    </body>
</html>
