<?php namespace Nova\Foundation\Services\PageCompiler;

class CompilerEngine {

	protected $tags = ['{%', '%}'];
	protected $pattern;
	protected $compilers = [];

	public function __construct()
	{
		$this->pattern = sprintf('/(@)?%s\s*(.+?)\s*%s(\r?\n)?/s', $this->tags[0], $this->tags[1]);
	}

	/**
	 * Compile the content.
	 *
	 * @param	string	$value	Content to compile
	 * @return	string
	 */
	public function compile($value)
	{
		return $this->compileString($value);
	}

	/**
	 * Get the replacement pattern.
	 *
	 * @return	string
	 */
	public function getPattern()
	{
		return $this->pattern;
	}

	/**
	 * Get the tags.
	 *
	 * @return	array
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * Register a compiler with the engine.
	 *
	 * @param	string			$key	Key for the compiler to use
	 * @param	object|Closure	$object	Class for compiling or Closure
	 * @return	$this
	 * @throws	PageCompilerExistsException
	 */
	public function registerCompiler($key, $object)
	{
		if (array_key_exists($key, $this->compilers))
		{
			throw new PageCompilerExistsException;
		}

		$this->compilers[$key] = $object;

		return $this;
	}

	/**
	 * Remove a compiler from the engine.
	 *
	 * @param	string	$key	Compiler key to remove
	 * @return	$this
	 * @throws	PageCompilerNotRegisteredException
	 */
	public function removeCompiler($key)
	{
		if ( ! array_key_exists($key, $this->compilers))
		{
			throw new PageCompilerNotRegisteredException;
		}

		unset($this->compilers[$key]);

		return $this;
	}

	/**
	 * Start the process of parsing the string to its final output.
	 *
	 * @internal
	 * @param	string	$value	Content to compile
	 * @return	string
	 */
	protected function compileString($value)
	{
		$result = '';

		foreach (token_get_all($value) as $token)
		{
			$result.= is_array($token) ? $this->parseToken($token) : $token;
		}

		return $result;
	}

	/**
	 * Do the actual parsing and compiling.
	 *
	 * @param	array	$token
	 * @return	string
	 */
	protected function parseToken($token)
	{
		list($id, $content) = $token;

		if ($id == T_INLINE_HTML)
		{
			foreach ($this->compilers as $compiler)
			{
				$content = (is_callable($compiler))
					? preg_replace_callback($this->pattern, $compiler, $content)
					: $compiler->compile($content, $this);
			}
		}

		return $content;
	}

}