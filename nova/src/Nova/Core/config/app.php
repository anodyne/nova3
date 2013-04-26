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
		'Illuminate\Html\HtmlServiceProvider',
		'Illuminate\Foundation\Providers\KeyGeneratorServiceProvider',
		'Illuminate\Log\LogServiceProvider',
		'Illuminate\Mail\MailServiceProvider',
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
		//'Illuminate\Translation\TranslationServiceProvider',
		'Illuminate\Validation\ValidationServiceProvider',
		'Illuminate\View\ViewServiceProvider',
		'Illuminate\Workbench\WorkbenchServiceProvider',

		/**
		 * Nova Service Providers
		 */
		'Nova\Citadel\CitadelServiceProvider',
		'Nova\Core\Providers\LocationServiceProvider',
		'Nova\Foundation\Routing\RoutingServiceProvider',
		'Nova\Foundation\Translation\TranslationServiceProvider',

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
		'Form'            => 'Illuminate\Support\Facades\Form',
		'Hash'            => 'Illuminate\Support\Facades\Hash',
		'Html'            => 'Illuminate\Support\Facades\Html',
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
		'Date'			=> 'Carbon\Carbon',
		'Email'			=> 'Nova\Core\Lib\Email',
		'Location'		=> 'Nova\Core\Facades\Location',
		'Markdown'		=> 'Nova\Core\Lib\Markdown',
		'Media'			=> 'Nova\Core\Lib\Media',
		'Model'			=> 'Nova\Foundation\Database\Eloquent\Model',
		'Nav'			=> 'Nova\Core\Lib\Nav',
		'Sentry' 		=> 'Cartalyst\Sentry\Facades\Laravel\Sentry',
		'Status'		=> 'Nova\Core\Lib\Status',
		'SystemEvent'	=> 'Nova\Core\Lib\SystemEvent',
		'Utility'		=> 'Nova\Core\Lib\Utility',

		/**
		 * Nova Interfaces
		 */
		'MediaInterface'			=> 'Nova\Core\Contracts\Media',
		'QuickInstallInterface'		=> 'Nova\Core\Contracts\QuickInstall',
		'SearchInterface'			=> 'Nova\Core\Contracts\Search',

		/**
		 * Nova Models
		 */
		'AccessRole'				=> 'Nova\Core\Model\Access\Role',
		'AccessRoleTask'			=> 'Nova\Core\Model\Access\RoleTask',
		'AccessTask'				=> 'Nova\Core\Model\Access\Task',

		'NovaApp'					=> 'Nova\Core\Model\Application',
		'NovaAppResponse'			=> 'Nova\Core\Model\Application\Response',
		'NovaAppReviewer'			=> 'Nova\Core\Model\Application\Reviewer',
		'NovaAppRule'				=> 'Nova\Core\Model\Application\Rule',

		'Award'						=> 'Nova\Core\Model\Award',
		'AwardCategory'				=> 'Nova\Core\Model\Award\Category',
		'AwardRecipient'			=> 'Nova\Core\Model\Award\Recipient',
		
		'ModuleCatalog'				=> 'Nova\Core\Model\Catalog\Module',
		'RankCatalog'				=> 'Nova\Core\Model\Catalog\Rank',
		'SkinCatalog'				=> 'Nova\Core\Model\Catalog\Skin',
		'SkinSectionCatalog'		=> 'Nova\Core\Model\Catalog\SkinSection',
		'WidgetCatalog'				=> 'Nova\Core\Model\Catalog\Widget',

		'Character'					=> 'Nova\Core\Model\Character',
		'CharacterPosition'			=> 'Nova\Core\Model\Character\Positions',
		'CharacterPromotion'		=> 'Nova\Core\Model\Character\Promotion',

		'NovaForm'					=> 'Nova\Core\Model\Form',
		'NovaFormData'				=> 'Nova\Core\Model\Form\Data',
		'NovaFormField'				=> 'Nova\Core\Model\Form\Field',
		'NovaFormSection'			=> 'Nova\Core\Model\Form\Section',
		'NovaFormTab'				=> 'Nova\Core\Model\Form\Tab',
		'NovaFormValue'				=> 'Nova\Core\Model\Form\Value',

		'Mission'					=> 'Nova\Core\Model\Mission',
		'MissionGroup'				=> 'Nova\Core\Model\Mission\Group',
		'MissionNote'				=> 'Nova\Core\Model\Mission\Note',

		'Post'						=> 'Nova\Core\Model\Post',
		'PostAuthor'				=> 'Nova\Core\Model\Post\Author',
		'PostLock'					=> 'Nova\Core\Model\Post\Lock',
		'PostParticipant'			=> 'Nova\Core\Model\Post\Participant',

		'Rank'						=> 'Nova\Core\Model\Rank',
		'RankGroup'					=> 'Nova\Core\Model\Rank\Group',
		'RankInfo'					=> 'Nova\Core\Model\Rank\Info',

		'User'						=> 'Nova\Core\Model\User',
		'UserLoa'					=> 'Nova\Core\Model\User\Loa',
		'UserPrefs'					=> 'Nova\Core\Model\User\Preferences',
		'UserSuspend'				=> 'Nova\Core\Model\User\Suspend',

		'Announcement'				=> 'Nova\Core\Model\Announcement',
		'Ban'						=> 'Nova\Core\Model\Ban',
		'Comment'					=> 'Nova\Core\Model\Comment',
		'Dept'						=> 'Nova\Core\Model\Department',
		'Manifest'					=> 'Nova\Core\Model\Manifest',
		'Media'						=> 'Nova\Core\Model\Media',
		'Message'					=> 'Nova\Core\Model\Message',
		'MessageRecipient'			=> 'Nova\Core\Model\MessageRecipient',
		'Moderation'				=> 'Nova\Core\Model\Moderation',
		'NavModel'					=> 'Nova\Core\Model\Nav',
		'PersonalLog'				=> 'Nova\Core\Model\PersonalLog',
		'Position'					=> 'Nova\Core\Model\Position',
		'Settings'					=> 'Nova\Core\Model\Settings',
		'SimType'					=> 'Nova\Core\Model\SimType',
		'SiteContent'				=> 'Nova\Core\Model\SiteContent',
		'System'					=> 'Nova\Core\Model\System',
		'SystemEventModel'			=> 'Nova\Core\Model\SystemEvent',

		/**
		 * Nova Event Handlers
		 */
		'NovaFormFieldHandler'		=> 'Nova\Core\Handlers\Form\Field',
		'NovaFormSectionHandler'	=> 'Nova\Core\Handlers\Form\Section',
		'NovaFormTabHandler'		=> 'Nova\Core\Handlers\Form\Tab',

		'RankGroupHandler'			=> 'Nova\Core\Handlers\Rank\Group',
		'RankInfoHandler'			=> 'Nova\Core\Handlers\Rank\Info',
		
		'AppHandler'				=> 'Nova\Core\Handlers\Application',
		'CharacterHandler'			=> 'Nova\Core\Handlers\Character',
		'CommentHandler'			=> 'Nova\Core\Handlers\Comment',
		'PositionHandler'			=> 'Nova\Core\Handlers\Position',
		'RankHandler'				=> 'Nova\Core\Handlers\Rank',
		'UserHandler'				=> 'Nova\Core\Handlers\User',

		/**
		 * Nova Validator Service
		 */
		'AccessRoleValidator'	=> 'Nova\Core\Services\Validators\Access\Role',
		'AccessTaskValidator'	=> 'Nova\Core\Services\Validators\Access\Task',

		'BaseValidator'			=> 'Nova\Core\Services\Validators\Base',
		'UserValidator'			=> 'Nova\Core\Services\Validators\User',

	),

);