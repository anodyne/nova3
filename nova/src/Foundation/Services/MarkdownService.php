<?php namespace Nova\Core\Services;

use Parsedown;

class MarkdownService {

	protected $markdown;

	public function __construct(Parsedown $markdown)
	{
		$this->markdown = $markdown;
	}

	/**
	 * Parse the string from Markdown to HTML.
	 *
	 * @param	string	$str	The string to parse
	 * @return	string
	 */
	public function parse($str)
	{
		return $this->markdown->text($str);
	}
	
}