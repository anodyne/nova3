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
            ['uri' => '/', 'key' => 'home', 'resource' => 'Nova\\Foundation\\Controllers\\WelcomeController'],
            ['uri' => 'dashboard', 'key' => 'dashboard', 'resource' => 'Nova\\Dashboards\\Controllers\\DashboardController', 'layout' => 'admin'],
            ['uri' => 'system-overview', 'key' => 'system-overview', 'resource' => 'Nova\\Dashboards\\Controllers\\SystemOverviewController', 'layout' => 'admin'],
            ['uri' => 'writing-overview', 'key' => 'writing-overview', 'resource' => 'Nova\\Dashboards\\Controllers\\WritingOverviewController', 'layout' => 'admin'],
            ['uri' => 'activity-log', 'key' => 'activity-log.index', 'resource' => 'Nova\\Dashboards\\Controllers\\ActivityLogController@index', 'layout' => 'admin'],
            ['uri' => 'activity-log/{activity}/show', 'key' => 'activity-log.show', 'resource' => 'Nova\\Dashboards\\Controllers\\ActivityLogController@show', 'layout' => 'admin'],
            ['uri' => 'whats-new', 'key' => 'whats-new', 'resource' => 'Nova\\Dashboards\\Controllers\\WhatsNewController', 'layout' => 'admin'],

            ['uri' => 'site-themes', 'key' => 'themes.index', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@index', 'layout' => 'admin'],
            ['uri' => 'site-themes/{theme}/show', 'key' => 'themes.show', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@show', 'layout' => 'admin'],
            ['uri' => 'site-themes/create', 'key' => 'themes.create', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@create', 'layout' => 'admin'],
            ['uri' => 'site-themes', 'key' => 'themes.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@store', 'layout' => 'admin'],
            ['uri' => 'site-themes/{theme}/edit', 'key' => 'themes.edit', 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@edit', 'layout' => 'admin'],
            ['uri' => 'site-themes/{theme}', 'key' => 'themes.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Themes\\Controllers\\ThemeController@update', 'layout' => 'admin'],

            ['uri' => 'roles', 'key' => 'roles.index', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@index', 'layout' => 'admin'],
            ['uri' => 'roles/{role}/show', 'key' => 'roles.show', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@show', 'layout' => 'admin'],
            ['uri' => 'roles/create', 'key' => 'roles.create', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@create', 'layout' => 'admin'],
            ['uri' => 'roles', 'key' => 'roles.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Roles\\Controllers\\RoleController@store', 'layout' => 'admin'],
            ['uri' => 'roles/{role}/edit', 'key' => 'roles.edit', 'resource' => 'Nova\\Roles\\Controllers\\RoleController@edit', 'layout' => 'admin'],
            ['uri' => 'roles/{role}', 'key' => 'roles.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Roles\\Controllers\\RoleController@update', 'layout' => 'admin'],

            ['uri' => 'permissions', 'key' => 'permissions.index', 'resource' => 'Nova\\Roles\\Controllers\\PermissionController@index', 'layout' => 'admin'],

            ['uri' => 'users', 'key' => 'users.index', 'resource' => 'Nova\\Users\\Controllers\\UserController@index', 'layout' => 'admin'],
            ['uri' => 'users/{user}/show', 'key' => 'users.show', 'resource' => 'Nova\\Users\\Controllers\\UserController@show', 'layout' => 'admin'],
            ['uri' => 'users/create', 'key' => 'users.create', 'resource' => 'Nova\\Users\\Controllers\\UserController@create', 'layout' => 'admin'],
            ['uri' => 'users', 'key' => 'users.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Users\\Controllers\\UserController@store', 'layout' => 'admin'],
            ['uri' => 'users/{user}/edit', 'key' => 'users.edit', 'resource' => 'Nova\\Users\\Controllers\\UserController@edit', 'layout' => 'admin'],
            ['uri' => 'users/{user}', 'key' => 'users.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Users\\Controllers\\UserController@update', 'layout' => 'admin'],

            ['uri' => 'profile', 'key' => 'profile.edit', 'resource' => 'Nova\\Users\\Controllers\\ProfileController@edit', 'layout' => 'admin'],
            ['uri' => 'profile', 'key' => 'profile.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Users\\Controllers\\ProfileController@update', 'layout' => 'admin'],

            ['uri' => 'notes', 'key' => 'notes.index', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@index', 'layout' => 'admin'],
            ['uri' => 'notes/{note}/show', 'key' => 'notes.show', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@show', 'layout' => 'admin'],
            ['uri' => 'notes/create', 'key' => 'notes.create', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@create', 'layout' => 'admin'],
            ['uri' => 'notes', 'key' => 'notes.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Notes\\Controllers\\NoteController@store', 'layout' => 'admin'],
            ['uri' => 'notes/{note}/edit', 'key' => 'notes.edit', 'resource' => 'Nova\\Notes\\Controllers\\NoteController@edit', 'layout' => 'admin'],
            ['uri' => 'notes/{note}', 'key' => 'notes.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Notes\\Controllers\\NoteController@update', 'layout' => 'admin'],

            ['uri' => 'settings/{tab?}', 'key' => 'settings.index', 'resource' => 'Nova\\Settings\\Controllers\\SettingsController@index', 'layout' => 'admin'],
            ['uri' => 'settings/{tab?}', 'key' => 'settings.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Settings\\Controllers\\SettingsController@update', 'layout' => 'admin'],

            ['uri' => 'ranks/groups', 'key' => 'ranks.groups.index', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@index', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}/show', 'key' => 'ranks.groups.show', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@show', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/create', 'key' => 'ranks.groups.create', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@create', 'layout' => 'admin'],
            ['uri' => 'ranks/groups', 'key' => 'ranks.groups.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@store', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}/edit', 'key' => 'ranks.groups.edit', 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@edit', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}', 'key' => 'ranks.groups.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Ranks\\Controllers\\RankGroupController@update', 'layout' => 'admin'],

            ['uri' => 'ranks/names', 'key' => 'ranks.names.index', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@index', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}/show', 'key' => 'ranks.names.show', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@show', 'layout' => 'admin'],
            ['uri' => 'ranks/names/create', 'key' => 'ranks.names.create', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@create', 'layout' => 'admin'],
            ['uri' => 'ranks/names', 'key' => 'ranks.names.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@store', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}/edit', 'key' => 'ranks.names.edit', 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@edit', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}', 'key' => 'ranks.names.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Ranks\\Controllers\\RankNameController@update', 'layout' => 'admin'],

            ['uri' => 'ranks/items', 'key' => 'ranks.items.index', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@index', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}/show', 'key' => 'ranks.items.show', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@show', 'layout' => 'admin'],
            ['uri' => 'ranks/items/create', 'key' => 'ranks.items.create', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@create', 'layout' => 'admin'],
            ['uri' => 'ranks/items', 'key' => 'ranks.items.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@store', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}/edit', 'key' => 'ranks.items.edit', 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@edit', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}', 'key' => 'ranks.items.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Ranks\\Controllers\\RankItemController@update', 'layout' => 'admin'],

            ['uri' => 'departments', 'key' => 'departments.index', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@index', 'layout' => 'admin'],
            ['uri' => 'departments/{department}/show', 'key' => 'departments.show', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@show', 'layout' => 'admin'],
            ['uri' => 'departments/create', 'key' => 'departments.create', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@create', 'layout' => 'admin'],
            ['uri' => 'departments', 'key' => 'departments.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@store', 'layout' => 'admin'],
            ['uri' => 'departments/{department}/edit', 'key' => 'departments.edit', 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@edit', 'layout' => 'admin'],
            ['uri' => 'departments/{department}', 'key' => 'departments.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Departments\\Controllers\\DepartmentController@update', 'layout' => 'admin'],

            ['uri' => 'positions', 'key' => 'positions.index', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@index', 'layout' => 'admin'],
            ['uri' => 'positions/{position}/show', 'key' => 'positions.show', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@show', 'layout' => 'admin'],
            ['uri' => 'positions/create', 'key' => 'positions.create', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@create', 'layout' => 'admin'],
            ['uri' => 'positions', 'key' => 'positions.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Departments\\Controllers\\PositionController@store', 'layout' => 'admin'],
            ['uri' => 'positions/{position}/edit', 'key' => 'positions.edit', 'resource' => 'Nova\\Departments\\Controllers\\PositionController@edit', 'layout' => 'admin'],
            ['uri' => 'positions/{position}', 'key' => 'positions.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Departments\\Controllers\\PositionController@update', 'layout' => 'admin'],

            ['uri' => 'characters', 'key' => 'characters.index', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@index', 'layout' => 'admin'],
            ['uri' => 'characters/{character}/show', 'key' => 'characters.show', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@show', 'layout' => 'admin'],
            ['uri' => 'characters/create', 'key' => 'characters.create', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@create', 'layout' => 'admin'],
            ['uri' => 'characters', 'key' => 'characters.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@store', 'layout' => 'admin'],
            ['uri' => 'characters/{character}/edit', 'key' => 'characters.edit', 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@edit', 'layout' => 'admin'],
            ['uri' => 'characters/{character}', 'key' => 'characters.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Characters\\Controllers\\CharacterController@update', 'layout' => 'admin'],

            ['uri' => 'post-types', 'key' => 'post-types.index', 'resource' => 'Nova\\PostTypes\\Controllers\\PostTypeController@index', 'layout' => 'admin'],
            ['uri' => 'post-types/{postType}/show', 'key' => 'post-types.show', 'resource' => 'Nova\\PostTypes\\Controllers\\PostTypeController@show', 'layout' => 'admin'],
            ['uri' => 'post-types/create', 'key' => 'post-types.create', 'resource' => 'Nova\\PostTypes\\Controllers\\PostTypeController@create', 'layout' => 'admin'],
            ['uri' => 'post-types', 'key' => 'post-types.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\PostTypes\\Controllers\\PostTypeController@store', 'layout' => 'admin'],
            ['uri' => 'post-types/{postType}/edit', 'key' => 'post-types.edit', 'resource' => 'Nova\\PostTypes\\Controllers\\PostTypeController@edit', 'layout' => 'admin'],
            ['uri' => 'post-types/{postType}', 'key' => 'post-types.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\PostTypes\\Controllers\\PostTypeController@update', 'layout' => 'admin'],

            ['uri' => 'stories', 'key' => 'stories.index', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@index', 'layout' => 'admin'],
            ['uri' => 'stories/{story}/show', 'key' => 'stories.show', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@show', 'layout' => 'admin'],
            ['uri' => 'stories/create', 'key' => 'stories.create', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@create', 'layout' => 'admin'],
            ['uri' => 'stories', 'key' => 'stories.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Stories\\Controllers\\StoryController@store', 'layout' => 'admin'],
            ['uri' => 'stories/{story}/edit', 'key' => 'stories.edit', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@edit', 'layout' => 'admin'],
            ['uri' => 'stories/{story}', 'key' => 'stories.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Stories\\Controllers\\StoryController@update', 'layout' => 'admin'],
            ['uri' => 'stories/{id}/delete', 'key' => 'stories.delete', 'verb' => 'get', 'resource' => 'Nova\\Stories\\Controllers\\StoryController@delete', 'layout' => 'admin'],
            ['uri' => 'stories', 'key' => 'stories.destroy', 'verb' => PageVerb::delete, 'resource' => 'Nova\\Stories\\Controllers\\StoryController@destroy', 'layout' => 'admin'],
            ['uri' => 'timeline/{type}', 'key' => 'stories.timeline', 'resource' => 'Nova\\Stories\\Controllers\\ShowTimelineController', 'layout' => 'admin'],

            ['uri' => 'posts', 'key' => 'posts.index', 'resource' => 'Nova\\Posts\\Controllers\\PostController@index', 'layout' => 'admin'],
            ['uri' => 'stories/{story}/posts/{post}/show', 'key' => 'posts.show', 'resource' => 'Nova\\Posts\\Controllers\\PostController@show', 'layout' => 'admin'],
            ['uri' => 'posts/create/{neighbor?}/{direction?}', 'key' => 'posts.create', 'resource' => 'Nova\\Posts\\Controllers\\PostController@create', 'layout' => 'admin'],
            ['uri' => 'posts/{post}/edit', 'key' => 'posts.edit', 'resource' => 'Nova\\Posts\\Controllers\\PostController@edit', 'layout' => 'admin'],

            ['uri' => 'forms', 'key' => 'forms.index', 'resource' => 'Nova\\Forms\\Controllers\\ShowFormController@all', 'layout' => 'admin'],
            ['uri' => 'forms/{form}/show', 'key' => 'forms.show', 'resource' => 'Nova\\Forms\\Controllers\\ShowFormController@show', 'layout' => 'admin'],
            ['uri' => 'forms/create', 'key' => 'forms.create', 'resource' => 'Nova\\Forms\\Controllers\\CreateFormController@create', 'layout' => 'admin'],
            ['uri' => 'forms', 'key' => 'forms.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Forms\\Controllers\\CreateFormController@store', 'layout' => 'admin'],
            ['uri' => 'forms/{form}/edit', 'key' => 'forms.edit', 'resource' => 'Nova\\Forms\\Controllers\\UpdateFormController@edit', 'layout' => 'admin'],
            ['uri' => 'forms/{form}', 'key' => 'forms.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Forms\\Controllers\\UpdateFormController@update', 'layout' => 'admin'],
            ['uri' => 'forms/delete', 'key' => 'forms.delete', 'verb' => PageVerb::post, 'resource' => 'Nova\\Forms\\Controllers\\DeleteFormController@confirm', 'layout' => 'admin'],
            ['uri' => 'forms/{form}', 'key' => 'forms.destroy', 'verb' => PageVerb::delete, 'resource' => 'Nova\\Forms\\Controllers\\DeleteFormController@destroy', 'layout' => 'admin'],
            ['uri' => 'forms/{original}/duplicate', 'key' => 'forms.duplicate', 'verb' => PageVerb::post, 'resource' => 'Nova\\Forms\\Controllers\\DuplicateFormController', 'layout' => 'admin'],

            ['uri' => 'pages', 'key' => 'pages.index', 'resource' => 'Nova\\Pages\\Controllers\\ShowPageController@all', 'layout' => 'admin'],
            ['uri' => 'pages/{page}/show', 'key' => 'pages.show', 'resource' => 'Nova\\Pages\\Controllers\\ShowPageController@show', 'layout' => 'admin'],
            ['uri' => 'pages/create', 'key' => 'pages.create', 'resource' => 'Nova\\Pages\\Controllers\\CreatePageController@create', 'layout' => 'admin'],
            ['uri' => 'forms', 'key' => 'pages.store', 'verb' => PageVerb::post, 'resource' => 'Nova\\Pages\\Controllers\\CreatePageController@store', 'layout' => 'admin'],
            ['uri' => 'pages/{form}/edit', 'key' => 'pages.edit', 'resource' => 'Nova\\Pages\\Controllers\\UpdatePageController@edit', 'layout' => 'admin'],
            ['uri' => 'pages/{form}', 'key' => 'pages.update', 'verb' => PageVerb::put, 'resource' => 'Nova\\Pages\\Controllers\\UpdatePageController@update', 'layout' => 'admin'],
            ['uri' => 'pages/delete', 'key' => 'pages.delete', 'verb' => PageVerb::post, 'resource' => 'Nova\\Pages\\Controllers\\DeletePageController@confirm', 'layout' => 'admin'],
            ['uri' => 'pages/{form}', 'key' => 'pages.destroy', 'verb' => PageVerb::delete, 'resource' => 'Nova\\Pages\\Controllers\\DeletePageController@destroy', 'layout' => 'admin'],
            ['uri' => 'pages/{original}/duplicate', 'key' => 'pages.duplicate', 'verb' => PageVerb::post, 'resource' => 'Nova\\Pages\\Controllers\\DuplicatePageController', 'layout' => 'admin'],
        ];

        collect($pages)->each([Page::class, 'create']);

        activity()->enableLogging();
    }

    public function down()
    {
        Page::truncate();
    }
}
