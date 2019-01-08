# Forms

## Field Wrapper Component

Nova uses a special HTML tag created by a Vue component. The `field-wrapper` component is meant to wrap up all of the markup needed for a form field so that developers don't have to worry about what the correct markup is. This also allows us to continually update forms without the need for your HTML to be updated to get those changes.

```html
<field-wrapper
    label="Name"
    field-id="name"
    error="{{ $errors->first('name') }}"
>
    <input type="text" name="name" id="name" class="field">
</field-wrapper>
```