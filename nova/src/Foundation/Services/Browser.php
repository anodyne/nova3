<?php namespace Nova\Foundation\Services;

use Ikimea\Browser\Browser as IkimeaBrowser;

class Browser {

	protected $browser;

	public function __construct(IkimeaBrowser $browser)
	{
		$this->browser = $browser;
	}

	public function browser() : string
	{
		return $this->browser->getBrowser();
	}

	public function browserVersion() : string
	{
		return $this->browser->getVersion();
	}

	public function platform() : string
	{
		return $this->browser->platform();
	}

	public function userAgent() : string
	{
		return $this->browser->getUserAgent();
	}

	public function isAndroid() : bool
	{
		return $this->platform() == IkimeaBrowser::BROWSER_ANDROID;
	}

	public function isChrome() : bool
	{
		return $this->browser() == IkimeaBrowser::BROWSER_CHROME;
	}

	public function isEdge() : bool
	{
		return $this->browser() == IkimeaBrowser::BROWSER_EDGE;
	}

	public function isFirefox() : bool
	{
		return $this->browser() == IkimeaBrowser::BROWSER_FIREFOX;
	}

	public function isIE() : bool
	{
		return $this->browser() == IkimeaBrowser::BROWSER_IE;
	}

	public function isMobile() : bool
	{
		return $this->browser->isMobile();
	}

	public function isSafari() : bool
	{
		return $this->browser() == IkimeaBrowser::BROWSER_SAFARI;
	}

	public function platformIsAndroid() : bool
	{
		return $this->platform() == IkimeaBrowser::PLATFORM_ANDROID;
	}

	public function platformIsIOS() : bool
	{
		$platform = $this->platform();

		return $platform == IkimeaBrowser::PLATFORM_IPHONE or $platform == IkimeaBrowser::PLATFORM_IPAD or $platform == IkimeaBrowser::PLATFORM_IPOD;
	}

	public function platformIsMac() : bool
	{
		return $this->platform() == IkimeaBrowser::PLATFORM_APPLE;
	}

	public function platformIsWindows() : bool
	{
		return $this->platform() == IkimeaBrowser::PLATFORM_WINDOWS;
	}

	public function __toString()
	{
		return "<strong>Browser:</strong> {$this->browser()} {$this->browserVersion()}<br>\n<strong>Platform:</strong> {$this->platform()}";
	}
}
