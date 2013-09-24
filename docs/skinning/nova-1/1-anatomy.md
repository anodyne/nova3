# Anatomy of a Nova Skin

Skinning has undergone radical changes since the first version of SMS arrived in 2005. Gone are the image-based skins, opting instead to use HTML and CSS instead. With Nova, the idea of breaking skins into sections gave skin developers more granular control over how specific sections were styled. With that control came several headaches though. For Nova 3, we've gone back to the drawing board to come up with a skinning system that offers both flexibility and simplicity.

At first glance, Nova 3's skin folders look empty compared to previous versions. Gone are individual sections. Instead, the majority of the system uses the same styles and it's up to you to make only the changes you want to your skin. This system eliminates the need to do all your work in one section only to have to duplicate it and tweak it for the admin and wiki sections.

Nova 3 skins take full advantage of the _cascading_ part of CSS. Let's dive in and take a look at some of the basics around a Nova skin.

## The design folder

The majority of work you do on a skin will be in the `design` folder. As its name implies, the `design` folder is where all of the skin's design elements will live. If you have images you want to use for your skin, you can create an images folder, but if you don't have any images, it isn't required to be there.

So how do you make changes to Nova?

### Custom.css

The simplest and most straightforward way to make changes is through the `custom.css` stylesheet. Since Nova 3's base style is defined in the core, your skins will always work when you start them (though they'll look like the vanilla Bootstrap 3 theme). In order to change something, you simply need to style the element you want to change. Your changes, which are loaded after the core styles, will override whatever is coming out of the core.

### Style.css

Sometimes, you may want to do something really crazy and out there. In those instances, you can actually create a `style.css` stylesheet and start from scratch. If you do this, the default Bootstrap 3 styles _will not_ be loaded. You'll have a lot of work to do, but it gives you total control over your skin at that point.

### Admin and login changes

Much the same as with the `custom.css` and `style.css` files, you can do the same thing with login and admin sections as well. If you want to make changes to the login pages, you can create a file called `custom.login.css` and, of course, you can start with a blank slate by creating a file called `style.login.css`. The same rules apply for the admin section as well, you'll simply create files named `custom.admin.css` and `style.admin.css`.

## The components folder

You'll learn more about seamless substitution in a future lesson, but for now, we'll touch on the `components` folder and what it's used for. As a skin developer, you can override the view files that Nova uses by simply placing the properly named file in the correct folder. In Nova 3, skin developers have access to override more than they've had in the past. The `components` folder isn't required for your skin, but if you do want to override something, you'll need to create the folder and then create any additional folders (listed below) that you want to override for. If you have questions about the actual structure of this directory, you can check out the `views` directory in the Nova core.

Below are some of the components you can override from your skin.

- `ajax`: Any Ajax calls, like modal pop-ups, are pulled from this directory.
- `email`: The majority of emails in Nova are pulled out of the database, but the template for those emails (and the emails that aren't pulled from the database) are grabbed from here.
- `error`: Error pages that Nova displays can be overridden for your skin from here.
- `js`: Any Javascript view files in the system are pulled from this folder.
- `page`: Any view file in the system is taken from this directory.
- `partial`: Partials are, as their name implies, partial pages that are embedded in larger pages. Partials are covered in greater detail in a future course, but if you need to make tweaks to a partial for your skin, this is where they're pulled from.
- `structure`: Structure files are the full HTML structure of the skin. In most cases, your skin won't need a new strucuture file (and in fact we don't encourage people to change the structure files), but if your skin calls for such a change, you can do so from here.
- `template`: Template files are the "guts" of the skin's HTML (in other words, everything that's contained within the `body` tags). You can make any markup changes you want for your skin or you can use what comes out of the core.