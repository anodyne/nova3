<?php

namespace Nova\Foundation\Sanitizers\Rules;

interface Rule
{
	public function handle($value);
}
