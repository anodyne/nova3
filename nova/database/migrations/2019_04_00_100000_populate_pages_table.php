<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Pages\Enums\PageVerb;
use Nova\Pages\Models\Page;

class PopulatePagesTable extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        $pages = [
            ['name' => 'Home', 'uri' => '/', 'key' => 'home', 'resource' => 'Nova\\Foundation\\Controllers\\WelcomeController'],
            ['name' => 'Dashboard', 'uri' => 'dashboard', 'key' => 'dashboard', 'resource' => 'Nova\\Dashboards\\Controllers\\DashboardController', 'layout' => 'admin'],
            ['name' => 'System overview dashboard', 'uri' => 'system-overview', 'key' => 'system-overview', 'resource' => 'Nova\\Dashboards\\Controllers\\SystemOverviewController', 'layout' => 'admin'],
            ['name' => 'Writing dashboard', 'uri' => 'writing-overview', 'key' => 'writing-overview', 'resource' => 'Nova\\Stories\\Controllers\\WritingOverviewController', 'layout' => 'admin'],
            ['name' => 'List activity logs', 'uri' => 'activity-log', 'key' => 'activity-log.index', 'resource' => 'Nova\\Dashboards\\Controllers\\ActivityLogController@index', 'layout' => 'admin'],
            ['name' => 'View activity log', 'uri' => 'activity-log/{activity}/show', 'key' => 'activity-log.show', 'resource' => 'Nova\\Dashboards\\Controllers\\ActivityLogController@show', 'layout' => 'admin'],

            ['name' => 'List themes', 'uri' => 'site-themes', 'key' => 'themes.index', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@index', 'layout' => 'admin'],
            ['name' => 'View theme', 'uri' => 'site-themes/{theme}/show', 'key' => 'themes.show', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@show', 'layout' => 'admin'],
            ['name' => 'Create theme', 'uri' => 'site-themes/create', 'key' => 'themes.create', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@create', 'layout' => 'admin'],
            ['name' => 'Store theme', 'uri' => 'site-themes', 'key' => 'themes.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@store', 'layout' => 'admin'],
            ['name' => 'Edit theme', 'uri' => 'site-themes/{theme}/edit', 'key' => 'themes.edit', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@edit', 'layout' => 'admin'],
            ['name' => 'Update theme', 'uri' => 'site-themes/{theme}', 'key' => 'themes.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@update', 'layout' => 'admin'],

            ['name' => 'List roles', 'uri' => 'roles', 'key' => 'roles.index', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@index', 'layout' => 'admin'],
            ['name' => 'View role', 'uri' => 'roles/{role}/show', 'key' => 'roles.show', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@show', 'layout' => 'admin'],
            ['name' => 'Create role', 'uri' => 'roles/create', 'key' => 'roles.create', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@create', 'layout' => 'admin'],
            ['name' => 'Store role', 'uri' => 'roles', 'key' => 'roles.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Roles\\Controllers\\RoleController@store', 'layout' => 'admin'],
            ['name' => 'Edit role', 'uri' => 'roles/{role}/edit', 'key' => 'roles.edit', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@edit', 'layout' => 'admin'],
            ['name' => 'Update role', 'uri' => 'roles/{role}', 'key' => 'roles.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Roles\\Controllers\\RoleController@update', 'layout' => 'admin'],

            ['name' => 'List permissions', 'uri' => 'permissions', 'key' => 'permissions.index', 'resource' => 'Nova\\Roles\\Controllers\\PermissionController@index', 'layout' => 'admin'],

            ['name' => 'List users', 'uri' => 'users', 'key' => 'users.index', 'resource' => 'Nova\\Users\\Controllers\\UserController@index', 'layout' => 'admin'],
            ['name' => 'View user', 'uri' => 'users/{user}/show', 'key' => 'users.show', 'resource' => 'Nova\\Users\\Controllers\\UserController@show', 'layout' => 'admin'],
            ['name' => 'Create user', 'uri' => 'users/create', 'key' => 'users.create', 'resource' => 'Nova\\Users\\Controllers\\UserController@create', 'layout' => 'admin'],
            ['name' => 'Store user', 'uri' => 'users', 'key' => 'users.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Users\\Controllers\\UserController@store', 'layout' => 'admin'],
            ['name' => 'Edit user', 'uri' => 'users/{user}/edit', 'key' => 'users.edit', 'resource' => 'Nova\\Users\\Controllers\\UserController@edit', 'layout' => 'admin'],
            ['name' => 'Update user', 'uri' => 'users/{user}', 'key' => 'users.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Users\\Controllers\\UserController@update', 'layout' => 'admin'],

            ['name' => 'My account', 'uri' => 'account/{tab?}', 'key' => 'account.edit', 'resource' => 'Nova\\Users\\Controllers\\AccountController@edit', 'layout' => 'admin'],
            ['name' => 'Update my account', 'uri' => 'account', 'key' => 'account.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Users\\Controllers\\AccountController@update', 'layout' => 'admin'],

            ['name' => 'List all my notes', 'uri' => 'notes', 'key' => 'notes.index', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@index', 'layout' => 'admin'],
            ['name' => 'View my note', 'uri' => 'notes/{note}/show', 'key' => 'notes.show', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@show', 'layout' => 'admin'],
            ['name' => 'Create note', 'uri' => 'notes/create', 'key' => 'notes.create', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@create', 'layout' => 'admin'],
            ['name' => 'Store note', 'uri' => 'notes', 'key' => 'notes.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Notes\\Controllers\\NoteController@store', 'layout' => 'admin'],
            ['name' => 'Edit note', 'uri' => 'notes/{note}/edit', 'key' => 'notes.edit', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@edit', 'layout' => 'admin'],
            ['name' => 'Update note', 'uri' => 'notes/{note}', 'key' => 'notes.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Notes\\Controllers\\NoteController@update', 'layout' => 'admin'],

            ['name' => 'Appearance settings', 'uri' => 'settings/appearance', 'key' => 'settings.appearance.edit', 'resource' => 'Nova\\Settings\\Controllers\\AppearanceSettingsController@edit', 'layout' => 'admin'],
            ['name' => 'Update appearance settings', 'uri' => 'settings/appearance', 'key' => 'settings.appearance.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\AppearanceSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Character settings', 'uri' => 'settings/characters', 'key' => 'settings.characters.edit', 'resource' => 'Nova\\Settings\\Controllers\\CharacterSettingsController@edit', 'layout' => 'admin'],
            ['name' => 'Update character settings', 'uri' => 'settings/characters', 'key' => 'settings.characters.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\CharacterSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Content ratings settings', 'uri' => 'settings/content-ratings', 'key' => 'settings.content-ratings.edit', 'resource' => 'Nova\\Settings\\Controllers\\ContentRatingSettingsController@edit', 'layout' => 'admin'],
            ['name' => 'Update content settings ratings', 'uri' => 'settings/content-ratings', 'key' => 'settings.content-ratings.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\ContentRatingSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Email settings', 'uri' => 'settings/email', 'key' => 'settings.email.edit', 'resource' => 'Nova\\Settings\\Controllers\\EmailSettingsController@edit', 'layout' => 'admin'],
            ['name' => 'Update email settings', 'uri' => 'settings/email', 'key' => 'settings.email.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\EmailSettingsController@update', 'layout' => 'admin'],
            ['name' => 'General settings', 'uri' => 'settings/general', 'key' => 'settings.general.edit', 'resource' => 'Nova\\Settings\\Controllers\\GeneralSettingsController@edit', 'layout' => 'admin'],
            ['name' => 'Update general settings', 'uri' => 'settings/general', 'key' => 'settings.general.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\GeneralSettingsController@update', 'layout' => 'admin'],
            ['name' => 'Posting activity settings', 'uri' => 'settings/posting-activity', 'key' => 'settings.posting-activity.edit', 'resource' => 'Nova\\Settings\\Controllers\\PostingActivitySettingsController@edit', 'layout' => 'admin'],
            ['name' => 'Update posting activity settings', 'uri' => 'settings/posting-activity', 'key' => 'settings.posting-activity.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\PostingActivitySettingsController@update', 'layout' => 'admin'],
            ['name' => 'Notification settings', 'uri' => 'settings/notifications', 'key' => 'settings.notifications.edit', 'resource' => 'Nova\\Settings\\Controllers\\NotificationSettingsController@edit', 'layout' => 'admin'],

            ['name' => 'List rank groups', 'uri' => 'ranks/groups', 'key' => 'ranks.groups.index', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@index', 'layout' => 'admin'],
            ['name' => 'View rank group', 'uri' => 'ranks/groups/{group}/show', 'key' => 'ranks.groups.show', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@show', 'layout' => 'admin'],
            ['name' => 'Create rank group', 'uri' => 'ranks/groups/create', 'key' => 'ranks.groups.create', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@create', 'layout' => 'admin'],
            ['name' => 'Store rank group', 'uri' => 'ranks/groups', 'key' => 'ranks.groups.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@store', 'layout' => 'admin'],
            ['name' => 'Edit rank group', 'uri' => 'ranks/groups/{group}/edit', 'key' => 'ranks.groups.edit', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@edit', 'layout' => 'admin'],
            ['name' => 'Update rank group', 'uri' => 'ranks/groups/{group}', 'key' => 'ranks.groups.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@update', 'layout' => 'admin'],

            ['name' => 'List rank names', 'uri' => 'ranks/names', 'key' => 'ranks.names.index', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@index', 'layout' => 'admin'],
            ['name' => 'View rank name', 'uri' => 'ranks/names/{name}/show', 'key' => 'ranks.names.show', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@show', 'layout' => 'admin'],
            ['name' => 'Create rank name', 'uri' => 'ranks/names/create', 'key' => 'ranks.names.create', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@create', 'layout' => 'admin'],
            ['name' => 'Store rank nane', 'uri' => 'ranks/names', 'key' => 'ranks.names.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@store', 'layout' => 'admin'],
            ['name' => 'Edit rank name', 'uri' => 'ranks/names/{name}/edit', 'key' => 'ranks.names.edit', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@edit', 'layout' => 'admin'],
            ['name' => 'Update rank name', 'uri' => 'ranks/names/{name}', 'key' => 'ranks.names.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@update', 'layout' => 'admin'],

            ['name' => 'List rank items', 'uri' => 'ranks/items', 'key' => 'ranks.items.index', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@index', 'layout' => 'admin'],
            ['name' => 'View rank item', 'uri' => 'ranks/items/{item}/show', 'key' => 'ranks.items.show', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@show', 'layout' => 'admin'],
            ['name' => 'Create rank item', 'uri' => 'ranks/items/create', 'key' => 'ranks.items.create', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@create', 'layout' => 'admin'],
            ['name' => 'Store rank item', 'uri' => 'ranks/items', 'key' => 'ranks.items.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@store', 'layout' => 'admin'],
            ['name' => 'Edit rank item', 'uri' => 'ranks/items/{item}/edit', 'key' => 'ranks.items.edit', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@edit', 'layout' => 'admin'],
            ['name' => 'Update rank item', 'uri' => 'ranks/items/{item}', 'key' => 'ranks.items.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@update', 'layout' => 'admin'],

            ['name' => 'List departments', 'uri' => 'departments', 'key' => 'departments.index', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@index', 'layout' => 'admin'],
            ['name' => 'View department', 'uri' => 'departments/{department}/show', 'key' => 'departments.show', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@show', 'layout' => 'admin'],
            ['name' => 'Create department', 'uri' => 'departments/create', 'key' => 'departments.create', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@create', 'layout' => 'admin'],
            ['name' => 'Store department', 'uri' => 'departments', 'key' => 'departments.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@store', 'layout' => 'admin'],
            ['name' => 'Edit department', 'uri' => 'departments/{department}/edit', 'key' => 'departments.edit', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@edit', 'layout' => 'admin'],
            ['name' => 'Update department', 'uri' => 'departments/{department}', 'key' => 'departments.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@update', 'layout' => 'admin'],

            ['name' => 'List positions', 'uri' => 'positions', 'key' => 'positions.index', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@index', 'layout' => 'admin'],
            ['name' => 'View position', 'uri' => 'positions/{position}/show', 'key' => 'positions.show', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@show', 'layout' => 'admin'],
            ['name' => 'Create position', 'uri' => 'positions/create', 'key' => 'positions.create', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@create', 'layout' => 'admin'],
            ['name' => 'Store position', 'uri' => 'positions', 'key' => 'positions.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Departments\\Controllers\\PositionController@store', 'layout' => 'admin'],
            ['name' => 'Edit position', 'uri' => 'positions/{position}/edit', 'key' => 'positions.edit', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@edit', 'layout' => 'admin'],
            ['name' => 'Update position', 'uri' => 'positions/{position}', 'key' => 'positions.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Departments\\Controllers\\PositionController@update', 'layout' => 'admin'],

            ['name' => 'List characters', 'uri' => 'characters', 'key' => 'characters.index', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@index', 'layout' => 'admin'],
            ['name' => 'View character', 'uri' => 'characters/{character}/show', 'key' => 'characters.show', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@show', 'layout' => 'admin'],
            ['name' => 'Create character', 'uri' => 'characters/create', 'key' => 'characters.create', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@create', 'layout' => 'admin'],
            ['name' => 'Store character', 'uri' => 'characters', 'key' => 'characters.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@store', 'layout' => 'admin'],
            ['name' => 'Edit character', 'uri' => 'characters/{character}/edit', 'key' => 'characters.edit', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@edit', 'layout' => 'admin'],
            ['name' => 'Update character', 'uri' => 'characters/{character}', 'key' => 'characters.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@update', 'layout' => 'admin'],

            ['name' => 'List post types', 'uri' => 'post-types', 'key' => 'post-types.index', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@index', 'layout' => 'admin'],
            ['name' => 'View post type', 'uri' => 'post-types/{postType}/show', 'key' => 'post-types.show', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@show', 'layout' => 'admin'],
            ['name' => 'Create post type', 'uri' => 'post-types/create', 'key' => 'post-types.create', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@create', 'layout' => 'admin'],
            ['name' => 'Store post type', 'uri' => 'post-types', 'key' => 'post-types.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@store', 'layout' => 'admin'],
            ['name' => 'Edit post type', 'uri' => 'post-types/{postType}/edit', 'key' => 'post-types.edit', 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@edit', 'layout' => 'admin'],
            ['name' => 'Update post type', 'uri' => 'post-types/{postType}', 'key' => 'post-types.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Stories\\Controllers\\PostTypeController@update', 'layout' => 'admin'],

            ['name' => 'List stories', 'uri' => 'stories', 'key' => 'stories.index', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@index', 'layout' => 'admin'],
            ['name' => 'View story', 'uri' => 'stories/{story}/show', 'key' => 'stories.show', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@show', 'layout' => 'admin'],
            ['name' => 'Create story', 'uri' => 'stories/create', 'key' => 'stories.create', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@create', 'layout' => 'admin'],
            ['name' => 'Store story', 'uri' => 'stories', 'key' => 'stories.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Stories\\Controllers\\StoryController@store', 'layout' => 'admin'],
            ['name' => 'Edit story', 'uri' => 'stories/{story}/edit', 'key' => 'stories.edit', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@edit', 'layout' => 'admin'],
            ['name' => 'Update story', 'uri' => 'stories/{story}', 'key' => 'stories.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Stories\\Controllers\\StoryController@update', 'layout' => 'admin'],
            ['name' => 'Delete stories', 'uri' => 'stories/{id}/delete', 'key' => 'stories.delete', 'verb' => 'get', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@delete', 'layout' => 'admin'],
            ['name' => 'Destroy stories', 'uri' => 'stories', 'key' => 'stories.destroy', 'verb' => PageVerb::delete, 'resource' => 'Nova\\Stories\\Controllers\\StoryController@destroy', 'layout' => 'admin'],
            ['name' => 'Story timeline', 'uri' => 'timeline/{type}', 'key' => 'stories.timeline', 'resource' => 'Nova\\Stories\\Controllers\\ShowTimelineController', 'layout' => 'admin'],

            ['name' => 'List posts', 'uri' => 'posts', 'key' => 'posts.index', 'resource' => 'Nova\\Stories\\Controllers\\PostController@index', 'layout' => 'admin'],
            ['name' => 'View story post', 'uri' => 'stories/{story}/posts/{post}/show', 'key' => 'posts.show', 'resource' => 'Nova\\Stories\\Controllers\\PostController@show', 'layout' => 'admin'],
            ['name' => 'Create story post', 'uri' => 'posts/create/{neighbor?}/{direction?}', 'key' => 'posts.create', 'resource' => 'Nova\\Stories\\Controllers\\PostController@create', 'layout' => 'admin'],
            ['name' => 'Edit story post', 'uri' => 'posts/{post}/edit', 'key' => 'posts.edit', 'resource' => 'Nova\\Stories\\Controllers\\PostController@edit', 'layout' => 'admin'],

            ['name' => 'List forms', 'uri' => 'forms', 'key' => 'forms.index', 'resource' => 'Nova\\Forms\\Controllers\\ShowFormController@all', 'layout' => 'admin'],
            ['name' => 'View form', 'uri' => 'forms/{form}/show', 'key' => 'forms.show', 'resource' => 'Nova\\Forms\\Controllers\\ShowFormController@show', 'layout' => 'admin'],
            ['name' => 'Create form', 'uri' => 'forms/create', 'key' => 'forms.create', 'resource' => 'Nova\\Forms\\Controllers\\CreateFormController@create', 'layout' => 'admin'],
            ['name' => 'Store form', 'uri' => 'forms', 'key' => 'forms.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Forms\\Controllers\\CreateFormController@store', 'layout' => 'admin'],
            ['name' => 'Edit form', 'uri' => 'forms/{form}/edit', 'key' => 'forms.edit', 'resource' => 'Nova\\Forms\\Controllers\\UpdateFormController@edit', 'layout' => 'admin'],
            ['name' => 'Update form', 'uri' => 'forms/{form}', 'key' => 'forms.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Forms\\Controllers\\UpdateFormController@update', 'layout' => 'admin'],

            ['name' => 'List pages', 'uri' => 'pages', 'key' => 'pages.index', 'resource' => 'Nova\\Pages\\Controllers\\PageController@index', 'layout' => 'admin'],
            ['name' => 'View page', 'uri' => 'pages/{page}/show', 'key' => 'pages.show', 'resource' => 'Nova\\Pages\\Controllers\\PageController@show', 'layout' => 'admin'],
            ['name' => 'Design page', 'uri' => 'pages/{page}/design', 'key' => 'pages.design', 'resource' => 'Nova\\Pages\\Controllers\\DesignPageController', 'layout' => 'admin'],
            ['name' => 'Create page', 'uri' => 'pages/create', 'key' => 'pages.create', 'resource' => 'Nova\\Pages\\Controllers\\PageController@create', 'layout' => 'admin'],
            ['name' => 'Store page', 'uri' => 'pages', 'key' => 'pages.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Pages\\Controllers\\PageController@store', 'layout' => 'admin'],
            ['name' => 'Edit page', 'uri' => 'pages/{page}/edit', 'key' => 'pages.edit', 'resource' => 'Nova\\Pages\\Controllers\\PageController@edit', 'layout' => 'admin'],
            ['name' => 'Update page', 'uri' => 'pages/{page}', 'key' => 'pages.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Pages\\Controllers\\PageController@update', 'layout' => 'admin'],

            ['name' => 'Page test', 'uri' => 'page-test', 'key' => 'page-test', 'layout' => 'public'],
        ];

        collect($pages)->each([Page::class, 'create']);

        activity()->enableLogging();
    }

    public function down()
    {
        Page::truncate();
    }
}
