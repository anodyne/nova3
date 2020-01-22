# Dropdown

Dropdowns are custom Vue components designed to replace `select` menus.

## Props

| Prop | Type | Default | Notes |
|---|---|---|---|
| `placement` | `string` | `bottom-start` | Available options are bottom-start, bottom-end, top-start, top-end. |

## Slots

| Slot Name | Props | Notes |
|---|---|---|---|
| `(default)` |  | Slot for the dropdown trigger. |
| `dropdown` | `{ toggle }` | Slot for the dropdown panel. Injects the toggle method. |

## Example

```html
<dropdown>
    Dropdown

    <template #dropdown="{ dropdownProps }">
        <a href="#" class="dropdown-link">Link One</a>
        <a href="#" class="dropdown-link">Link Two</a>
        <a href="#" class="dropdown-link">Link Three</a>

        <div class="dropdown-divider"></div>

        <div class="dropdown-text">
            This is a content area for any content we want.
        </div>
    </template>
</dropdown>
```

## Styling

The final HTML output of the component will be something along these lines:

```html
<div class="dropdown-wrapper">
    <div class="dropdown-overlay"></div>

    <button type="button" class="dropdown-trigger">
        Dropdown
    </button>

    <div class="dropdown-panel dropdown-bottom-start">
        <a href="#" class="dropdown-link">Dropdown link</a>

        <div class="dropdown-divider"></div>

        <div class="dropdown-text">
            Dropdown text
        </div>
    </div>
</div>
```

*In addition, there are individual classes for `dropdown-bottom-end`, `dropdown-top-start`, and `dropdown-top-end` to handle positioning. In reality, those classes shouldn't need to be modified.*