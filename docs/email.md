# Emails

One of the changes made in Nova 3 was the removal of using PHP's built-in `mail()` function. In recent years, we've found it's gotten harder to send emails that way. To combat that, we're switching things up to only use SMTP email sending. While this will provide greater reliability when sending messages, it'll also (likely) require signing up for a third-party service to handle sending emails. Here are a few services we've found that have free accounts or very cheap monthly costs associated with them.

* https://www.mailjet.com/
	* Free accounts allow sending up to 6,000 emails a month (capped at 200 a day)
	* For $7.49 a month, you can send up to 30,000 emails a month
* https://postmarkapp.com/
	* When you sign up, you'll get 1,000 emails for free
	* Additional batches of 1,000 are only $1.50
* http://mandrill.com/
	* Free accounts can send up to 12,000 emails a month
	* For $9.95 a month, you can send up to 40,000 emails a month
* Gmail
	* You can create a new Gmail account for sending your email though
* Your host
	* Most hosting companies provide an SMTP server and credentials that you can use
	* Contact your host to see if there are limits on how much mail you can send or if there will be repercussions for using their email servers to send email through a CMS

### How many emails does Nova 3 send anyway?

This all depends on the activity level of your game. In general though, an average Nova sim probably only sends between 100 and 200 emails a month. Higher traffic sites may send 400 or 500 emails, but that would be pretty rare. Below are some of the emails Nova sends.