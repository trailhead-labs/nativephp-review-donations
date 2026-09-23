# Review Donations: spec

People pay for AI subscriptions and API credit they never use up. NativePHP has more open issues and pull requests than its core team can triage. Review Donations turns the first into help with the second: pick a prompt, paste it into your own coding agent, and it gives a real open issue or pull request a first look.

The goal is a head start, not a fix to merge. Accountability always sits with the maintainers. A report saves them starting from zero; it never decides anything for them.

The five second test for the home page: a visitor understands "my spare AI budget, spent on an open source project, by copying one prompt".

This doc holds the decisions behind the prompts. The page copy lives in [copy.md](copy.md), how prompts are authored in [prompts.md](prompts.md).

## Grounding

The prompts are distilled from how issues and pull requests are worked on NativePHP today:

- Every claim is backed by an observation. Say "not measured" instead of inferring.
- Read the whole thread and follow every link before touching code. Check the reporter's version against the default branch, and whether it was already fixed there.
- Reproduce on an emulator and a simulator before and after a fix. Verify suggested fixes on a device before suggesting them.
- Separate agents for separate jobs: a planner writes the device playbook, a cheaper model drives it and only records, a strong model analyses. Fix, scrutinise and simplify each get a fresh strong model.
- A realism filter: do not report things that cannot happen in a real app.
- Human voice in comments, no padding, collaborative with the author.

What does not travel to a stranger's machine: local plugins, process managers, personal devices, private notes. The prompts use plain shell and files in the donor's workspace instead.

## Tracks

Two axes: what the agent works on, and whether it runs the app on a device.

| Track | Key | Picks | Device | May open a PR |
|---|---|---|---|---|
| Diagnose an issue | `issue-reason` | open issues with no linked PR | no | Thorough and Deep, PHP only fixes with a failing then passing test |
| Reproduce an issue | `issue-prove` | open issues with no linked PR | yes | Thorough and Deep, any fix, device verified before and after |
| Review a pull request | `pr-reason` | open, non draft PRs | no | never, posts a review comment |
| Test a pull request | `pr-prove` | open, non draft PRs | yes | never, posts a verification comment |

Pull request tracks never push commits. Suggested changes go in the comment as code blocks, marked verified (tried on a device or under tests) or unverified.

## Levels

| Level | Idea | Helpers |
|---|---|---|
| Quick | One agent, one focused pass. Answers "what is this and where". | none |
| Thorough | The full single item workflow, with one independent check. | 1 to 3 |
| Deep | Separate fresh agents per job, every finding re-verified. | 4 to 8 |
| Adaptive | Sizes itself from the item, up to a ceiling the donor sets. | as chosen |

The steps, skips, requirements and estimates per track and level live in `config/donations.php`, next to the prompts that implement them.

### Cost

Token ranges are totals across all agents in a run, calibrated from comparable real runs (a single review helper on this codebase used 115k to 330k tokens; a device reproduction with before and after builds took two to four hours). They must be re-measured per prompt before launch, and the site tags them as estimates.

Money is not shown yet. The plan is an API list price range computed from per model prices, and a coarse gauge for subscription users ("light", "a good chunk", "most of a session") instead of a percentage nobody can measure.

## Models

Prompts name a role, never a model. Each role resolves per agent in `config/donations.php`.

| Role | Job | Claude Code | Codex | Other |
|---|---|---|---|---|
| lead | the session the donor pastes into; picks, claims, orchestrates, reports | Opus 5.5 (Sonnet 5 is fine for Quick) | OpenAI flagship, high effort | your main model |
| analyst | diagnose, fix, scrutinise, simplify, review | Fable 5.1 | OpenAI flagship, high effort | your strongest model |
| planner | write the device playbook, analyse what the driver saw | Opus 5.5 | OpenAI flagship, medium effort | your strongest model |
| driver | execute the playbook, record only | Sonnet 5 | OpenAI coding model, low effort | your fastest model |
| scout | list and filter items, grep logs | Haiku 4.5 | OpenAI small model | your fastest model |

