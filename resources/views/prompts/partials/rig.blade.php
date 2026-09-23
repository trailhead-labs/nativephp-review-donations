## The host app

NativePHP is a Composer package, so to see a bug you need a Laravel app that uses it. Build a throwaway one in the item folder that points at your local clones, so any fix you make is what runs.

```
cd ~/nativephp-donation/{repo_short}-{n}
composer create-project laravel/laravel host --no-interaction
cd host
composer config repositories.mobile '{"type":"path","url":"../mobile-air","options":{"symlink":true}}'
composer config repositories.mobile-ui '{"type":"path","url":"../mobile-ui","options":{"symlink":true}}'   # if cloned
composer config minimum-stability dev && composer config prefer-stable true
composer require "nativephp/mobile:dev-$(git -C ../mobile-air branch --show-current) as {version}" -W
```

`{version}` is the latest released version from `git -C ../mobile-air tag --sort=-v:refname | head -1`. The alias is required because plugins require a version range; the branch name must be the one currently checked out in the clone or Composer refuses.

If `mobile-ui` is cloned, also:

```
composer require "nativephp/mobile-ui:dev-$(git -C ../mobile-ui branch --show-current)" -W
php artisan native:plugin:register nativephp/mobile-ui
```

Then:

```
php artisan native:install --no-interaction
```

Set a unique app id in `.env` (`NATIVEPHP_APP_ID=com.donation.r{n}`) and a first screen (`NATIVEPHP_START_URL=/probe`).

### Build pitfalls

Each of these has cost someone an hour. Read them before your first build.

1. **`native:run` exits 0 on a failed build, and on a failed install.** Never trust the exit code. After every build check the log:
   - Android: `grep -c "BUILD SUCCESSFUL" nativephp/android-build.log`, then read the lines after it for `APK installed on device`.
   - iOS: `grep -c "BUILD SUCCEEDED" nativephp/ios-build.log`.
2. **`native:run` does not copy native sources.** Changes to Kotlin or Swift in the clone only reach the app through `php artisan native:install --no-interaction --no-force --skip-php`. After that, check `nativephp/android/local.properties` still reads `sdk.dir=<your sdk path>`; install can blank it, and the next build then fails with "SDK location not found".
3. **Host PHP must match the lock.** If `php -v` does not match the version in `nativephp.lock`, `native:run` silently reinstalls first. Let the first install finish; do not fight the lock.
4. **`native:run ios` without a simulator id waits forever on a device picker.** It looks like a hang: 0% CPU, an empty `ios-build.log`. Always pass the id: `php artisan native:run ios {udid} --no-interaction`.
5. **Do not pipe `native:run` through `head` or `tail`.** The pipe hides a prompt that is waiting for input. Redirect to a file instead and read the file.
6. **Nothing native renders without `nativephp/mobile-ui` registered.** The element classes live in mobile-air, but every renderer ships in mobile-ui. An empty screen with no error usually means the plugin is missing.
7. **`Route::nativeGroup()` does nothing for `Route::get()` routes.** Only `Route::native()` screens get a native layout.
8. **After `composer require ... --no-scripts`, run `php artisan package:discover`**, or plugin commands will be missing.
9. **Emulator storage fills up.** `INSTALL_FAILED_INSUFFICIENT_STORAGE` means uninstall old test apps: `adb uninstall {app_id}`.
10. **A dangling symlink anywhere in the app breaks the bundle copy** with an rsync error before any native step runs.

Write every build's command, duration, outcome and log check to `run.log`.
