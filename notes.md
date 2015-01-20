# Page Manager

- Page content should be parsed for different possible tags to insert dynamic content:
	- {% form:{key} %} would grab the form with the passed key and insert it into the page
	- {% setting:{key} %} would grab the setting with the passed key and print the value out