## Probes and evidence

A probe is the smallest screen or route that shows the bug, in the host app. It makes the bug a yes or no question a screenshot can answer.

### Build the probe

1. Start from the reporter's own code when they gave some. Paste it into a route or native component in the host app first, unchanged, and see if the bug shows. Only then reduce it.
2. Reduce until removing anything more makes the bug disappear.
3. Make it readable in a screenshot:
   - Give every text element an explicit colour class. A `<text>` without one renders black on black in dark mode.
   - Put a short marker string at the top of the screen (`P{n} BEFORE`, `P{n} AFTER`) so every screenshot says which build it came from.
   - For layout and scroll bugs, give each row a solid colour that encodes its index (for example red channel = index × 8). A one pixel strip from a screenshot then tells you exactly which rows are visible and how far scrolled, as numbers.
4. Native screens: register with `Route::native('/probe', ProbeScreen::class)`. A native component's `render()` may return an Element instead of a view when a builder only property has no Blade attribute.

### Drive it without touching the screen

Tapping is slow and fragile, and on iOS it needs extra permissions. Where you can, make the probe drive itself:

- Add `#[Poll(500)]` to the probe component and have it read a command file from `storage_path('app/probe-cmd.txt')` on each tick, applying whatever the file says (change a property, navigate, toggle a flag). This runs PHP side, so it works on a headless simulator.
- Write the command file with the platform commands in the device sections above.
- Have the probe log each tick it applies (`Log::info('[probe] ...')`) so you can prove the command landed.

### Evidence

- Take a screenshot for every observation you report. Name them by step.
- Before and after: the same probe, the same steps, the same device, only the code changed. Build the "before" on the default branch (or the PR base) and the "after" on the fix (or the PR head).
- Say which commit each build came from, and prove the build used it (the build log check from the rig pitfalls, plus the marker on screen).
- Timing and animation bugs: record a video and describe what changes between frames. A single screenshot can hide a jump.
- If a finding depends on reading pixels, give the pixel values, not an impression.
