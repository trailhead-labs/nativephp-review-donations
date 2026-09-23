The goal is a review where nothing is guessed: every finding survived an attempt to disprove it, and every suggested fix was tried.

1. Step 0, the self check.
2. Pick a PR (Pick). PR track.
3. Claim it (Claim). Expiry 4 hours.
4. Read the item properly, all six points. Write `context.md`, including companion PRs, earlier attempts, overlapping open PRs, and anything a maintainer already asked for in review.
5. Workspace. Baseline on the PR's base branch, then check out the PR (and any companion PR in the sibling clone). Record how far behind its base it is and whether it still merges cleanly (`gh pr view {n} --json mergeable`).
6. **Four reviewers in parallel.** Four {{ $models['analyst'] }} helpers, fresh, read only, each with the diff, `context.md`, native-facts, the evidence rules, and one angle from Review angles: Correctness; Blast radius; Tests plus Compatibility; Simplification. Each returns findings with a failure scenario and a citation, and a "checked and fine" list. They may run PHP and tests but not change the checkout.
7. **Merge** their findings into `findings.md`. Drop duplicates, keeping the best evidenced version.
8. **Falsify each finding.** For every finding, one {{ $models['analyst'] }} helper, fresh, with only that finding, the diff and `context.md`: "This finding claims X. Try to prove it wrong. Return confirmed, refuted, or not measurable, with the evidence." Run these in parallel. Drop refuted findings. Keep not measurable ones only if they matter, labelled as such.
9. **Prove the tests.** Run the PR's new or changed tests against a clean base checkout with only those test files copied in:

   ```
   git worktree add ../base-{n} {base_sha}
   cp -R {new or changed test files} ../base-{n}/{same paths}
   ln -s "$PWD/vendor" ../base-{n}/vendor
   (cd ../base-{n} && vendor/bin/pest {test files})
   git worktree remove --force ../base-{n}
   ```

   A test that passes on the base proves nothing about the fix. Run the suite, Pint and PHPStan on head and compare to the base baseline.
10. **Verify suggested fixes.** For each confirmed finding with a fix, apply it locally on top of the PR head, run the relevant tests plus the suite, and mark the suggestion verified or unverified accordingly. Revert after each. Never push.
11. Realism filter, order by severity, and cut: if a finding would not change what the author does, drop it.
12. Write the report with the "PR review" template. Add one line: how many findings the reviewers raised and how many survived falsification. Outcome `reviewed`.
13. Finish. Restore the clones.
