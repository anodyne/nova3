---
paths:
  - '**/*'
---

# General

## Use Bun for JavaScript tooling
Use Bun exclusively for JavaScript dependency management and package scripts. Commit bun.lock, do not create package-lock.json, and use bun install, bun add, bunx, and bun run instead of npm/npx/yarn/pnpm commands.
