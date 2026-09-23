# Review Donations: prove a NativePHP pull request (adaptive)

@include('prompts.partials.preamble')

## Work

1. Step 0, the self check.
2. Pick a PR (Pick). PR track, platform filter on.
3. Read the PR, its thread and `gh pr diff {n} --repo {repo} --stat`.
4. Size it (Adaptive). For a PR, "how big" is the diff, and "related work" includes companion PRs and open review points. A PR with a companion, or with open review points that can be checked on a device, scores at least Thorough. Tell the donor the score, the level and its range in one line.
5. Claim it (Claim), with the expiry of the chosen level.
6. Run the steps of the chosen level below, starting from its "Read" step. Skip its self check, pick and claim steps.

### If you chose Quick

@include('prompts.pr-prove.work-quick')

### If you chose Thorough

@include('prompts.pr-prove.work-thorough')

### If you chose Deep

@include('prompts.pr-prove.work-deep')

@include('prompts.partials.sizing')

@include('prompts.partials.rules')

@include('prompts.partials.evidence')

@include('prompts.partials.subagents')

@include('prompts.partials.relay')

@include('prompts.partials.pick')

@include('prompts.partials.claim')

@include('prompts.partials.context')

@include('prompts.partials.workspace')

@include('prompts.partials.native-facts')

@include('prompts.partials.rig')

@include('prompts.partials.android')

@include('prompts.partials.ios')

@include('prompts.partials.probe')

@include('prompts.partials.review-angles')

@include('prompts.partials.report')

@include('prompts.partials.finish')
