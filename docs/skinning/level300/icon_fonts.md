# Icon Fonts

Another major shift when it comes to design is the removal of as many images as possible. Given the varying pixel densities of different screens, using images can be messy and provide a less than optimal experience for users. No one wants to see pixelated and blurry images and accounting for that everywhere would create bloated code. Instead, we've chosen to drop images from as many places as possible. In their stead, we use icon fonts.

An icon font is just what it sounds like: a font made up of icons. The advantage to using an icon font is that it will scale seamlessly based on text size. Instead of needing a 16 pixel image and 32 pixel image (for scaling up on high density displays), using an icon font, the icon remains crisp and sharp no matter what the pixel density of the screen is.

Icon fonts can be a little trickier to start using, but once you start using them, you'll quickly see the benefit to them. Nova 3 ships with a wide array of options and using the icon index feature, you can change what icon font is used. The entire icon array is available in any view file or Javascript view file in Nova 3 and you can access the font quite simply:

<pre>&lt;a href="#" class="btn btn-success icn-size-16">{{ $_icons['add'] }}&lt;/a></pre>