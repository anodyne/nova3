# Toasts

Toasts are lightweight notifications designed to mimic the push notifications that have been popularized by mobile and desktop operating systems. They're built with flexbox, so they’re easy to align and position.

We have worked hard to ensure the both the JavaScript and PHP implementations of the toasts are nearly identical.

## Basic Toast

```js
this.$toast
    .message('Hello, world! This is an toast message.')
    .make();
```

```php
toast()->withMessage('Hello, world! This is an toast message.')
    ->make();
```

## Success Toast

```js
this.$toast
    .message('Hello, world! This is an toast message.')
    .success();
```

```php
toast()->withMessage('Hello, world! This is an toast message.')
    ->success();
```

## Error Toast

```js
this.$toast
    .message('Hello, world! This is an toast message.')
    .error();
```

```php
toast()->withMessage('Hello, world! This is an toast message.')
    ->error();
```

## Actionable Toast

In addition to showing simple messages, toasts can be actionable with a single button.

```js
this.$toast
    .actionText('OK')
    .message('Hello, world! This is an toast message.')
    .make();

this.$toast
    .action('https://google.com')
    .actionText('OK')
    .message('Hello, world! This is an toast message.')
    .make();
```

```php
toast()
    ->withActionLink('https://google.com')
    ->withActionText('OK')
    ->withMessage('Hello, world! This is an toast message.')
    ->error();
```

### Action Callback

By default, an actionable toast will simply close after 6 seconds unless the user clicks/taps on the action button. It's possible to specify custom actions when the action button is clicked/tapped.

```js
const actionFunction = () => {
    axios.post('https://api.example/do-something');
};

this.$toast
    .actionText('Notify')
    .action(actionFunction)
    .message('Do you want to notify the API?')
    .make();
```

**Note:** Actionable toasts can specify a callback function (JavaScript only) or a link.

## Redirecting with toasts

When redirecting, you can specify an additional `withToast` or `withErrorToast` method to setup a toast message for the next page.

```php
return redirect()
    ->route('roles.index')
    ->withToast('Hello, world! This is an toast message.');

return redirect()
    ->route('roles.index')
    ->withErrorToast('Hello, world! This is an toast message.');

return back()
    ->withToast('Hello, world! This is an toast message.');

return back()
    ->withErrorToast('Hello, world! This is an toast message.');
```

## Customizing Toasts

### Changing the position of toasts

In the HTML markup, toasts are injected into a toasts manager container. This container is used to position toasts on screen with flexbox. Changing the positioning of tosts is done by a combination of CSS properties on either the toasts manager container or the toast itself.

#### Toasts on the top

```css
.toasts {
    flex-direction: column;
}
```

#### Toasts on the bottom

```css
.toasts {
    flex-direction: column-reverse;
}
```

#### Toasts in the center of the screen

```css
.toast {
    align-self: center;
}
```

#### Toasts on the left of the screen

```css
.toast {
    align-self: flex-start;
}
```

#### Toasts on the right of the screen

```css
.toast {
    align-self: flex-end;
}
```

### Changing the entrance/exit animations

Toasts animate onto the screen using the [Animate.css](https://daneden.github.io/animate.css/) library. Because of the default position, if your theme changes the position of the toast, you may also want to change how the toasts animate onto the screen. For example, if you change the position of the toasts from the top center to the bottom right, you may want the toasts to slide in from the right side. You can simply replace the `animation-name` with a different animation from the library.

#### Entrance

```css
.toast-animated-enter-active {
    animation-name: flipInY;
}
```

#### Exit

```css
.toast-animated-leave-active {
    animation-name: flipOutY;
}
```