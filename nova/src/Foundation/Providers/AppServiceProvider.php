<?php namespace Nova\Foundation\Providers;

use Form;
use Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
	public function boot()
	{
		Schema::defaultStringLength(191);

		$this->app->singleton('nova', function ($app) {
			return new \Nova\Foundation\Nova;
		});

		$this->registerTheme();
		$this->registerTranslator();
		$this->registerMacros();
		// $this->registerRepositoryBindings();

		$this->app->bind('nova.avatar', function ($app) {
			return new \Nova\Foundation\Avatar;
		});

		// Build up the morph map
		Relation::morphMap(config('maps.morph'));
	}

	public function register()
	{
		if ($this->app['env'] == 'local') {
			if (class_exists('Barryvdh\Debugbar\ServiceProvider')) {
				$this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
			}
		}
	}

	protected function registerTheme()
	{
		$this->app->singleton('nova.theme', function ($app) {
			return new \Nova\Foundation\Theme\Theme;
		});
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
	}
}
