<?php namespace Nova\Core\Traits;

trait SecurityTrait {

	/**
	 * Make sure the integer is a number and then scrub it.
	 *
	 * @param	int		$num	The integer to sanitize
	 * @return	bool|int
	 */
	public function sanitizeInt($num)
	{
		return ( ! is_numeric($num)) ? false : $num;
	}

	/**
	 * Make sure the string is a string and then scrub it.
	 *
	 * @param	string	$str	The string to sanitize
	 * @return	bool|int
	 */
	public function sanitizeString($str)
	{
		return ( ! is_string($str)) ? false : $str;
	}

}