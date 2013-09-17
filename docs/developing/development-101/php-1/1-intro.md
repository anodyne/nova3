# What is PHP?

At this point, you know that Nova is written on top of PHP and if you've been brave enough to look at source, you have a little bit of an idea what PHP looks like, but it most likely looks like Greek to you. That's why you're here after all, to learn about PHP and how to use it. We're going to look at PHP in small pieces to give you a better understanding of the most basic concepts. These are the building blocks to learning how to work with PHP, even in small doses.

In the simplest of terms, PHP is just a programming language that lets you create dynamic pages on a web server. Unlike HTML which the server sends back without doing anything, with PHP, the server has to do some work before it can send anything back to your browser. Being able to do processing on the server is what gives PHP its power.

## PHP Files

In order to use PHP, your files need to have a `.php` extension. This tells the server to use the PHP parser to do its magic with your PHP file. Just because your file has a `.php` extension doesn't mean you can only have PHP code in there though. The nice thing about PHP is that it's an HTML embedded language, which means you can combine HTML and PHP in the same file without any issues.

You can have a PHP file that looks like this:

<pre>&lt;php

echo 'This is a PHP page.';</pre>

Or, it can look like this:

<pre>&lt;html>
	&lt;body>
		This is a &lt;php echo 'PHP';?> page.
	&lt;/body>
&lt;/html></pre>

Regardless of how your PHP files are built, one important thing to note is that PHP only sends the _final output_ back to the browser, not the actual PHP code that's used. That means if you view the source of a PHP page in the browser, you'll only see the final output, the HTML, not any PHP code. (This can be confusing for people new to PHP since they want to see the PHP code that's being run. In order to see that, you have to have access to the actual PHP file.)

## Requirements

Since PHP is a server-side programming language, it does mean you need to have a server running in order to play around with PHP. Never fear, there are several ways to do this. The easiest way is to use your existing web server and play around on there. That may be easiest, but it can be a little clunky to constantly be uploading files to test them. In order to really play around fully, you'll want to install a web server on your computer. While it may sound complicated, it isn't with the use of some specialized programs. Here are the programs we recommend:

- Windows
	- (AMPPS)[http://www.ampps.com/]
- OS X
	- (MAMP)[http://www.mamp.info/en/index.html]
- Linux
	- (XAMPP)[http://www.apachefriends.org/en/xampp-linux.html]

All of the above programs have at least PHP 5.4 available (which you'll need to be able to install Nova 3 locally). In addition, these programs include MySQL, so you'll also have databases to play with as we get rolling.

Go ahead and download the program that matches your operating system and install it. Once you've installed and started up the server, make sure the PHP version you're using is PHP 5.4. (If you're not sure how to do this, consult the software's website for more help.) Once you're up and running, come back and we'll dive into the meat of the lessons.