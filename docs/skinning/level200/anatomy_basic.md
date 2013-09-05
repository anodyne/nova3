# Anatomy of a Nova Skin

Skinning has undergone radical changes since the first version of SMS arrived in 2005. Gone are the image-based skins, opting instead to use HTML and CSS instead. With Nova, the idea of breaking skins into sections gave skin developers more granular control over how specific sections were styled. With that control came several headaches though. For Nova 3, we've gone back to the drawing board to come up with a skinning system that offers flexibility and simplicity.

At first glance, Nova 3's skin folders look empty. Gone are individual sections. Instead, the majority of the system uses the same styles. This eliminates the need to do all your work only to have to duplicate it and tweak it for the admin and wiki sections.

Nova 3 skins take full advantage of the cascading part of CSS.

Let's dive in and take a look at some of the basics around a Nova skin.

## The design folder

The majority of work you do on a skin will be in the design folder. As its name implies, the design folder is where all of the skin's design elements will live. If you have images you want to use for your skin, you can create an images folder, but if you don't have any images, it isn't required to be there.

So how do you make changes to Nova?

### Custom.css

The simplest and most straightforward way to make changes is through the `custom.css` stylesheet. Since Nova 3's base style is defined in the core, your skins will always work when you start them (though they'll look like the vanilla Bootstrap 3 theme). In order to change something, you simply need to style the element you want to change. Your changes, which are loaded after the core styles, will override whatever is coming out of the core.

### Style.css

Sometimes, you may want to do something really crazy and out there. In those instances, you can actually create a `style.css` stylesheet and start from scratch. If you do this, the default Bootstrap 3 styles _will not_ be loaded. You'll have a lot of work to do, but it gives you total control over your skin at that point.

### Admin and login changes

Much the same as with the `custom.css` and `style.css` files, you can do the same thing with login and admin sections as well. If you want to make changes to the login pages, you can create a file called `custom.login.css` and, of course, you can start with a blank slate by creating a file called `style.login.css`. The same rules apply for the admin section as well, you'll simply create files named `custom.admin.css` and `style.admin.css`.

## The components folder