## The PR gate

You may prepare a pull request only if **every** item below holds. Check each one with a command and note the result in `gate.md`. If any fails, do not open a PR: put the fix in your report as a suggestion, marked verified or unverified, and name the gate item that failed.

1. **Cause pinned.** The root cause is located to specific lines, and the mechanism explains every symptom in the report, not only the headline one.
2. **Failing before.** Prove track: reproduced on a device, on each platform the report names, with screenshots. Reason track: an automated test that encodes the bug fails on the current default branch.
3. **Passing after.** The same reproduction or test passes with the fix, same device, same steps.
4. **Nothing else moved.** No behaviour change beyond the bug. If one is unavoidable, it is listed and justified in the PR body.
5. **No worse than main.** `vendor/bin/pest` passes. `vendor/bin/pint --test` is clean. The PHPStan error set, with line numbers stripped, is identical to the baseline. For any native change: both platforms build, install and launch, checked in the build logs.
6. **Adjacent paths checked.** Callers of the changed code, and sibling paths that share it, exercised, or listed as not exercised.
7. **Fresh eyes.** An independent helper with a clean context tried to break the fix (Review angles) and found nothing blocking. Anything non blocking it found is either fixed or listed.
8. **Current.** Rebased on the latest default branch read from the repo, and the bug still reproduces there before the fix.
9. **Nobody else did it.** No PR linked to the issue appeared while you worked: `gh issue view {n} --repo {repo} --json closedByPullRequestsReferences`, plus a search of open PRs for the issue number.
10. **Minimal.** Fewest files. No refactors, renames or drive by cleanups. No version, tag, changelog or dependency constraint changes; if a constraint must move, say so in the body and leave it to the maintainers.

Extra limits:

- Reason tracks: only PHP only fixes may become a PR. Anything touching Kotlin, Swift, Gradle, Xcode project files or build output needs device evidence, so it stays a suggestion.
- Quick levels never open a PR.
- Companion changes across mobile-air and mobile-ui: open both, say in each body that they must land together and in which order, and check that neither breaks a build on its own.

### Opening it

1. Branch on the donor's fork from the default branch: `git switch -c review-donations/{n}-{short-slug} upstream/$DEFAULT`.
2. One commit per logical fix, single line messages in the imperative ("Stop the build when a copy_assets hook fails"). No trailers.
3. Push to the donor's fork only: `git push -u origin HEAD`. Check the remote URL first.
4. Write the body from the PR template in Report.
5. Show the donor the branch, `git diff upstream/$DEFAULT...HEAD --stat`, the full diff if they want it, and the body. Wait for them to say go. `POST_MODE=unattended` does not cover this; a PR always needs a yes.
6. `gh pr create --repo {repo} --base $DEFAULT --head {donor}:{branch} --draft --title "{title}" --body-file pr-body.md`.
7. Post the short issue report linking the PR (Report, "fixed" template).
