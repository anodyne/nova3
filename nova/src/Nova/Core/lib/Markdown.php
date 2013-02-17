<?php

namespace Nova\Core\Lib;

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
		$parser = new \dflydev\markdown\MarkdownParser;

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
		$parser = new \dflydev\markdown\MarkdownExtraParser;

		// Return the transformed text
		return $parser->transformMarkdown($str);
	}
}
