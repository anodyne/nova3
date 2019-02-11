# Alerts

Alerts are lightweight notifications designed to mimic the push notifications that have been popularized by mobile and desktop operating systems. They're built with flexbox, so they’re easy to align and position.

We have worked hard to ensure the both the Javascript and PHP implementations of the alerts are nearly identical.

## Basic Alert

```js
Nova.alert()
    .withMessage('Hello, world! This is an alert message.')
    .make();
```

```php
alert()
    ->withMessage('Hello, world! This is an alert message.')
    ->make();
```

## Success Alert

```js
Nova.alert()
    .withMessage('Hello, world! This is an alert message.')
    .success();
```

```php
alert()
    ->withMessage('Hello, world! This is an alert message.')
    ->success();
```

## Error Alert

```js
Nova.alert()
    .withMessage('Hello, world! This is an alert message.')
    .error();
```

```php
alert()
    ->withMessage('Hello, world! This is an alert message.')
    ->error();
```

## Actionable Alert

In addition to showing simple messages, alerts can be actionable with a single button.

```js
Nova.alert()
    .withActionText('OK')
    .withMessage('Hello, world! This is an alert message.')
    .make();

Nova.alert()
    .withAction('https://google.com')
    .withActionText('OK')
    .withMessage('Hello, world! This is an alert message.')
    .make();
```

```php
alert()
    ->withActionLink('https://google.com')
    ->withActionText('OK')
    ->withMessage('Hello, world! This is an alert message.')
    ->error();
```

### Action Callback

By default, an actionable alert will simply close after 6 seconds unless the user clicks/taps on the action button. It's possible to specify custom actions when the action button is clicked/tapped.

```js
const actionFunction = () => {
    Nova.request().post('https://api.example/do-something');
};

Nova.alert()
    .withActionText('Notify')
    .withAction(actionFunction)
    .withMessage('Do you want to notify the API?')
    .make();
```

**Note:** Actionable alerts can specify a callback function (Javascript only) or a link.

## Customizing Alerts

### Changing the position of alerts

In the HTML markup, alerts are injected into a notices container. This container is used to position alerts on screen with flexbox. Changing the positioning of alerts is done by a combination of CSS properties on either the notices container or the alert itself.

#### Alerts on the top

```css
.notices {
    flex-direction: column;
}
```

#### Alerts on the bottom

```css
.notices {
    flex-direction: column-reverse;
}
```

#### Alerts in the center of the screen

```css
.alert {
    align-self: center;
}
```

#### Alerts on the left of the screen

```css
.alert {
    align-self: flex-start;
}
```

#### Alerts on the right of the screen

```css
.alert {
    align-self: flex-end;
}
```

### Changing the entrance/exit animations

Alerts animate onto the screen using the [Animate.css](https://daneden.github.io/animate.css/) library. Because of the default position, if your theme changes the position of the alert, you may also want to change how the alerts animate onto the screen. For example, if you change the position of the alerts from the top center to the bottom right, you may want the alerts to slide in from the right side. You can simply replace the `animation-name` with a different animation from the library.

#### Entrance

```css
.alert-animated-enter-active {
    animation-name: flipInY;
}
```

#### Exit

```css
.alert-animated-leave-active {
    animation-name: flipOutY;
}
```