The Codex names are placeholders. The Codex prompts pass them to `codex exec -m`, so they must be replaced with real model ids before launch.

## Picking and claiming

### Pool

`NativePHP/mobile-air` and `NativePHP/mobile-ui`.

Issue tracks search:

```
repo:NativePHP/mobile-air is:issue is:open -linked:pr -label:wontfix -label:invalid -label:duplicate -label:question -label:review-donations-skip no:assignee
```

Pull request tracks search:

```
repo:NativePHP/mobile-air repo:NativePHP/mobile-ui is:pr is:open draft:false -label:review-donations-skip
```

Then the prompt filters:

- Skip items that already carry a report for the same track at the same or a deeper level.
- Skip items with an unexpired claim for the same track.
- Skip items where a member, owner or collaborator commented in the last 7 days, unless labelled `review-donations-wanted`.
- Skip pull requests updated in the last hour, the author may be mid push.
- Skip items authored by the donor.
- Device tracks skip items whose platform the donor cannot run (iOS needs macOS).
- Issue tracks prefer `bug` and `needs testing`, and skip feature requests and questions.
- Order: `review-donations-wanted` first, then `high-priority`, then oldest last activity.

A donor may name a specific item. The rules and the claim still apply.

### Claims without a database

Claims are comments on one ledger issue in this repository, set as `DONATIONS_LEDGER`. Donors need no permissions to comment on a public issue, and NativePHP's own threads only ever get finished reports.

```
<!-- review-donations:claim v1 state=live repo=NativePHP/mobile-air item=489 track=issue-reason level=thorough donor=@someone expires=2026-09-23T18:40:00Z -->
Claiming NativePHP/mobile-air#489 for issue-reason, thorough. Expires 18:40 UTC.
```

1. Read ledger comments from the last 24 hours.
2. Pick a candidate with no unexpired claim for the same track.
3. Post the claim.
4. Wait 20 seconds and read again. If another unexpired claim for the same item and track has a lower comment id, you lost: delete your claim and pick the next candidate. GitHub assigns ids in creation order, so the tiebreak is deterministic.
5. On finish or abort, edit the claim to say released, with `state=released` in the marker.

Claims expire on their own, so a crashed run frees its item:

| | Quick | Thorough | Deep |
|---|---|---|---|
| Reading tracks | 1 h | 2 h | 4 h |
| Device tracks | 3 h | 6 h | 12 h |

Different tracks may work the same item at the same time. Same track, one at a time. The ledger should be rotated monthly to keep reads cheap.

## Ground rules

**May**: read anything public; fork and clone; install PHP dependencies inside the workspace; build and run on emulators and simulators; post one claim and one report per run; prepare a draft PR from the donor's fork when the gate is met and the donor says go.

**May not**: push to a branch it did not create; approve or request changes on a PR; label, close, assign, lock or edit anything it did not write; change versions, tags, changelogs or dependency constraints (it may suggest them); deploy to a physical device; use real signing credentials; install system software without the donor's consent; post secrets or paths containing the donor's username; mention anyone but the donor; post before showing the donor, unless the donor chose to post without asking.

**Stops when**: it loses the claim race twice in a row; the item gets a linked PR, is closed, or a maintainer comments while it works; a prerequisite is missing; the level's budget runs out; it needs credentials; it cannot reproduce within its attempts (still worth a "could not reproduce, here is what I tried" report); two of its own findings contradict and a further measurement cannot settle it.

At most three reports per donor per day across the pool.

## Reporting

One comment per run, on the issue or pull request, posted with `gh` as the donor.

- Starts with the disclosure: `Agent report ({agent}, {models}), inference donated by @{donor} via Review Donations.`
- Then the finding in one or two sentences, with the evidence in it.
- Then a short list, each point marked **measured** (with how) or **reasoned** (with file and line), and a **not measured** list.
- Suggested code as code blocks, each marked verified or unverified.
- Ends with a hidden marker so later agents and the site can find it:

