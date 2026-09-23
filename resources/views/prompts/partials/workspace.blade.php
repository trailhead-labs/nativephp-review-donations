## Workspace and baseline

Work in `~/nativephp-donation/{repo_short}-{n}/`.

1. **Clone.** For read only work, clone upstream directly. If you might open a PR (issue tracks, Thorough or Deep), fork first so `origin` is the donor's fork and `upstream` is NativePHP:

   ```
   gh repo fork NativePHP/mobile-air --clone --remote --default-branch-only=false -- mobile-air
   cd mobile-air && git remote -v
   ```

   Check the remote names after cloning. Do not assume `origin` is NativePHP. Every push in this run goes to the donor's fork and nowhere else.

2. **Default branch.** Read it, do not assume it:

   ```
   DEFAULT=$(gh repo view NativePHP/mobile-air --json defaultBranchRef --jq .defaultBranchRef.name)
   git fetch upstream "$DEFAULT"
   ```

3. **The companion repo.** Many fixes span `mobile-air` (core, bridge, build commands) and `mobile-ui` (every EDGE renderer and component). If the item names both, or a stack trace goes through `resources/android` or `resources/ios` in `mobile-ui`, clone both side by side.

4. **PR tracks:** check out the PR head and note the base:

   ```
   gh pr checkout {n} --repo {repo}
   git log --oneline -1
   git rev-list --left-right --count upstream/$DEFAULT...HEAD   # behind, ahead
   ```

   A PR many commits behind its base may conflict with, or duplicate, work that already landed. Say so if it matters.

5. **Install.** `composer install --no-interaction`. Nothing global.

6. **Baseline, on the default branch before any change.** Record these once. Every later "no worse than main" claim compares against them.

   ```
   vendor/bin/pest 2>&1 | tail -5
   vendor/bin/pint --test 2>&1 | tail -3
   vendor/bin/phpstan analyse --error-format=raw 2>/dev/null | sed -E 's/:[0-9]+:/:/' | sort > ../phpstan-base.txt
   wc -l ../phpstan-base.txt
   ```

   PHPStan may already report errors on the default branch. That is the baseline, not your problem. What matters later is that the set of errors is identical, compared with `diff` after stripping line numbers as above.

7. **A scratch app, when PHP can answer a question.** Package code only runs inside a Laravel app. For a quick check without any device, make one next to the clone and point it at your checkout:

   ```
   composer create-project laravel/laravel scratch --no-interaction && cd scratch
   composer config repositories.mobile '{"type":"path","url":"../mobile-air","options":{"symlink":true}}'
   composer config minimum-stability dev && composer config prefer-stable true
   composer require "nativephp/mobile:dev-$(git -C ../mobile-air branch --show-current) as $(git -C ../mobile-air tag --sort=-v:refname | head -1)" -W
   php artisan tinker --execute='...'
   ```

   Prefer a Pest test in the package itself when the question fits one; tests are evidence a maintainer can re-run.

Conventions if you change code: follow Pint, write Pest tests in the style of the neighbouring tests, add no dependencies, change nothing you have no reason to touch. Code comments are full sentences.
