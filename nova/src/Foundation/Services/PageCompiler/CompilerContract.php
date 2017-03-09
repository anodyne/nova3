<?php namespace Nova\Foundation\Services\PageCompiler;

interface CompilerContract {

	/**
	 * Compile the content.
	 *
	 * @param	string			$value	Content to compile
	 * @param	CompilerEngine	$engine	Instance of the compiler engine
	 * @return	string
	 */
	public function compile($value, CompilerEngine $engine);

	/**
	 * Provide information about this specific compiler.
	 *
	 * @return	string
	 */
	public function help();
}
