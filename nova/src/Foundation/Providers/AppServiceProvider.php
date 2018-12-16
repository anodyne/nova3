<?php namespace Nova\Foundation\Providers;

use Date;
use Form;
use Schema;
use Illuminate\Http\Request;
use Nova\Themes\ThemeFactory;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Database\Eloquent\Relations\Relation;
use Nova\Foundation\Http\Middleware\CaptureRequestExtension;
use Nova\Pages\Page;

class AppServiceProvider extends ServiceProvider
{
	public function boot()
	{
		Schema::defaultStringLength(191);

		$this->app[PackageManifest::class]->vendorPath = $this->app->basePath().'/nova/vendor';

		$this->app->singleton('nova', function ($app) {
			return new \Nova\Foundation\Nova;
		});

		// $this->registerTranslator();
		$this->registerMacros();

		// $this->app->bind('nova.avatar', function ($app) {
		// 	return new \Nova\Foundation\Avatar;
		// });

		$this->app->singleton('nova.hooks', function ($app) {
			return new \Nova\Foundation\HookManager;
		});

		$this->app->singleton('nova.response.data', function ($app) {
			return [];
		});

		// Make sure we can use the _settings object in every view
		// $this->app['view']->share('_settings', $this->app['nova.settings']);

		// Build up the morph map
		Relation::morphMap(config('maps.morph'));
	}

	public function register()
	{
		// Set the locale for Carbon
		Date::setLocale(app()->getLocale());

		$this->registerTheme();
	}

	protected function registerTheme()
	{
		$theme = 'pulsar';

		// if ($this->app['nova']->isInstalled()) {
		// 	$theme = (auth()->check())
		// 		? auth()->user()->preference('theme')
		// 		: cache('nova.settings')->theme;
		// }

		$this->app->singleton('nova.theme', function ($app) use ($theme) {
			return ThemeFactory::make($theme);
		});

		// Make sure the file finder can find Javascript files
		$this->app['view']->addExtension('js', 'file');

		// Add the theme location to the file finder
		$this->app['view']->getFinder()->prependLocation(theme_path($theme));
	}

	protected function registerTranslator()
	{
		// Figure out what language we need
		$lang = $this->app['config']->get('app.locale');

		// Grab the full list of language items
		$this->app->singleton('nova.translator.loader', function ($app) {
			return new \Nova\Foundation\TranslationFileLoader(
				$app['files'],
				$app['path.lang'],
				$app['path.nova.lang']
			);
		});

		$this->app->singleton('nova.translator.messages', function ($app) use ($lang) {
			return $app['nova.translator.loader']->load($lang, '*', '*');
		});

		// Create a new instance of the translator
		$translator = new \Krinkle\Intuition\Intuition([
			'globalfunctions' => false,
			'lang' => $lang,
			'stayalive' => true,
			'suppressfatal' => false,
			'suppressnotice' => false,
		]);

		// Set the messages from the loaded file(s)
		$translator->setMsgs($this->app['nova.translator.messages']);

		// Bind the translator instance into the container
		$this->app->instance('nova.translator', $translator);
	}

	protected function registerRepositoryBindings()
	{
		collect(config('maps.repositories'))->each(function ($repo, $contract) {
			app()->bind($contract, $repo);
		});
	}

	protected function registerMacros()
	{
		Route::macro('multiformat', function () {
            // Hello darkness, my old friend
            if (count($this->parameterNames()) > 0 && ends_with($this->uri(), '}')) {
                $lastParameter = array_last($this->parameterNames());
                // I've come to talk with you again
                if (! isset($this->wheres[$lastParameter])) {
                    $this->where($lastParameter, '[^\/.]+');
                }
            }

            $this->uri = $this->uri . '{_extension?}';
            $this->where('_extension', '(\..+)');
            $this->middleware(CaptureRequestExtension::class);
            $this->parameterNames = $this->compileParameterNames();

            return $this;
        });

        Request::macro('match', function ($responses, $defaultFormat = 'html') {
            if ($this->attributes->get('_extension') !== null) {
                return value(array_get($responses, $this->attributes->get('_extension'), function () {
                    abort(404);
                }));
            }

            return value(array_get($responses, $this->format($defaultFormat)));
		});

		Route::macro('findPageFromRoute', function () {
			return Page::where('key', $this->getName())->first();
		});
	}
}
