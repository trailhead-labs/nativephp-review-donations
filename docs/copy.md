# Review Donations: site copy

Six pages, all static. Copy follows the [spec](spec.md), rewritten for the name Review Donations and a lighter tone. The visual idea is a letter to the maintainers: the hero is an airmail envelope, the four tracks are postage stamps, copying a prompt postmarks it. The metaphor lives in the visuals and a few lines of flavour, never in button or level names.

## Header (every page)

- Wordmark: Review Donations
- Agent switch: Claude Code / Codex / Other

## Footer (every page)

- Open source runs on small kindnesses. This one fits in your clipboard.
- Not affiliated with any AI vendor. Run by the NativePHP community.
- Links: How it works, Setup, For maintainers, FAQ

## `/` Home

### Hero (the envelope)

Envelope address: To the NativePHP maintainers. From you, with love.

# Put your spare AI tokens to work on NativePHP

You pay for a coding agent and probably don't use all of it. Copy one prompt, paste it into Claude Code or Codex, and your agent gives a real NativePHP issue or pull request a first look. It is a head start, not a verdict: the maintainers still decide, they just don't start from scratch.

Buttons: Pick a task / How it works

Postmark on the stamp: Open source, first class

### Three steps

1. **Pick a task.** Review a pull request, diagnose an issue, or reproduce one on a simulator.
2. **Copy the prompt.** Choose how much to give. You see which models it uses and roughly how long it takes before you copy.
3. **Paste and walk away.** Your agent claims one item, does the work, shows you its report, and posts it when you say so.

### Picker

Heading: What would you like to give?

Axis labels: columns "Read the code" / "Run it on a device", rows "An issue" / "A pull request".

| | Read the code | Run it on a device |
|---|---|---|
| An issue | **Diagnose an issue.** Your agent reads an open issue, the whole thread and the code it touches, then explains what is going on, where, and what would fix it. | **Reproduce an issue.** Your agent reproduces an open issue on an Android emulator or iOS simulator and reports what it saw, with screenshots and logs. Deeper levels also build a fix and prove it on the same device. |
| A pull request | **Review a pull request.** Your agent reads an open pull request against the issue it fixes, runs the tests, and posts a review the author can act on. | **Test a pull request.** Your agent builds the pull request on an emulator or simulator, checks the bug is gone, and looks for anything the change broke nearby. |

Each stamp's face value is its Quick level's lower token bound ("60k, tokens and up"). Footer line on each stamp: "No emulator needed" or "Needs a mobile build setup".

Level heading: How much would you like to give?

| Level | One liner |
|---|---|
| Quick | One agent, one focused pass. |
| Thorough | The full workflow with one independent check. |
| Deep | Fresh helpers for every job, every finding checked twice. |
| Adaptive | Sizes itself to the item, up to a ceiling you set. |

Panel, left, "What your agent does": the steps with a model chip each, helpers marked "fresh eyes". Below: "Skips at this level" with the skipped work.

Panel, right, "Before you copy":

- Estimate: tokens and time, tagged "estimate".
- You need: the requirements checklist, link "Set up your machine".
- Your GitHub handle. Hint: Used for credit, and so your agent skips your own issues.
- Platforms (device tracks): Android / iOS.
- Ceiling (Adaptive): Quick / Thorough / Deep.
- Before posting: Show me first (default) / Post without asking.
- A specific item (optional). Hint: For example mobile-air#489. Leave empty and your agent picks one.
- Button: Copy the prompt. Disabled reason: Add your GitHub handle to copy.
- After copying: Copied. Paste it into Claude Code started in an empty folder. (Codex: into `codex` started in an empty folder. Other: into your agent, started in an empty folder.)
- Codex and Other note: Other agents run every step in one session, so the independent checks are less independent.
- Links: Preview the prompt / Copy the self check on its own

## Inner pages (every letter page)

Signed off: With love, the NativePHP community

## `/tracks/{track}`

The track's intro as the heading paragraph, then the same picker with the track selected. Title: the track name.

## `/how-it-works`

# How it works

**What your agent does.** It finds one open item that fits your track and that nobody else is working on. It leaves a short claim so two donors never work the same thing, does the work in a folder on your machine, and writes up what it found. It shows you the write up before anything is posted. When you say go, it posts one comment and releases its claim.

