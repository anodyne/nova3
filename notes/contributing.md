# Contributing

## Requirements

- All pull requests __must__ contain tests for the code you are checking in.
- All pull requests __must__ contain proper internationalization code and the necessary updates to the language files for the code you are checking in.
- Issues marked as requiring documentation __must__ have clear, concise documentation in Markdown format for the code you are checking in.
- All tests __must__ pass in order to have your pull request merged.
- All style checks __must__ pass in order to have your pull request merged.

If any of these items aren't complete, the pull request will be sent back.

## Recommendations

- Keep all work related to the feature you're working on in a feature branch. We find the easiest way to do that is with a branch name that's something like `feature/name-of-my-feature`.

## Others

- Do not make changes to the theme system without first talking to Anodyne.
- Do not make changes to the extension system without first talking to Anodyne.
- Do not make architectural changes without first talking to Anodyne.

## Examples

### Authorization

To handle authorization from a controller method, you can use Laravel's built-in `authorize` method.

```php
$this->authorize('manage', $permission);
$this->authorize('manage', Permission::class);
```

From a Blade file, you can use Laravel's built-in directives.

```
@can('manage', $permission)
	// Do something
@endcan

@cannot('manage', $permission)
	// Do something
@endcan
```

### Internationalization (I18n)
