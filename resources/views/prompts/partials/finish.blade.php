## Finish

1. **Recheck the item** right before posting. If it was closed, got a linked PR, or a member, owner or collaborator commented since you claimed it, read what changed. If your report is now moot, do not post; release the claim with outcome `superseded` and tell the donor. If it still adds something, adjust it to acknowledge what changed.

2. **Self review.** Read `report.md` back once against the Voice rules and the evidence rules. Every claim marked. No em dashes. No absolute paths. Under 300 words unless the evidence needs more. Fix what you find.

3. **Show the donor.** Print the report exactly as it will be posted, plus where it will go. If `POST_MODE` is `confirm`, wait for a yes. If they ask for changes, make them and show it again. If `POST_MODE` is `unattended`, post it.

4. **Post:**

   ```
   gh issue comment {n} --repo {repo} --body-file report.md     # issues
   gh pr comment {n} --repo {repo} --body-file report.md        # PRs
   ```

   If posting fails, tell the donor and stop. Do not retry in a loop.

5. **Release the claim** (Claim, Release) with the outcome.

6. **Clean up the machine.** Uninstall the test app from the emulator or simulator and shut them down. Delete any throwaway keystore. Keep the item folder so the donor can inspect it; tell them it can be deleted with `rm -rf ~/nativephp-donation/{repo_short}-{n}`.

7. **Tell the donor**, in three or four lines: which item, what you found, the link to your comment (and PR, if any), and roughly how much work it took. Thank them once.
