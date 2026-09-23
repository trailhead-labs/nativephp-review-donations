The goal is the evidence a maintainer would otherwise have to produce themselves before merging: every claim the PR makes, every open review point, and every nearby path, checked on device, with any suggested fix already tried. All device work goes through the relay (Device work). Helpers get stranger briefs (Helpers).

1. Step 0, the self check.
2. Pick a PR (Pick). PR track, platform filter on.
3. Claim it (Claim). Expiry 12 hours.
4. Read the item properly, all six points. Write `context.md`: the issue's reproduction, every claim in the PR description, every review and inline review comment with its status, companion PRs and merge order, overlapping PRs.
5. Clones, host app on the base, baseline suite, Pint and PHPStan on the base.
6. **What to test.** One {{ $models['analyst'] }} helper, fresh, read only, with the diff and `context.md` and the Review angles: "List every behaviour this change could affect, on each platform, as concrete device scenarios. Mark which ones the PR claims to fix, which ones reviewers raised, and which ones are neighbouring paths that share the changed code." This becomes `scenarios.md`.
7. **Plan.** A {{ $models['planner'] }} helper turns `scenarios.md` into `playbook.md`: probes, build commands with log checks, the switch from base to head (including `native:install --no-force --skip-php` for native changes), each step with the expected screen on base and on head.
8. **Drive the base,** then **the head**, one platform at a time, with a {{ $models['driver'] }} helper. Observations to `observations-{base|head}-{platform}.md`.
9. **Analyse.** The planner compares base and head per scenario and writes the result table. Unclear rows get a narrower playbook and another drive.
10. **Verify each finding.** Every problem found in step 9, and every open review point on the PR, gets its own short playbook and drive to confirm it, with a failure scenario a maintainer can repeat. Drop anything that does not reproduce twice.
11. **Try the fixes.** For each confirmed finding where a fix is clear, a {{ $models['analyst'] }} helper applies it locally on top of the PR head (never pushed), then plan and drive it on device. Only fixes that make the scenario pass and break no other scenario are marked **verified** in the report. The rest are **unverified**, or left out.
12. **Companion PRs and merge order.** If there is a companion, build each PR alone against the other repo's base, on each platform, and record whether it builds and launches. State the safe merge order.
13. **Regression sweep.** The driver exercises every neighbouring scenario from `scenarios.md` on the head that was not already covered, on each platform. Anything not exercised goes under not measured.
14. Suite, Pint and PHPStan on the head against the base baseline.
15. Write the report with the "PR verification" template: the base versus head table first, then numbered confirmed findings, most severe first, each with its scenario and a verified or unverified fix, then "checked and fine", then not measured. Outcome `verified` or `regression-found`.
16. Finish. Restore the clones, uninstall the app, shut down the devices.
