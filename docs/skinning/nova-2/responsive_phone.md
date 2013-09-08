# Responsive Design - Mobile Phones

It seems that just about everyone has a smartphone today. In fact, some statistics indicate that within a few years, a majority of people will access the Internet from a mobile device than from a computer. Because of this fact, we felt it was imperative that Nova be able to scale from mobile phone to desktop seamlessly.

## Targeting Mobile Phones for your Skins

If you want to hide something from being seen on a mobile phone, you can use the `hidden-xs` class. If you want to show something just on a mobile phone, you can use the `visible-xs` class.

Bootstrap's grid system also has triggers for creating columns on a mobile phone. In most cases, you'll want to avoid creating too many columns because of the constrained space on a mobile phone's screen. To create a column on a mobile phone, use the `col-xs-*` classes.

<pre>&lt;div class="row">
	&lt;div class="col-xs-6">&lt;/div>
	&lt;div class="col-xs-6">&lt;/div>
&lt;/div>

&lt;div class="row">
	&lt;div class="col-xs-12">&lt;/div>
&lt;/div></pre>

## Phone-Specific Changes in Nova 3

- When creating or editing an access role, the task list is handled differently on mobile phones to provide a better user experience for admins. Instead of a long list of checkboxes, the task checkboxes are hidden inside accordions to provide a more concise layout.
- In most cases, when we have a table with buttons, we display the buttons slightly differently to make it easier to tap on the button itself.
- Nova's styles make form buttons larger to make it easier to tap on the button.
- Upload areas are hidden on a mobile phone.