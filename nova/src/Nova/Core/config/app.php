<?php

return array(

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
	| to a random, long string, otherwise these encrypted values will not
	| be safe. Make sure to change it before deploying any application!
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

	'providers' => array(

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
		'Illuminate\Log\LogServiceProvider',
		'Illuminate\Mail\MailServiceProvider',
		'Illuminate\Database\MigrationServiceProvider',
		'Illuminate\Pagination\PaginationServiceProvider',
		'Illuminate\Foundation\Providers\PublisherServiceProvider',
		'Illuminate\Queue\QueueServiceProvider',
		'Illuminate\Redis\RedisServiceProvider',
		'Illuminate\Auth\Reminders\ReminderServiceProvider',
		'Illuminate\Database\SeedServiceProvider',
		'Illuminate\Foundation\Providers\ServerServiceProvider',
		'Illuminate\Session\SessionServiceProvider',
		'Illuminate\Foundation\Providers\TinkerServiceProvider',
		//'Illuminate\Translation\TranslationServiceProvider',
		'Illuminate\Validation\ValidationServiceProvider',
		'Illuminate\View\ViewServiceProvider',
		'Illuminate\Workbench\WorkbenchServiceProvider',

		/**
		 * Nova Service Providers
		 */
		'Nova\Citadel\CitadelServiceProvider',
		'Nova\Foundation\Routing\RoutingServiceProvider',
		'Nova\Foundation\Translation\TranslationServiceProvider',

		'Meido\HTML\HTMLServiceProvider',

	),

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

	'manifest' => APPPATH.'storage/meta',

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

	'aliases' => array(

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
		'Hash'            => 'Illuminate\Support\Facades\Hash',
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
		'BaseController'		=> 'Nova\Core\Controller\Base\Core',
		'MainBaseController'	=> 'Nova\Core\Controller\Base\Main',
		'LoginBaseController'	=> 'Nova\Core\Controller\Base\Login',
		'AdminBaseController'	=> 'Nova\Core\Controller\Base\Admin',
		'AjaxBaseController'	=> 'Nova\Core\Controller\Base\Ajax',
		'WikiBaseController'	=> 'Nova\Wiki\Controller\Base\Wiki',
		'ForumBaseController'	=> 'Nova\Forum\Controller\Base\Forum',

		/**
		 * Nova Classes
		 */
		'Date'		=> 'Datum\Datum',
		'Debug'		=> 'Nova\Core\Lib\Debug',
		'HTML'		=> 'Meido\HTML\HTMLFacade',
		'Markdown'	=> 'Nova\Core\Lib\Markdown',
		'Model'		=> 'Nova\Foundation\Database\Eloquent\Model',
		'Nav'		=> 'Nova\Core\Lib\Nav',
		'Sentry' 	=> 'Cartalyst\Sentry\Facades\Laravel\Sentry',
		'Status'	=> 'Nova\Core\Lib\Status',
		'Utility'	=> 'Nova\Core\Lib\Utility',

		/**
		 * Nova Interfaces
		 */
		'QuickInstallInterface'	=> 'Nova\Core\Lib\QuickInstallInterface',
		'SearchInterface'		=> 'Nova\Core\Lib\SearchInterface',

		/**
		 * Nova Models
		 */
		'AccessRoleModel'			=> 'Nova\Core\Model\Access\Role',
		'AccessRoleTaskModel'		=> 'Nova\Core\Model\Access\RoleTask',
		'AccessTaskModel'			=> 'Nova\Core\Model\Access\Task',

		'AppModel'					=> 'Nova\Core\Model\Application',
		'AppResponseModel'			=> 'Nova\Core\Model\Application\Response',
		'AppReviewerModel'			=> 'Nova\Core\Model\Application\Reviewer',
		'AppRuleModel'				=> 'Nova\Core\Model\Application\Rule',

		'AwardModel'				=> 'Nova\Core\Model\Award',
		'AwardCategoryModel'		=> 'Nova\Core\Model\Award\Category',
		'AwardQueueModel'			=> 'Nova\Core\Model\Award\Queue',
		'AwardReceiveModel'			=> 'Nova\Core\Model\Award\Receive',
		
		'ModuleCatalogModel'		=> 'Nova\Core\Model\Catalog\Module',
		'RankCatalogModel'			=> 'Nova\Core\Model\Catalog\Rank',
		'SkinCatalogModel'			=> 'Nova\Core\Model\Catalog\Skin',
		'SkinSectionCatalogModel'	=> 'Nova\Core\Model\Catalog\SkinSection',
		'WidgetCatalogModel'		=> 'Nova\Core\Model\Catalog\Widget',

		'CharacterModel'			=> 'Nova\Core\Model\Character',
		'CharacterImageModel'		=> 'Nova\Core\Model\Character\Image',
		'CharacterPositionModel'	=> 'Nova\Core\Model\Character\Positions',
		'CharacterPromotionModel'	=> 'Nova\Core\Model\Character\Promotion',

		'FormModel'					=> 'Nova\Core\Model\Form',
		'FormDataModel'				=> 'Nova\Core\Model\Form\Data',
		'FormFieldModel'			=> 'Nova\Core\Model\Form\Field',
		'FormSectionModel'			=> 'Nova\Core\Model\Form\Section',
		'FormTabModel'				=> 'Nova\Core\Model\Form\Tab',
		'FormValueModel'			=> 'Nova\Core\Model\Form\Value',

		'RankModel'					=> 'Nova\Core\Model\Rank',
		'RankGroupModel'			=> 'Nova\Core\Model\Rank\Group',
		'RankInfoModel'				=> 'Nova\Core\Model\Rank\Info',

		'UserModel'					=> 'Nova\Core\Model\User',
		'UserLoaModel'				=> 'Nova\Core\Model\User\Loa',
		'UserPrefsModel'			=> 'Nova\Core\Model\User\Preferences',
		'UserSuspendModel'			=> 'Nova\Core\Model\User\Suspend',

		'AnnouncementModel'			=> 'Nova\Core\Model\Announcement',
		'AnnouncementCategoryModel'	=> 'Nova\Core\Model\AnnouncementCategory',
		'BanModel'					=> 'Nova\Core\Model\Ban',
		'CommentModel'				=> 'Nova\Core\Model\Comment',
		'DeptModel'					=> 'Nova\Core\Model\Department',
		'ManifestModel'				=> 'Nova\Core\Model\Manifest',
		'MediaModel'				=> 'Nova\Core\Model\Media',
		'MessageModel'				=> 'Nova\Core\Model\Message',
		'MessageRecipientModel'		=> 'Nova\Core\Model\MessageRecipient',
		'MissionModel'				=> 'Nova\Core\Model\Mission',
		'MissionGroupModel'			=> 'Nova\Core\Model\MissionGroup',
		'ModerationModel'			=> 'Nova\Core\Model\Moderation',
		'NavModel'					=> 'Nova\Core\Model\Nav',
		'LogModel'					=> 'Nova\Core\Model\PersonalLog',
		'PositionModel'				=> 'Nova\Core\Model\Position',
		'PostModel'					=> 'Nova\Core\Model\Post',
		'PostAuthorModel'			=> 'Nova\Core\Model\PostAuthor',
		'SettingsModel'				=> 'Nova\Core\Model\Settings',
		'SimTypeModel'				=> 'Nova\Core\Model\SimType',
		'SiteContentModel'			=> 'Nova\Core\Model\SiteContent',
		'SystemModel'				=> 'Nova\Core\Model\System',
		'SystemEventModel'			=> 'Nova\Core\Model\SystemEvent',

	),

);
