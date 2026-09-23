# Review Donations: diagnose a NativePHP issue (adaptive)

@include('prompts.partials.preamble')

## Work

1. Step 0, the self check.
2. Pick an issue (Pick). Issue track.
3. Read the issue and its whole thread (Read the item properly, point 1).
4. Size it (Adaptive). Tell the donor the score, the level and its range in one line.
5. Claim it (Claim), with the expiry of the chosen level.
6. Run the steps of the chosen level below, starting from its "Read the item properly" step. Skip its self check, pick and claim steps, you did those.

### If you chose Quick

@include('prompts.issue-reason.work-quick')

### If you chose Thorough

@include('prompts.issue-reason.work-thorough')

### If you chose Deep

@include('prompts.issue-reason.work-deep')

@include('prompts.partials.sizing')

@include('prompts.partials.rules')

@include('prompts.partials.evidence')

@include('prompts.partials.subagents')

@include('prompts.partials.pick')

@include('prompts.partials.claim')

@include('prompts.partials.context')

@include('prompts.partials.workspace')

@include('prompts.partials.native-facts')

@include('prompts.partials.review-angles')

@include('prompts.partials.pr-gate')

@include('prompts.partials.report')

@include('prompts.partials.finish')
