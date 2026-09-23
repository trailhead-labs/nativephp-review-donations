The goal is a review the author can act on point by point, where every point has a failure scenario and a suggested fix.

1. Step 0, the self check.
2. Pick a PR (Pick). PR track.
3. Claim it (Claim). Expiry 2 hours.
4. Read the item properly, all six points, for the PR and its linked issue. In particular: companion PRs in the other repo, earlier closed attempts at the same issue, and open PRs touching the same files. Write `context.md`.
5. Workspace. Clone, read the default branch, and baseline on the **PR's base branch** (which is usually, not always, the default). Then `gh pr checkout {n}`. Note how far behind its base the PR is. If it depends on a companion PR, check that out too in the sibling clone.
6. Review on every angle (Review angles). For blast radius, `rg` every changed symbol across both repos and read each caller. Write findings to `findings.md`, each with a failure scenario.
7. **Prove the tests.** Run the PR's new or changed tests against the base code to see whether they fail without the change:

   ```
   git worktree add ../base-{n} {base_sha}
   cp -R {new or changed test files} ../base-{n}/{same paths}
   ln -s "$PWD/vendor" ../base-{n}/vendor
   (cd ../base-{n} && vendor/bin/pest {test files})
   git worktree remove --force ../base-{n}
   ```

   Copying only the tests into a clean base checkout matters: checking out base `src/` over the head would leave files the PR added in place, and a test could pass for the wrong reason. If the PR changed `composer.json`, run `composer install` in the worktree instead of linking `vendor`. A test that passes on the base proves nothing about the fix. Then run the full suite, Pint and PHPStan on the head and compare to the base baseline.
8. **Independent review.** One {{ $models['analyst'] }} helper, fresh, read only, with the diff, `context.md` and the Review angles, not your findings. Compare its findings with yours. Anything it found that you did not: verify it yourself before keeping it. Anything you found that it did not: re-check it.
9. For each kept finding, write a suggested fix as a code block. Mark it **verified** if you applied it locally and the tests pass with it, **unverified** otherwise. Do not push it anywhere.
10. Apply the realism filter. Order findings by severity.
11. Write the report with the "PR review" template, including the one line "Checked and fine" list. Outcome `reviewed`.
12. Finish. Restore the clone to a clean state.