```
<!-- review-donations:report v1 track=issue-prove level=thorough agent=claude donor=@someone head=abc1234 outcome=reproduced -->
```

`outcome` is one of `diagnosed`, `reproduced`, `not-reproduced`, `already-fixed`, `fixed-pr-opened`, `reviewed`, `verified`, `regression-found`, `inconclusive`.

Voice: plain language, no em dashes, no emoji, no filler, no restating the author's findings back at them, one idea per sentence, suggest fixes rather than only pointing at problems.

Screenshots: the API cannot attach images to comments. With the donor's yes, images go on an orphan evidence branch on the donor's fork and are embedded by raw URL. Otherwise they are described precisely.

## The pull request gate

An issue track only opens a draft PR when all of these hold. Otherwise the fix goes into the report as a suggestion, naming the item that failed.

1. **Cause pinned** to specific lines, with a mechanism that explains every symptom.
2. **Failing before**: reproduced on a device on each affected platform, or for PHP only fixes an automated test that fails on the default branch.
3. **Passing after**: the same reproduction or test passes with the fix.
4. **Nothing else moved**, or every other change is listed and justified.
5. **No worse than main**: tests pass, formatter clean, static analysis unchanged, and for native changes both platforms build, install and launch.
6. **Adjacent paths checked**, or listed as not checked.
7. **Fresh eyes**: an independent agent tried to break the fix and found nothing blocking.
8. **Current**: rebased on the latest default branch, and the bug still reproduces there before the fix.
9. **Unclaimed**: no PR for the issue appeared meanwhile.
10. **Minimal**: fewest files, no refactors, no version changes.

Reading tracks may only open a PR for PHP only fixes. Quick levels never open one. The branch is `review-donations/{issue}-{slug}` on the donor's fork, and the donor sees the branch, diff and description before `gh pr create`.

## Agents

Where Claude Code and Codex actually differ, and how the prompts handle it:

| Concern | Claude Code | Codex | Handling |
|---|---|---|---|
| Helpers | Agent tool with a model per call, fresh context, parallel | `codex exec` with the brief in a file (unverified) | Variant lines in the `subagents` and `relay` partials |
| Skills and review commands | Skill tool, `/code-review`, `/simplify` | none | Inlined as checklists, same text for both |
| Symbol lookup | LSP when installed | none | Claude may use LSP, everyone else uses `rg` |
| Models | Anthropic | OpenAI | Resolved per role |

Other agents get the single session version: phases run in order, each writes its output to a file, and "fresh" steps re-read only their brief. The site says in one line that those checks are less independent.

## Open questions

1. **Maintainer buy in.** Opt out (everything in the pool unless skipped) or opt in (only items labelled wanted), and the final label names.
2. **Ledger.** Create the ledger issue and set `DONATIONS_LEDGER`. Until then every prompt stops before claiming.
3. **Codex.** Verify how Codex spawns helpers today and its model ids.
4. **Cost calibration.** Run each of the 16 prompts once on a real item, record tokens and time per agent, and replace the estimates.
5. **Prices.** Per model prices for the money range.
6. **Post mode default.** Show me first (current) or post without asking. Unattended would need a stricter self review.
7. **Draft or ready PRs.** Draft today.
8. **Repo scope.** mobile-air and mobile-ui only, or also desktop and first party plugins.
9. **Corrected skills.** The fixed plugin-dev skills exist only locally. Publishing them lets prompts reference one source; until then `native-facts` inlines the verified contracts.
10. **Credit format.** `@handle` pings the donor on every report. Linking the profile instead would not.
11. **Screenshots.** Evidence branch on the donor's fork, or text only.
12. **Live numbers.** The home page could show issues waiting, runs in progress and reports posted, fetched at build time from GitHub search and the ledger. Needs a scheduled rebuild.
13. **Physical devices.** A hard no today. Some bugs only show on hardware, so maybe an opt-in track later.
14. **Numbers to confirm.** Level names, claim expiry per level, three reports per donor per day, the 7 day "someone is on it" window, and the reproduction attempt budgets. Each is one edit in the partials.
