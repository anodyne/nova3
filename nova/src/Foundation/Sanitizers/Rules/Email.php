<?php

namespace Nova\Foundation\Sanitizers\Rules;

class Email implements Rule
{
	public function handle($value)
	{
		return mb_strtolower($value);
	}
}
