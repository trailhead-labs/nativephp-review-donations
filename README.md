# Review Donations

A love letter to [NativePHP](https://nativephp.com), and a way for anyone to add a line to it.

Live at [trailhead-labs.github.io/nativephp-review-donations](https://trailhead-labs.github.io/nativephp-review-donations).

## Why this exists

Open source is built out of small gifts. A bug report with clear steps, a review on a Sunday, an evening spent chasing something that only breaks on one phone. None of it is glamorous, and all of it adds up to software a whole community gets to build on.

A lot of us now pay for a coding agent and never use all of it. NativePHP has more open issues and pull requests than its maintainers have evenings. Review Donations puts the first to work on the second.

## How giving works

Pick a task and how much you'd like to give, copy one prompt, and paste it into Claude Code, Codex or any other agent. Your agent claims one open issue or pull request, digs in, and writes up what it found: a diagnosis, a reproduction on a simulator, a review or a test run. It shows you the report before posting, unless you opted out, and your name goes on it.

## A head start, not a verdict

The maintainers stay accountable for every decision. Nothing here decides anything for them, and nobody expects them to merge what an agent wrote. A report just means they don't start from scratch. It says plainly what was measured and what was only reasoned, so they know how far to trust it.

## How it's built

A plain Laravel app that never runs as one in production. It is exported to static HTML and served by GitHub Pages. No database, no sessions, no app key.

| Where | What |
|---|---|
| `resources/views/pages` | The pages |
| `resources/views/components` | The picker, stamps, envelope and letter layout |
| `resources/views/prompts` | The prompts your agent runs, one per track and level, with shared partials |
| `config/donations.php` | Tracks, levels, steps, models per agent and cost estimates |
| `config/export.php` | Which paths the static export writes |
| `docs` | The [spec](docs/spec.md), how [prompts](docs/prompts.md) are written, and the [site copy](docs/copy.md) |

Each prompt is served as plain text for every agent at `/prompts/{agent}/{track}/{level}.txt`. The picker fetches it, fills in the donor's settings and copies it.

## Working on it

```bash
composer setup   # install everything and build the assets
composer dev     # php artisan serve and Vite, side by side
composer test
```

On [Herd](https://herd.laravel.com) skip `php artisan serve` and open the `.test` domain with `npm run dev` running.

## Publishing

```bash
composer publish
```

That formats the code, builds the assets, exports every page and prompt to `dist`, and pushes it to the `gh-pages` branch. GitHub Pages serves that branch.

The site lives on a subpath, so `APP_URL` in the build script carries it and the routes are prefixed with it. If it ever moves to its own domain, change that URL and the `--dist` folder in `composer.json`.

After a build, run `npm run dev` or `npm run build` again before working locally. The build points the font URLs at the live site.

## Contributing

Better prompts, clearer copy, a fix for something that broke: all welcome. Open an issue or a pull request. The [spec](docs/spec.md) explains the thinking behind the prompts, so that is a good place to start.

Open source runs on small kindnesses. This one fits in your clipboard.
