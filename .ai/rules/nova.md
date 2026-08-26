---
paths:
  - 'nova/**/*.php'
---

# Nova

## Treat Nova model identifiers as UUID strings
Nova's base model uses HasUuids, so model primary keys and foreign keys passed through application code are strings. Keep legacy Nova 2 source IDs as integers only at migration boundaries, and map them to string new_id UUIDs.
