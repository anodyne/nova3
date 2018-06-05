# Badges

```html
<span class="badge">2 days ago</span>
```

Badges can come in one of four different states: default, error, primary, or success. (By default that means colors of grey, red, blue and green respectively.) Internally, we use the appropriate CSS variables, so your theme's version of error could be orange instead of red while your primary is green and your success is blue.

__Note:__ The only "gotcha" about styling badges is that we don't use a traditional border. Because of the small size, on some displays, a border sometimes look pixelated and choppy. To solve this issue, we use an inset box shadow to create the border. Since the box shadow still uses the CSS variables, changes to your CSS variables will still change the color of the pseudo-border.

## Primary Badge

```html
<span class="badge is-primary">Primary</span>
```

## Error Badge

```html
<span class="badge is-error">Error</span>
```

## Success Badge

```html
<span class="badge is-success">Success</span>
```

## Actionable Badge

Actionable badges are simple `a` tags that have a class of `badge` on them. You can use any of the modifiers above to create actionable badges of different contexts.

```html
<a href="#" class="badge">Actionable Badge</a>
```
