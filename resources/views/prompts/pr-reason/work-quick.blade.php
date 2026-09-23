The goal is a short review that answers two questions: does this change fix what its issue describes, and is there anything obviously wrong. You do not run tests or trace every caller at this level; list that under "Not measured". You never push to the PR branch and never approve or request changes.

1. Step 0, the self check. PHP and Composer are optional at this level.
2. Pick a PR (Pick). PR track.
3. Claim it (Claim). Expiry 1 hour.
4. Read the PR description, every comment and review, and the linked issue with its thread (Read the item properly, point 1).
5. Read the diff: `gh pr diff {n} --repo {repo}`. For each changed file, read enough of the surrounding file on the PR head to understand the change (`gh api repos/{repo}/contents/{path}?ref={head_sha} --jq .content | base64 -d`).
6. Review with the Correctness angle only. Does the change address every symptom in the issue? Any error path that is swallowed or reports false success? Anything the description claims that the diff does not do?
7. If an earlier review on the PR raised points, check whether the latest commits addressed them. Do not repeat points a maintainer already made unless you have new evidence.
8. Write the report with the "PR review" template. If there is nothing blocking, say so in the first sentence and keep it short. Everything is reasoned at this level; cite file and line on the PR head. Outcome `reviewed`.
9. Finish.
