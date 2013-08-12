# Responsive Design

At the heart of Nova 3's design philosophy is an approach called _responsive design._

In the simplest terms, responsive design aims to create sites that provide the best possible viewing experience across a wide range of devices (everything from a desktop computer to a mobile phone). That means the same markup is used regardless of the device you're viewing the page on, but the stylesheets involved dictate how things are laid out depending on the device you're using.

Given the fact that more and more people are using Nova from phones and tablets, we felt it was imperative that Nova 3 be as easy to use on a wide array of devices as possible. Using responsive design techniques, we've been able to create a better experience for users, regardless of how they're viewing Nova.

## Bootstrap 3

At the heart of Nova 3 design architecture is the Bootstrap toolkit. In previous versions of Nova, we've used Bootstrap to help handle more complex user interactions (tooltips, popovers, etc), but start with Nova 3, we rely much more heavily on Bootstrap and even pull in the entire toolkit. From the ground up, all of Anodyne's skins for Nova 3 use Bootstrap.

You aren't required to use the Bootstrap grid system for your template files. If there's another toolkit you'd rather use or if you want to roll your own grid system, you're welcome to do so. Despite that though, the core view files use many of Bootstrap's components, including the grid system.

For more information about Bootstrap and how to use it, please see their [http://getbootstrap.com](documentation).

### Bootstrap Components in Nova 3

Nova 3 makes extensive use of many of Bootstrap's components. Below is a list of what Nova 3 uses:

- Tabs and pills
- Tooltips
- Popovers
- Modal dialogs
- Alerts
- Dropdowns
- Buttons
- Collapse functionality
- Navigation
- Media objects
- Image styles
- Grid
- Thumbnails

### Mobile First

Starting with version 3 of Bootstrap, the framework has taken a "mobile first" approach. This means that everything is designed to work on a phone first, then scale up to a tablet, then finally scale up again to a desktop. Nova 3 has embraced this philosophy. Every page in the system has been tested on phone, tablet and desktop resolutions to ensure everything works at different screen sizes.

## Targeting Specific Devices

Because of the very nature of responsive design, it's possible for you to target specific types of devices and make changes just for those devices. The pages below will show you how to target mobile phones, tablets and desktop computers to ensure your skin works flawlessly on all devices.

## Icon Fonts

Another major shift when it comes to design is the removal of as many images as possible. Given the varying pixel densities of different screens, using images can be messy and provide a less than optimal experience for users. No one wants to see pixelated and blurry images and accounting for that everywhere would create bloated code. Instead, we've chosen to drop images from as many places as possible. In their stead, we use icon fonts.

An icon font is just what it sounds like: a font made up of icons. The advantage to using an icon font is that it will scale seamlessly based on text size. Instead of needing a 16 pixel image and 32 pixel image (for scaling up on high density displays), using an icon font, the icon remains crisp and sharp no matter what the density of the screen is.

Icon fonts can be a little trickier to start using, but once you start using them, you'll quickly see the benefit to them. Nova 3 ships with a wide array of options and using the icon index feature, you can change what icon font is used. The entire icon array is available in any view file or Javascript view file in Nova 3 and you can access the font quite simply:

`<a href="#" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>`