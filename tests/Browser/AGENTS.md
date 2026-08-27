# Browser Tests (Pest Browser v4)

Tests in this directory drive a real browser. `Pest.php` already extends `TestCase` with `RefreshDatabase` and `CreatesTestUsers` for this directory.

Run: `php vendor/bin/pest tests/Browser/` (via Herd's PHP).

Browser tests are not as cheap as unit/feature tests. We should be mindful when creating a browser test. It's preferable to combine assertions into existing tests than writing new browser tests for every little feature/fix.

## Required seed data

Most browser tests need: School, SchoolYear (active), Student, User (with `student_id`), teacher User, origin/destination Locations, Grade (matching student ordinal), `GradeFacilities` per facility type, `staff_routing_rules` for service types, and Spatie role/permissions (e.g. `pass:request`, `visit:create`).

## Gotchas

- **Never use a bare `->wait(seconds)`.** A fixed sleep is both slow (it always waits the full time) and flaky (the interval can be too short on a loaded CI runner). Always wait on a concrete signal that the action actually completed, then assert. Pick the signal that proves the thing you're about to assert:

    ```php
    // ❌ flaky + slow — waits a fixed 2s and hopes the write landed
    ->press('Submit Request')
    ->wait(2);

    // ✅ wait on the success signal (e.g. the onSuccess toast), then assert
    ->press('Submit Request')
    ->waitForText('Office visit request submitted');
    ```

    Common signals: a success toast (`->waitForText('Meeting ended')`), a dialog closing or item leaving a list (`->assertDontSee('Send Recall')` / `->assertDontSee('Moore, Casey')` — these auto-wait for absence), a navigation (`->waitForLocation('/path')`), or an element appearing. When the assertion that follows is `assertSee`/`assertDontSee`, that assertion already auto-waits, so no separate wait is needed. This rule is enforced by `tests/Arch/BrowserWaitsTest.php`; if there is genuinely no observable condition, add the file to that test's allowlist with a comment explaining why.
