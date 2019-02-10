# Alerts

Alerts are simple messages to inform the user of things happening with the system.

There are 3 types of alerts: default, success, and danger.

## Actionable Alerts

In addition to showing simple messages, alerts can be actionable with a single button.

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

**Note:** Actionable alerts can only specify a callback function when called from Javascript.

## Customizing Alerts