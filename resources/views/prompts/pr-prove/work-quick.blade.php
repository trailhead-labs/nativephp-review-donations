The goal is one answer: with this PR, is the bug from its issue gone on a real build. You do not compare against the base or check the other platform at this level; say so under "Not measured". You never push to the PR branch.

1. Step 0, the self check, including device checks.
2. Pick a PR (Pick). PR track, platform filter on. Prefer PRs labelled `needs testing`.
3. Claim it (Claim). Expiry 3 hours.
4. Read the PR, its reviews and the linked issue with its thread (Read the item properly, points 1 and 2). Extract the reproduction: the reporter's steps, or the PR's own test plan. If the PR says it needs a companion PR in the other repo, you need both.
5. Clone `mobile-air` and `mobile-ui` as needed. `gh pr checkout {n}` in the PR's repo, and the companion PR in the other clone if there is one.
6. Build the host app against those checkouts (The host app). Read every build pitfall first.
7. Start the device for the platform the PR targets.
8. Build a probe from the reproduction, marker `P{n} HEAD {short sha}`. Build, check the log, confirm the marker.
9. Run the steps. Screenshot each observation. Pull the relevant logs.
10. Decide: the bug is gone, still there, or changed. If the PR description makes a claim you tested (a table of before and after, a behaviour), say whether your run matches it.
11. Write the report with the "PR verification" template (one column for head is fine at this level). Outcome `verified` or `regression-found`, or `inconclusive` with the reason.
12. Finish.
