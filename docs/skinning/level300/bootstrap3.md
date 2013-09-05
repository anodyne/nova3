# Bootstrap 3

At the heart of Nova 3 design architecture is the Bootstrap toolkit. In previous versions of Nova, we've used Bootstrap to help handle more complex user interactions (tooltips, popovers, etc), but starting with Nova 3, we rely much more heavily on Bootstrap and even pull in the entire toolkit. From the ground up, all of Anodyne's skins for Nova 3 use Bootstrap.

You aren't required to use the Bootstrap grid system for your template files. If there's another toolkit you'd rather use or if you want to roll your own grid system, you're welcome to do so. Despite that though, the core view files use many of Bootstrap's components, including the grid system.

For more information about Bootstrap and how to use it, please see their [http://getbootstrap.com](documentation).

## Bootstrap Components in Nova 3

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

## Mobile First

Starting with version 3 of Bootstrap, the framework has taken a "mobile first" approach. This means that everything is designed to work on a phone first, then scale up to a tablet, then finally scale up again to a desktop. Nova 3 has embraced this philosophy. Every page in the system has been tested on phone, tablet and desktop resolutions to ensure everything works at different screen sizes.