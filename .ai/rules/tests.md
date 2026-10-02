---
paths:
  - 'tests/**'
---

# Tests

## Keep the custom test bootstrap cache-aware and HTTP requests isolated
Tests/CreatesApplication.php uses nova/bootstrap/app.php rather than Laravel's default bootstrap. Apply cached configuration before kernel bootstrap and cached routes in an application booting callback, matching Laravel's TestCase lifecycle. Parallel testing also reuses this trait on an anonymous helper, so keep trait-discovery state in a local variable rather than assuming the helper has TestCase properties. Shared HTTP fakes must use the configured Anodyne latest-version and next-version URLs; prevent stray requests so outdated fakes cannot silently reach the network.

## Spotlight commands accumulate across test application boots
wire-elements/spotlight 2.0.4 stores registrations in the public static Spotlight::$commands array. Nova's DomainServiceProvider appends the same 57 commands on every application boot, and Laravel's test teardown does not clear this third-party registry. Every admin layout renders Spotlight and reevaluates each command's authorization, so later tests accumulate thousands of duplicate permission queries. Isolate this registry before bootstrapping each test application; clearing it after providers boot would remove the current application's real commands. A controlled 27-test sample grew from 57 to 1539 registrations without isolation, while a temporary pre-bootstrap reset held it at 57.
