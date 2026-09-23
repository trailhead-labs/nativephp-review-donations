## iOS simulator

Boot headless, so nothing takes over the donor's screen:

```
UDID=$(xcrun simctl list devices available | grep -E "iPhone 1[5-9]|iPhone 2" | grep -oE '[0-9A-F-]{36}' | head -1)
xcrun simctl boot "$UDID" 2>/dev/null ; xcrun simctl bootstatus "$UDID" -b
```

Build with the id, always: `php artisan native:run ios "$UDID" --no-interaction > build-ios.log 2>&1`. Without it the command waits on a picker forever.

A `CoreSimulator ... code=405 Unable to boot device in current state: Booted` line after the build is harmless.

### Driving and observing

- Screenshot: `xcrun simctl io "$UDID" screenshot shot-{step}.png`, works headless.
- Video: `xcrun simctl io "$UDID" recordVideo clip.mp4 &`, stop with `kill -INT`.
- Relaunch: `xcrun simctl terminate "$UDID" {app_id} ; xcrun simctl launch "$UDID" {app_id}`.
- Is it installed and running: `xcrun simctl listapps "$UDID" | grep {app_id}` and `xcrun simctl spawn "$UDID" launchctl list | grep {app_id}`.
- App files: `xcrun simctl get_app_container "$UDID" {app_id} data` gives the data folder. Laravel's `storage_path()` is `<that folder>/Library/Application Support/storage`. Quote it; the space in "Application Support" breaks unquoted shell paths silently.
- Logs: `xcrun simctl spawn "$UDID" log show --last 5m --predicate 'process CONTAINS "NativePHP"'`.
- Appearance: `xcrun simctl ui "$UDID" appearance dark|light`.

**Taps need care.** `simctl` has no tap command. Prefer not to tap at all: drive the app through a probe that polls a command file (see Probes). If a tap is unavoidable and the donor has granted their terminal accessibility access, AppleScript can click the Simulator window, but ask the donor first, because it takes over their screen: `osascript -e 'tell application "System Events" to tell process "Simulator" to get {position, size} of window 1'` then `click at {x, y}` in screen coordinates. The click reply names the element it hit; check it is the one you meant.

The Simulator app's Shake and hardware shortcuts can stop reaching the app after the window has been unfocused for a while. A full Simulator restart fixes it. Never conclude a gesture is broken without restarting first.

When you are done: `xcrun simctl uninstall "$UDID" {app_id}` and `xcrun simctl shutdown "$UDID"`.
