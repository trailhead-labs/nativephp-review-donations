## Read the item properly

Most wrong reports come from reading half the story. Before touching code:

1. **The whole thread.** Body, every comment, every review and every inline review comment.

   ```
   gh issue view {n} --repo {repo} --comments
   gh pr view {n} --repo {repo} --comments
   gh api repos/{repo}/pulls/{n}/reviews --jq '.[] | "[\(.user.login) \(.state)] \(.body)"'
   gh api repos/{repo}/pulls/{n}/comments --jq '.[] | "\(.path):\(.line // .original_line) \(.user.login): \(.body)"'
   ```

2. **Follow every link.** Linked issues, linked PRs, companion PRs in the other repo, and especially reporter repositories. Fetch the files they point at (`gh api repos/{o}/{r}/contents/{path} --jq .content | base64 -d`, or raw.githubusercontent.com). A report's own code often tells a different story than its prose: a routing file, a layout class copied unchanged from the docs, a missing plugin in the debug output.

3. **Versions.** Note the reporter's package version from the debug output. Find the repo's real default branch (never assume it): `gh repo view {repo} --json defaultBranchRef --jq .defaultBranchRef.name`. Find which tags contain what. A bug reported on 4.2 may already be fixed on the default branch.

4. **Already fixed?** Search merged PRs and recent commits on the default branch for the symptom and the files involved:

   ```
   gh search prs --repo {repo} --merged "{keywords}" --limit 10
   git log --oneline origin/{default}..upstream/{default} -- {paths}   # once cloned
   ```

   If it is fixed on the default branch, the report is short: which commit, and that the reporter should update.

5. **Overlap.** Open PRs that touch the same files or mention the issue number. On PR tracks, also closed PRs for the same issue (a rejected earlier attempt explains a lot).

6. **Project skills.** Once cloned (Workspace), read the skills shipped in mobile-air that apply: `resources/boost/skills/nativephp-mobile/SKILL.md` for app side usage and EDGE components, `resources/boost/skills/nativephp-v3-to-v4-upgrade/SKILL.md` for anything upgrade related, `resources/boost/skills/nativephp-webview-to-native/SKILL.md` for webview versus native screens. Read `native-facts` below before reasoning about plugins or the bridge.

Write what you learned to `~/nativephp-donation/{repo_short}-{n}/context.md`: the claim being made, the reporter's environment, links followed and what they showed, version and already-fixed findings, overlapping work. Subagents get this file.
