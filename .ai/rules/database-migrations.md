---
paths:
  - 'nova/database/migrations/**/*.php'
---

# Database Migrations

- Migrations are forward-only. Never write a `down()` method; remove it when an Artisan-generated stub includes one.
- Never configure cascading deletes or updates. Do not use `cascadeOnDelete()`, `cascadeOnUpdate()`, `onDelete()`, or `onUpdate()`.
- Always constrain foreign ID columns with `constrained()`.
- Never use `foreignIdFor()`. Models must not be referenced or imported in migration files; declare the foreign ID column explicitly with `foreignId()`.
- Never define database defaults with `default()` in migrations. Set initial values explicitly in application code instead.

## Do not test migrations
Do not create or run automated tests for migration files. Verify migrations with formatting and static checks only.
