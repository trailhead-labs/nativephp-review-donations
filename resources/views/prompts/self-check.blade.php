# Review Donations: check my setup

You are checking whether this machine is ready to donate work to NativePHP through Review Donations. Do not clone anything, claim anything or post anything. Only run the commands below and report.

```
TRACKS    = @{{donor.tracks}}       # which tracks the donor wants to run
PLATFORMS = @{{donor.platforms}}
```

@include('prompts.partials.self-check-step')

Finish with a table: each requirement, found or missing, and the version where relevant. Then one line per track in `TRACKS`: ready, ready for one platform only, or not ready, with the first thing to fix. For anything missing, link the setup page ({{ $siteUrl }}/setup). Do not install anything.
