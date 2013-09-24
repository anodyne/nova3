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
		if ( ! is_numeric($num))
			return false;
		
		return $num;
	}

	/**
	 * Make sure the string is a string and then scrub it.
	 *
	 * @param	string	$str	The string to sanitize
	 * @return	bool|int
	 */
	public function sanitizeString($str)
	{
		if ( ! is_string($str))
			return false;
		
		return $str;
	}

}