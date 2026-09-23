The goal is a diagnosis that has survived people trying to break it, and a fix that is proven, reviewed and minimal. Every helper gets a brief written as for a stranger (Helpers).

1. Step 0, the self check.
2. Pick an issue (Pick). Issue track.
3. Claim it (Claim). Expiry 4 hours.
4. Read the item properly, all six points. Write `context.md`. If already fixed on the default branch, verify that by running the reporter's scenario as a Pest test or in a scratch app (Workspace, point 7) against the default branch, then skip to step 13 with outcome `already-fixed`.
5. Workspace: fork and clone, default branch, companion repo if involved, Composer install, baseline.
6. Two independent diagnoses. Start two {{ $models['analyst'] }} helpers in parallel with the same brief (`context.md`, clone paths, the evidence rules, native-facts) and the same job: "Find the root cause. Cite file and line for every claim. Run PHP where it can answer. Say what you could not check." They must not see each other's work.
7. Reconcile. Compare A and B point by point in `diagnosis.md`. Where they agree and both measured, keep it. Where they disagree, settle it with a measurement you run yourself, not by picking the more convincing text. If it cannot be settled without a device, say so and mark that part not measured.
8. Falsify. One more {{ $models['analyst'] }} helper, fresh, with only `context.md` and `diagnosis.md`: "This diagnosis claims X. Assume it is wrong. Find how." Include the realism filter. Fold real findings back in and say what changed.
9. Decide on a fix. Native fixes stay suggestions at this track (write them, mark unverified, and say a prove track run would verify them). For PHP only fixes, start one {{ $models['analyst'] }} helper that owns the checkout: write a Pest test that fails on the default branch for the reported reason, then the smallest change that makes it pass, as atomic commits on a branch.
10. Scrutinise. One {{ $models['analyst'] }} helper, fresh, read only, with the diff and the Review angles, told to assume the fix is wrong and find how. Run the full suite, Pint and PHPStan against the baseline yourself. Fix blocking findings (back to the fix helper), list the rest.
11. Simplify. One {{ $models['analyst'] }} helper, fresh, with the diff and only the Simplification angles. Apply what keeps behaviour identical; skip the rest and say why. Re-run the suite, Pint and PHPStan.
12. Walk the PR gate into `gate.md`. If every item holds, prepare the PR and wait for the donor's yes. Otherwise the fix goes in the report as a suggestion, with the failing gate item named.
13. Write the report. Include, in one line, that two independent diagnoses agreed or where they differed. Finish.
