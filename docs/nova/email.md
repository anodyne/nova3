# Emails

One of the core features of Nova has always been the emails it sends throughout the process of managing and playing your game. That hasn't changed, but what has changed in recent years is the struggles game masters have had with sending emails from Nova. With the rise of spam, many hosts are taking active measures to slow the tide of unwanted emails. In some cases though, Nova emails have been marked as spam and never delivered to users. If not that, then the configuration of the server has led to some unreliable email delivery as well.

We understand this frustration and have worked to curb this as much as we possibly can. Because of this, Nova 3 introduces a new recommendation for how to send emails from your Nova site.

## SMTP Email

One of the many changes made in Nova 3 is the switch to recommending using an SMTP service to send email from Nova. This change should provide greater reliability when sending emails, though it'll likely require signing up for a third-party service to handle these emails. Here are a few services we've found that offer free or cheap accounts:

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
	* You can create a new Gmail account for free for sending your email though
* Your host
	* Most hosting companies provide an SMTP server and credentials that you can use
	* Contact your host to see if there are limits on how much mail you can send or if there will be repercussions for using their email servers to send email through a CMS

### How many emails does Nova 3 send anyway?

This all depends on the activity level of your game. In general though, an average Nova sim probably only sends between 100 and 200 emails a month. Higher traffic sites may send 400 or 500 emails, but that would be pretty rare.

## The Old Way

There are some people who may not have any issues using PHP's built-in `mail()` function. We still provide that functionality which you can select during the setup process when configuring your email options. We recommend using an SMTP service instead of PHP's `mail()` function though.