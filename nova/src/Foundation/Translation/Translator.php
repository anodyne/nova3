<?php namespace Nova\Foundation\Translation;

class Translator
{
	protected $count = 1;
	protected $gender = false;
	protected $manager;

	public function __construct(TranslationManager $manager)
	{
		$this->manager = $manager;
	}

	public function withCount($value)
	{
		$this->count = $value;

		return $this;
	}

	public function withGender($value)
	{
		$this->gender = $value;

		return $this;
	}

	public function __toString()
	{
		if (! $this->gender) {
			$this->gender = $this->manager->gender;
		}
	}
}
