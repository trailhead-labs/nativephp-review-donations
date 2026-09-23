# Review Donations

Donate your spare AI tokens to [NativePHP](https://nativephp.com). Pick a task, copy one prompt into Claude Code, Codex or any coding agent, and it gives a real open issue or pull request a first look. The maintainers still decide, they just don't start from scratch.

Live at [trailhead-labs.github.io/nativephp-review-donations](https://trailhead-labs.github.io/nativephp-review-donations).

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
