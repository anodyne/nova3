# Custom Error Pages

## 404 File Not Found Error Pages

Nova 3 allows creating a special 404 page either at the system level (through the override module) or at a skin level (so it matches the skin). In order to create a 404 page, simply create a view called `404.php` in the `components/error` directory. If a 404 is encountered, your page will be displayed.

__Note:__ When creating your view file, you have to include all of the relevant HTML as the 404 page doesn't go through the templating system.

### Special Messages

The default 404 page uses a series of random headers and messages. You can choose to use them or not in your own 404 pages. In order to use them, simply reference the `$header` and `$message` variables in your 404 page and the header and message will be generated for you. If you'd prefer to have more control, you can hard-code your content into the page.