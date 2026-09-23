@props(['track' => null])

@php
    $catalog = [
        'agents' => config('donations.agents'),
        'roles' => config('donations.roles'),
        'tracks' => config('donations.tracks'),
        'prompts' => config('donations.prompts'),
    ];

    $axes = [
        'columns' => ['reason' => 'Read the code', 'device' => 'Run it on a device'],
        'rows' => ['issue' => 'An issue', 'pr' => 'A pull request'],
    ];
@endphp

<div x-data="picker({ catalog: @js($catalog), promptBase: @js(url('prompts')), track: @js($track) })" class="grid gap-16">

    {{-- Tracks: two axes, so the four stamps sit on a labelled grid. --}}
    <fieldset>
        <legend class="font-display text-3xl sm:text-4xl">What would you like to give?</legend>

        <div class="mt-8 grid gap-5 md:grid-cols-[auto_1fr_1fr] md:gap-x-6 md:gap-y-5">
            <div class="hidden md:block"></div>
            @foreach ($axes['columns'] as $column)
                <p class="hidden self-end pl-2 font-bold text-ink-soft md:block">{{ $column }}</p>
            @endforeach

            @foreach ($axes['rows'] as $subject => $row)
                <p class="hidden self-center pr-2 text-right font-bold text-ink-soft md:block">{{ $row }}</p>

                @foreach (collect($catalog['tracks'])->where('subject', $subject) as $key => $option)
                    <label class="group relative block cursor-pointer transition-[translate,rotate,filter] duration-200 hover:-translate-y-0.5 has-checked:-rotate-1"
                           :class="track === '{{ $key }}' ? 'drop-shadow-[0_8px_8px_rgb(39_45_72/0.25)]' : 'drop-shadow-[0_2px_2px_rgb(39_45_72/0.16)]'">
                        <input type="radio" name="track" value="{{ $key }}" class="sr-only" x-model="track" @change="choose('{{ $key }}')">

                        <div class="stamp h-full">
                            <div class="stamp-face flex h-full flex-col gap-3 p-6 group-has-checked:outline-2 group-has-checked:outline-red group-has-focus-visible:outline-3 group-has-focus-visible:outline-red sm:p-7">
                                <div class="flex items-start justify-between gap-4">
                                    <h3 class="font-display text-2xl leading-tight sm:text-[1.75rem]">{{ $option['name'] }}</h3>
                                    <span class="shrink-0 text-right leading-none">
                                        <span class="block font-display text-2xl text-red">{{ Str::before(config("donations.prompts.$key.quick.tokens"), ' to') }}</span>
                                        <span class="text-xs text-ink-soft">tokens and up</span>
                                    </span>
                                </div>

                                <p class="text-ink-soft">{{ $option['blurb'] }}</p>

                                <p class="mt-auto text-sm font-bold text-blue">{{ $option['device'] ? 'Needs a mobile build setup' : 'No emulator needed' }}</p>
                            </div>
                        </div>

                        <x-postmark x-show="track === '{{ $key }}'" x-cloak label="Picked with care" top="for" bottom="you"
                                    class="postmark-drop absolute -right-4 -bottom-6 w-36 text-red opacity-90" />
                    </label>
                @endforeach
            @endforeach
        </div>
    </fieldset>

    {{-- Levels: how much to give, with a stamp gauge for the relative cost. --}}
    <fieldset x-show="track" x-cloak x-ref="levels" class="scroll-mt-6">
        <legend class="font-display text-3xl sm:text-4xl">How much would you like to give?</legend>

        <div class="mt-8 grid grid-cols-2 gap-3 lg:grid-cols-4">
            @foreach (config('donations.levels') as $key => $option)
                <label class="cursor-pointer">
                    <input type="radio" name="level" value="{{ $key }}" class="peer sr-only" x-model="level">

                    <div class="flex h-full flex-col gap-2 rounded-lg border-2 border-rule bg-sheet p-4 transition-colors peer-checked:border-red peer-checked:shadow-[inset_0_0_0_1px_var(--red)] peer-focus-visible:outline-3 peer-focus-visible:outline-offset-3 peer-focus-visible:outline-red hover:border-ink/50">
                        <span class="text-lg font-bold">{{ $option['name'] }}</span>
                        <span class="text-sm leading-snug text-ink-soft">{{ $option['blurb'] }}</span>

                        <span class="mt-auto flex gap-1 pt-2">
                            @foreach (range(1, 5) as $bar)
                                <span class="size-3 rounded-[2px]"
                                      :class="{
                                          'bg-red': track && weight('{{ $key }}', {{ $bar }}) === 'full',
                                          'bg-red/30': track && weight('{{ $key }}', {{ $bar }}) === 'range',
                                          'bg-rule': track && weight('{{ $key }}', {{ $bar }}) === 'empty',
                                      }"></span>
                            @endforeach
                            <span class="sr-only" x-text="track && `Costs about ${catalog.prompts[track]['{{ $key }}'].tokens} tokens`"></span>
                        </span>
                    </div>
                </label>
            @endforeach
        </div>
    </fieldset>

    {{-- The prompt itself: what it does on the left, what it needs on the right. --}}
    <section x-show="track" x-cloak class="grid items-start gap-6 lg:grid-cols-[1.25fr_1fr]" aria-live="polite">

        <div class="rounded-lg bg-sheet p-6 sm:p-8">
            <h2 class="font-display text-2xl">What your agent does</h2>
            <p class="mt-3 max-w-[60ch] text-ink-soft" x-text="prompt?.summary"></p>

            <ol class="mt-6 grid">
                <template x-for="(step, index) in prompt?.steps ?? []" :key="index">
                    <li class="grid grid-cols-[2rem_1fr] gap-x-2 border-t border-rule py-3 first:border-t-0">
                        <span class="font-display text-lg leading-7 text-red" x-text="index + 1"></span>
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5">
                            <span class="leading-7" x-text="step[0]"></span>
                            <span class="inline-flex flex-wrap gap-1.5">
                                <span class="cursor-help rounded-full bg-ink/8 px-2.5 py-0.5 text-sm font-bold" :title="job(step[1])" x-text="model(step[1])"></span>
                                <span x-show="step[2]" class="rounded-full border border-blue px-2.5 py-0.5 text-sm text-blue" title="A helper that starts with a clean context, so it checks the work without the lead's assumptions">Fresh eyes</span>
                            </span>
                        </div>
                    </li>
                </template>
            </ol>

            <div x-show="prompt?.skips.length" class="mt-6 border-t-2 border-dashed border-rule pt-5">
                <h3 class="font-bold">Skips at this level</h3>
                <p class="mt-1 text-ink-soft first-letter:uppercase" x-text="prompt?.skips.join(', ')"></p>
            </div>

            <div class="mt-5">
                <h3 class="font-bold">Opens a pull request</h3>
                <p class="mt-1 text-ink-soft first-letter:uppercase" x-text="prompt?.opens_pr"></p>
            </div>
        </div>

        <div class="rounded-lg border-2 border-ink bg-sheet p-6 sm:p-8">
            <h2 class="font-display text-2xl">Before you copy</h2>

            <dl class="mt-5 grid grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm text-ink-soft">Tokens <span class="rounded bg-ink/8 px-1.5 text-xs">estimate</span></dt>
                    <dd class="font-bold" x-text="prompt?.tokens"></dd>
                </div>
                <div>
                    <dt class="text-sm text-ink-soft">Time</dt>
                    <dd class="font-bold" x-text="prompt?.time"></dd>
                </div>
            </dl>

            <div class="mt-5">
                <h3 class="text-sm text-ink-soft">You need</h3>
                <ul class="mt-1.5 grid gap-1">
                    <template x-for="requirement in prompt?.requires ?? []" :key="requirement">
                        <li class="flex gap-2"><span aria-hidden="true" class="text-red">&lt;3</span><span x-text="requirement"></span></li>
                    </template>
                </ul>
                <a href="{{ route('setup') }}" class="mt-2 inline-block text-sm underline decoration-red underline-offset-4">Set up your machine</a>
            </div>

            <form class="mt-6 grid gap-5 border-t border-rule pt-6" @submit.prevent="copy()">
                <div>
                    <label for="handle" class="font-bold">Your GitHub handle</label>
                    <input id="handle" x-model="handle" autocomplete="username" spellcheck="false" placeholder="octocat"
                           class="mt-1.5 w-full rounded-md border-2 border-rule bg-paper px-3 py-2 placeholder:text-ink-soft/60 focus:border-ink focus:outline-none">
                    <p class="mt-1 text-sm text-ink-soft">Used for credit, and so your agent skips your own issues.</p>
                </div>

                <fieldset x-show="onDevice">
                    <legend class="font-bold">I can run</legend>
                    <div class="mt-1.5 flex gap-5">
                        <label class="flex items-center gap-2"><input type="checkbox" value="android" x-model="platforms" class="size-4 accent-red">Android</label>
                        <label class="flex items-center gap-2"><input type="checkbox" value="ios" x-model="platforms" class="size-4 accent-red">iOS <span class="text-sm text-ink-soft">(macOS)</span></label>
                    </div>
                </fieldset>

                <div x-show="level === 'adaptive'">
                    <label for="ceiling" class="font-bold">Never go above</label>
                    <select id="ceiling" x-model="ceiling" class="mt-1.5 w-full rounded-md border-2 border-rule bg-paper px-3 py-2 focus:border-ink focus:outline-none">
                        <option value="quick">Quick</option>
                        <option value="thorough">Thorough</option>
                        <option value="deep">Deep</option>
                    </select>
                </div>

                <fieldset>
                    <legend class="font-bold">Before posting</legend>
                    <div class="mt-1.5 grid gap-1">
                        <label class="flex items-center gap-2"><input type="radio" value="confirm" x-model="postMode" class="size-4 accent-red">Show me first</label>
                        <label class="flex items-center gap-2"><input type="radio" value="unattended" x-model="postMode" class="size-4 accent-red">Post without asking</label>
                    </div>
                </fieldset>

                <div>
                    <label for="item" class="font-bold">A specific item <span class="font-normal text-ink-soft">(optional)</span></label>
                    <input id="item" x-model="item" spellcheck="false" placeholder="mobile-air#489"
                           class="mt-1.5 w-full rounded-md border-2 border-rule bg-paper px-3 py-2 placeholder:text-ink-soft/60 focus:border-ink focus:outline-none">
                    <p class="mt-1 text-sm text-ink-soft">Leave empty and your agent picks one.</p>
                </div>

                <div class="relative">
                    <button type="submit" :aria-disabled="!!blocker"
                            class="w-full rounded-lg bg-red px-5 py-4 text-lg font-bold text-on-red transition-colors hover:bg-red-ink aria-disabled:cursor-not-allowed aria-disabled:bg-rule aria-disabled:text-ink-soft">
                        Copy the prompt
                    </button>

                    <x-postmark x-show="copied" x-cloak label="Copied, thank you" top="with" bottom="love"
                                class="postmark-drop absolute -top-10 -right-6 w-40 text-ink opacity-85" />
                </div>

                <p x-show="blocker" class="-mt-2 text-sm text-ink-soft" x-text="blocker"></p>
                <p x-show="copied" class="-mt-2" role="status">
                    <strong>Copied.</strong> <span x-text="copied && `${copied.words} words.`"></span> <span x-text="copied?.paste"></span>
                </p>
                <p x-show="failure" class="-mt-2 text-red-ink" role="alert" x-text="failure"></p>
                <p x-show="catalog.agents[agent].caveat" class="-mt-2 text-sm text-ink-soft" x-text="catalog.agents[agent].caveat"></p>
            </form>

            <details class="mt-6 border-t border-rule pt-4" @toggle="showPreview($el.open)">
                <summary class="cursor-pointer font-bold">Preview the prompt</summary>
                <pre class="mt-3 max-h-96 overflow-auto rounded-md bg-paper p-4 font-mono text-[13px] leading-relaxed whitespace-pre-wrap" x-text="preview || 'Loading…'"></pre>
            </details>

            <div x-data="selfCheck({ promptBase: @js(url('prompts')) })" class="mt-4 text-sm">
                <button type="button" class="underline decoration-red underline-offset-4" @click="copy(track, onDevice ? platformSetting : 'none')">Copy the self check on its own</button>
                <span x-show="copied" class="ml-1 text-ink-soft">Copied. It claims nothing and posts nothing.</span>
                <span x-show="failure" class="ml-1 text-red-ink" x-text="failure"></span>
            </div>
        </div>
    </section>
</div>
