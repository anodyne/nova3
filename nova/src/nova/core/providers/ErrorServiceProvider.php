<?php namespace nova\core\providers;

use Illuminate\Support\ServiceProvider;

class ErrorServiceProvider extends ServiceProvider {

	public function register()
	{
		//
	}

	public function boot()
	{
		$this->bootMissing();
		$this->bootRuntimeException();
		$this->bootGeneralException();
	}

	/**
	 * What to do when a 404 error is encountered.
	 */
	protected function bootMissing()
	{
		$this->app->missing(function()
		{
			// Random headers and messages to use
			$messages = [
				0 => [
					'header' => "Aw, crap!",
					'message' => "Looks like what you're trying to find isn't here. It was probably moved, or sucked into a black hole. Chin up."],
				1 => [
					'header' => "Bloody Hell!",
					'message' => "The rabbits have been nibbling on the cables again."],
				2 => [
					'header' => "Uh Oh!",
					'message' => "You seem to have stumbled off the beaten path. Perhaps you should try again."],
				3 => [
					'header' => "Nope, not here.",
					'message' => "That file ain't there. Kind of pathetic really."],
				4 => [
					'header' => "Danger, Will Robinson! Danger!",
					'message' => "We couldn't find what you were looking for. Try again."],
				5 => [
					'header' => "Doh!",
					'message' => "We lost that page. Try again."],
				6 => [
					'header' => "What have you done?!",
					'message' => "I take my eye off you for one minute and this is where I find you?!"],
				7 => [
					'header' => "Congratulations, you broke the Internet",
					'message' => "The page you're after doesn't exist. Try again."],
				8 => [
					'header' => "404'd",
					'message' => "Boy, you sure are stupid.\r\nWere you just making up filenames or what? I mean, I've seen some pretend file names in my day, but come on! It's like you're not even trying."],
				9 => [
					'header' => "Error 404: Page Not Found",
					'message' => "We actually know where the page is. Chuck Norris has it and he decided to keep it."],
				10 => [
					'header' => "404 Error",
					'message' => "This is not the page you're looking for.\r\nMove along. Move along."],
				11 => [
					'header' => "202 + 202 = 404",
					'message' => "For those who aren't great at math, that means your page couldn't be found. Try again."],
				12 => [
					'header' => "Bummer!",
					'message' => "aka Error 404\r\nThe web address you entered is not a functioning page on the site."],
				13 => [
					'header' => "Page Not Found",
					'message' => "We think it may have been murdered.\r\nProfessor Plum, in the Ball Room, with the Wrench."],
				14 => [
					'header' => "This is awkward...",
					'message' => "Sooooo, we kind of, sort of, can't find that page. Try another one?"],
			];
			
			// Get a random item
			$rand = array_rand($messages);

			// Log the error
			$this->app['log']->error('404 Not Found. Could not find the page requested: '.$this->app['request']->path());

			return $this->app['view']->make($this->app['nova.location']->error('404'))
				->with('header', $messages[$rand]['header'])
				->with('message', $messages[$rand]['message']);
		});
	}

	/**
	 * What to do when a RuntimeException is encountered.
	 */
	protected function bootRuntimeException()
	{
		$this->app->error(function(\RuntimeException $ex, $code)
		{
			switch ($ex->getMessage())
			{
				case "php 5.4 required":
					return $this->app['view']->make($this->app['nova.location']->error('php_version'))
						->with('env', $this->app->environment());
				break;

				case "cache directory not writable":
					return $this->app['view']->make($this->app['nova.location']->error('cache_dir'));
				break;
			}
		});
	}

	/**
	 * What to do when a general exception is encountered.
	 */
	protected function bootGeneralException()
	{
		$this->app->error(function(\Exception $ex, $code)
		{
			$this->app['log']->error($ex);
		});
	}

}