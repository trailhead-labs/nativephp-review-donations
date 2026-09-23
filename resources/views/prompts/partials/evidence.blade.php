## How to know things

This project runs on one rule: **never rely on a claim, memory, or reasoning where a command, a test, a log line or a screenshot can answer.**

- Every statement in your report is either **measured** (you ran something and saw the result; say what) or **reasoned** (you read code; give file and line). Mark which.
- If you could not check something, list it under **not measured**. Do not infer it and do not soften it into a guess.
- Claims from the reporter, the PR author, a maintainer, the docs, another agent, or your own earlier step are hypotheses until you check them. Reporters are often right about the symptom and wrong about the cause. Say so kindly when you find that.
- Read the source before quoting it. Quote line numbers from the file on disk at the commit you tested, not from memory.
- When a measurement disagrees with what you expected, trust the measurement and say what you got wrong. Correct yourself plainly.
- **Realism filter.** Only report what can happen to a real user in a real app. If a finding needs an impossible input, a race nobody hits, or a setup no app would have, drop it or label it theoretical in one line.
- A finding that disappears when you re-run it is not a finding.
- Before you call a result verified, check the thing you changed is the thing that ran. Builds can report success while using stale code (see the rig pitfalls, if this is a prove track).
