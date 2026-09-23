The goal is a before and after table a maintainer can merge on: same probe, same devices, base versus head, plus the obvious neighbouring behaviour.

1. Step 0, the self check.
2. Pick a PR (Pick). PR track, platform filter on.
3. Claim it (Claim). Expiry 6 hours.
4. Read the item properly, all six points. Write `context.md`: the reproduction, every claim the PR description makes (behaviour tables, "verified on X"), every open review point, and any companion PR with its merge order.
5. Clones. Check out the PR's base in each repo first. Build the host app (The host app) and the probe, marker `P{n} BASE {sha}`. Baseline the suite on the base.
6. **Before.** For each platform in `PLATFORMS` the PR could affect: start the device, build, check the log, run the steps, screenshot. One platform at a time. The bug should show. If it does not show on the base, that changes everything: report that the base already behaves correctly on this setup, with evidence, and stop.
7. **Switch to the head.** `gh pr checkout {n}` (and the companion). If the PR changes Kotlin or Swift, run `php artisan native:install --no-interaction --no-force --skip-php` in the host app and check `local.properties` (build pitfall 2). Update the probe marker to `P{n} HEAD {sha}`.
8. **After.** Same devices, same steps, screenshots. Record a table: case, base result, head result, evidence file.
9. **Adjacent behaviour.** List the paths that share the changed code (Review angles, blast radius, and the PR's own file list). Exercise the two or three most likely to break on each platform, base and head. For example, if a PR changes how buttons dismiss the keyboard, also check pressables, list items, and a tap on empty space.
10. **The PR's own claims and open review points.** For every behaviour the description claims, and every open review point that can be checked on a device, check it and record whether it holds. Where a maintainer's review asked for a change, check whether the latest commit delivers it.
11. **Companion PRs.** If the PR needs a companion, also build each one alone on the base of the other and record whether the build breaks. A PR that breaks every build when merged first is a merge order finding.
12. Suite, Pint and PHPStan on the head against the base baseline.
13. Write the report with the "PR verification" template: the table first, then numbered findings with failure scenarios. Suggested fixes only if you tried them on the device (verified), otherwise marked unverified. Outcome `verified` or `regression-found`.
14. Finish. Restore the clones.
