import Alpine from 'alpinejs';

const agents = ['claude', 'codex', 'other'];

/*
 * Browser storage only remembers conveniences like the agent and
 * your handle. It may be blocked, so every access is guarded.
 */
const remembered = {
    get(key) {
        try {
            return localStorage.getItem(key);
        } catch {
            return null;
        }
    },
    set(key, value) {
        try {
            localStorage.setItem(key, value);
        } catch {
            //
        }
    },
};

const prompts = {};

function fetchPrompt(url) {
    prompts[url] ??= fetch(url).then((response) => {
        if (!response.ok) {
            delete prompts[url];
            throw new Error(`Could not load ${url}`);
        }

        return response.text();
    });

    return prompts[url];
}

/*
 * Safari only allows clipboard writes inside the click itself,
 * so a prompt still loading is handed over as a pending blob.
 */
async function copyToClipboard(pendingText) {
    if (window.ClipboardItem && navigator.clipboard?.write) {
        const blob = pendingText.then((text) => new Blob([text], { type: 'text/plain' }));

        await navigator.clipboard.write([new ClipboardItem({ 'text/plain': blob })]);
    } else {
        await navigator.clipboard.writeText(await pendingText);
    }

    return pendingText;
}

function fillPlaceholders(text, values) {
    return text.replace(/\{\{(donor\.[a-z_]+)\}\}/g, (placeholder, key) => values[key] ?? placeholder);
}

function platformSetting(platforms) {
    return platforms.length === 2 ? 'both' : platforms[0];
}

function wordCount(text) {
    return text.split(/\s+/).filter(Boolean).length.toLocaleString('en');
}

Alpine.store('agent', {
    current: 'claude',

    init() {
        const fromUrl = new URLSearchParams(window.location.search).get('agent');
        const fromStorage = remembered.get('agent');

        this.current = [fromUrl, fromStorage].find((agent) => agents.includes(agent)) ?? 'claude';
    },

    choose(agent) {
        this.current = agent;
        remembered.set('agent', agent);

        const url = new URL(window.location.href);
        url.searchParams.set('agent', agent);
        window.history.replaceState(null, '', url);
    },
});

Alpine.data('picker', ({ catalog, promptBase, track = null }) => ({
    catalog,
    track,
    level: 'quick',
    handle: remembered.get('handle') ?? '',
    platforms: ['android'],
    ceiling: 'thorough',
    postMode: 'confirm',
    item: '',
    preview: '',
    copied: null,
    failure: null,

    init() {
        this.$watch('handle', (handle) => remembered.set('handle', handle.trim()));
        this.$watch('url', () => this.reset());
    },

    get agent() {
        return Alpine.store('agent').current;
    },

    get prompt() {
        return this.track ? this.catalog.prompts[this.track][this.level] : null;
    },

    get onDevice() {
        return this.track && this.catalog.tracks[this.track].device;
    },

    get url() {
        return this.track ? `${promptBase}/${this.agent}/${this.track}/${this.level}.txt` : null;
    },

    get cleanHandle() {
        return this.handle.trim().replace(/^@/, '');
    },

    get platformSetting() {
        return platformSetting(this.platforms) ?? '';
    },

    get blocker() {
        if (!this.cleanHandle) {
            return 'Add your GitHub handle to copy.';
        }

        if (this.onDevice && !this.platforms.length) {
            return 'Choose at least one platform to copy.';
        }

        return null;
    },

    model(role) {
        return this.catalog.roles[role].models[this.agent];
    },

    job(role) {
        return this.catalog.roles[role].job;
    },

    weight(level, bar) {
        const [low, high] = this.catalog.prompts[this.track][level].weight;

        if (bar <= low) {
            return 'full';
        }

        if (bar <= high) {
            return 'range';
        }

        return 'empty';
    },

    choose(track) {
        this.track = track;

        this.$nextTick(() =>
            this.$refs.levels?.scrollIntoView({
                behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
                block: 'start',
            }),
        );
    },

    reset() {
        this.copied = null;
        this.failure = null;
        this.preview = '';
    },

    filled() {
        return fetchPrompt(this.url).then((text) =>
            fillPlaceholders(text, {
                'donor.handle': this.cleanHandle,
                'donor.ceiling': this.level === 'adaptive' ? this.ceiling : 'not used',
                'donor.post_mode': this.postMode,
                'donor.platforms': this.onDevice ? this.platformSetting : 'not used',
                'donor.item': this.item.trim(),
            }),
        );
    },

    async showPreview(open) {
        this.preview = open ? await this.filled().catch(() => 'The prompt could not be loaded.') : '';
    },

    async copy() {
        if (this.blocker) {
            return;
        }

        this.reset();

        try {
            const text = await copyToClipboard(this.filled());

            this.copied = { words: wordCount(text), paste: this.catalog.agents[this.agent].paste };
        } catch {
            this.failure = 'Your browser blocked the clipboard. Open the preview and copy it from there.';
        }
    },
}));

Alpine.data('selfCheck', ({ promptBase }) => ({
    platforms: ['android', 'ios'],
    copied: false,
    failure: null,

    async copy(tracks = null, platforms = null) {
        this.copied = false;
        this.failure = null;

        const url = `${promptBase}/${Alpine.store('agent').current}/self-check.txt`;
        const pending = fetchPrompt(url).then((text) =>
            fillPlaceholders(text, {
                'donor.tracks': tracks ?? 'all tracks',
                'donor.platforms': platforms ?? platformSetting(this.platforms) ?? 'none',
            }),
        );

        try {
            await copyToClipboard(pending);
            this.copied = true;
        } catch {
            this.failure = 'Your browser blocked the clipboard. Try the button again.';
        }
    },
}));

window.Alpine = Alpine;

Alpine.start();
