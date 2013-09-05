# Responsive Design - Tablets

Whether it's a small tablet or a larger tablet, these mobile devices offer unique challenges for skin developers. You can choose to present the full site to those users or design something that works better for tablets using responsive design. In most cases, we've taken a hybrid approach, displaying things only slightly different for tablet users.

## Targeting Tablets for your Skins

If you want to hide something from being seen on a tablet, you can use the `hidden-sm` class. If you want to show something just on a tablet, you can use the `visible-sm` class.

Bootstrap's grid system also has triggers for creating columns on a tablet. To create a column on a tablet, use the `col-sm-*` classes.

<pre>&lt;div class="row">
	&lt;div class="col-sm-4">&lt;/div>
	&lt;div class="col-sm-4">&lt;/div>
	&lt;div class="col-sm-4">&lt;/div>
&lt;/div>

&lt;div class="row">
	&lt;div class="col-sm-6">&lt;/div>
	&lt;div class="col-sm-6">&lt;/div>
&lt;/div>

&lt;div class="row">
	&lt;div class="col-sm-12">&lt;/div>
&lt;/div></pre>

## Tablet-Specific Styles in Nova 3

- Upload areas are hidden on a tablet.