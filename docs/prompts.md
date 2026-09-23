# Writing prompts

The prompts live in `resources/views/prompts` as Blade views that render to plain text. What the site shows about each one (steps, skips, requirements, estimates) lives in `config/donations.php`. When you change what a prompt does, update both.

## Layout

```
prompts/
  self-check.blade.php          checks a donor's setup, claims and posts nothing
  {track}/
    quick.blade.php             one file per level
    thorough.blade.php
    deep.blade.php
    adaptive.blade.php          sizes the item, then runs one of the others
    work-quick.blade.php        the Work section of each level, shared with adaptive
    work-thorough.blade.php
    work-deep.blade.php
  partials/
    preamble                    who you are, donor settings, workspace
    self-check-step             step 0, also used by self-check
    rules                       may, may not, stop conditions, voice
    evidence                    the empirical mandate and realism filter
    pick, claim                 choosing an item and claiming it on the ledger
    context, workspace          reading the item, clones, test baseline
    subagents, relay            starting helpers, and plan, drive, analyse for device work
    rig, android, ios, probe    the host app, emulator, simulator and evidence capture
    native-facts                verified bridge and plugin contracts
    review-angles, sizing       what a review checks, and the adaptive rubric
    pr-gate, report, finish     the PR bar, comment templates, and wrapping up
```

Track keys are `issue-reason`, `issue-prove`, `pr-reason` and `pr-prove`.

## Conventions

- `@include('prompts.partials.rules')` inlines a partial. Every prompt includes what it needs, so a copied prompt is always self contained.
- Agent specific lines sit in `@if ($agent === 'claude')` blocks, one per agent: `claude`, `codex` or `other`. Anything outside them goes to every agent.
- `{{ $models['analyst'] }}` names the model for a role, resolved per agent from `config/donations.php`. Never write a model name directly.
- `{{ $track }}`, `{{ $level }}`, `{{ $tokens }}`, `{{ $time }}`, `{{ $siteUrl }}` and `{{ $ledger }}` are filled in when the prompt renders.
- `@{{donor.handle}}` and the other `donor.*` placeholders stay in the text. The picker fills them in the browser from the donor's settings before copying.

## Things to watch

- Whitespace is the output. A directive on its own line disappears with its line break, and runs of blank lines are collapsed, but indentation inside code blocks is kept exactly.
- A literal `{{` must be written as `@{{`, and an `@` followed by a word Blade knows (`@if`, `@include`, `@php`) is read as a directive.
- `tests/Feature/PromptTest.php` renders every prompt for every agent and fails on leftover Blade syntax. Run it after every change.
- Open a rendered prompt at `/prompts/{agent}/{track}/{level}.txt` to read it the way an agent will.
