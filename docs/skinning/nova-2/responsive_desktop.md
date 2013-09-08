# Responsive Design - Desktop Computers

Desktops and laptops may be less and less appealing to some users, but they haven't gone the way of the dinosaurs just yet. Nova 3 has still been tested to take full advantage of the larger desktop screens. In fact, we can actually differentiate between large desktop screens and normal desktop screens.

## Targeting Desktop Computers for your Skins

If you want to hide something from being seen on a desktop, you can use the `hidden-lg` class to hide it from large screens or the `hidden-md` class to hide it from normal screens. If you want to show something just on a desktop, you can use the `visible-lg` class to show it on large screens or the `visible-md` class to show it on normal screens.

Bootstrap's grid system also has triggers for creating columns on a desktop. To create a column on a desktop, use the `col-lg-*` classes for large desktop displays and `col-md-*` for medium desktop displays.

<pre>&lt;div class="row">
	&lt;div class="col-md-6 col-lg-6">&lt;/div>
	&lt;div class="col-md-6 col-lg-6">&lt;/div>
&lt;/div>

&lt;div class="row">
	&lt;div class="col-md-12 col-lg-12">&lt;/div>
&lt;/div></pre>

## Large Desktop-Specific Styles in Nova 3

## Normal Desktop-Specific Styles in Nova 3

- On user bios, the user avatar is scaled down to fit into the columns properly.