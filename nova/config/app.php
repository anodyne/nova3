<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => env('APP_DEBUG', true),

	/*
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| This URL is used by the console to properly generate URLs when using
	| the Artisan command line tool. You should set this to the root of
	| your application so that it is used when running Artisan tasks.
	|
	*/

	'url' => 'http://localhost',

	/*
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default timezone for your application, which
	| will be used by the PHP date and date-time functions. We have gone
	| ahead and set this to a sensible default for you out of the box.
	|
	*/

	'timezone' => 'UTC',

	/*
	|--------------------------------------------------------------------------
	| Application Locale Configuration
	|--------------------------------------------------------------------------
	|
	| The application locale determines the default locale that will be used
	| by the translation service provider. You are free to set this value
	| to any of the locales which will be supported by the application.
	|
	*/

	'locale' => 'en',

	/*
	|--------------------------------------------------------------------------
	| Application Fallback Locale
	|--------------------------------------------------------------------------
	|
	| The fallback locale determines the locale to use when the current one
	| is not available. You may change the value to correspond to any of
	| the language folders that are provided through your application.
	|
	*/

	'fallback_locale' => 'en',

	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => env('APP_KEY', 'SomeRandomString'),

	'cipher' => MCRYPT_RIJNDAEL_128,

	/*
	|--------------------------------------------------------------------------
	| Logging Configuration
	|--------------------------------------------------------------------------
	|
	| Here you may configure the log settings for your application. Out of
	| the box, Laravel uses the Monolog PHP logging library. This gives
	| you a variety of powerful log handlers / formatters to utilize.
	|
	| Available Settings: "single", "daily", "syslog"
	|
	*/

	'log' => 'daily',

	/*
	|--------------------------------------------------------------------------
	| Autoloaded Service Providers
	|--------------------------------------------------------------------------
	|
	| The service providers listed here will be automatically loaded on the
	| request to your application. Feel free to add your own services to
	| this array to grant expanded functionality to your applications.
	|
	*/

	'providers' => [

		/*
		 * Laravel Framework Service Providers...
		 */
		Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
		Illuminate\Auth\AuthServiceProvider::class,
		Illuminate\Broadcasting\BroadcastServiceProvider::class,
		Illuminate\Bus\BusServiceProvider::class,
		Illuminate\Cache\CacheServiceProvider::class,
		Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
		Illuminate\Routing\ControllerServiceProvider::class,
		Illuminate\Cookie\CookieServiceProvider::class,
		Illuminate\Database\DatabaseServiceProvider::class,
		Illuminate\Encryption\EncryptionServiceProvider::class,
		Illuminate\Filesystem\FilesystemServiceProvider::class,
		Illuminate\Foundation\Providers\FoundationServiceProvider::class,
		Illuminate\Hashing\HashServiceProvider::class,
		Illuminate\Mail\MailServiceProvider::class,
		Illuminate\Pagination\PaginationServiceProvider::class,
		Illuminate\Pipeline\PipelineServiceProvider::class,
		Illuminate\Queue\QueueServiceProvider::class,
		Illuminate\Redis\RedisServiceProvider::class,
		Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
		Illuminate\Session\SessionServiceProvider::class,
		Illuminate\Translation\TranslationServiceProvider::class,
		Illuminate\Validation\ValidationServiceProvider::class,
		Illuminate\View\ViewServiceProvider::class,

		/*
		 * Nova Service Providers
		 */

		Zizaco\Entrust\EntrustServiceProvider::class,
		Collective\Html\HtmlServiceProvider::class,
		Nova\Setup\Providers\SetupServiceProvider::class,
		Nova\Setup\Providers\SetupRouteServiceProvider::class,
		//Nova\Foundation\Providers\ErrorServiceProvider::class,
		Nova\Foundation\Providers\NovaServiceProvider::class,
		Nova\Foundation\Providers\EventServiceProvider::class,
		Nova\Foundation\Providers\RouteServiceProvider::class,
		//Nova\Foundation\Providers\ExtensionServiceProvider::class,

	],

	/*
	|--------------------------------------------------------------------------
	| Class Aliases
	|--------------------------------------------------------------------------
	|
	| This array of class aliases will be registered when this application
	| is started. However, feel free to register as many as you wish as
	| the aliases are "lazy" loaded so they don't hinder performance.
	|
	*/

	'aliases' => [

		'App'       => Illuminate\Support\Facades\App::class,
		'Artisan'   => Illuminate\Support\Facades\Artisan::class,
		'Auth'      => Illuminate\Support\Facades\Auth::class,
		'Blade'     => Illuminate\Support\Facades\Blade::class,
		'Bus'       => Illuminate\Support\Facades\Bus::class,
		'Cache'     => Illuminate\Support\Facades\Cache::class,
		'Config'    => Illuminate\Support\Facades\Config::class,
		'Cookie'    => Illuminate\Support\Facades\Cookie::class,
		'Crypt'     => Illuminate\Support\Facades\Crypt::class,
		'DB'        => Illuminate\Support\Facades\DB::class,
		'Eloquent'  => Illuminate\Database\Eloquent\Model::class,
		'Event'     => Illuminate\Support\Facades\Event::class,
		'File'      => Illuminate\Support\Facades\File::class,
		'Hash'      => Illuminate\Support\Facades\Hash::class,
		'Input'     => Illuminate\Support\Facades\Input::class,
		'Inspiring' => Illuminate\Foundation\Inspiring::class,
		'Lang'      => Illuminate\Support\Facades\Lang::class,
		'Log'       => Illuminate\Support\Facades\Log::class,
		'Mail'      => Illuminate\Support\Facades\Mail::class,
		'Password'  => Illuminate\Support\Facades\Password::class,
		'Queue'     => Illuminate\Support\Facades\Queue::class,
		'Redirect'  => Illuminate\Support\Facades\Redirect::class,
		'Redis'     => Illuminate\Support\Facades\Redis::class,
		'Request'   => Illuminate\Support\Facades\Request::class,
		'Response'  => Illuminate\Support\Facades\Response::class,
		'Route'     => Illuminate\Support\Facades\Route::class,
		'Schema'    => Illuminate\Support\Facades\Schema::class,
		'Session'   => Illuminate\Support\Facades\Session::class,
		'Storage'   => Illuminate\Support\Facades\Storage::class,
		'URL'       => Illuminate\Support\Facades\URL::class,
		'Validator' => Illuminate\Support\Facades\Validator::class,
		'View'      => Illuminate\Support\Facades\View::class,

		'BaseController'	=> Nova\Foundation\Http\Controllers\BaseController::class,
		'Date'				=> Carbon\Carbon::class,
		'Entrust'			=> Zizaco\Entrust\EntrustFacade::class,
		'Model'				=> Illuminate\Database\Eloquent\Model::class,
		'Form'				=> Collective\Html\FormFacade::class,
		'Flash'				=> Nova\Foundation\Services\FlashNotifierFacade::class,
		'HTML'				=> Collective\Html\HtmlFacade::class,
		'Locate'			=> Nova\Foundation\Services\Locator\LocatorFacade::class,
		'Markdown'			=> Nova\Foundation\Services\MarkdownParserFacade::class,
		'Str'				=> Illuminate\Support\Str::class,

		/**
		 * Mailers
		 */
		'BaseMailer' => 'Nova\Foundation\Services\Mailers\BaseMailer',

		/**
		 * Models
		 */
		'Character'		=> 'Nova\Core\Characters\Data\Character',
		'Setting'		=> 'Nova\Core\Settings\Data\Setting',
		'System'		=> 'Nova\Foundation\Data\System',
		'User'			=> 'Nova\Core\Users\Data\User',

		/**
		 * Repository Interfaces
		 */
		'CharacterRepositoryInterface'		=> 'Nova\Core\Characters\Data\Interfaces\CharacterRepositoryInterface',
		'SettingRepositoryInterface'		=> 'Nova\Core\Settings\Data\Interfaces\SettingRepositoryInterface',
		'SystemRepositoryInterface'			=> 'Nova\Foundation\Data\Interfaces\SystemRepositoryInterface',
		'UserRepositoryInterface'			=> 'Nova\Core\Users\Data\Interfaces\UserRepositoryInterface',

		/**
		 * Repositories
		 */
		'CharacterRepository'		=> 'Nova\Core\Characters\Data\Repositories\CharacterRepository',
		'SettingRepository'			=> 'Nova\Core\Settings\Data\Repositories\SettingRepository',
		'SystemRepository'			=> 'Nova\Foundation\Data\Repositories\SystemRepository',
		'UserRepository'			=> 'Nova\Core\Users\Data\Repositories\UserRepository',

		/**
		 * Services
		 */
		'CharacterCreator'	=> 'Nova\Core\Characters\Services\CharacterCreatorService',
		'UserCreator'		=> 'Nova\Core\Users\Services\UserCreatorService',

		/**
		 * Pages
		 */
		'Page' => 'Nova\Core\Pages\Data\Page',
		'PageContent' => 'Nova\Core\Pages\Data\PageContent',
		'PagePresenter' => 'Nova\Core\Pages\Data\Presenters\PagePresenter',
		'PageContentPresenter' => 'Nova\Core\Pages\Data\Presenters\PageContentPresenter',
		'PageRepositoryInterface' => 'Nova\Core\Pages\Data\Interfaces\PageRepositoryInterface',
		'PageContentRepositoryInterface' => 'Nova\Core\Pages\Data\Interfaces\PageContentRepositoryInterface',
		'PageRepository' => 'Nova\Core\Pages\Data\Repositories\PageRepository',
		'PageContentRepository' => 'Nova\Core\Pages\Data\Repositories\PageContentRepository',
		'CachePageRoutes' => 'Nova\Core\Pages\Listeners\CachePageRoutes',
		'CreatePageContentRequest' => 'Nova\Core\Pages\Http\Requests\CreatePageContentRequest',
		'EditPageContentRequest' => 'Nova\Core\Pages\Http\Requests\EditPageContentRequest',
		'RemovePageContentRequest' => 'Nova\Core\Pages\Http\Requests\RemovePageContentRequest',
		'CreatePageRequest' => 'Nova\Core\Pages\Http\Requests\CreatePageRequest',
		'EditPageRequest' => 'Nova\Core\Pages\Http\Requests\EditPageRequest',
		'RemovePageRequest' => 'Nova\Core\Pages\Http\Requests\RemovePageRequest',

		/**
		 * Menus
		 */
		'Menu' => 'Nova\Core\Menus\Data\Menu',
		'MenuItem' => 'Nova\Core\Menus\Data\MenuItem',
		'MenuPresenter' => 'Nova\Core\Menus\Data\Presenters\MenuPresenter',
		'MenuItemPresenter' => 'Nova\Core\Menus\Data\Presenters\MenuItemPresenter',
		'MenuRepositoryInterface' => 'Nova\Core\Menus\Data\Interfaces\MenuRepositoryInterface',
		'MenuItemRepositoryInterface' => 'Nova\Core\Menus\Data\Interfaces\MenuItemRepositoryInterface',
		'MenuRepository' => 'Nova\Core\Menus\Data\Repositories\MenuRepository',
		'MenuItemRepository' => 'Nova\Core\Menus\Data\Repositories\MenuItemRepository',
		'CreateMenuItemRequest' => 'Nova\Core\Menus\Http\Requests\CreateMenuItemRequest',
		'EditMenuItemRequest' => 'Nova\Core\Menus\Http\Requests\EditMenuItemRequest',
		'RemoveMenuItemRequest' => 'Nova\Core\Menus\Http\Requests\RemoveMenuItemRequest',
		'CreateMenuRequest' => 'Nova\Core\Menus\Http\Requests\CreateMenuRequest',
		'EditMenuRequest' => 'Nova\Core\Menus\Http\Requests\EditMenuRequest',
		'RemoveMenuRequest' => 'Nova\Core\Menus\Http\Requests\RemoveMenuRequest',

		/**
		 * Access
		 */
		'Permission' => Nova\Core\Access\Data\Permission::class,
		'Role' => Nova\Core\Access\Data\Role::class,
		'PermissionPresenter' => Nova\Core\Access\Data\Presenters\PermissionPresenter::class,
		'PermissionRepositoryInterface' => Nova\Core\Access\Data\Interfaces\PermissionRepositoryInterface::class,
		'RoleRepositoryInterface' => Nova\Core\Access\Data\Interfaces\RoleRepositoryInterface::class,
		'PermissionRepository' => Nova\Core\Access\Data\Repositories\PermissionRepository::class,
		'RoleRepository' => Nova\Core\Access\Data\Repositories\RoleRepository::class,
		'CreatePermissionRequest' => Nova\Core\Access\Http\Requests\CreatePermissionRequest::class,
		'EditPermissionRequest' => Nova\Core\Access\Http\Requests\EditPermissionRequest::class,
		'RemovePermissionRequest' => Nova\Core\Access\Http\Requests\RemovePermissionRequest::class,
		'CreateRoleRequest' => Nova\Core\Access\Http\Requests\CreateRoleRequest::class,
		'EditRoleRequest' => Nova\Core\Access\Http\Requests\EditRoleRequest::class,
		'RemoveRoleRequest' => Nova\Core\Access\Http\Requests\RemoveRoleRequest::class,

	],

];
