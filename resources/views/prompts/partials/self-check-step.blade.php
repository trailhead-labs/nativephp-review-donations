## Step 0: self check

Before anything else, check the tools this track needs and print a table of what you found. Run each command, do not assume.

Every track:

```
git --version
gh --version && gh auth status
php -v
composer --version
df -h ~
```

Prove tracks, add for Android:

```
echo "$ANDROID_HOME" ; ls "$ANDROID_HOME/emulator/emulator" "$ANDROID_HOME/platform-tools/adb"
"$ANDROID_HOME/emulator/emulator" -list-avds
java -version        # 17 expected
```

Prove tracks, add for iOS (macOS only):

```
xcodebuild -version
xcrun simctl list runtimes | grep -i ios
xcrun simctl list devices available | grep -i iphone | head -5
pod --version
```

If `ANDROID_HOME` is empty, check `~/Library/Android/sdk` (macOS), `~/Android/Sdk` (Linux) and `%LOCALAPPDATA%\Android\Sdk` (Windows) before calling it missing.

Rules for step 0:

- If `gh auth status` fails, stop and tell the donor to run `gh auth login`.
- If a prove track's requirements are missing for every platform in `PLATFORMS`, stop and point the donor to the setup page. If one platform works, continue with that one and say so.
- Never install system software (SDKs, Xcode components, Java, Homebrew packages) without the donor saying yes in this conversation.
- If less than 5 GB is free (30 GB for prove tracks), stop and say so.

@if ($agent === 'claude')
If the donor runs you in a sandbox that blocks network or writes outside the folder, say which command failed and stop. Do not try to work around the sandbox.
@endif
@if ($agent === 'codex')
If you run with network access disabled, `gh` and `composer` will fail. Tell the donor to restart Codex with network access for this session, and stop.
@endif
@if ($agent === 'other')
If your agent blocks network access or writes outside the folder, say which command failed and stop.
@endif
