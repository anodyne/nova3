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

	'debug' => true,

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
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => 'YourSecretKey!!!',

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

		'Illuminate\Foundation\Providers\ArtisanServiceProvider',
		'Illuminate\Auth\AuthServiceProvider',
		'Illuminate\Cache\CacheServiceProvider',
		'Illuminate\Session\CommandsServiceProvider',
		'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
		'Illuminate\Routing\ControllerServiceProvider',
		'Illuminate\Cookie\CookieServiceProvider',
		'Illuminate\Database\DatabaseServiceProvider',
		'Illuminate\Encryption\EncryptionServiceProvider',
		'Illuminate\Filesystem\FilesystemServiceProvider',
		'Illuminate\Hashing\HashServiceProvider',
		'Illuminate\Html\HtmlServiceProvider',
		'Illuminate\Log\LogServiceProvider',
		'Illuminate\Mail\MailServiceProvider',
		'Illuminate\Database\MigrationServiceProvider',
		'Illuminate\Pagination\PaginationServiceProvider',
		'Illuminate\Queue\QueueServiceProvider',
		'Illuminate\Redis\RedisServiceProvider',
		'Illuminate\Remote\RemoteServiceProvider',
		'Illuminate\Auth\Reminders\ReminderServiceProvider',
		'Illuminate\Database\SeedServiceProvider',
		'Illuminate\Session\SessionServiceProvider',
		'Illuminate\Translation\TranslationServiceProvider',
		'Illuminate\Validation\ValidationServiceProvider',
		'Illuminate\View\ViewServiceProvider',
		'Illuminate\Workbench\WorkbenchServiceProvider',

		'Nova\Core\Providers\ErrorServiceProvider',
		'Nova\Core\Providers\NovaServiceProvider',
		'Nova\Core\Providers\SystemRouteServiceProvider',
		'Nova\Setup\SetupServiceProvider',
		'Nova\Api\ApiServiceProvider',
		'Nova\Extensions\Cartalyst\Sentry\SentryServiceProvider',
		'Nova\Extensions\Laravel\Translation\TranslationServiceProvider',
		'Thomaswelton\LaravelGravatar\LaravelGravatarServiceProvider',
		'Intervention\Image\ImageServiceProvider',

	],

	/*
	|--------------------------------------------------------------------------
	| Service Provider Manifest
	|--------------------------------------------------------------------------
	|
	| The service provider manifest is used by Laravel to lazy load service
	| providers which are not needed for each request, as well to keep a
	| list of all of the services. Here, you may set its storage spot.
	|
	*/

	'manifest' => storage_path().'/meta',

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

		'App'             => 'Illuminate\Support\Facades\App',
		'Artisan'         => 'Illuminate\Support\Facades\Artisan',
		'Auth'            => 'Illuminate\Support\Facades\Auth',
		'Blade'           => 'Illuminate\Support\Facades\Blade',
		'Cache'           => 'Illuminate\Support\Facades\Cache',
		'ClassLoader'     => 'Illuminate\Support\ClassLoader',
		'Config'          => 'Illuminate\Support\Facades\Config',
		'Controller'      => 'Illuminate\Routing\Controller',
		'Cookie'          => 'Illuminate\Support\Facades\Cookie',
		'Crypt'           => 'Illuminate\Support\Facades\Crypt',
		'DB'              => 'Illuminate\Support\Facades\DB',
		'Eloquent'        => 'Illuminate\Database\Eloquent\Model',
		'Event'           => 'Illuminate\Support\Facades\Event',
		'File'            => 'Illuminate\Support\Facades\File',
		'Form'            => 'Illuminate\Support\Facades\Form',
		'Hash'            => 'Illuminate\Support\Facades\Hash',
		'HTML'            => 'Illuminate\Support\Facades\HTML',
		'Input'           => 'Illuminate\Support\Facades\Input',
		'Lang'            => 'Illuminate\Support\Facades\Lang',
		'Log'             => 'Illuminate\Support\Facades\Log',
		'Mail'            => 'Illuminate\Support\Facades\Mail',
		'Paginator'       => 'Illuminate\Support\Facades\Paginator',
		'Password'        => 'Illuminate\Support\Facades\Password',
		'Queue'           => 'Illuminate\Support\Facades\Queue',
		'Redirect'        => 'Illuminate\Support\Facades\Redirect',
		'Redis'           => 'Illuminate\Support\Facades\Redis',
		'Request'         => 'Illuminate\Support\Facades\Request',
		'Response'        => 'Illuminate\Support\Facades\Response',
		'Route'           => 'Illuminate\Support\Facades\Route',
		'Schema'          => 'Illuminate\Support\Facades\Schema',
		'Seeder'          => 'Illuminate\Database\Seeder',
		'Session'         => 'Illuminate\Support\Facades\Session',
		'Str'             => 'Illuminate\Support\Str',
		'URL'             => 'Illuminate\Support\Facades\URL',
		'Validator'       => 'Illuminate\Support\Facades\Validator',
		'View'            => 'Illuminate\Support\Facades\View',

		/**
		 * Base Controllers
		 */
		'BaseController'		=> 'Nova\Core\Controllers\Base\Core',
		'MainBaseController'	=> 'Nova\Core\Controllers\Base\Main',
		'LoginBaseController'	=> 'Nova\Core\Controllers\Base\Login',
		'AdminBaseController'	=> 'Nova\Core\Controllers\Base\Admin',
		'AjaxBaseController'	=> 'Nova\Core\Controllers\Base\Ajax',
		'WikiBaseController'	=> 'Nova\Wiki\Controllers\Base\Wiki',
		'ForumBaseController'	=> 'Nova\Forum\Controllers\Base\Forum',
		'SetupBaseController'	=> 'Nova\Setup\Controllers\Base\Setup',

		/**
		 * Nova Classes
		 */
		'Date'			=> 'Carbon\Carbon',
		'DynamicForm'	=> 'Nova\Core\Facades\DynamicForm',
		'ErrorCode'		=> 'Nova\Core\Utilities\ErrorCode',
		'Gravatar'		=> 'Thomaswelton\LaravelGravatar\Facades\Gravatar',
		'Image'			=> 'Intervention\Image\Facades\Image',
		'Location'		=> 'Nova\Core\Facades\Location',
		'Markdown'		=> 'Nova\Core\Facades\Markdown',
		'Media'			=> 'Nova\Core\Facades\Media',
		'Model'			=> 'Nova\Extensions\Laravel\Database\Eloquent\Model',
		'Nav'			=> 'Nova\Core\Lib\Nav',
		'Nova'			=> 'Nova\Core\Facades\Nova',
		'NovaAuth'		=> 'Nova\Core\Lib\Auth',
		'Setup'			=> 'Nova\Setup\SetupFacade',
		'Status'		=> 'Nova\Core\Utilities\Status',
		'SystemEvent'	=> 'Nova\Core\Facades\SystemEvent',

		'Activation'	=> 'Cartalyst\Sentry\Laravel\Facades\Activation',
		'Auth'			=> 'Cartalyst\Sentry\Laravel\Facades\Sentry',
		'Reminder'		=> 'Cartalyst\Sentry\Laravel\Facades\Reminder',
		'Sentry'		=> 'Cartalyst\Sentry\Laravel\Facades\Sentry',
		'SwipeIdentity'	=> 'Cartalyst\Sentry\Laravel\Facades\SwipeIdentity',
		
		/**
		 * Nova Interfaces
		 */
		'CacheInterface'			=> "Nova\Core\Interfaces\CacheInterface",
		'FormDataInterface'			=> "Nova\Core\Interfaces\FormDataInterface",
		'MediaInterface'			=> "Nova\Core\Interfaces\MediaInterface",
		'NovaAuthInterface'			=> "Nova\Core\Interfaces\NovaAuthInterface",
		'QuickInstallInterface'		=> "Nova\Core\Interfaces\QuickInstallInterface",
		'SearchInterface'			=> "Nova\Core\Interfaces\SearchInterface",

		/**
		 * Nova Traits
		 */
		'FormTrait'			=> "Nova\Core\Traits\FormTrait",
		'SecurityTrait'		=> "Nova\Core\Traits\SecurityTrait",
		'UtilityTrait'		=> "Nova\Core\Traits\UtilityTrait",

		/**
		 * Nova Mailers
		 */
		'BaseMailer'		=> "Nova\Core\Mailers\BaseMailer",
		'FormViewerMailer'	=> "Nova\Core\Mailers\FormViewerMailer",
		'UserMailer'		=> "Nova\Core\Mailers\UserMailer",

		/**
		 * Nova Exceptions
		 */
		'FormProtectedException'		=> "Nova\Core\Exceptions\FormProtectedException",
		'MediaBadFileTypeException'		=> "Nova\Core\Exceptions\MediaBadFileTypeException",
		'MediaFileTooBigException'		=> "Nova\Core\Exceptions\MediaFileTooBigException",
		'MediaNoInputException'			=> "Nova\Core\Exceptions\MediaNoInputException",
		'MediaNotUploadedException'		=> "Nova\Core\Exceptions\MediaNotUploadedException",
		'NotifierNoContentException'	=> "Nova\Core\Exceptions\NotifierNoContentException",
		'NotifierNoSubjectException'	=> "Nova\Core\Exceptions\NotifierNoSubjectException",
		'NovaGeneralException'			=> "Nova\Core\Exceptions\NovaGeneralException",
		'RouteProtectedException'		=> "Nova\Core\Exceptions\RouteProtectedException",

		/**
		 * Models
		 */
		'AccessRoleModel'			=> "Nova\Core\Models\Eloquent\Access\Role",
		'AccessRoleTaskModel'		=> "Nova\Core\Models\Eloquent\Access\RoleTask",
		'AccessTaskModel'			=> "Nova\Core\Models\Eloquent\Access\Task",

		'ApplicationModel'			=> "Nova\Core\Models\Eloquent\Application",
		'ApplicationResponseModel'	=> "Nova\Core\Models\Eloquent\Application\Response",
		'ApplicationReviewerModel'	=> "Nova\Core\Models\Eloquent\Application\Reviewer",
		'ApplicationRuleModel'		=> "Nova\Core\Models\Eloquent\Application\Rule",

		'AwardModel'				=> "Nova\Core\Models\Eloquent\Award",
		'AwardCategoryModel'		=> "Nova\Core\Models\Eloquent\Award\Category",
		'AwardRecipientModel'		=> "Nova\Core\Models\Eloquent\Award\Recipient",
		
		'ModuleCatalogModel'		=> "Nova\Core\Models\Eloquent\Catalog\Module",
		'RankCatalogModel'			=> "Nova\Core\Models\Eloquent\Catalog\Rank",
		'SkinCatalogModel'			=> "Nova\Core\Models\Eloquent\Catalog\Skin",
		'WidgetCatalogModel'		=> "Nova\Core\Models\Eloquent\Catalog\Widget",

		'CharacterModel'			=> "Nova\Core\Models\Eloquent\Character",
		'CharacterPositionModel'	=> "Nova\Core\Models\Eloquent\Character\Positions",
		'CharacterPromotionModel'	=> "Nova\Core\Models\Eloquent\Character\Promotion",

		'FormModel'					=> "Nova\Core\Models\Eloquent\Form",
		'FormDataModel'				=> "Nova\Core\Models\Eloquent\Form\Data",
		'FormFieldModel'			=> "Nova\Core\Models\Eloquent\Form\Field",
		'FormSectionModel'			=> "Nova\Core\Models\Eloquent\Form\Section",
		'FormTabModel'				=> "Nova\Core\Models\Eloquent\Form\Tab",
		'FormValueModel'			=> "Nova\Core\Models\Eloquent\Form\Value",

		'MissionModel'				=> "Nova\Core\Models\Eloquent\Mission",
		'MissionGroupModel'			=> "Nova\Core\Models\Eloquent\Mission\Group",
		'MissionNoteModel'			=> "Nova\Core\Models\Eloquent\Mission\Note",

		'PostModel'					=> "Nova\Core\Models\Eloquent\Post",
		'PostAuthorModel'			=> "Nova\Core\Models\Eloquent\Post\Author",
		'PostLockModel'				=> "Nova\Core\Models\Eloquent\Post\Lock",
		'PostParticipantModel'		=> "Nova\Core\Models\Eloquent\Post\Participant",

		'RankModel'					=> "Nova\Core\Models\Eloquent\Rank",
		'RankGroupModel'			=> "Nova\Core\Models\Eloquent\Rank\Group",
		'RankInfoModel'				=> "Nova\Core\Models\Eloquent\Rank\Info",

		'UserModel'					=> "Nova\Core\Models\Eloquent\User",
		'UserLoaModel'				=> "Nova\Core\Models\Eloquent\User\Loa",
		'UserPrefsModel'			=> "Nova\Core\Models\Eloquent\User\Preferences",
		'UserSuspendModel'			=> "Nova\Core\Models\Eloquent\User\Suspend",

		'AnnouncementModel'			=> "Nova\Core\Models\Eloquent\Announcement",
		'BanModel'					=> "Nova\Core\Models\Eloquent\Ban",
		'CommentModel'				=> "Nova\Core\Models\Eloquent\Comment",
		'DeptModel'					=> "Nova\Core\Models\Eloquent\Department",
		'ManifestModel'				=> "Nova\Core\Models\Eloquent\Manifest",
		'MediaModel'				=> "Nova\Core\Models\Eloquent\Media",
		'MessageModel'				=> "Nova\Core\Models\Eloquent\Message",
		'MessageRecipientModel'		=> "Nova\Core\Models\Eloquent\MessageRecipient",
		'ModerationModel'			=> "Nova\Core\Models\Eloquent\Moderation",
		'NavModel'					=> "Nova\Core\Models\Eloquent\Nav",
		'PersonalLogModel'			=> "Nova\Core\Models\Eloquent\PersonalLog",
		'PositionModel'				=> "Nova\Core\Models\Eloquent\Position",
		'SettingsModel'				=> "Nova\Core\Models\Eloquent\Settings",
		'SiteContentModel'			=> "Nova\Core\Models\Eloquent\SiteContent",
		'SystemModel'				=> "Nova\Core\Models\Eloquent\System",
		'SystemEventModel'			=> "Nova\Core\Models\Eloquent\SystemEvent",
		'SystemRouteModel'			=> "Nova\Core\Models\Eloquent\SystemRoute",

		/**
		 * Event Handlers
		 */
		//'AccessRoleEventHandler'		=> "Nova\Core\Events\AccessRoleEventHandler",
		//'ApplicationEventHandler'		=> "Nova\Core\Events\ApplicationEventHandler",
		'BaseEventHandler'				=> "Nova\Core\Events\BaseEventHandler",
		//'CatalogEventHandler'			=> "Nova\Core\Events\CatalogEventHandler",
		//'CharacterEventHandler'		=> "Nova\Core\Events\CharacterEventHandler",
		//'CommentEventHandler'			=> "Nova\Core\Events\CommentEventHandler",
		'FormEventHandler'				=> "Nova\Core\Events\FormEventHandler",
		//'MediaEventHandler'			=> "Nova\Core\Events\MediaEventHandler",
		'NavigationEventHandler'		=> "Nova\Core\Events\NavigationEventHandler",
		//'PositionEventHandler'		=> "Nova\Core\Events\PositionEventHandler",
		'RankEventHandler'				=> "Nova\Core\Events\RankEventHandler",
		//'SettingsEventHandler'		=> "Nova\Core\Events\SettingsEventHandler",
		'SiteContentEventHandler'		=> "Nova\Core\Events\SiteContentEventHandler",
		'SystemRouteEventHandler'		=> "Nova\Core\Events\SystemRouteEventHandler",
		'UserEventHandler'				=> "Nova\Core\Events\UserEventHandler",

		'AccessRoleModelEventHandler'	=> "Nova\\Core\\Events\\Models\\Access\\Role",
		'AccessTaskModelEventHandler'	=> "Nova\\Core\\Events\\Models\\Access\\Task",
		'ApplicationModelEventHandler'	=> "Nova\\Core\\Events\\Models\\Application",
		'RankCatalogModelEventHandler'	=> "Nova\\Core\\Events\\Models\\Catalog\\Rank",
		'SkinCatalogModelEventHandler'	=> "Nova\\Core\\Events\\Models\\Catalog\\Skin",
		'CharacterModelEventHandler'	=> "Nova\\Core\\Events\\Models\\Character",
		'CommentModelEventHandler'		=> "Nova\\Core\\Events\\Models\\Comment",
		'MediaModelEventHandler'		=> "Nova\\Core\\Events\\Models\\Media",
		'PositionModelEventHandler'		=> "Nova\\Core\\Events\\Models\\Position",

		/**
		 * Validators
		 */
		
		'AccessRoleValidator'		=> "Nova\Core\Validators\Access\RoleValidator",
		'AccessTaskValidator'		=> "Nova\Core\Validators\Access\TaskValidator",

		'RankCatalogValidator'		=> "Nova\Core\Validators\Catalog\RankValidator",
		'SkinCatalogValidator'		=> "Nova\Core\Validators\Catalog\SkinValidator",

		'FormValidator'				=> "Nova\Core\Validators\FormValidator",
		'FormFieldValidator'		=> "Nova\Core\Validators\Form\FieldValidator",
		'FormSectionValidator'		=> "Nova\Core\Validators\Form\SectionValidator",
		'FormTabValidator'			=> "Nova\Core\Validators\Form\TabValidator",
		'FormValueValidator'		=> "Nova\Core\Validators\Form\ValueValidator",

		'BaseValidator'				=> "Nova\Core\Validators\BaseValidator",
		'NavigationValidator'		=> "Nova\Core\Validators\NavigationValidator",
		'SiteContentValidator'		=> "Nova\Core\Validators\SiteContentValidator",
		'SystemRouteValidator'		=> "Nova\Core\Validators\SystemRouteValidator",
		'UserValidator'				=> "Nova\Core\Validators\UserValidator",

		/**
		 * Repositories
		 */
		'AccessRoleRepository'		=> "Nova\Core\Repositories\Eloquent\AccessRoleRepository",
		'CatalogRepository'			=> "Nova\Core\Repositories\Eloquent\CatalogRepository",
		'FormRepository'			=> "Nova\Core\Repositories\Eloquent\FormRepository",
		'NavigationRepository'		=> "Nova\Core\Repositories\Eloquent\NavigationRepository",
		'SettingsRepository'		=> "Nova\Core\Repositories\Eloquent\SettingsRepository",
		'SiteContentRepository'		=> "Nova\Core\Repositories\Eloquent\SiteContentRepository",
		'SystemRouteRepository'		=> "Nova\Core\Repositories\Eloquent\SystemRouteRepository",
		'UserRepository'			=> "Nova\Core\Repositories\Eloquent\UserRepository",

		/**
		 * Repository Interfaces
		 */
		'BaseRepositoryInterface'			=> "Nova\Core\Interfaces\BaseRepositoryInterface",

		'AccessRoleRepositoryInterface'		=> "Nova\Core\Interfaces\Repositories\AccessRoleRepositoryInterface",
		'CatalogRepositoryInterface'		=> "Nova\Core\Interfaces\Repositories\CatalogRepositoryInterface",
		'FormRepositoryInterface'			=> "Nova\Core\Interfaces\Repositories\FormRepositoryInterface",
		'NavigationRepositoryInterface'		=> "Nova\Core\Interfaces\Repositories\NavigationRepositoryInterface",
		'SettingsRepositoryInterface'		=> "Nova\Core\Interfaces\Repositories\SettingsRepositoryInterface",
		'SiteContentRepositoryInterface'	=> "Nova\Core\Interfaces\Repositories\SiteContentRepositoryInterface",
		'SystemRouteRepositoryInterface'	=> "Nova\Core\Interfaces\Repositories\SystemRouteRepositoryInterface",
		'UserRepositoryInterface'			=> "Nova\Core\Interfaces\Repositories\UserRepositoryInterface",

	],

];