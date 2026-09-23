The goal is evidence before and after, on every platform the report names that you can run, and a fix only if it holds up.

Allowed attempts: three probe variations per platform before calling it not reproduced.

1. Step 0, the self check.
2. Pick an issue (Pick). Issue track, platform filter on.
3. Claim it (Claim). Expiry 6 hours.
4. Read the item properly, all six points. Write `context.md`. Note which platforms the report says are affected.
5. Workspace: fork and clone both repos if any native element is involved, default branch, Composer install, baseline. Then the host app.
6. **Before.** For each platform in `PLATFORMS` that the issue could affect: start the device, build the probe on the default branch with marker `P{n} BEFORE {sha}`, check the build log, run the steps, screenshot, logs. One platform at a time. Record a small table: platform, reproduced yes or no, evidence file.
   - If it does not reproduce anywhere, write the "not reproduced" report and finish.
   - If it reproduces on one platform only when the reporter said both, or the other way round, that is a finding in itself.
7. **Diagnose.** With the reproduction in hand, find the cause. Read the code the probe exercises, on each platform where it reproduced. For native changes remember build pitfall 2: native edits only reach the app through `native:install --no-force --skip-php`. Write `diagnosis.md`, every point measured or reasoned.
8. **Fix.** Smallest change on a branch from the default branch. If there is a PHP side to the bug, add a Pest test that fails before and passes after.
9. **After.** Same probe, marker `P{n} AFTER {sha}`, same devices, same steps. If you changed native code, run `native:install --no-force --skip-php`, check `local.properties`, then rebuild. Confirm from the log and the marker that the new code ran. Also run the probe's happy path and one neighbouring use of the changed code, to catch the obvious regression.
10. Run the gate's automated checks: suite, Pint, PHPStan against the baseline. For native changes, both platforms must still build and launch, if both are in `PLATFORMS`; otherwise mark the other platform not measured.
11. **Review.** One {{ $models['analyst'] }} helper, fresh, read only, with the diff, `context.md`, `diagnosis.md` and the Review angles. Address blocking findings and re-verify on device after any change.
12. Walk the PR gate into `gate.md`. If every item holds, prepare the PR and wait for the donor's yes. If only one platform could be tested and the fix touches both, the gate fails on item 2; the fix goes in the report as a suggestion, verified on the platform you tested.
13. Write the report ("Issue, reproduction" with the fix as a verified suggestion, or "Issue, fixed with a PR"). Finish.
