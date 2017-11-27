<?php namespace Nova\Foundation;

use Gravatar;
use Nova\Users\User;

class Avatar
{
	protected $url;
	protected $user;
	protected $options = [];

	public function __construct()
	{
		$this->options = [
			'default' => 'retro',
			'label' => false,
			'size' => false,
			'type' => 'link',
			'labelContentBefore' => null,
			'labelContentAfter' => null,
		];
	}

	public function default($value): Avatar
	{
		$this->options['default'] = $value;
		return $this;
	}

	public function image(): Avatar
	{
		$this->options['type'] = 'image';
		return $this;
	}

	public function link(): Avatar
	{
		$this->options['type'] = 'link';
		$this->options['link'] = route('profile.show', [$this->user]);
		return $this;
	}

	public function tiny(): Avatar
	{
		$this->options['size'] = 'xs';
		return $this;
	}

	public function small(): Avatar
	{
		$this->options['size'] = 'sm';
		return $this;
	}

	public function medium(): Avatar
	{
		$this->options['size'] = 'md';
		return $this;
	}

	public function large(): Avatar
	{
		$this->options['size'] = 'lg';
		return $this;
	}

	public function label($contentBefore = null, $contentAfter = null): Avatar
	{
		$this->options['label'] = true;
		$this->options['labelContentBefore'] = $contentBefore;
		$this->options['labelContentAfter'] = $contentAfter;
		return $this;
	}

	public function getOptions(): array
	{
		return $this->options;
	}

	public function getUser(): User
	{
		return $this->user;
	}

	public function setUser(User $user): Avatar
	{
		$this->user = $user;
		return $this;
	}

	public function render(): string
	{
		// Set the URL
		$this->options['url'] = Gravatar::image(
			$this->user->email,
			500,
			$this->options['default'],
			'pg',
			null,
			true
		);

		$this->options['user'] = $this->user;

		return view('partials.avatar')->with($this->options);
	}

	public function __toString()
	{
		return $this->render();
	}
}
