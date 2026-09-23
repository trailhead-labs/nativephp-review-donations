## Android emulator

Start the donor's first AVD headless enough not to steal their screen:

```
AVD=$("$ANDROID_HOME/emulator/emulator" -list-avds | head -1)
"$ANDROID_HOME/emulator/emulator" -avd "$AVD" -no-snapshot-load -no-boot-anim > emulator.log 2>&1 &
adb wait-for-device shell 'while [ -z "$(getprop sys.boot_completed)" ]; do sleep 2; done'
adb devices
adb shell wm size ; adb shell wm density
```

Never target a physical device. If `adb devices` lists anything other than `emulator-*`, pass the emulator's serial explicitly with `-s` on every command and to `native:run android {serial}`.

### Driving and observing

- Screenshot: `adb exec-out screencap -p > shot-{step}.png`, then look at it.
- Tap: `adb shell input tap {x} {y}` in physical pixels from `wm size`. Take a screenshot first to find coordinates, and one after to confirm the tap landed.
- Text: `adb shell input text '{text}'`. Keys: `adb shell input keyevent KEYCODE_ENTER` (or `KEYCODE_BACK`).
- Is the keyboard up: `adb shell dumpsys input_method | grep mInputShown`.
- Logs: `adb logcat -d -t 500 | grep -iE "nativephp|php|AndroidRuntime|FATAL"`.
- App files: `adb shell run-as {app_id} ls app_storage/persisted_data/storage/app`. To write a file into the app: `echo -n '{content}' | adb shell run-as {app_id} tee app_storage/persisted_data/storage/app/{file}` (`cp` is denied).
- Orientation: apps are portrait locked unless configured. After enabling rotation, use `adb emu rotate`.
- `uiautomator dump` sees native views only. Content inside a webview is invisible to it; use screenshots.
- Dark mode: `adb shell cmd uimode night yes|no`.

Relaunch cleanly between cases:

```
adb shell am force-stop {app_id}
adb shell monkey -p {app_id} -c android.intent.category.LAUNCHER 1
```

When you are done: `adb uninstall {app_id}`, then `adb emu kill`.
