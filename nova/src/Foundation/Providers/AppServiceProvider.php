<?php namespace Nova\Foundation\Providers;

use Date;
use Form;
use Schema;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Database\Eloquent\Relations\Relation;
use Nova\Foundation\Http\Middleware\CaptureRequestExtension;

class AppServiceProvider extends ServiceProvider
{
	public function boot()
	{
		Schema::defaultStringLength(191);

		$this->app[PackageManifest::class]->vendorPath = $this->app->basePath().'/nova/vendor';

		$this->app->singleton('nova', function ($app) {
			return new \Nova\Foundation\Nova;
		});

		$this->registerTheme();
		$this->registerTranslator();
		$this->registerMacros();

		$this->app->bind('nova.avatar', function ($app) {
			return new \Nova\Foundation\Avatar;
		});

		$this->app->singleton('nova.hooks', function ($app) {
			return new \Nova\Foundation\HookManager;
		});

		$this->app->bind('nova.markdown', function ($app) {
			return new \Nova\Foundation\MarkdownParser(new \Parsedown);
		});

		$this->app->singleton('nova.settings', function ($app) {
			if ($app['nova']->isInstalled()) {
				$settings = \Nova\Settings\Settings::get()
					->pluck('value', 'key')
					->all();

				return (object)$settings;
			}

			return (object)collect();
		});

		// Make sure we can use the _settings object in every view
		$this->app['view']->share('_settings', $this->app['nova.settings']);

		$this->app->singleton('nova2-migrator', function ($app) {
			return new \Nova\Setup\Migrations\MigrationManager;
		});

		// Build up the morph map
		Relation::morphMap(config('maps.morph'));
	}

	public function register()
	{
		// Set the locale for Carbon
		Date::setLocale(app()->getLocale());
	}

	protected function registerTheme()
	{
		$theme = new \Nova\Foundation\Theme\Theme;

		// spl_autoload_register(function ($class) {
		// 	include_once app()->themePath('pulsar').DIRECTORY_SEPARATOR.'Theme.php';
		// });

		// Make a new theme
		// $theme = new \Theme;

		$this->app->instance('nova.theme', $theme);
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
		Form::macro('departments', function ($name, $options = null, $value = null, $attributes = [], $onlyParents = false) {
			if ($options == null) {
				$options = \Nova\Genres\Department::with('subDepartments')->parents()->orderBy('order')->get();
			}

			$options = $options->mapWithKeys(function ($d) use ($onlyParents) {
				if (! $onlyParents and $d->subDepartments->count() > 0) {
					return [$d->name => [$d->id => $d->name] + $d->subDepartments->pluck('name', 'id')->all()];
				} else {
					return [$d->id => $d->name];
				}
			})->all();

			$class = 'custom-select';

			if (array_key_exists('class', $attributes)) {
				$class.= " {$attributes['class']}";
				unset($attributes['class']);
			}

			return Form::select(
				$name,
				$options,
				$value,
				array_merge(['class' => $class], $attributes)
			);
		});

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
	}
}