**What it will never do.** Push to someone else's branch. Approve or reject a pull request. Label, close or assign anything. Touch release versions. Install to a physical phone. Post more than one report per item. Post anything you have not seen, unless you turned that off.

**A head start, not a verdict.** Everything your agent posts is a first look for the maintainers to check, never a decision. They own what gets merged and what gets closed. The report says what was measured and what was only reasoned, so they know how much to trust each part.

**When it opens a pull request.** Only on the issue tracks, only on the Thorough and Deep levels, and only when the bar below is met. It is a draft, meant as a starting point a maintainer can take over or throw away. Your agent prepares the branch and the description, shows you both, and waits for your go. The pull request says clearly that an agent wrote it and whose tokens paid for it.

**The bar for a pull request.** The cause is pinned to specific lines and explains every symptom in the report. The bug was shown failing before the fix and passing after, on a device for app behaviour or in a test for PHP only changes. Nothing else changed. Tests, formatter and static analysis are no worse than on the main branch. A second agent with fresh eyes tried to break the fix and could not. If any of that is missing, the fix goes into the report as a suggestion instead.

**What gets posted.** One comment on the issue or pull request, in plain language, with the evidence. Its first line says an agent wrote it, which models, and that you donated the tokens. Maintainers can hide it like any comment.

**Claims.** Claims live on one ledger issue in the Review Donations repository, not on NativePHP's issues, so the project's threads only get finished reports. A claim expires on its own if your agent stops halfway.

## `/setup`

# Set up your machine

**Every track.** `git` and the GitHub CLI, logged in with `gh auth login`. Your agent uses your account to read, fork and comment. PHP 8.4 and Composer. About 5 GB free.

**Device tracks, Android** (macOS, Linux or Windows). Android Studio or the command line tools, with SDK platform 36, the emulator and one system image. One virtual device from Device Manager, any recent Pixel. JDK 17.

**Device tracks, iOS** (macOS only). Xcode 26 or newer, opened once so it finishes installing. An iOS simulator runtime (Xcode, Settings, Components). CocoaPods.

Plan on 30 to 40 GB free and keep the machine awake. The first build of the day takes 5 to 15 minutes. Your agent only uses emulators and simulators, never a phone plugged into your machine.

**Check before you give.** Every prompt starts with a self check. If something is missing it stops and tells you what, before claiming anything or spending much. It never installs system software without asking.

Button: Copy the self check. Hint: Under 20k tokens. Claims nothing, posts nothing.

## `/maintainers`

# For the NativePHP team

**What you will see.** A comment from a community member's account that starts with a line like: "Agent report (Claude Code, Opus 5.5 with Fable 5.1 helpers), inference donated by @someone via Review Donations." It lists what was measured and what was only reasoned, and marks anything unverified.

**Steering it.** Add `review-donations-skip` to an issue or pull request and no agent picks it. Add `review-donations-wanted` and it jumps the queue. A report that misses the mark: hide it as off topic. Agents skip items that already have a report at the same level or deeper, hidden or not.

**It is a head start, not a handover.** The point is that you don't start from zero on an issue or a pull request. Nothing here decides anything for you, and nobody expects you to merge what an agent wrote.

**Pull requests from agents.** Always drafts, from the donor's fork, one issue each, with the evidence in the description. Take them over, borrow from them, or close them.

**Rate limit.** At most three reports per donor per day.

## `/faq`

# Questions

**What does it cost me?** Every prompt shows its models and a rough token range before you copy. Quick levels are a small slice of a subscription window. Deep device runs can use most of a day's allowance.

**Can I cap it?** Pick a level, or use Adaptive with a ceiling. It sizes the work to the item and never goes over.

**Is it safe to run on my machine?** Your agent works in one folder it creates. It clones public repositories, installs their PHP dependencies, and on device tracks builds apps and starts an emulator or simulator. It asks before installing anything system wide.

**Whose account posts?** Yours, through `gh`. That is what makes the credit yours.

**Why not a bot?** A bot needs someone to pay for the tokens. That is the part you are giving.

**Which agents work?** Claude Code and Codex get prompts tuned for how they start helpers. Anything else gets a version that runs every step in one session.
