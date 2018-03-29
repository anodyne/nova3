# Forms

## Text Fields

## Text Areas

## Select Menus

## Checkboxes

Nova includes a library to generate much nicer checkboxes that can be styled to match Nova's themes. The downside is that it requires a lot of HTML markup to accomplish that. To avoid having to constantly write out verbose HTML though, we've wrapped all that up into a simple component that makes life significantly easier!

```
<toggle type="checkbox" name="field1" value="foo">
	<label slot="label">Checkbox</label>
</toggle>
```

Just give the component the type, the name of the field, and the value you want it to have when it's checked. You can also supply it with the label for the checkbox as well. That component will spit out exactly what you need to display gorgeous checkboxes without any hassle.

## Radio Buttons

The same component that we use for checkboxes can also be used for radio buttons.

```
<toggle type="radio" name="field2" value="one">
	<label slot="label">One</label>
</toggle>

<toggle type="radio" name="field2" value="two">
	<label slot="label">Two</label>
</toggle>
```

## Toggle Switches

You guessed it, we're able to use the `toggle` component for toggle switches too!

```
<toggle type="switch" name="field3" value="yes">
	<label slot="label">Active</label>
</toggle>
```

## Form Groups