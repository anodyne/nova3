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

		Collective\Html\HtmlServiceProvider::class,
		Nova\Setup\Providers\SetupServiceProvider::class,
		Nova\Setup\Providers\SetupRouteServiceProvider::class,
		//Nova\Foundation\Providers\ErrorServiceProvider::class,
		Nova\Foundation\Providers\NovaServiceProvider::class,
		Nova\Foundation\Providers\EventServiceProvider::class,
		Nova\Foundation\Providers\RouteServiceProvider::class,
		Nova\Foundation\Providers\AuthServiceProvider::class,
		Nova\Foundation\Providers\ExtensionServiceProvider::class,

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
		'Gate'      => Illuminate\Support\Facades\Gate::class,
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
		'Model'				=> Illuminate\Database\Eloquent\Model::class,
		'Form'				=> Collective\Html\FormFacade::class,
		'Flash'				=> Nova\Foundation\Services\FlashNotifierFacade::class,
		'HTML'				=> Collective\Html\HtmlFacade::class,
		'Locate'			=> Nova\Foundation\Services\Locator\LocatorFacade::class,
		'Markdown'			=> Nova\Foundation\Services\MarkdownParserFacade::class,
		'Status'			=> Nova\Foundation\Services\StatusService::class,
		'Str'				=> Illuminate\Support\Str::class,

		/**
		 * Mailers
		 */
		'BaseMailer' => Nova\Foundation\Services\Mailers\BaseMailer::class,

		/**
		 * Models
		 */
		'Character' => Nova\Core\Characters\Data\Character::class,
		'Setting' => Nova\Core\Settings\Data\Setting::class,
		'System' => Nova\Foundation\Data\System::class,
		'User' => Nova\Core\Users\Data\User::class,

		/**
		 * Repository Interfaces
		 */
		'CharacterRepositoryInterface' => Nova\Core\Characters\Data\Interfaces\CharacterRepositoryInterface::class,
		'SettingRepositoryInterface' => Nova\Core\Settings\Data\Interfaces\SettingRepositoryInterface::class,
		'SystemRepositoryInterface' => Nova\Foundation\Data\Interfaces\SystemRepositoryInterface::class,
		'UserRepositoryInterface' => Nova\Core\Users\Data\Interfaces\UserRepositoryInterface::class,

		/**
		 * Repositories
		 */
		'CharacterRepository' => Nova\Core\Characters\Data\Repositories\CharacterRepository::class,
		'SettingRepository' => Nova\Core\Settings\Data\Repositories\SettingRepository::class,
		'SystemRepository' => Nova\Foundation\Data\Repositories\SystemRepository::class,
		'UserRepository' => Nova\Core\Users\Data\Repositories\UserRepository::class,

		/**
		 * Services
		 */
		'CharacterCreator' => Nova\Core\Characters\Services\CharacterCreatorService::class,
		'UserCreator' => Nova\Core\Users\Services\UserCreatorService::class,

		/**
		 * Pages
		 */
		'Page' => Nova\Core\Pages\Data\Page::class,
		'PageContent' => Nova\Core\Pages\Data\PageContent::class,
		'PagePresenter' => Nova\Core\Pages\Data\Presenters\PagePresenter::class,
		'PageContentPresenter' => Nova\Core\Pages\Data\Presenters\PageContentPresenter::class,
		'PageRepositoryInterface' => Nova\Core\Pages\Data\Interfaces\PageRepositoryInterface::class,
		'PageContentRepositoryInterface' => Nova\Core\Pages\Data\Interfaces\PageContentRepositoryInterface::class,
		'PageRepository' => Nova\Core\Pages\Data\Repositories\PageRepository::class,
		'PageContentRepository' => Nova\Core\Pages\Data\Repositories\PageContentRepository::class,
		'CachePageRoutes' => Nova\Core\Pages\Listeners\CachePageRoutes::class,
		'CreatePageContentRequest' => Nova\Core\Pages\Http\Requests\CreatePageContentRequest::class,
		'EditPageContentRequest' => Nova\Core\Pages\Http\Requests\EditPageContentRequest::class,
		'RemovePageContentRequest' => Nova\Core\Pages\Http\Requests\RemovePageContentRequest::class,
		'CreatePageRequest' => Nova\Core\Pages\Http\Requests\CreatePageRequest::class,
		'EditPageRequest' => Nova\Core\Pages\Http\Requests\EditPageRequest::class,
		'RemovePageRequest' => Nova\Core\Pages\Http\Requests\RemovePageRequest::class,
		'PagePolicy' => Nova\Core\Pages\Policies\PagePolicy::class,
		'PageContentPolicy' => Nova\Core\Pages\Policies\PageContentPolicy::class,

		/**
		 * Menus
		 */
		'Menu' => Nova\Core\Menus\Data\Menu::class,
		'MenuItem' => Nova\Core\Menus\Data\MenuItem::class,
		'MenuPresenter' => Nova\Core\Menus\Data\Presenters\MenuPresenter::class,
		'MenuItemPresenter' => Nova\Core\Menus\Data\Presenters\MenuItemPresenter::class,
		'MenuRepositoryInterface' => Nova\Core\Menus\Data\Interfaces\MenuRepositoryInterface::class,
		'MenuItemRepositoryInterface' => Nova\Core\Menus\Data\Interfaces\MenuItemRepositoryInterface::class,
		'MenuRepository' => Nova\Core\Menus\Data\Repositories\MenuRepository::class,
		'MenuItemRepository' => Nova\Core\Menus\Data\Repositories\MenuItemRepository::class,
		'CreateMenuItemRequest' => Nova\Core\Menus\Http\Requests\CreateMenuItemRequest::class,
		'EditMenuItemRequest' => Nova\Core\Menus\Http\Requests\EditMenuItemRequest::class,
		'RemoveMenuItemRequest' => Nova\Core\Menus\Http\Requests\RemoveMenuItemRequest::class,
		'CreateMenuRequest' => Nova\Core\Menus\Http\Requests\CreateMenuRequest::class,
		'EditMenuRequest' => Nova\Core\Menus\Http\Requests\EditMenuRequest::class,
		'RemoveMenuRequest' => Nova\Core\Menus\Http\Requests\RemoveMenuRequest::class,
		'MenuPolicy' => Nova\Core\Menus\Policies\MenuPolicy::class,
		'MenuItemPolicy' => Nova\Core\Menus\Policies\MenuItemPolicy::class,

		/**
		 * Access
		 */
		'Permission' => Nova\Core\Access\Data\Permission::class,
		'Role' => Nova\Core\Access\Data\Role::class,
		'RolePresenter' => Nova\Core\Access\Data\Presenters\RolePresenter::class,
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
		'HasRoles' => Nova\Core\Access\Traits\HasRoles::class,
		'RolePolicy' => Nova\Core\Access\Policies\RolePolicy::class,
		'PermissionPolicy' => Nova\Core\Access\Policies\PermissionPolicy::class,

		/**
		 * Forms
		 */
		'NovaForm' => Nova\Core\Forms\Data\Form::class,
		'FormPresenter' => Nova\Core\Forms\Data\Presenters\FormPresenter::class,
		'FormRepositoryInterface' => Nova\Core\Forms\Data\Interfaces\FormRepositoryInterface::class,
		'FormRepository' => Nova\Core\Forms\Data\Repositories\FormRepository::class,
		'FormPolicy' => Nova\Core\Forms\Policies\FormPolicy::class,
		'CreateFormRequest' => Nova\Core\Forms\Http\Requests\CreateFormRequest::class,
		'EditFormRequest' => Nova\Core\Forms\Http\Requests\EditFormRequest::class,
		'RemoveFormRequest' => Nova\Core\Forms\Http\Requests\RemoveFormRequest::class,

		'NovaFormField' => Nova\Core\Forms\Data\Field::class,
		'FormFieldPresenter' => Nova\Core\Forms\Data\Presenters\FieldPresenter::class,
		'FormFieldRepositoryInterface' => Nova\Core\Forms\Data\Interfaces\FieldRepositoryInterface::class,
		'FormFieldRepository' => Nova\Core\Forms\Data\Repositories\FieldRepository::class,
		'FieldPolicy' => Nova\Core\Forms\Policies\FieldPolicy::class,
		'CleanupFormFields' => Nova\Core\Forms\Listeners\CleanupFormFields::class,
		
		'NovaFormFieldValue' => Nova\Core\Forms\Data\FieldValue::class,
		'FormFieldValuePresenter' => Nova\Core\Forms\Data\Presenters\FieldValuePresenter::class,
		'FormFieldValueRepositoryInterface' => Nova\Core\Forms\Data\Interfaces\FieldValueRepositoryInterface::class,
		'FormFieldValueRepository' => Nova\Core\Forms\Data\Repositories\FieldValueRepository::class,
		'FieldValuePolicy' => Nova\Core\Forms\Policies\FieldValuePolicy::class,
		
		'NovaFormSection' => Nova\Core\Forms\Data\Section::class,
		'FormSectionPresenter' => Nova\Core\Forms\Data\Presenters\SectionPresenter::class,
		'FormSectionRepositoryInterface' => Nova\Core\Forms\Data\Interfaces\SectionRepositoryInterface::class,
		'FormSectionRepository' => Nova\Core\Forms\Data\Repositories\SectionRepository::class,
		'SectionPolicy' => Nova\Core\Forms\Policies\SectionPolicy::class,
		'CleanupFormSections' => Nova\Core\Forms\Listeners\CleanupFormSections::class,
		
		'NovaFormTab' => Nova\Core\Forms\Data\Tab::class,
		'FormTabPresenter' => Nova\Core\Forms\Data\Presenters\TabPresenter::class,
		'FormTabRepositoryInterface' => Nova\Core\Forms\Data\Interfaces\TabRepositoryInterface::class,
		'FormTabRepository' => Nova\Core\Forms\Data\Repositories\TabRepository::class,
		'TabPolicy' => Nova\Core\Forms\Policies\TabPolicy::class,
		'CreateFormTabRequest' => Nova\Core\Forms\Http\Requests\CreateFormTabRequest::class,
		'EditFormTabRequest' => Nova\Core\Forms\Http\Requests\EditFormTabRequest::class,
		'RemoveFormTabRequest' => Nova\Core\Forms\Http\Requests\RemoveFormTabRequest::class,
		'CleanupFormTabs' => Nova\Core\Forms\Listeners\CleanupFormTabs::class,
		
		'NovaFormData' => Nova\Core\Forms\Data\Data::class,
		'FormDataPresenter' => Nova\Core\Forms\Data\Presenters\DataPresenter::class,
	],

];
