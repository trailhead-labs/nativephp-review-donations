## Review angles

Use these angles for any review, of a PR or of your own fix. Each finding needs a concrete failure scenario: which input or state, and what goes wrong. No scenario, no finding.

**Correctness**
- Does the change fix what the issue describes, every symptom of it, on every platform the issue names?
- Does it fix the cause or hide a symptom?
- Error paths: what happens when the new code fails? Is a failure swallowed, turned into a false success, or reported?
- Early returns and exit codes: is every early exit really a failure, or a legitimate stop?

**Blast radius**
- Every caller of every changed function or class. `rg -n "{symbol}"` across both repos.
- Sibling code paths that share the changed code (for example the three build commands, the three text input variants, button versus pressable versus list item).
- Behaviour that used to be allowed and now is not.
- Platform parity: does Android now behave differently from iOS, or the other way round?

**Tests**
- Would the new tests fail without the change? Run them against the base to find out; a test that passes both ways proves nothing.
- What important path is untested?

**Compatibility**
- Public method signatures, manifest keys, config keys, Blade attributes.
- Merge order with companion PRs: does one PR alone break a build?

**Simplification** (the cleanup pass)
- Reuse: does it re-implement something the codebase already has? Name the existing helper.
- Simplification: redundant state, copy paste with small variations, dead code left behind, unnecessary nesting.
- Efficiency: repeated work, blocking work on a hot path.
- Altitude: is this a special case bolted onto shared code where fixing the shared mechanism would be cleaner?

Skip style nits the formatter would catch. Skip anything the realism filter drops.
