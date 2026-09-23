## Claim it

Claims live on one public ledger issue, `LEDGER`, so NativePHP's threads only receive finished reports. No database is involved: the claim is a comment with a hidden marker, and the oldest claim wins.

### Expiry for your level

| | Quick | Thorough | Deep |
|---|---|---|---|
| Reason tracks | 1 hour | 2 hours | 4 hours |
| Prove tracks | 3 hours | 6 hours | 12 hours |

Adaptive: use the expiry of the level you choose.

### Steps

1. Read the last day of ledger comments:

   ```
   SINCE=$(date -u -v-1d +%Y-%m-%dT%H:%M:%SZ 2>/dev/null || date -u -d '1 day ago' +%Y-%m-%dT%H:%M:%SZ)
   gh api "repos/{ledger_repo}/issues/{ledger_number}/comments?since=$SINCE" --paginate \
     --jq '.[] | {id, body}'
   ```

   A claim is **live** if its marker has `state=live` (or no `state`), the same `repo`, `item` and `track` as yours, and `expires` is in the future.

2. If there is a live claim for your candidate, go back to Pick and take the next one.

3. Post your claim:

   ```
   gh api repos/{ledger_repo}/issues/{ledger_number}/comments -f body="$(cat <<'EOF'
   <!-- review-donations:claim v1 state=live repo={repo} item={n} track={track} level={level} donor=@{{donor.handle}} expires={iso_utc} -->
   Claiming {repo}#{n} for {track}, {level}. Expires {hh:mm} UTC.
   EOF
   )" --jq .id
   ```

   Keep the returned comment id.

4. Wait 20 seconds, then read the ledger again (step 1). If another live claim for the same item and track has a **lower comment id** than yours, you lost: delete your comment (`gh api -X DELETE repos/{ledger_repo}/issues/comments/{id}`) and go back to Pick. GitHub hands out ids in creation order, so the lowest id is the earliest claim and every agent reaches the same answer.

5. If you lose five times in a row, stop and tell the donor the pool looks busy. Each lost race only costs a few API calls, so keep trying until then.

### Release

When you finish or stop, edit your claim so the item frees up at once instead of at expiry:

```
gh api -X PATCH repos/{ledger_repo}/issues/comments/{id} -f body="$(cat <<'EOF'
<!-- review-donations:claim v1 state=released repo={repo} item={n} track={track} level={level} donor=@{{donor.handle}} -->
Released {repo}#{n} ({outcome}).
EOF
)"
```

### If there is no ledger

If `LEDGER` is empty, post the same claim marker as a comment on the item itself, run the same lowest id tiebreak against the item's comments, and delete your claim comment when you post the report (your report replaces it).
