<fieldset x-data class="flex items-center gap-3">
    <legend class="sr-only">Which coding agent do you use?</legend>

    <span aria-hidden="true" class="hidden text-sm text-ink-soft sm:inline">My agent</span>

    <div class="flex rounded-full border-2 border-ink p-0.5">
        @foreach (config('donations.agents') as $key => $agent)
            <label class="cursor-pointer">
                <input type="radio" name="agent" value="{{ $key }}" class="peer sr-only" @checked($key === 'claude')
                       :checked="$store.agent.current === '{{ $key }}'"
                       @change="$store.agent.choose('{{ $key }}')">
                <span class="block rounded-full px-3 py-1 text-sm font-bold transition-colors peer-checked:bg-ink peer-checked:text-sheet peer-focus-visible:outline-3 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-red">{{ $agent['name'] }}</span>
            </label>
        @endforeach
    </div>
</fieldset>
