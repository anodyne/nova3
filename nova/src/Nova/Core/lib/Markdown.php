<?php namespace Nova\Core\Lib;

use dflydev\markdown\MarkdownParser;

class Markdown {

	protected $markdown;

	/**
	 * Setup a new Markdown parser.
	 *
	 * @param	MarkdownParser
	 * @return	void
	 */
	public function __construct(MarkdownParser $markdown)
	{
		$this->markdown = $markdown;
	}

	/**
	 * Parse the from Markdown to HTML.
	 *
	 * @param	string	The string to parse
	 * @return	string
	 */
	public function parse($str)
	{
		return $this->markdown->transformMarkdown($str);
	}
	
}