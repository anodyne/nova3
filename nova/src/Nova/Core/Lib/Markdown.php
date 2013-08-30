<?php namespace Nova\Core\Lib;

/**
 * Parse Markdown text into HTML using the MarkdownParser.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Lib
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

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
	 * @param	string	The string to parse
	 * @return	string
	 */
	public function parse($str)
	{
		return $this->markdown->transformMarkdown($str);
	}
	
}