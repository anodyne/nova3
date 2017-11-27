<?php namespace Nova\Foundation\Translation;

class TranslationManager
{
	protected $gender = false;
	protected $messages = [];

	public function setGender($value)
	{
		$this->gender = $value;

		return $this;
	}
}
