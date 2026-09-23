<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Claims Ledger
    |--------------------------------------------------------------------------
    |
    | The repo#number of the issue donors' agents claim items on. It
    | is not decided yet, so prompts say so until it is set here.
    |
    */

    'ledger' => env('DONATIONS_LEDGER', 'not set yet, stop before claiming and tell the donor'),

    'repository' => 'https://github.com/trailhead-labs/nativephp-review-donations',

    /*
    |--------------------------------------------------------------------------
    | Agents
    |--------------------------------------------------------------------------
    |
    | The coding agents a donor can paste a prompt into. Each gets
    | its own rendering of every prompt, with its variant lines.
    |
    */

    'agents' => [
        'claude' => [
            'name' => 'Claude Code',
            'paste' => 'Paste it into Claude Code started in an empty folder.',
            'caveat' => null,
        ],
        'codex' => [
            'name' => 'Codex',
            'paste' => 'Paste it into codex started in an empty folder.',
            'caveat' => 'Codex runs helpers as separate codex exec sessions. This part is not tested yet.',
        ],
        'other' => [
            'name' => 'Other',
            'paste' => 'Paste it into your agent, started in an empty folder.',
            'caveat' => 'Other agents run every step in one session, so the independent checks are less independent.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    |
    | Prompts name a role, never a model. Each role resolves to a
    | model per agent, mirroring the spec's config/models.md.
    |
    */

    'roles' => [
        'lead' => [
            'job' => 'The session you paste into. Picks, claims, orchestrates and writes the report.',
            'models' => ['claude' => 'Opus 5.5', 'codex' => 'OpenAI flagship, high effort', 'other' => 'Your main model'],
        ],
        'analyst' => [
            'job' => 'Diagnoses, fixes, scrutinises, simplifies and reviews. The strongest reasoning you have.',
            'models' => ['claude' => 'Fable 5.1', 'codex' => 'OpenAI flagship, high effort', 'other' => 'Your strongest model'],
        ],
        'planner' => [
            'job' => 'Writes the plan for the simulator run, then reads what the driver saw.',
            'models' => ['claude' => 'Opus 5.5', 'codex' => 'OpenAI flagship, medium effort', 'other' => 'Your strongest model'],
        ],
        'driver' => [
            'job' => 'Follows the plan on the emulator or simulator and writes down what it saw. Never diagnoses.',
            'models' => ['claude' => 'Sonnet 5', 'codex' => 'OpenAI coding model, low effort', 'other' => 'Your fastest model'],
        ],
        'scout' => [
            'job' => 'Lists and filters candidate items and greps big logs. Cheap and fast.',
            'models' => ['claude' => 'Haiku 4.5', 'codex' => 'OpenAI small model', 'other' => 'Your fastest model'],
        ],
        'as chosen' => [
            'job' => 'Whichever models the chosen level uses.',
            'models' => ['claude' => 'As chosen', 'codex' => 'As chosen', 'other' => 'As chosen'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tracks
    |--------------------------------------------------------------------------
    |
    | Two axes: what the agent works on, and whether it runs the
    | app on a device. The keys match the ones in the prompts.
    |
    */

    'tracks' => [
        'issue-reason' => [
            'name' => 'Diagnose an issue',
            'subject' => 'issue',
            'device' => false,
            'blurb' => 'Read an open issue and the code behind it, then explain what is going on.',
            'intro' => 'Your agent reads an open issue, the whole thread and the code it touches, then explains what is going on, where, and what would fix it. No emulators needed. It only picks issues nobody has opened a pull request for yet.',
        ],
        'issue-prove' => [
            'name' => 'Reproduce an issue',
            'subject' => 'issue',
            'device' => true,
            'blurb' => 'Make a reported bug happen on an emulator or simulator, with screenshots and logs.',
            'intro' => 'Your agent reproduces an open issue on an Android emulator or iOS simulator and reports what it saw, with screenshots and logs. Deeper levels also build a fix and prove it on the same device.',
        ],
        'pr-reason' => [
            'name' => 'Review a pull request',
            'subject' => 'pr',
            'device' => false,
            'blurb' => 'Read a pull request against its issue, run the tests, and write a review.',
            'intro' => 'Your agent reads an open pull request against the issue it fixes and the code around it, runs the tests, and posts a review the author can act on. No emulators needed.',
        ],
        'pr-prove' => [
            'name' => 'Test a pull request',
            'subject' => 'pr',
            'device' => true,
            'blurb' => 'Build a pull request on a device, check the bug is gone and nothing nearby broke.',
            'intro' => 'Your agent builds the pull request on an emulator or simulator, checks the bug is gone, and looks for anything the change broke nearby.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Levels
    |--------------------------------------------------------------------------
    |
    | How much a donor gives. Weights drive the little stamp gauge
    | and are relative across every track, from one to five.
    |
    */

    'levels' => [
        'quick' => ['name' => 'Quick', 'blurb' => 'One agent, one focused pass.'],
        'thorough' => ['name' => 'Thorough', 'blurb' => 'The full workflow with one independent check.'],
        'deep' => ['name' => 'Deep', 'blurb' => 'Fresh helpers for every job, every finding checked twice.'],
        'adaptive' => ['name' => 'Adaptive', 'blurb' => 'Sizes itself to the item, up to a ceiling you set.'],
    ],

    'self_check' => [
        'tokens' => 'under 20k',
        'time' => '1 to 3 min',
    ],

    /*
    |--------------------------------------------------------------------------
    | Prompts
    |--------------------------------------------------------------------------
    |
    | What each track and level does, shown beside the copy button.
    | The prompt text itself lives in resources/views/prompts.
    |
    */

    'prompts' => [
        'issue-reason' => [
            'quick' => [
                'summary' => 'Read one open issue and the code it touches, and post a diagnosis marked as reasoned.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim an issue', 'lead'],
                    ['Read the issue, thread and the code it points at', 'lead'],
                    ['Diagnose', 'lead'],
                    ['Draft, show you, post', 'lead'],
                ],
                'skips' => ['following external links', 'version and already-fixed checks', 'duplicate search', 'tests', 'any fix or PR'],
                'tokens' => '60k to 150k',
                'time' => '5 to 15 min',
                'weight' => [1, 1],
                'opens_pr' => 'never',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer'],
            ],
            'thorough' => [
                'summary' => 'Read the whole story, including linked repositories and version history, diagnose, have a fresh helper try to break the diagnosis, and propose a fix. Opens a draft PR only for PHP only fixes that pass the gate.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim an issue', 'scout', true],
                    ['Read everything, follow every link, check versions', 'lead'],
                    ['Clone, install, baseline', 'lead'],
                    ['Diagnose', 'lead'],
                    ['Try to break the diagnosis', 'analyst', true],
                    ['Fix and test (PHP only fixes)', 'lead'],
                    ['Review the fix', 'analyst', true],
                    ['Draft, show you, post (and PR on your yes)', 'lead'],
                ],
                'skips' => ['parallel competing diagnoses', 'simplify pass', 'device verification'],
                'tokens' => '250k to 600k',
                'time' => '20 to 40 min',
                'weight' => [2, 2],
                'opens_pr' => 'PHP only fixes, draft, after your yes',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer'],
            ],
            'deep' => [
                'summary' => 'Two independent diagnoses compared, each claim re-verified, a test that encodes the bug, a fix scrutinised and simplified by fresh helpers. Opens a draft PR only for PHP only fixes that pass the gate.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim an issue', 'scout', true],
                    ['Read everything, follow every link, check versions', 'lead'],
                    ['Clone, install, baseline', 'lead'],
                    ['Diagnosis A', 'analyst', true],
                    ['Diagnosis B', 'analyst', true],
                    ['Reconcile', 'lead'],
                    ['Falsify the reconciled diagnosis', 'analyst', true],
                    ['Write the failing test and the fix', 'analyst', true],
                    ['Scrutinise the fix', 'analyst', true],
                    ['Simplify the fix', 'analyst', true],
                    ['Gate, draft, show you, post (and PR on your yes)', 'lead'],
                ],
                'skips' => ['device verification'],
                'tokens' => '0.8M to 2M',
                'time' => '45 to 90 min',
                'weight' => [3, 3],
                'opens_pr' => 'PHP only fixes, draft, after your yes',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer'],
            ],
            'adaptive' => [
                'summary' => 'Reads the issue first, scores how hard it is, and runs Quick, Thorough or Deep accordingly, never above your ceiling.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim an issue', 'scout', true],
                    ['Size the work and tell you', 'lead'],
                    ['Run the chosen level', 'as chosen'],
                ],
                'skips' => ['whatever the chosen level skips'],
                'tokens' => '60k to your ceiling',
                'time' => '5 to 90 min',
                'weight' => [1, 3],
                'opens_pr' => 'as the chosen level allows',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer'],
            ],
        ],
        'issue-prove' => [
            'quick' => [
                'summary' => 'Reproduce one open issue on the platform it was reported on, with screenshots and logs. No fix.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim an issue for your platform', 'lead'],
                    ['Read the issue and linked code', 'lead'],
                    ['Build the host app and a probe', 'lead'],
                    ['Reproduce on the reported platform', 'lead'],
                    ['Draft, show you, post', 'lead'],
                ],
                'skips' => ['second platform', 'diagnosis beyond what the repro shows', 'any fix or PR', 'regression checks'],
                'tokens' => '300k to 800k',
                'time' => '30 to 60 min',
                'weight' => [2, 2],
                'opens_pr' => 'never',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer', 'Android emulator or iOS simulator (macOS)', '30 GB free'],
            ],
            'thorough' => [
                'summary' => 'Reproduce on both platforms, diagnose, fix, and prove the fix on the same devices. Opens a draft PR on your yes when the gate is met.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim an issue', 'scout', true],
                    ['Read everything, follow every link, check versions', 'lead'],
                    ['Clone, install, baseline, host app', 'lead'],
                    ['Reproduce before, each platform', 'lead'],
                    ['Diagnose', 'lead'],
                    ['Fix', 'lead'],
                    ['Verify after, each platform', 'lead'],
                    ['Review the fix', 'analyst', true],
                    ['Gate, draft, show you, post (and PR on your yes)', 'lead'],
                ],
                'skips' => ['plan and drive split for device work', 'separate fix and simplify helpers', 'wider regression sweep'],
                'tokens' => '1M to 2.5M',
                'time' => '1 to 2 hours',
                'weight' => [3, 3],
                'opens_pr' => 'yes, draft, after your yes, when the gate is met',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer', 'Android emulator and/or iOS simulator (macOS)', '30 to 40 GB free'],
            ],
            'deep' => [
                'summary' => 'The full workflow. Device work split into plan, drive and analyse; fix, scrutiny and simplification by fresh strong helpers; before and after on both platforms; a regression sweep of every path that shares the changed code. Opens a draft PR on your yes when the gate is met.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim an issue', 'scout', true],
                    ['Read everything, follow every link, check versions', 'lead'],
                    ['Clone, install, baseline, host app', 'lead'],
                    ['Plan the reproduction', 'planner', true],
                    ['Drive it, each platform', 'driver', true],
                    ['Analyse and diagnose', 'planner'],
                    ['Fix', 'analyst', true],
                    ['Plan and drive the after run, each platform', 'driver', true],
                    ['Scrutinise the fix', 'analyst', true],
                    ['Simplify the fix', 'analyst', true],
                    ['Regression sweep', 'driver', true],
                    ['Gate, draft, show you, post (and PR on your yes)', 'lead'],
                ],
                'skips' => [],
                'tokens' => '2.5M to 6M',
                'time' => '2 to 4 hours',
                'weight' => [4, 4],
                'opens_pr' => 'yes, draft, after your yes, when the gate is met',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer', 'Android emulator and iOS simulator (macOS) recommended', '40 GB free', 'machine kept awake'],
            ],
            'adaptive' => [
                'summary' => 'Reads the issue first, scores how hard it is, and runs Quick, Thorough or Deep accordingly, never above your ceiling or beyond the platforms you can run.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim an issue for your platforms', 'scout', true],
                    ['Size the work and tell you', 'lead'],
                    ['Run the chosen level', 'as chosen'],
                ],
                'skips' => ['whatever the chosen level skips'],
                'tokens' => '300k to your ceiling',
                'time' => '30 min to 4 hours',
                'weight' => [2, 4],
                'opens_pr' => 'as the chosen level allows',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer', 'Android emulator and/or iOS simulator (macOS)', '30 to 40 GB free'],
            ],
        ],
        'pr-reason' => [
            'quick' => [
                'summary' => 'Read one open PR against the issue it fixes, and post a short review of whether it does and anything obviously wrong.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim a PR', 'lead'],
                    ['Read the PR, its issue and the diff', 'lead'],
                    ['Review', 'lead'],
                    ['Draft, show you, post', 'lead'],
                ],
                'skips' => ['running tests', 'base comparison', 'overlapping PR search', 'reading every caller', 'suggested fixes beyond one liners'],
                'tokens' => '80k to 200k',
                'time' => '5 to 15 min',
                'weight' => [1, 1],
                'opens_pr' => 'never',
                'requires' => ['git', 'gh (logged in)'],
            ],
            'thorough' => [
                'summary' => 'Check out the PR, run its tests against the base and the head, trace every caller, compare suite, formatter and static analysis to the base, and post a review with suggested fixes.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim a PR', 'scout', true],
                    ['Read everything, follow every link, find overlapping work', 'lead'],
                    ['Check out, install, baseline on the base branch', 'lead'],
                    ['Review on all angles', 'lead'],
                    ['Prove the tests', 'lead'],
                    ['Independent review', 'analyst', true],
                    ['Reconcile, draft, show you, post', 'lead'],
                ],
                'skips' => ['parallel reviewers per angle', 'per finding falsification', 'device verification'],
                'tokens' => '300k to 700k',
                'time' => '20 to 45 min',
                'weight' => [2, 2],
                'opens_pr' => 'never',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer'],
            ],
            'deep' => [
                'summary' => 'Parallel reviewers, one per angle, each finding independently falsified before it is kept, tests proven against the base, suggested fixes applied and tested locally.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim a PR', 'scout', true],
                    ['Read everything, follow every link, find overlapping work', 'lead'],
                    ['Check out, install, baseline on the base branch', 'lead'],
                    ['Correctness review', 'analyst', true],
                    ['Blast radius review', 'analyst', true],
                    ['Tests and compatibility review', 'analyst', true],
                    ['Simplification review', 'analyst', true],
                    ['Falsify each finding', 'analyst', true],
                    ['Verify suggested fixes under tests', 'lead'],
                    ['Draft, show you, post', 'lead'],
                ],
                'skips' => ['device verification'],
                'tokens' => '1M to 2.5M',
                'time' => '45 to 90 min',
                'weight' => [3, 3],
                'opens_pr' => 'never',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer'],
            ],
            'adaptive' => [
                'summary' => 'Reads the PR first, scores how big and risky it is, and runs Quick, Thorough or Deep accordingly, never above your ceiling.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim a PR', 'scout', true],
                    ['Size the work and tell you', 'lead'],
                    ['Run the chosen level', 'as chosen'],
                ],
                'skips' => ['whatever the chosen level skips'],
                'tokens' => '80k to your ceiling',
                'time' => '5 to 90 min',
                'weight' => [1, 3],
                'opens_pr' => 'never',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer'],
            ],
        ],
        'pr-prove' => [
            'quick' => [
                'summary' => 'Build one open PR on the platform it targets, run its issue\'s reproduction, and confirm the bug is gone.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim a PR for your platform', 'lead'],
                    ['Read the PR and its issue', 'lead'],
                    ['Build the PR head in a host app', 'lead'],
                    ['Run the issue\'s reproduction', 'lead'],
                    ['Draft, show you, post', 'lead'],
                ],
                'skips' => ['running the app without the pull request first', 'second platform', 'regression checks', 'code review'],
                'tokens' => '400k to 1M',
                'time' => '30 to 60 min',
                'weight' => [2, 2],
                'opens_pr' => 'never',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer', 'Android emulator or iOS simulator (macOS)', '30 GB free'],
            ],
            'thorough' => [
                'summary' => 'Build the base and the PR on both platforms, show the bug before and gone after, check the behaviour next to it, and build companion PRs together.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim a PR', 'scout', true],
                    ['Read everything, follow every link', 'lead'],
                    ['Clones, host app, baseline', 'lead'],
                    ['Before, on the base, each platform', 'lead'],
                    ['After, on the PR head, each platform', 'lead'],
                    ['Adjacent behaviour', 'lead'],
                    ['Check the PR\'s own claims and review points', 'lead'],
                    ['Draft, show you, post', 'lead'],
                ],
                'skips' => ['plan and drive split', 'per finding falsification', 'full regression sweep'],
                'tokens' => '1.2M to 3M',
                'time' => '1 to 2 hours',
                'weight' => [3, 3],
                'opens_pr' => 'never',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer', 'Android emulator and/or iOS simulator (macOS)', '30 to 40 GB free'],
            ],
            'deep' => [
                'summary' => 'The full workflow. Device work split into plan, drive and analyse; before and after on both platforms; every claim and review point verified on device; suggested fixes tried on device before they are suggested; companion PRs and merge order checked; a regression sweep of every path that shares the change.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim a PR', 'scout', true],
                    ['Read everything, follow every link', 'lead'],
                    ['Clones, host app, baseline', 'lead'],
                    ['Code review for what to test', 'analyst', true],
                    ['Plan the before and after runs', 'planner', true],
                    ['Drive the base, each platform', 'driver', true],
                    ['Drive the head, each platform', 'driver', true],
                    ['Analyse', 'planner'],
                    ['Verify each finding on device', 'driver', true],
                    ['Try suggested fixes on device', 'analyst', true],
                    ['Regression sweep', 'driver', true],
                    ['Draft, show you, post', 'lead'],
                ],
                'skips' => [],
                'tokens' => '3M to 7M',
                'time' => '2 to 4 hours',
                'weight' => [5, 5],
                'opens_pr' => 'never',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer', 'Android emulator and iOS simulator (macOS) recommended', '40 GB free', 'machine kept awake'],
            ],
            'adaptive' => [
                'summary' => 'Reads the PR first, scores how big and risky it is, and runs Quick, Thorough or Deep accordingly, never above your ceiling or beyond the platforms you can run.',
                'steps' => [
                    ['Self check', 'lead'],
                    ['Pick and claim a PR for your platforms', 'scout', true],
                    ['Size the work and tell you', 'lead'],
                    ['Run the chosen level', 'as chosen'],
                ],
                'skips' => ['whatever the chosen level skips'],
                'tokens' => '400k to your ceiling',
                'time' => '30 min to 4 hours',
                'weight' => [2, 5],
                'opens_pr' => 'never',
                'requires' => ['git', 'gh (logged in)', 'PHP 8.4', 'Composer', 'Android emulator and/or iOS simulator (macOS)', '30 to 40 GB free'],
            ],
        ],
    ],

];
