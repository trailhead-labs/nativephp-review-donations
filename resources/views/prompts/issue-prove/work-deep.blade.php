The goal is a fix a maintainer can merge after reading it once, with evidence for every claim and every obvious way it could break already tried. Helpers get stranger briefs (Helpers). Device work always goes through the relay (Device work).

Allowed attempts: four probe variations per platform, planned and driven, before calling it not reproduced.

1. Step 0, the self check.
2. Pick an issue (Pick). Issue track, platform filter on.
3. Claim it (Claim). Expiry 12 hours.
4. Read the item properly, all six points. Write `context.md`.
5. Workspace: fork and clone both repos, default branch, Composer install, baseline. The host app, with `mobile-ui` registered.
6. **Plan before.** A {{ $models['planner'] }} helper writes `playbook-before.md` from `context.md`, the rig pitfalls, the probe section and the device sections: the probe code to add, the build commands with log checks, each step with the expected screen if the bug is present and if absent, and the screenshots to take.
7. **Drive before.** A {{ $models['driver'] }} helper runs the playbook on one platform and writes `observations-before-{platform}.md`. Then the next platform. One at a time.
8. **Analyse.** The planner reads the observations and screenshots and decides per platform: reproduced, not reproduced, or unclear. Unclear means a narrower playbook and another drive, within the attempt budget. If not reproduced anywhere, report and finish.
9. **Diagnose.** The planner, or you if you are a strong model, finds the cause with the reproduction in hand. `diagnosis.md`, every point measured or reasoned.
10. **Fix.** A {{ $models['analyst'] }} helper owns the checkout and writes the smallest fix on a branch from the default branch, atomic commits, plus a Pest test for any PHP side. It reads native-facts first. It runs `native:install --no-force --skip-php` after native edits and checks `local.properties`.
11. **After.** Plan and drive the same scenario against the fix, marker `P{n} AFTER {sha}`, both platforms. The planner analyses: fixed, not fixed, or changed.
12. **Scrutinise.** A {{ $models['analyst'] }} helper, fresh, read only, with the diff, `context.md`, `diagnosis.md`, the before and after observations and the Review angles: "Assume this fix is wrong or incomplete. Find how. Give a failure scenario for each finding." Every finding it reports must be checked: by a test, or by a small extra playbook driven on device. Fix what is real (back to the fix helper) and re-run step 11.
13. **Simplify.** A {{ $models['analyst'] }} helper, fresh, with the diff and the Simplification angles. Apply only changes that keep behaviour identical, then re-run the suite and a short after drive on one platform.
14. **Regression sweep.** The planner lists every path that shares the changed code (Review angles, blast radius; for build pipeline code that means `native:run`, `native:package` and `native:build`, for a renderer the sibling renderers). The driver exercises each on device, before and after, and records. Anything it cannot exercise goes under not measured.
15. Suite, Pint and PHPStan against the baseline. Both platforms build, install and launch.
16. Walk the PR gate into `gate.md`. If every item holds, prepare the PR (a companion PR in the other repo if the fix spans both, with merge order stated) and wait for the donor's yes.
17. Write the report. Finish.
