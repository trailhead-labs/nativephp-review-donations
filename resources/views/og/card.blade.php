@php
    $content = config("og.cards.$card");
    $art = resource_path('images/og-art.webp');
@endphp

<!DOCTYPE html>
{{-- Cards are always light, whatever the rendering browser prefers. --}}
<html lang="en" style="color-scheme: light; --paper: #e8ebf6; --sheet: #fcfcfe; --ink: #272d48; --ink-soft: #5a6180; --rule: #cfd3e6; --red: #d2343c; --blue: #505b93; --on-red: #fcfcfe;">
    <head>
        <meta charset="utf-8">
        <title>{{ $content['title'] }}</title>
        @fonts
        @vite('resources/css/app.css')
    </head>
    <body class="m-0 overflow-hidden bg-paper p-6">
        <div class="airmail relative flex h-[582px] w-[1152px] overflow-hidden bg-sheet">
            <div class="relative z-10 flex w-[640px] flex-col justify-between py-11 pr-4 pl-14">
                <div class="flex items-center gap-3">
                    <x-love-stamp size="small" class="w-10 -rotate-6" />
                    <span class="font-display text-[30px] text-ink">Review Donations</span>
                </div>

                <div>
                    <h1 class="font-display leading-[1.02] text-balance text-ink {{ match (true) { mb_strlen($content['title']) <= 12 => 'text-[88px]', mb_strlen($content['title']) <= 20 => 'text-[72px]', default => 'text-[62px]' } }}">{{ $content['title'] }}</h1>
                    <p class="mt-5 max-w-[30ch] text-[26px] leading-snug text-pretty text-ink-soft">{{ $content['line'] }}</p>
                </div>

                <div class="flex items-center gap-4">
                    <span class="text-[20px] text-ink-soft">To the maintainers of</span>
                    <span class="block -rotate-1 rounded-sm bg-sheet px-4 py-2.5 shadow-[0_1px_3px_rgb(39_45_72/0.25)] ring-1 ring-rule">
                        <span class="block w-48 [&_svg]:h-auto [&_svg]:w-full">{!! file_get_contents(resource_path('images/nativephp-light.svg')) !!}</span>
                    </span>
                </div>
            </div>

            @if (file_exists($art))
                <img src="data:image/webp;base64,{{ base64_encode(file_get_contents($art)) }}" alt=""
                     class="absolute top-1/2 -right-20 w-[580px] -translate-y-1/2 mix-blend-multiply">
            @else
                <div class="absolute top-16 right-20">
                    <x-love-stamp class="w-64 rotate-3" />
                    <x-postmark :waves="0.35" class="absolute top-24 -left-36 w-96 text-ink opacity-50" />
                </div>
            @endif
        </div>
    </body>
</html>
