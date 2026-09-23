@props(['label' => 'Open source, first class', 'top' => 'with', 'bottom' => 'love', 'waves' => 1])

{{-- A round postmark with wavy cancellation lines trailing to its right. --}}
<svg {{ $attributes->merge(['class' => 'pointer-events-none']) }} viewBox="0 0 260 120" fill="none" aria-hidden="true">
    <defs>
        <path id="postmark-ring" d="M60 60 m-44 0 a44 44 0 1 1 88 0 a44 44 0 1 1 -88 0" />
    </defs>
    <g stroke="currentColor" stroke-width="2.5">
        <circle cx="60" cy="60" r="56" />
        <circle cx="60" cy="60" r="32" />
    </g>
    <g stroke="currentColor" stroke-width="2.5" stroke-opacity="{{ $waves }}">
        @foreach ([36, 50, 64, 78, 92] as $y)
            <path d="M126 {{ $y }} q 16 -8 32 0 t 32 0 t 32 0 t 32 0" />
        @endforeach
    </g>
    <text fill="currentColor" font-size="11.5" font-weight="700" letter-spacing="2.4" class="font-sans uppercase">
        <textPath href="#postmark-ring" startOffset="0">{{ $label }}</textPath>
    </text>
    <text x="60" y="58" fill="currentColor" font-size="13" font-weight="700" text-anchor="middle" class="font-sans">{{ $top }}</text>
    <text x="60" y="74" fill="currentColor" font-size="13" font-weight="700" text-anchor="middle" class="font-sans">{{ $bottom }}</text>
</svg>
