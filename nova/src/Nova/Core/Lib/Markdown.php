<?php namespace Nova\Core\Lib;

use dflydev\markdown\MarkdownParser;

class Markdown {

	protected $markdown;

	public function __construct(MarkdownParser $markdown)
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
		return $this->markdown->transformMarkdown($str);
	}
	
}