## Device work: plan, drive, analyse

Driving an emulator or simulator is the most expensive thing in this workflow, and the part where a strong model wastes the most. Split it in three, and keep the roles apart.

1. **Plan** ({{ $models['planner'] }}). Write `playbook.md`: the exact commands to run in order, what the screen should show at each step if the bug is present and if it is absent, which screenshot to take where, and what to write down. No judgement is left to the driver. Include the build log checks from the rig pitfalls.
2. **Drive** ({{ $models['driver'] }}). Execute `playbook.md` line by line. Write `observations.md`: each step, the command, what came back, the screenshot file, and what is visibly on screen, described literally. The driver does not diagnose, does not fix, does not skip or improvise steps. If a step cannot be done as written, it records why and stops.
3. **Analyse** ({{ $models['planner'] }}). Read `observations.md` and the screenshots, compare against the playbook's expectations, and decide what was shown. If the answer is unclear, write a second, narrower playbook and go round again. Do not guess.

Run one relay per platform, one after the other, never two drivers on one device at the same time.

@if ($agent === 'claude')
Start the planner and the driver as separate Agent calls with `model` set (`opus`, then `sonnet`). Give the driver only the playbook and the relevant device section of this prompt, not your diagnosis. You, the lead, may do the analysis yourself if you are running Opus 5.5 or Fable 5.1; otherwise hand it to an `opus` helper.
@endif

@if ($agent === 'codex')
Run the planner and the driver as separate `codex exec` sessions (see Helpers), the driver with {{ $models['driver'] }}. Give the driver only the playbook and the relevant device section of this prompt. If separate sessions are unavailable, run the three phases yourself in order and, while driving, act strictly as the driver: follow the playbook, record, do not interpret.
@endif

@if ($agent === 'other')
If your agent can start separate sessions, use a fast model for the driver and give it only the playbook. Otherwise run the three phases yourself in order and, while driving, act strictly as the driver: follow the playbook, record, do not interpret.
@endif
