<x-letter title="Set up your machine" intro="The reading tracks need the basics. The device tracks build real apps, so they need a mobile toolchain too.">
    <x-letter-section heading="Every track">
        <ul>
            <li><code>git</code> and the GitHub CLI, logged in with <code>gh auth login</code>. Your agent uses your account to read, fork and comment.</li>
            <li>PHP 8.4 and Composer.</li>
            <li>About 5 GB free.</li>
        </ul>
    </x-letter-section>

    <x-letter-section heading="Device tracks on Android">
        <p class="text-ink-soft">macOS, Linux or Windows.</p>
        <ul class="mt-2">
            <li>Android Studio or the command line tools, with SDK platform 36, the emulator and one system image.</li>
            <li>One virtual device from Device Manager. Any recent Pixel works.</li>
            <li>JDK 17.</li>
        </ul>
    </x-letter-section>

    <x-letter-section heading="Device tracks on iOS">
        <p class="text-ink-soft">macOS only.</p>
        <ul class="mt-2">
            <li>Xcode 26 or newer, opened once so it finishes installing.</li>
            <li>An iOS simulator runtime, from Xcode, Settings, Components.</li>
            <li>CocoaPods.</li>
        </ul>
        <p class="mt-4">Plan on 30 to 40 GB free and keep the machine awake. The first build of the day takes 5 to 15 minutes. Your agent only uses emulators and simulators, never a phone plugged into your machine.</p>
    </x-letter-section>

    <x-letter-section heading="Check before you give">
        <p>Every prompt starts with a self check. If something is missing it stops and tells you what, before claiming anything or spending much. It never installs system software without asking.</p>

        <div x-data="selfCheck({ promptBase: @js(route('home').'/prompts') })" class="mt-6 rounded-lg border-2 border-ink p-5">
            <fieldset>
                <legend class="font-bold">I want to check for</legend>
                <div class="mt-1.5 flex gap-5">
                    <label class="flex items-center gap-2"><input type="checkbox" value="android" x-model="platforms" class="size-4 accent-red">Android</label>
                    <label class="flex items-center gap-2"><input type="checkbox" value="ios" x-model="platforms" class="size-4 accent-red">iOS</label>
                </div>
            </fieldset>

            <button type="button" @click="copy()" class="mt-5 rounded-lg bg-red px-5 py-3 font-bold text-on-red transition-colors hover:bg-red-ink">Copy the self check</button>

            <p class="mt-3 text-sm text-ink-soft" x-show="!copied && !failure">Under 20k tokens. Claims nothing, posts nothing.</p>
            <p class="mt-3" x-show="copied" x-cloak role="status"><strong>Copied.</strong> <span x-text="$store.agent.current === 'codex' ? 'Paste it into codex started in any folder.' : 'Paste it into your agent, started in any folder.'"></span></p>
            <p class="mt-3 text-red-ink" x-show="failure" x-cloak role="alert" x-text="failure"></p>
        </div>
    </x-letter-section>
</x-letter>
