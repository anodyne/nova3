<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Application Environment
	|--------------------------------------------------------------------------
	|
	| This value determines the "environment" your application is currently
	| running in. This may determine how you prefer to configure various
	| services your application utilizes. Set this in your ".env" file.
	|
	*/
	'env' => env('APP_ENV', 'local'),

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

	'key' => env('APP_KEY', 'base64:TMZNjNdADtYcKjuYMTL1LoFP15PTYCjxku8g8y+rUe4='),

	'cipher' => 'AES-256-CBC',

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

	'log_level' => env('APP_LOG_LEVEL', 'debug'),

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
		Illuminate\Auth\AuthServiceProvider::class,
		Illuminate\Broadcasting\BroadcastServiceProvider::class,
		Illuminate\Bus\BusServiceProvider::class,
		Illuminate\Cache\CacheServiceProvider::class,
		Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
		Illuminate\Cookie\CookieServiceProvider::class,
		Illuminate\Database\DatabaseServiceProvider::class,
		Illuminate\Encryption\EncryptionServiceProvider::class,
		Illuminate\Filesystem\FilesystemServiceProvider::class,
		Illuminate\Foundation\Providers\FoundationServiceProvider::class,
		Illuminate\Hashing\HashServiceProvider::class,
		Illuminate\Mail\MailServiceProvider::class,
		Illuminate\Notifications\NotificationServiceProvider::class,
		Illuminate\Pagination\PaginationServiceProvider::class,
		Illuminate\Pipeline\PipelineServiceProvider::class,
		Illuminate\Queue\QueueServiceProvider::class,
		Illuminate\Redis\RedisServiceProvider::class,
		Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
		Illuminate\Session\SessionServiceProvider::class,
		Illuminate\Translation\TranslationServiceProvider::class,
		Illuminate\Validation\ValidationServiceProvider::class,
		Illuminate\View\ViewServiceProvider::class,

		/**
		 * Package Service Providers
		 */

		Dingo\Api\Provider\LaravelServiceProvider::class,
		Collective\Html\HtmlServiceProvider::class,
		Peslis\Gravatar\Laravel\GravatarServiceProvider::class,
		BladeSvg\BladeSvgServiceProvider::class,

		/*
		 * Nova Service Providers
		 */

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
		'Notification' => Illuminate\Support\Facades\Notification::class,
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

		'API'				=> Dingo\Api\Facade\API::class,
		'BaseController'	=> Nova\Foundation\Http\Controllers\BaseController::class,
		'BasePresenter'		=> Nova\Foundation\Data\Presenters\BasePresenter::class,
		'Date'				=> Carbon\Carbon::class,
		'Debugbar'			=> Barryvdh\Debugbar\Facade::class,
		'Form'				=> Collective\Html\FormFacade::class,
		'Flash'				=> Nova\Foundation\Services\FlashNotifierFacade::class,
		'Gravatar'			=> Peslis\Gravatar\Laravel\GravatarFacade::class,
		'HTML'				=> Collective\Html\HtmlFacade::class,
		'Locate'			=> Nova\Foundation\Services\Locator\LocatorFacade::class,
		'Markdown'			=> Nova\Foundation\Services\MarkdownParserFacade::class,
		'MenuBuilder'		=> Spatie\Menu\Laravel\Menu::class,
		'Model'				=> Illuminate\Database\Eloquent\Model::class,
		'Nova'				=> Nova\Foundation\Facades\NovaFacade::class,
		'Nova'				=> Nova\Foundation\Nova::class,
		'Status'			=> Nova\Foundation\Services\StatusService::class,
		'StatusTrait'		=> Nova\Foundation\Traits\StatusTrait::class,
		'Str'				=> Illuminate\Support\Str::class,

		/**
		 * Mailers
		 */
		'BaseMailer' => Nova\Foundation\Services\Mailers\BaseMailer::class,
		'BaseMailable' => Nova\Foundation\BaseMailable::class,

		/**
		 * Models
		 */
		'Character' => Nova\Core\Characters\Data\Character::class,
		'Setting' => Nova\Core\Settings\Data\Setting::class,
		'System' => Nova\Foundation\Data\System::class,

		/**
		 * Repository Interfaces
		 */
		'CharacterRepositoryContract' => Nova\Core\Characters\Data\Contracts\CharacterRepositoryContract::class,
		'SettingRepositoryContract' => Nova\Core\Settings\Data\Contracts\SettingRepositoryContract::class,
		'SystemRepositoryContract' => Nova\Foundation\Data\Contracts\SystemRepositoryContract::class,

		/**
		 * Repositories
		 */
		'CharacterRepository' => Nova\Core\Characters\Data\Repositories\CharacterRepository::class,
		'SettingRepository' => Nova\Core\Settings\Data\Repositories\SettingRepository::class,
		'SystemRepository' => Nova\Foundation\Data\Repositories\SystemRepository::class,

		/**
		 * Services
		 */
		'CharacterCreator' => Nova\Core\Characters\CharacterCreator::class,

		/**
		 * Pages
		 */
		'Page' => Nova\Core\Pages\Data\Page::class,
		'PageContent' => Nova\Core\Pages\Data\PageContent::class,
		'PagePresenter' => Nova\Core\Pages\Data\Presenters\PagePresenter::class,
		'PageContentPresenter' => Nova\Core\Pages\Data\Presenters\PageContentPresenter::class,
		'PageRepositoryContract' => Nova\Core\Pages\Data\Contracts\PageRepositoryContract::class,
		'PageContentRepositoryContract' => Nova\Core\Pages\Data\Contracts\PageContentRepositoryContract::class,
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
		'MenuRepositoryContract' => Nova\Core\Menus\Data\Contracts\MenuRepositoryContract::class,
		'MenuItemRepositoryContract' => Nova\Core\Menus\Data\Contracts\MenuItemRepositoryContract::class,
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
		'PermissionRepositoryContract' => Nova\Core\Access\Data\Contracts\PermissionRepositoryContract::class,
		'RoleRepositoryContract' => Nova\Core\Access\Data\Contracts\RoleRepositoryContract::class,
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
		'FormRepositoryContract' => Nova\Core\Forms\Data\Contracts\FormRepositoryContract::class,
		'FormRepository' => Nova\Core\Forms\Data\Repositories\FormRepository::class,
		'FormPolicy' => Nova\Core\Forms\Policies\FormPolicy::class,
		'CreateFormRequest' => Nova\Core\Forms\Http\Requests\CreateFormRequest::class,
		'EditFormRequest' => Nova\Core\Forms\Http\Requests\EditFormRequest::class,
		'RemoveFormRequest' => Nova\Core\Forms\Http\Requests\RemoveFormRequest::class,

		'NovaFormField' => Nova\Core\Forms\Data\Field::class,
		'FormFieldPresenter' => Nova\Core\Forms\Data\Presenters\FieldPresenter::class,
		'FormFieldRepositoryContract' => Nova\Core\Forms\Data\Contracts\FieldRepositoryContract::class,
		'FormFieldRepository' => Nova\Core\Forms\Data\Repositories\FieldRepository::class,
		'FieldPolicy' => Nova\Core\Forms\Policies\FieldPolicy::class,
		'CreateFormFieldRequest' => Nova\Core\Forms\Http\Requests\CreateFormFieldRequest::class,
		'EditFormFieldRequest' => Nova\Core\Forms\Http\Requests\EditFormFieldRequest::class,
		'RemoveFormFieldRequest' => Nova\Core\Forms\Http\Requests\RemoveFormFieldRequest::class,
		
		'NovaFormSection' => Nova\Core\Forms\Data\Section::class,
		'FormSectionPresenter' => Nova\Core\Forms\Data\Presenters\SectionPresenter::class,
		'FormSectionRepositoryContract' => Nova\Core\Forms\Data\Contracts\SectionRepositoryContract::class,
		'FormSectionRepository' => Nova\Core\Forms\Data\Repositories\SectionRepository::class,
		'SectionPolicy' => Nova\Core\Forms\Policies\SectionPolicy::class,
		'CreateFormSectionRequest' => Nova\Core\Forms\Http\Requests\CreateFormSectionRequest::class,
		'EditFormSectionRequest' => Nova\Core\Forms\Http\Requests\EditFormSectionRequest::class,
		'RemoveFormSectionRequest' => Nova\Core\Forms\Http\Requests\RemoveFormTabRequest::class,
		
		'NovaFormTab' => Nova\Core\Forms\Data\Tab::class,
		'FormTabPresenter' => Nova\Core\Forms\Data\Presenters\TabPresenter::class,
		'FormTabRepositoryContract' => Nova\Core\Forms\Data\Contracts\TabRepositoryContract::class,
		'FormTabRepository' => Nova\Core\Forms\Data\Repositories\TabRepository::class,
		'TabPolicy' => Nova\Core\Forms\Policies\TabPolicy::class,
		'CreateFormTabRequest' => Nova\Core\Forms\Http\Requests\CreateFormTabRequest::class,
		'EditFormTabRequest' => Nova\Core\Forms\Http\Requests\EditFormTabRequest::class,
		'RemoveFormTabRequest' => Nova\Core\Forms\Http\Requests\RemoveFormTabRequest::class,
		
		'NovaFormData' => Nova\Core\Forms\Data\Data::class,
		'FormDataPresenter' => Nova\Core\Forms\Data\Presenters\DataPresenter::class,
		'FormDataRepositoryContract' => Nova\Core\Forms\Data\Contracts\DataRepositoryContract::class,
		'FormDataRepository' => Nova\Core\Forms\Data\Repositories\DataRepository::class,

		'FormEntryRepositoryContract' => Nova\Core\Forms\Data\Contracts\EntryRepositoryContract::class,
		'FormEntryRepository' => Nova\Core\Forms\Data\Repositories\EntryRepository::class,
		'EmailFormCenterRecipients' => Nova\Core\Forms\Listeners\EmailFormCenterRecipients::class,
		'FormCenterMailer' => Nova\Core\Forms\Mailers\FormCenterMailer::class,
		'FormEntryPresenter' => Nova\Core\Forms\Data\Presenters\EntryPresenter::class,
		'NovaFormEntry' => Nova\Core\Forms\Data\Entry::class,
		'FormCenterUserTrait' => Nova\Core\Forms\Traits\FormCenterUserTrait::class,

		/**
		 * Users
		 */
		'User' => Nova\Core\Users\Data\User::class,
		'UserPreference' => Nova\Core\Users\Data\UserPreference::class,
		'PreferenceDefault' => Nova\Core\Users\Data\PreferenceDefault::class,
		'UserRepositoryContract' => Nova\Core\Users\Data\Contracts\UserRepositoryContract::class,
		'UserPreferenceRepositoryContract' => Nova\Core\Users\Data\Contracts\UserPreferenceRepositoryContract::class,
		'PreferenceDefaultRepositoryContract' => Nova\Core\Users\Data\Contracts\PreferenceDefaultRepositoryContract::class,
		'UserRepository' => Nova\Core\Users\Data\Repositories\UserRepository::class,
		'UserPreferenceRepository' => Nova\Core\Users\Data\Repositories\UserPreferenceRepository::class,
		'PreferenceDefaultRepository' => Nova\Core\Users\Data\Repositories\PreferenceDefaultRepository::class,
		'UserCreator' => Nova\Core\Users\UserCreator::class,
		'UserPresenter' => Nova\Core\Users\Data\Presenters\UserPresenter::class,
		'UserPolicy' => Nova\Core\Users\Policies\UserPolicy::class,
		'CreateUserRequest' => Nova\Core\Users\Http\Requests\CreateUserRequest::class,
		'EditUserRequest' => Nova\Core\Users\Http\Requests\EditUserRequest::class,
		'RemoveUserRequest' => Nova\Core\Users\Http\Requests\RemoveUserRequest::class,
		'BuildUserPreferences' => Nova\Core\Users\Listeners\BuildUserPreferences::class,
		'EmailNewUserPassword' => Nova\Core\Users\Listeners\EmailNewUserPassword::class,
		'AdminCreatedUserMailer' => Nova\Core\Users\Mail\AdminCreatedUser::class,
	],

];
