## The report

One comment on the item. Draft it to `report.md` in the item folder, then follow Finish.

### Rules for every report

- First line is the disclosure, exactly this shape:
  `Agent report ({agent}, {models used}), inference donated by @@{{donor.handle}} via Review Donations.`
  `{models used}` lists the models that actually ran, lead first: "Opus 5.5 with Fable 5.1 and Sonnet 5 helpers".
- Second paragraph is the finding in one or two sentences, with the evidence in them.
- Then the detail as a short list. Each point is marked **measured** (say how) or **reasoned** (file and line).
- Then **Not measured**, if anything is.
- Code as indented blocks (four spaces), each suggestion marked **verified** or **unverified**.
- Screenshots: the API cannot attach images to a comment, and gists do not take binary files. Ask the donor once whether screenshots may go on an evidence branch of their fork of the repo. If yes: create an orphan branch `review-donations-evidence-{n}` in the fork (`git switch --orphan`), commit only the images, push to the donor's fork, and embed them with `![step](https://raw.githubusercontent.com/{donor}/{fork}/{branch}/{file}.png)`. If no, or there is no fork, describe what each screenshot shows precisely (marker text, element text, pixel values) and say the images are available from the donor.
- Paths: relative to the repo root. Never absolute paths with the donor's username.
- Last line is the marker, on its own line:
  `<!-- review-donations:report v1 track={track} level={level} agent={agent} donor=@{{donor.handle}} head={short sha tested} outcome={outcome} -->`
  `outcome` is one of `diagnosed`, `reproduced`, `not-reproduced`, `already-fixed`, `fixed-pr-opened`, `reviewed`, `verified`, `regression-found`, `inconclusive`.
- Keep it under 300 words unless the evidence genuinely needs more. Cut before you post. Read it back as if a person typed it.

### Issue, diagnosis

```
Agent report (...), inference donated by @donor via Review Donations.

{What is going on, in plain words, and where. One or two sentences.}

- {point}, measured: {how}
- {point}, reasoned: `path/File.php:123`

A likely fix, unverified:

    {code}

Not measured: {list}

<!-- marker -->
```

### Issue, reproduction

```
Agent report (...), inference donated by @donor via Review Donations.

Reproduced on {Android emulator API 36 / iOS 26 simulator} against {default branch} at {sha}. {What happened, one sentence.}

Steps: {numbered, minimal}

Evidence: {gist link or precise description}

{Cause, if found, marked measured or reasoned.}

Not measured: {e.g. the other platform, physical devices}

<!-- marker -->
```

Not reproduced: same shape, lead with "Could not reproduce on ..." and list exactly what was tried, with versions, so the reporter can say what differs.

Already fixed: "This no longer reproduces on {default} at {sha}; it was fixed by {PR or commit}. Updating to {version} should resolve it." Plus the evidence.

### Issue, fixed with a PR

```
Agent report (...), inference donated by @donor via Review Donations.

Draft fix in #{pr}. {One sentence: what caused it and what the fix changes.} Reproduced before and verified after on {devices}.

<!-- marker outcome=fixed-pr-opened -->
```

### PR body (issue tracks only)

```
Fixes #{n}.

{What was wrong, from the user's side, one or two sentences.}

{Why it happened, briefly, with the file.}

{What this changes.}

## Verified

{Before and after, per platform, as a small table where it helps. Suite, Pint, PHPStan compared to the default branch.}

## Not verified

{Honest list.}

Opened by an agent ({agent}, {models}) on inference donated by @donor via Review Donations. The donor reviewed this description before it was opened.
```

### PR review

```
Agent report (...), inference donated by @donor via Review Donations.

{Overall, one sentence: does it fix the issue, and is anything blocking.}

1. {Finding, with the failure scenario}. {measured or reasoned, citation}. Suggested fix, {verified|unverified}:

       {code}

2. ...

Checked and fine: {short list, so the author knows what was covered}.

Not measured: {list}

<!-- marker outcome=reviewed -->
```

Findings numbered, most severe first. If there is nothing blocking, say so in the first sentence and keep the rest short.

### PR verification (prove track)

```
Agent report (...), inference donated by @donor via Review Donations.

{Verified / Regression found} on {devices}. {One sentence.}

| | base {sha} | head {sha} |
|---|---|---|
| {case} | {result} | {result} |

{Numbered findings if any, as in the review template.}

Not measured: {list}

<!-- marker outcome=verified|regression-found -->
```
