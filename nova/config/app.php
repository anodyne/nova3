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

		/**
		 * Illuminate Service Providers
		 */
		'Illuminate\Foundation\Providers\ArtisanServiceProvider',
		'Illuminate\Auth\AuthServiceProvider',
		'Illuminate\Cache\CacheServiceProvider',
		'Illuminate\Foundation\Providers\CommandCreatorServiceProvider',
		'Illuminate\Session\CommandsServiceProvider',
		'Illuminate\Foundation\Providers\ComposerServiceProvider',
		'Illuminate\Routing\ControllerServiceProvider',
		'Illuminate\Cookie\CookieServiceProvider',
		'Illuminate\Database\DatabaseServiceProvider',
		'Illuminate\Encryption\EncryptionServiceProvider',
		'Illuminate\Filesystem\FilesystemServiceProvider',
		'Illuminate\Hashing\HashServiceProvider',
		'Illuminate\Html\HtmlServiceProvider',
		'Illuminate\Foundation\Providers\KeyGeneratorServiceProvider',
		'Illuminate\Log\LogServiceProvider',
		'Illuminate\Mail\MailServiceProvider',
		'Illuminate\Foundation\Providers\MaintenanceServiceProvider',
		'Illuminate\Database\MigrationServiceProvider',
		'Illuminate\Foundation\Providers\OptimizeServiceProvider',
		'Illuminate\Pagination\PaginationServiceProvider',
		'Illuminate\Foundation\Providers\PublisherServiceProvider',
		'Illuminate\Queue\QueueServiceProvider',
		'Illuminate\Redis\RedisServiceProvider',
		'Illuminate\Auth\Reminders\ReminderServiceProvider',
		'Illuminate\Foundation\Providers\RouteListServiceProvider',
		'Illuminate\Database\SeedServiceProvider',
		'Illuminate\Foundation\Providers\ServerServiceProvider',
		'Illuminate\Session\SessionServiceProvider',
		'Illuminate\Foundation\Providers\TinkerServiceProvider',
		'Illuminate\Translation\TranslationServiceProvider',
		'Illuminate\Validation\ValidationServiceProvider',
		'Illuminate\View\ViewServiceProvider',
		'Illuminate\Workbench\WorkbenchServiceProvider',

		/**
		 * Nova Service Providers
		 */
		'Cartalyst\Api\ApiServiceProvider',
		'nova\core\providers\ErrorServiceProvider',
		'nova\core\providers\NovaServiceProvider',
		'nova\core\providers\SystemRouteServiceProvider',
		'Nova\Setup\SetupServiceProvider',
		'Nova\Api\ApiServiceProvider',
		'nova\extensions\cartalyst\sentry\SentryServiceProvider',
		'nova\extensions\laravel\translation\TranslationServiceProvider',

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

		/**
		 * Illuminate Core Classes
		 */
		'App'             => 'Illuminate\Support\Facades\App',
		'Artisan'         => 'Illuminate\Support\Facades\Artisan',
		'Auth'            => 'Illuminate\Support\Facades\Auth',
		'Blade'           => 'Illuminate\Support\Facades\Blade',
		'Cache'           => 'Illuminate\Support\Facades\Cache',
		'ClassLoader'     => 'Illuminate\Support\ClassLoader',
		'Config'          => 'Illuminate\Support\Facades\Config',
		'Controller'      => 'Illuminate\Routing\Controllers\Controller',
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
		 * Nova Base Controllers
		 */
		'BaseController'		=> 'nova\core\controllers\base\Core',
		'MainBaseController'	=> 'nova\core\controllers\base\Main',
		'LoginBaseController'	=> 'nova\core\controllers\base\Login',
		'AdminBaseController'	=> 'nova\core\controllers\base\Admin',
		'AjaxBaseController'	=> 'nova\core\controllers\base\Ajax',
		'WikiBaseController'	=> 'Nova\Wiki\Controllers\Base\Wiki',
		'ForumBaseController'	=> 'nova\forum\controllers\base\Forum',
		'SetupBaseController'	=> 'Nova\Setup\Controllers\Base\Setup',

		/**
		 * Nova Classes
		 */
		'API'			=> 'Cartalyst\Api\Facades\API',
		'Date'			=> 'Carbon\Carbon',
		'DynamicForm'	=> 'nova\core\facades\DynamicForm',
		'Location'		=> 'nova\core\facades\Location',
		'Markdown'		=> 'nova\core\facades\Markdown',
		'Media'			=> 'nova\core\facades\Media',
		'Model'			=> 'nova\extensions\laravel\database\eloquent\Model',
		'Nav'			=> 'nova\core\lib\Nav',
		'Notify'		=> 'nova\core\facades\Notify',
		'Nova'			=> 'nova\core\facades\Nova',
		'Sentry' 		=> 'Cartalyst\Sentry\Facades\Laravel\Sentry',
		'Setup'			=> 'Nova\Setup\SetupFacade',
		'Status'		=> 'nova\core\lib\Status',
		'SystemEvent'	=> 'nova\core\facades\SystemEvent',

		'Input'			=> 'Cartalyst\Api\Facades\Input',
		'Request'		=> 'Cartalyst\Api\Facades\Request',
		'Response'		=> 'Cartalyst\Api\Facades\Response',

		/**
		 * Nova Interfaces
		 */
		'CacheInterface'			=> 'nova\core\interfaces\Cache',
		'FormDataInterface'			=> 'nova\core\interfaces\FormData',
		'MediaInterface'			=> 'nova\core\interfaces\Media',
		'QuickInstallInterface'		=> 'nova\core\interfaces\QuickInstall',
		'SearchInterface'			=> 'nova\core\interfaces\Search',

		/**
		 * Nova Traits
		 */
		'FormTrait'					=> 'nova\core\traits\Form',

		/**
		 * Nova Exceptions
		 */
		'MediaBadFileTypeException'		=> 'nova\core\exceptions\MediaBadFileTypeException',
		'MediaFileTooBigException'		=> 'nova\core\exceptions\MediaFileTooBigException',
		'MediaNoInputException'			=> 'nova\core\exceptions\MediaNoInputException',
		'MediaNotUploadedException'		=> 'nova\core\exceptions\MediaNotUploadedException',
		'NotifierNoContentException'	=> 'nova\core\exceptions\NotifierNoContentException',
		'NotifierNoSubjectException'	=> 'nova\core\exceptions\NotifierNoSubjectException',

		/**
		 * Nova Model Entities
		 */
		'AccessRole'				=> 'nova\core\models\entities\access\Role',
		'AccessRoleTask'			=> 'nova\core\models\entities\access\RoleTask',
		'AccessTask'				=> 'nova\core\models\entities\access\Task',

		'NovaApp'					=> 'nova\core\models\entities\Application',
		'NovaAppResponse'			=> 'nova\core\models\entities\application\Response',
		'NovaAppReviewer'			=> 'nova\core\models\entities\application\Reviewer',
		'NovaAppRule'				=> 'nova\core\models\entities\application\Rule',

		'Award'						=> 'nova\core\models\entities\Award',
		'AwardCategory'				=> 'nova\core\models\entities\award\Category',
		'AwardRecipient'			=> 'nova\core\models\entities\award\Recipient',
		
		'ModuleCatalog'				=> 'nova\core\models\entities\catalog\Module',
		'RankCatalog'				=> 'nova\core\models\entities\catalog\Rank',
		'SkinCatalog'				=> 'nova\core\models\entities\catalog\Skin',
		'WidgetCatalog'				=> 'nova\core\models\entities\catalog\Widget',

		'Character'					=> 'nova\core\models\entities\Character',
		'CharacterPosition'			=> 'nova\core\models\entities\character\Positions',
		'CharacterPromotion'		=> 'nova\core\models\entities\character\Promotion',

		'NovaForm'					=> 'nova\core\models\entities\Form',
		'NovaFormData'				=> 'nova\core\models\entities\form\Data',
		'NovaFormField'				=> 'nova\core\models\entities\form\Field',
		'NovaFormSection'			=> 'nova\core\models\entities\form\Section',
		'NovaFormTab'				=> 'nova\core\models\entities\form\Tab',
		'NovaFormValue'				=> 'nova\core\models\entities\form\Value',

		'Mission'					=> 'nova\core\models\entities\Mission',
		'MissionGroup'				=> 'nova\core\models\entities\mission\Group',
		'MissionNote'				=> 'nova\core\models\entities\mission\Note',

		'Post'						=> 'nova\core\models\entities\Post',
		'PostAuthor'				=> 'nova\core\models\entities\post\Author',
		'PostLock'					=> 'nova\core\models\entities\post\Lock',
		'PostParticipant'			=> 'nova\core\models\entities\post\Participant',

		'Rank'						=> 'nova\core\models\entities\Rank',
		'RankGroup'					=> 'nova\core\models\entities\rank\Group',
		'RankInfo'					=> 'nova\core\models\entities\rank\Info',

		'User'						=> 'nova\core\models\entities\User',
		'UserLoa'					=> 'nova\core\models\entities\user\Loa',
		'UserPrefs'					=> 'nova\core\models\entities\user\Preferences',
		'UserSuspend'				=> 'nova\core\models\entities\user\Suspend',

		'Announcement'				=> 'nova\core\models\entities\Announcement',
		'Ban'						=> 'nova\core\models\entities\Ban',
		'Comment'					=> 'nova\core\models\entities\Comment',
		'Dept'						=> 'nova\core\models\entities\Department',
		'Manifest'					=> 'nova\core\models\entities\Manifest',
		'MediaModel'				=> 'nova\core\models\entities\Media',
		'Message'					=> 'nova\core\models\entities\Message',
		'MessageRecipient'			=> 'nova\core\models\entities\MessageRecipient',
		'Moderation'				=> 'nova\core\models\entities\Moderation',
		'NavModel'					=> 'nova\core\models\entities\Nav',
		'PersonalLog'				=> 'nova\core\models\entities\PersonalLog',
		'Position'					=> 'nova\core\models\entities\Position',
		'Settings'					=> 'nova\core\models\entities\Settings',
		'SimType'					=> 'nova\core\models\entities\SimType',
		'SiteContent'				=> 'nova\core\models\entities\SiteContent',
		'System'					=> 'nova\core\models\entities\System',
		'SystemEventModel'			=> 'nova\core\models\entities\SystemEvent',
		'SystemRoute'				=> 'nova\core\models\entities\SystemRoute',

		/**
		 * Nova Model Event Handlers
		 */
		'AccessRoleEventHandler'		=> 'nova\core\models\events\access\Role',
		'AccessTaskEventHandler'		=> 'nova\core\models\events\access\Task',

		'NovaAppEventHandler'			=> 'nova\core\models\events\Application',

		'RankCatalogEventHandler'		=> 'nova\core\models\events\catalog\Rank',
		'SkinCatalogEventHandler'		=> 'nova\core\models\events\catalog\Skin',

		'NovaFormEventHandler'			=> 'nova\core\models\events\Form',
		'NovaFormFieldEventHandler'		=> 'nova\core\models\events\form\Field',
		'NovaFormSectionEventHandler'	=> 'nova\core\models\events\form\Section',
		'NovaFormTabEventHandler'		=> 'nova\core\models\events\form\Tab',
		'NovaFormValueEventHandler'		=> 'nova\core\models\events\form\Value',

		'RankEventHandler'				=> 'nova\core\models\events\Rank',
		'RankGroupEventHandler'			=> 'nova\core\models\events\rank\Group',
		'RankInfoEventHandler'			=> 'nova\core\models\events\rank\Info',
		
		'BaseEventHandler'				=> 'nova\core\models\events\Base',
		'CharacterEventHandler'			=> 'nova\core\models\events\Character',
		'CommentEventHandler'			=> 'nova\core\models\events\Comment',
		'PositionEventHandler'			=> 'nova\core\models\events\Position',
		'SettingsEventHandler'			=> 'nova\core\models\events\Settings',
		'SiteContentEventHandler'		=> 'nova\core\models\events\SiteContent',
		'SystemRouteEventHandler'		=> 'nova\core\models\events\SystemRoute',
		'UserEventHandler'				=> 'nova\core\models\events\User',

		/**
		 * Nova Model Validators
		 */
		'AccessRoleValidator'		=> 'nova\core\models\validators\access\Role',
		'AccessTaskValidator'		=> 'nova\core\models\validators\access\Task',

		'RankCatalogValidator'		=> 'nova\core\models\validators\catalog\Rank',
		'SkinCatalogValidator'		=> 'nova\core\models\validators\catalog\Skin',

		'FormValidator'				=> 'nova\core\models\validators\Form',
		'FormFieldValidator'		=> 'nova\core\models\validators\form\Field',
		'FormSectionValidator'		=> 'nova\core\models\validators\form\Section',
		'FormTabValidator'			=> 'nova\core\models\validators\form\Tab',
		'FormValueValidator'		=> 'nova\core\models\validators\form\Value',

		'BaseValidator'				=> 'nova\core\models\validators\Base',
		'SystemRouteValidator'		=> 'nova\core\models\validators\SystemRoute',
		'UserValidator'				=> 'nova\core\models\validators\User',

	],

];