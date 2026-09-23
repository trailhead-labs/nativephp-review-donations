## Pick an item

If `SPECIFIC_ITEM` is set, use it, check it against the filters below, and tell the donor if it fails one (then stop, do not substitute another item). Otherwise, pick one.

@if ($agent === 'claude')
Do the listing and filtering with a {{ $models['scout'] }} subagent to keep your own context small. Give it this section and have it return the ordered candidate list with one line of reasoning per item.
@endif

### Candidates

Issue tracks:

```
gh search issues --repo NativePHP/mobile-air --state open --limit 100 \
  --json number,title,labels,updatedAt,author,assignees,url \
  -- "-linked:pr -label:wontfix -label:invalid -label:duplicate -label:question -label:review-donations-skip no:assignee"
```

PR tracks:

```
for r in NativePHP/mobile-air NativePHP/mobile-ui; do
  gh pr list --repo "$r" --state open --limit 100 --search "draft:false -label:review-donations-skip" \
    --json number,title,labels,updatedAt,author,headRefName,baseRefName,url,isCrossRepository
done
```

### Filters

Drop a candidate if any of these is true. Check with commands, not by reading titles.

1. **Already reported.** A comment on it contains `<!-- review-donations:report` with the same `track=` and a level at or above yours (quick < thorough < deep).
   `gh api repos/{repo}/issues/{n}/comments --paginate --jq '.[].body' | grep -o '<!-- review-donations:report[^>]*-->'`
2. **Claimed.** The ledger has an unexpired claim for the same item and track (see Claim).
3. **Someone is on it.** A comment from a member, owner or collaborator (`author_association` of `MEMBER`, `OWNER` or `COLLABORATOR`) in the last 7 days, unless the item has the label `review-donations-wanted`.
4. **In flux.** PR tracks: the PR was updated in the last hour.
5. **Yours.** Authored by `DONOR_GITHUB`.
6. **Wrong platform.** Prove tracks: the item is about a platform not in `PLATFORMS`. Read the body and labels; "iOS" in the title, a Swift file in the diff, or an iOS only debug output counts.
7. **Not a bug.** Issue tracks: it reads as a feature request, a support question, or a discussion. Prefer `bug` and `needs testing`.
8. **Donor rate limit.** If `DONOR_GITHUB` has posted three or more `review-donations:report` markers in the last 24 hours, stop and tell the donor: that is the daily cap, so maintainers are not flooded.
   `gh search issues --commenter @{{donor.handle}} --updated ">=$(date -u -v-1d +%Y-%m-%d 2>/dev/null || date -u -d yesterday +%Y-%m-%d)" --repo NativePHP/mobile-air --repo NativePHP/mobile-ui --json url`, then count markers in those threads authored by the donor.

### Order

1. Labelled `review-donations-wanted`.
2. Labelled `high-priority`.
3. Oldest last activity first.

Other donors may be starting at the same moment with the same list. So do not always take the first candidate: pick one at random from the first five, and go to Claim. If the claim race is lost, pick at random from the rest of those five, then continue down the list.
