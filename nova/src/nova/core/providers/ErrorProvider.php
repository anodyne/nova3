<?php namespace Nova\Core\Providers;

use App;
use Log;
use View;
use Request;
use Location;
use Exception;
use RuntimeException;
use Illuminate\Support\ServiceProvider;

class ErrorProvider extends ServiceProvider {

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

	protected function bootMissing()
	{
		App::missing(function()
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
			Log::error('404 Not Found. Could not find the page requested: '.Request::path());

			return View::make(Location::error('404'))
				->with('header', $messages[$rand]['header'])
				->with('message', $messages[$rand]['message']);
		});
	}

	protected function bootRuntimeException()
	{
		App::error(function(RuntimeException $ex, $code)
		{
			switch ($ex->getMessage())
			{
				case 'Nova 3 requires PHP 5.4.0 or higher':
					return View::make(Location::error('php_version'))
						->with('env', App::environment());
				break;
			}
		});
	}

	protected function bootGeneralException()
	{
		App::error(function(Exception $ex, $code)
		{
			Log::error($ex);
		});
	}

}