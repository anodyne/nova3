---
name: filament-activitylog-pro
description: Use when working with Filament Activitylog Pro — installing or configuring it, its components, fields, inputs, columns, actions, widgets, or any of its APIs. Fetches the official, version-matched documentation so you write correct code instead of guessing.
---

# Filament Activitylog Pro documentation

The full Filament Activitylog Pro documentation is available to you as machine-readable Markdown. Consult it before writing or changing any code that uses this package — do not guess its API, class names, or configuration.

Docs base URL: `https://filamentplugins.com/filament-activitylog-pro/docs/v2/llm/`

## Workflow

> **The remote docs are ALWAYS the starting point for any Filament Activitylog Pro feature** — capability check, config option, API shape, or "how do I X". This holds even when the package source is available locally (e.g. symlinked into `vendor/`). Read the relevant `.md` page first; only drop to source to confirm a detail the docs leave ambiguous, never as the entry point.

1. **Fetch the index first.** Request `https://filamentplugins.com/filament-activitylog-pro/docs/v2/llm/llms.txt`. It lists every page, grouped by topic, each with a one-line description. It is small — read it before fetching anything else, and re-read it in the same task whenever you need another page.
2. **Pick the relevant pages from the links in `llms.txt`.** Only fetch paths that appear **literally** in the index — **never construct, infer, or guess a page path** (the group and slug are rarely what you'd assume). Don't fetch pages you do not need.
3. **Fetch each page as raw Markdown** using the exact URL from the index (each page link already ends in `.md`). Each page is fully assembled — it already includes its sub-sections, steps, and tabs.
4. **Apply what you read.** Match the documented APIs, class names, and configuration exactly.

**If a fetch returns 404, the path was wrong — go back and re-read `llms.txt`, then fetch the correct link.** Do not retry a guessed URL, and do not fall back to `llms-full.txt` just to recover a single page.

**Use `llms-full.txt` only as a last resort.** `https://filamentplugins.com/filament-activitylog-pro/docs/v2/llm/llms-full.txt` returns the entire documentation in one (large) request. Reach for it only when the index plus selective pages genuinely cannot answer the task — never to recover from a wrong path, and never as the default. The index plus a few `.md` pages is almost always the right, far cheaper approach.

The `llms.txt` preamble explains any package-specific Markdown directives (e.g. driver-specific content) you may encounter — read it.

## Efficiency

- Read `llms.txt` once per task and reuse it; do not re-fetch it for every page.
- Fetch only the pages you need.
- The raw `.md` is the source of truth — prefer it over the rendered HTML documentation site.
