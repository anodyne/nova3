# Release Notes

## Preview Release 3

- We've moved away from the Entrust authorization library and replaced with a solution of our own that's backed by the built-in Laravel authorization component. Despite Laravel 5 being nearly a year old, Entrust is still relying on a beta release of Entrust for Laravel 5 support. Frankly, this didn't sit well with us. We want something that's being actively maintained in a stable state. Nothing has changed about authorization, it's just that it's now code we've written instead of someone else.
- Welcome VueJS! Over the last few months, we've kept our eye on a new Javascript framework called VueJS. Vue is a small, fast, simple, reactive framework that we're really excited to play around with in several different areas. Despite it being new, it's very mature and we think that you'll love it as much as we do when you get in there and start playing around with it!
	- The first thing we decided to tackle with Vue is filtering. Several pages utilized a fast and easy filtering system that was originally built on top of AngularJS. Unfortunately, Angular is a beast and the code involved with doing something fairly trivial was significant and not easy to maintain. We've dropped AngularJS in favor of Vue.The filtering functionality has been re-written with about half as much code and it's significantly more expressive and cleaner code.
	- We've dipped our toe in the water of Vue components. These simple and powerful pieces of code have allowed us to create more expressive code that makes it a little clearer what's happening when you look at the code. We've started small with components to hide and show content based on the device being used. Since components are used just like HTML tags, you'll see and be able to use tags like `<desktop>Content</desktop>` to only display things on a desktop-sized device. So far, the following components are available:
		- desktop-lg
		- desktop-sm
		- phone
		- tablet
		- desktop (includes desktop-sm and desktop-lg)
		- phone-tablet (includes phone and tablet)
		- tablet-desktop (includes tablet, desktop-sm, and desktop-lg)
- The Additional Page Content management page has been updated to show content that is __not__ a _header_, _title_, or _message_. The previous way of showing all that content created some confusion about what the difference between the Page Manager and Page Content Manager was. Now, only additional content will be shown to make it easier to understand what's going on.
- And speaking of the Content Manager, we've moved some items out of Settings and moved them into the Content Manager (like sim name). Since those are pieces of content and not true settings, we felt like the Content Manager was a better place for those things to live. Additionally, we've removed the settings page compiler and replaced with a content page compiler to pull items out of the content tables. It works the same as the old settings page compiler, so you'll be able to do things like `content:sim_name` to pull the sim name out of the Content Manager in page content.

## Preview Release 2

## Preview Release 1

This first preview release of Nova NextGen serves as a preview of the work being done on Nova 3. The "NextGen" moniker is simply a marketing term to differentiate between all the talk over the previous years about Nova 3 and what Nova 3 is actually becoming. We've laid out our vision for what Nova should be and this is the first step in that direction. There's very little here, but there's also a lot.

The next version of Nova is being built off the powerful and robust Laravel PHP framework. Out of the box though, Laravel has a structure that doesn't work well for Nova, so a lot of tweaks have been made to ensure that it works as expected while still being completely Laravel.

Next is a whole new and significantly clearer file structure that takes a lot of the guessing out of what goes where. From a first glance, you'll be able to know exactly what different directories are for without needing to know cryptic terms (who thought it was a good idea for themes to live in a directory called _views_ anyway?) or know the history of the application. Now, if you want to see your themes, look in your `themes` directory. Want to upload a new rank set? Throw it in `ranks` and be done with it.

Finally, we've spent a lot of time building out a smart installation process that will make your first experience with Nova a breeze. Nova can detect almomst every issue it could run in to and will even tell you if there are potential problems. On top that, we've provided significantly more explanation about what's happening and even expanded the database and email options available from day 1.

Check out this first preview of Nova 3 and be sure to let us know what you think!
