The goal is a diagnosis a maintainer can trust without redoing it, and a fix they can merge when it is PHP only and proven by a test.

1. Step 0, the self check.
2. Pick an issue (Pick). Issue track.
3. Claim it (Claim). Expiry 2 hours.
4. Read the item properly, all six points. Write `context.md`. If the issue turns out to be fixed on the default branch already, skip to step 12 with outcome `already-fixed`.
5. Workspace: fork and clone (you may open a PR), default branch, companion repo if involved, Composer install, baseline.
6. Diagnose. Locate the code path with `rg`, read it, trace it on both platforms if native code is involved (`resources/androidstudio` and `resources/xcode` in mobile-air, `resources/android` and `resources/ios` in mobile-ui). Where you can check something by running PHP, do it: a short Pest test in the package, or tinker in a scratch app (Workspace, point 7). Write `diagnosis.md`: where, why, which symptoms it explains, what you measured versus reasoned.

7. Falsify. Start one {{ $models['analyst'] }} helper (Helpers) with `context.md`, `diagnosis.md` and the job: "Try to prove this diagnosis wrong. Check every cited line. Find a symptom it does not explain, or a simpler cause." Read its result. If it found a real problem, fix your diagnosis and say so; if you disagree, say why with a measurement.
8. Decide on a fix.
   - If the fix is PHP only: write a Pest test that encodes the bug and fails on the default branch (run it to confirm it fails for the right reason). Make the smallest change that makes it pass.
   - If the fix touches native code: write it as a suggestion only, marked unverified. Stop fixing here.
9. For a PHP fix, run the gate's checks: full suite, Pint, PHPStan compared to the baseline, callers of changed code (`rg`).
10. Review the fix. One {{ $models['analyst'] }} helper, fresh, read only, with the diff, `context.md` and the Review angles. Address blocking findings; list the rest.
11. Walk the PR gate item by item into `gate.md`. If every item holds and the fix is PHP only, prepare the PR (PR gate, Opening it) and wait for the donor's yes. Otherwise the fix goes in the report as a suggestion.
12. Write the report: "Issue, diagnosis", or "Issue, fixed with a PR" if you opened one. Finish.
