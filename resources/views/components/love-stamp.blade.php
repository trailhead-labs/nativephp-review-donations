@props(['size' => 'large'])

{{--
    A postage stamp whose picture is the oldest heart on the internet.
    The shadow sits on the wrapper, since the mask would clip it.
--}}
<div {{ $attributes->merge(['class' => 'shrink-0 drop-shadow-[0_3px_2px_rgb(39_45_72/0.22)]']) }} aria-hidden="true">
    <div class="stamp">
        @if ($size === 'small')
            <div class="grid aspect-[4/5] place-items-center bg-red">
                <span class="font-display text-[0.8rem] leading-none text-on-red">&lt;3</span>
            </div>
        @elseif ($size === 'medium')
            <div class="stamp-face grid aspect-[4/5] place-items-center [outline-offset:-5px]">
                <span class="font-display text-[2rem] leading-none text-red">&lt;3</span>
            </div>
        @else
            <div class="stamp-face flex aspect-[4/5] flex-col justify-between p-3 sm:p-4 sm:[outline-offset:-10px]">
                <span class="px-1 pt-1 text-xs font-bold whitespace-nowrap text-ink-soft sm:text-sm">1 prompt</span>
                <span class="text-center font-display text-[3.25rem] leading-none text-red sm:text-[6.5rem]">&lt;3</span>
                <span class="px-1 pb-1 text-center text-xs font-bold whitespace-nowrap text-ink-soft sm:text-sm">Open source post</span>
            </div>
        @endif
    </div>
</div>
