<?php namespace Nova\Core\Lib;

use dflydev\markdown\MarkdownParser;
use dflydev\markdown\MarkdownExtraParser;

class Markdown {

	/**
	 * Parse normal Markdown.
	 *
	 * @param	string	The text to parse
	 * @return	string
	 */
	public static function parse($str)
	{
		// Create a new parser
		$parser = new MarkdownParser;

		// Return the transformed text
		return $parser->transformMarkdown($str);
	}

	/**
	 * Parse Markdown with the PHPMarkdownExtra parser.
	 *
	 * @param	string	The text to parse
	 * @return	string
	 */
	public static function parseExtra($str)
	{
		// Create a new parser
		$parser = new MarkdownExtraParser;

		// Return the transformed text
		return $parser->transformMarkdown($str);
	}
	
}