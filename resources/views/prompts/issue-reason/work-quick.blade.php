This level is one focused pass by you alone, no helpers. The goal is a diagnosis a maintainer can check in two minutes: what is going on and where in the code. You do not follow external links, check versions, run tests or propose a PR at this level; list those under "Not measured" so the next donor knows what is left.

1. Step 0, the self check (Preamble).
2. Pick an issue (Pick). Issue track.
3. Claim it (Claim). Expiry 1 hour.
4. Read the issue and every comment (Read the item properly, point 1 only).
5. Clone the repo shallowly into the item folder: `git clone --depth 50 https://github.com/NativePHP/{repo}.git`. No Composer install.
6. Find the code path. Search for the element, command, class or message named in the issue with `rg`. Read the files you find; follow calls one or two levels deep. Read `native-facts` before reasoning about the bridge, plugins or routing.
7. Form one diagnosis. It must say where (file and line) and why (the mechanism), and account for the symptom in the report. If two explanations fit equally, give both and say what would tell them apart.
8. Everything in your diagnosis is **reasoned** at this level, unless you ran something. Mark it so.
9. Write the report with the "Issue, diagnosis" template (Report). Outcome `diagnosed`, or `inconclusive` if the code does not explain the report.
10. Finish.
