<?php namespace Nova\Foundation;

class MarkdownParser
{
	protected $parser;

	public function __construct($parser)
	{
		$this->parser = $parser;
	}

	public function transform($text)
	{
		return $this->parser->text($text);
	}
}