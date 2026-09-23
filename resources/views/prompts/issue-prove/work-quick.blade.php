The goal is a yes or no a maintainer can trust: does this bug happen on the current default branch, on the platform it was reported on, and what exactly does it look like. You do not fix it or try the other platform at this level; say so under "Not measured".

Allowed attempts: two probe variations. If neither reproduces, that is the result.

1. Step 0, the self check, including the device checks for your `PLATFORMS`.
2. Pick an issue (Pick). Issue track, platform filter on.
3. Claim it (Claim). Expiry 3 hours.
4. Read the issue, every comment, and any code the reporter linked (Read the item properly, points 1, 2 and 3). Note the reporter's version and platform.
5. Clone `mobile-air` (and `mobile-ui` if the issue involves any native element or renderer) into the item folder, on the default branch. Shallow is fine: `--depth 50`.
6. Build the host app (The host app). Read every build pitfall first.
7. Start the device for the reported platform (Android emulator or iOS simulator section).
8. Build a probe from the reporter's code, then reduce it (Probes). Put the marker `P{n} MAIN {short sha}` at the top.
9. Build and run. Check the build log, not the exit code. Take a screenshot of the first screen and confirm the marker is there.
10. Run the reporter's steps. Screenshot each observation. Pull the relevant log lines.
11. Decide: reproduced, not reproduced, or reproduced differently from the report. If the reporter's code is clearly misusing the API, and the native facts show it, say so kindly with the correct usage; that is often the most useful answer.
12. Write the report with the "Issue, reproduction" template. Outcome `reproduced`, `not-reproduced` or `already-fixed`.
13. Finish.
