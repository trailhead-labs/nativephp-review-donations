## Helpers with fresh eyes

Some steps are done by a separate helper so its judgement is not coloured by yours. A helper that has read your conclusions will agree with them. Brief it as a stranger.

### Every brief contains

Write the brief to a file in the item folder (`brief-{step}.md`) before starting the helper, so it can be re-run and so the donor can see it.

1. The job in one sentence, and that it should try to prove the hypothesis wrong, not right.
2. The item: title, full body, every comment (paste them, do not summarise).
3. `context.md` from the item folder.
4. Exact paths and refs: repo folder, branch, commit, default branch.
5. What it may and may not touch. Reviewers are read only. At most one helper owns the checkout at a time. Helpers never post to GitHub and never push.
6. The "How to know things" rules from this prompt, verbatim.
7. The output format you want back: findings, each marked measured or reasoned with citation, plus not measured.
8. A cleanup contract: leave the checkout as it found it, delete anything it created outside the item folder.

Device work runs one helper at a time. Two helpers on one emulator or simulator corrupt each other's results.

@if ($agent === 'claude')
### How, in Claude Code

Use the Agent tool. Set `model` explicitly on every call from the role named in the step (`{{ $models['analyst'] }}` is `fable`, `{{ $models['planner'] }}` is `opus`, `{{ $models['driver'] }}` is `sonnet`, `{{ $models['scout'] }}` is `haiku`). Put the brief file's contents in the prompt. Start independent read only helpers in the same message so they run in parallel; wait for all of them before acting on their results.

If the Swift or Kotlin LSP plugin is installed, helpers may use the LSP tool for symbol lookups. Otherwise `rg`.
@endif

@if ($agent === 'codex')
### How, in Codex

Run each helper as a separate non interactive Codex session so it starts with a clean context:

```
codex exec -m "{{ $models['analyst'] }}" --cd ~/nativephp-donation/{repo_short}-{n} "$(cat brief-{step}.md)" > result-{step}.md
```

Adjust the model per step from the role named in the step. Run independent read only helpers in parallel as background shell jobs and `wait` for all of them. **This invocation is unverified for current Codex versions. If `codex exec` or `-m` is not available, run the helper's job yourself, in a new section of your work, reading only the brief file and not your earlier notes, and say in the report that the independent check ran in the same session.**
@endif

@if ($agent === 'other')
### How, in your agent

If your agent can start subagents or background sessions with their own context, use that, one per helper, with the brief file as the prompt. If it cannot, do the helper's job yourself in a separate phase: read only the brief file, not your earlier notes, write the result to `result-{step}.md`, and say in the report that the independent check ran in the same session.
@endif
