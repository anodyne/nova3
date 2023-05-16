<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Nova\Pages\Page;

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
            ['uri' => 'whats-new', 'key' => 'whats-new', 'resource' => 'Nova\\Dashboards\\Controllers\\WhatsNewController', 'layout' => 'admin'],

            ['uri' => 'site-themes', 'key' => 'themes.index', 'resource' => 'Nova\\Themes\\Controllers\\ShowThemeController@all', 'layout' => 'admin'],
            ['uri' => 'site-themes/create', 'key' => 'themes.create', 'resource' => 'Nova\\Themes\\Controllers\\CreateThemeController@create', 'layout' => 'admin'],
            ['uri' => 'site-themes', 'key' => 'themes.store', 'verb' => 'post', 'resource' => 'Nova\\Themes\\Controllers\\CreateThemeController@store', 'layout' => 'admin'],
            ['uri' => 'site-themes/{theme}/edit', 'key' => 'themes.edit', 'resource' => 'Nova\\Themes\\Controllers\\UpdateThemeController@edit', 'layout' => 'admin'],
            ['uri' => 'site-themes/{theme}', 'key' => 'themes.update', 'verb' => 'put', 'resource' => 'Nova\\Themes\\Controllers\\UpdateThemeController@update', 'layout' => 'admin'],
            ['uri' => 'site-themes/delete', 'key' => 'themes.delete', 'verb' => 'post', 'resource' => 'Nova\\Themes\\Controllers\\DeleteThemeController@confirm', 'layout' => 'admin'],
            ['uri' => 'site-themes/{theme}', 'key' => 'themes.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Themes\\Controllers\\DeleteThemeController@destroy', 'layout' => 'admin'],
            ['uri' => 'site-themes/install', 'key' => 'themes.install', 'verb' => 'post', 'resource' => 'Nova\\Themes\\Controllers\\InstallThemeController', 'layout' => 'admin'],

            ['uri' => 'roles', 'key' => 'roles.index', 'resource' => 'Nova\\Roles\\Controllers\\ShowRoleController@all', 'layout' => 'admin'],
            ['uri' => 'roles/{role}/show', 'key' => 'roles.show', 'resource' => 'Nova\\Roles\\Controllers\\ShowRoleController@show', 'layout' => 'admin'],
            ['uri' => 'roles/create', 'key' => 'roles.create', 'resource' => 'Nova\\Roles\\Controllers\\CreateRoleController@create', 'layout' => 'admin'],
            ['uri' => 'roles', 'key' => 'roles.store', 'verb' => 'post', 'resource' => 'Nova\\Roles\\Controllers\\CreateRoleController@store', 'layout' => 'admin'],
            ['uri' => 'roles/{role}/edit', 'key' => 'roles.edit', 'resource' => 'Nova\\Roles\\Controllers\\UpdateRoleController@edit', 'layout' => 'admin'],
            ['uri' => 'roles/{role}', 'key' => 'roles.update', 'verb' => 'put', 'resource' => 'Nova\\Roles\\Controllers\\UpdateRoleController@update', 'layout' => 'admin'],
            ['uri' => 'roles/delete', 'key' => 'roles.delete', 'verb' => 'post', 'resource' => 'Nova\\Roles\\Controllers\\DeleteRoleController@confirm', 'layout' => 'admin'],
            ['uri' => 'roles/{role}', 'key' => 'roles.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Roles\\Controllers\\DeleteRoleController@destroy', 'layout' => 'admin'],
            ['uri' => 'roles/{original}/duplicate', 'key' => 'roles.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Roles\\Controllers\\DuplicateRoleController', 'layout' => 'admin'],

            ['uri' => 'users', 'key' => 'users.index', 'resource' => 'Nova\\Users\\Controllers\\ShowUserController@all', 'layout' => 'admin'],
            ['uri' => 'users/{user}/show', 'key' => 'users.show', 'resource' => 'Nova\\Users\\Controllers\\ShowUserController@show', 'layout' => 'admin'],
            ['uri' => 'users/create', 'key' => 'users.create', 'resource' => 'Nova\\Users\\Controllers\\CreateUserController@create', 'layout' => 'admin'],
            ['uri' => 'users', 'key' => 'users.store', 'verb' => 'post', 'resource' => 'Nova\\Users\\Controllers\\CreateUserController@store', 'layout' => 'admin'],
            ['uri' => 'users/{user}/edit', 'key' => 'users.edit', 'resource' => 'Nova\\Users\\Controllers\\UpdateUserController@edit', 'layout' => 'admin'],
            ['uri' => 'users/{user}', 'key' => 'users.update', 'verb' => 'put', 'resource' => 'Nova\\Users\\Controllers\\UpdateUserController@update', 'layout' => 'admin'],
            ['uri' => 'users/delete', 'key' => 'users.delete', 'verb' => 'post', 'resource' => 'Nova\\Users\\Controllers\\DeleteUserController@confirm', 'layout' => 'admin'],
            ['uri' => 'users/{user}', 'key' => 'users.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Users\\Controllers\\DeleteUserController@destroy', 'layout' => 'admin'],
            ['uri' => 'users/{user}/activate', 'key' => 'users.activate', 'verb' => 'post', 'resource' => 'Nova\\Users\\Controllers\\ActivateUserController', 'layout' => 'admin'],
            ['uri' => 'users/confirm-deactivate', 'key' => 'users.confirm-deactivate', 'verb' => 'post',  'resource' => 'Nova\\Users\\Controllers\\DeactivateUserController@confirm', 'layout' => 'admin'],
            ['uri' => 'users/{user}/deactivate', 'key' => 'users.deactivate', 'verb' => 'post', 'resource' => 'Nova\\Users\\Controllers\\DeactivateUserController@deactivate', 'layout' => 'admin'],

            ['uri' => 'notes', 'key' => 'notes.index', 'resource' => 'Nova\\Notes\\Controllers\\ShowNoteController@all', 'layout' => 'admin'],
            ['uri' => 'notes/{note}/show', 'key' => 'notes.show', 'resource' => 'Nova\\Notes\\Controllers\\ShowNoteController@show', 'layout' => 'admin'],
            ['uri' => 'notes/create', 'key' => 'notes.create', 'resource' => 'Nova\\Notes\\Controllers\\CreateNoteController@create', 'layout' => 'admin'],
            ['uri' => 'notes', 'key' => 'notes.store', 'verb' => 'post', 'resource' => 'Nova\\Notes\\Controllers\\CreateNoteController@store', 'layout' => 'admin'],
            ['uri' => 'notes/{note}/edit', 'key' => 'notes.edit', 'resource' => 'Nova\\Notes\\Controllers\\UpdateNoteController@edit', 'layout' => 'admin'],
            ['uri' => 'notes/{note}', 'key' => 'notes.update', 'verb' => 'put', 'resource' => 'Nova\\Notes\\Controllers\\UpdateNoteController@update', 'layout' => 'admin'],

            ['uri' => 'settings/{tab?}', 'key' => 'settings.index', 'resource' => 'Nova\\Settings\\Controllers\\SettingsController@index', 'layout' => 'admin'],
            ['uri' => 'settings/{tab?}', 'key' => 'settings.update', 'verb' => 'put', 'resource' => 'Nova\\Settings\\Controllers\\SettingsController@update', 'layout' => 'admin'],

            ['uri' => 'ranks/groups', 'key' => 'ranks.groups.index', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\ShowRankGroupController@all', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}/show', 'key' => 'ranks.groups.show', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\ShowRankGroupController@show', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/create', 'key' => 'ranks.groups.create', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\CreateRankGroupController@create', 'layout' => 'admin'],
            ['uri' => 'ranks/groups', 'key' => 'ranks.groups.store', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\CreateRankGroupController@store', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}/edit', 'key' => 'ranks.groups.edit', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\UpdateRankGroupController@edit', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}', 'key' => 'ranks.groups.update', 'verb' => 'put', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\UpdateRankGroupController@update', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/delete', 'key' => 'ranks.groups.delete', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\DeleteRankGroupController@confirm', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}', 'key' => 'ranks.groups.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\DeleteRankGroupController@destroy', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/confirm-duplicate', 'key' => 'ranks.groups.confirm-duplicate', 'verb' => 'post',  'resource' => 'Nova\\Ranks\\Controllers\\Groups\\DuplicateRankGroupController@confirm', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{original}/duplicate', 'key' => 'ranks.groups.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\DuplicateRankGroupController@duplicate', 'layout' => 'admin'],

            ['uri' => 'ranks/names', 'key' => 'ranks.names.index', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\ShowRankNameController@all', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}/show', 'key' => 'ranks.names.show', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\ShowRankNameController@show', 'layout' => 'admin'],
            ['uri' => 'ranks/names/create', 'key' => 'ranks.names.create', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\CreateRankNameController@create', 'layout' => 'admin'],
            ['uri' => 'ranks/names', 'key' => 'ranks.names.store', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\CreateRankNameController@store', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}/edit', 'key' => 'ranks.names.edit', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\UpdateRankNameController@edit', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}', 'key' => 'ranks.names.update', 'verb' => 'put', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\UpdateRankNameController@update', 'layout' => 'admin'],
            ['uri' => 'ranks/names/delete', 'key' => 'ranks.names.delete', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\DeleteRankNameController@confirm', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}', 'key' => 'ranks.names.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\DeleteRankNameController@destroy', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{original}/duplicate', 'key' => 'ranks.names.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\DuplicateRankNameController', 'layout' => 'admin'],

            ['uri' => 'ranks/items', 'key' => 'ranks.items.index', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\ShowRankItemController@all', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}/show', 'key' => 'ranks.items.show', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\ShowRankItemController@show', 'layout' => 'admin'],
            ['uri' => 'ranks/items/create', 'key' => 'ranks.items.create', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\CreateRankItemController@create', 'layout' => 'admin'],
            ['uri' => 'ranks/items', 'key' => 'ranks.items.store', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\CreateRankItemController@store', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}/edit', 'key' => 'ranks.items.edit', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\UpdateRankItemController@edit', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}', 'key' => 'ranks.items.update', 'verb' => 'put', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\UpdateRankItemController@update', 'layout' => 'admin'],
            ['uri' => 'ranks/items/delete', 'key' => 'ranks.items.delete', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\DeleteRankItemController@confirm', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}', 'key' => 'ranks.items.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\DeleteRankItemController@destroy', 'layout' => 'admin'],

            ['uri' => 'departments', 'key' => 'departments.index', 'resource' => 'Nova\\Departments\\Controllers\\ShowDepartmentController@all', 'layout' => 'admin'],
            ['uri' => 'departments/{department}/show', 'key' => 'departments.show', 'resource' => 'Nova\\Departments\\Controllers\\ShowDepartmentController@show', 'layout' => 'admin'],
            ['uri' => 'departments/create', 'key' => 'departments.create', 'resource' => 'Nova\\Departments\\Controllers\\CreateDepartmentController@create', 'layout' => 'admin'],
            ['uri' => 'departments', 'key' => 'departments.store', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\CreateDepartmentController@store', 'layout' => 'admin'],
            ['uri' => 'departments/{department}/edit', 'key' => 'departments.edit', 'resource' => 'Nova\\Departments\\Controllers\\UpdateDepartmentController@edit', 'layout' => 'admin'],
            ['uri' => 'departments/{department}', 'key' => 'departments.update', 'verb' => 'put', 'resource' => 'Nova\\Departments\\Controllers\\UpdateDepartmentController@update', 'layout' => 'admin'],
            ['uri' => 'departments/delete', 'key' => 'departments.delete', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\DeleteDepartmentController@confirm', 'layout' => 'admin'],
            ['uri' => 'departments/{department}', 'key' => 'departments.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Departments\\Controllers\\DeleteDepartmentController@destroy', 'layout' => 'admin'],
            ['uri' => 'departments/confirm-duplicate', 'key' => 'departments.confirm-duplicate', 'verb' => 'post',  'resource' => 'Nova\\Departments\\Controllers\\DuplicateDepartmentController@confirm', 'layout' => 'admin'],
            ['uri' => 'departments/{original}/duplicate', 'key' => 'departments.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\DuplicateDepartmentController@duplicate', 'layout' => 'admin'],

            ['uri' => 'positions', 'key' => 'positions.index', 'resource' => 'Nova\\Departments\\Controllers\\ShowPositionController@all', 'layout' => 'admin'],
            ['uri' => 'positions/{position}/show', 'key' => 'positions.show', 'resource' => 'Nova\\Departments\\Controllers\\ShowPositionController@show', 'layout' => 'admin'],
            ['uri' => 'positions/create', 'key' => 'positions.create', 'resource' => 'Nova\\Departments\\Controllers\\CreatePositionController@create', 'layout' => 'admin'],
            ['uri' => 'positions', 'key' => 'positions.store', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\CreatePositionController@store', 'layout' => 'admin'],
            ['uri' => 'positions/{position}/edit', 'key' => 'positions.edit', 'resource' => 'Nova\\Departments\\Controllers\\UpdatePositionController@edit', 'layout' => 'admin'],
            ['uri' => 'positions/{position}', 'key' => 'positions.update', 'verb' => 'put', 'resource' => 'Nova\\Departments\\Controllers\\UpdatePositionController@update', 'layout' => 'admin'],
            ['uri' => 'positions/delete', 'key' => 'positions.delete', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\DeletePositionController@confirm', 'layout' => 'admin'],
            ['uri' => 'positions/{position}', 'key' => 'positions.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Departments\\Controllers\\DeletePositionController@destroy', 'layout' => 'admin'],
            ['uri' => 'positions/confirm-duplicate', 'key' => 'positions.confirm-duplicate', 'verb' => 'post',  'resource' => 'Nova\\Departments\\Controllers\\DuplicatePositionController@confirm', 'layout' => 'admin'],
            ['uri' => 'positions/{original}/duplicate', 'key' => 'positions.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\DuplicatePositionController@duplicate', 'layout' => 'admin'],

            ['uri' => 'characters', 'key' => 'characters.index', 'resource' => 'Nova\\Characters\\Controllers\\ShowCharacterController@all', 'layout' => 'admin'],
            ['uri' => 'characters/{character}/show', 'key' => 'characters.show', 'resource' => 'Nova\\Characters\\Controllers\\ShowCharacterController@show', 'layout' => 'admin'],
            ['uri' => 'characters/create', 'key' => 'characters.create', 'resource' => 'Nova\\Characters\\Controllers\\CreateCharacterController@create', 'layout' => 'admin'],
            ['uri' => 'characters', 'key' => 'characters.store', 'verb' => 'post', 'resource' => 'Nova\\Characters\\Controllers\\CreateCharacterController@store', 'layout' => 'admin'],
            ['uri' => 'characters/{character}/edit', 'key' => 'characters.edit', 'resource' => 'Nova\\Characters\\Controllers\\UpdateCharacterController@edit', 'layout' => 'admin'],
            ['uri' => 'characters/{character}', 'key' => 'characters.update', 'verb' => 'put', 'resource' => 'Nova\\Characters\\Controllers\\UpdateCharacterController@update', 'layout' => 'admin'],
            ['uri' => 'characters/delete', 'key' => 'characters.delete', 'verb' => 'post', 'resource' => 'Nova\\Characters\\Controllers\\DeleteCharacterController@confirm', 'layout' => 'admin'],
            ['uri' => 'characters/{character}', 'key' => 'characters.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Characters\\Controllers\\DeleteCharacterController@destroy', 'layout' => 'admin'],
            ['uri' => 'characters/{character}/activate', 'key' => 'characters.activate', 'verb' => 'post', 'resource' => 'Nova\\Characters\\Controllers\\ActivateCharacterController', 'layout' => 'admin'],
            ['uri' => 'characters/confirm-deactivate', 'key' => 'characters.confirm-deactivate', 'verb' => 'post',  'resource' => 'Nova\\Characters\\Controllers\\DeactivateCharacterController@confirm', 'layout' => 'admin'],
            ['uri' => 'characters/{character}/deactivate', 'key' => 'characters.deactivate', 'verb' => 'post', 'resource' => 'Nova\\Characters\\Controllers\\DeactivateCharacterController@deactivate', 'layout' => 'admin'],

            ['uri' => 'post-types', 'key' => 'post-types.index', 'resource' => 'Nova\\PostTypes\\Controllers\\ShowPostTypeController@all', 'layout' => 'admin'],
            ['uri' => 'post-types/{postType}/show', 'key' => 'post-types.show', 'resource' => 'Nova\\PostTypes\\Controllers\\ShowPostTypeController@show', 'layout' => 'admin'],
            ['uri' => 'post-types/create', 'key' => 'post-types.create', 'resource' => 'Nova\\PostTypes\\Controllers\\CreatePostTypeController@create', 'layout' => 'admin'],
            ['uri' => 'post-types', 'key' => 'post-types.store', 'verb' => 'post', 'resource' => 'Nova\\PostTypes\\Controllers\\CreatePostTypeController@store', 'layout' => 'admin'],
            ['uri' => 'post-types/{postType}/edit', 'key' => 'post-types.edit', 'resource' => 'Nova\\PostTypes\\Controllers\\UpdatePostTypeController@edit', 'layout' => 'admin'],
            ['uri' => 'post-types/{postType}', 'key' => 'post-types.update', 'verb' => 'put', 'resource' => 'Nova\\PostTypes\\Controllers\\UpdatePostTypeController@update', 'layout' => 'admin'],
            ['uri' => 'post-types/delete', 'key' => 'post-types.delete', 'verb' => 'post', 'resource' => 'Nova\\PostTypes\\Controllers\\DeletePostTypeController@confirm', 'layout' => 'admin'],
            ['uri' => 'post-types/{postType}', 'key' => 'post-types.destroy', 'verb' => 'delete', 'resource' => 'Nova\\PostTypes\\Controllers\\DeletePostTypeController@destroy', 'layout' => 'admin'],
            ['uri' => 'post-types/{original}/duplicate', 'key' => 'post-types.duplicate', 'verb' => 'post', 'resource' => 'Nova\\PostTypes\\Controllers\\DuplicatePostTypeController', 'layout' => 'admin'],

            ['uri' => 'stories', 'key' => 'stories.index', 'resource' => 'Nova\\Stories\\Controllers\\ShowStoryController@all', 'layout' => 'admin'],
            ['uri' => 'stories/{story}/show', 'key' => 'stories.show', 'resource' => 'Nova\\Stories\\Controllers\\ShowStoryController@show', 'layout' => 'admin'],
            ['uri' => 'stories/create', 'key' => 'stories.create', 'resource' => 'Nova\\Stories\\Controllers\\CreateStoryController@create', 'layout' => 'admin'],
            ['uri' => 'stories', 'key' => 'stories.store', 'verb' => 'post', 'resource' => 'Nova\\Stories\\Controllers\\CreateStoryController@store', 'layout' => 'admin'],
            ['uri' => 'stories/{story}/edit', 'key' => 'stories.edit', 'resource' => 'Nova\\Stories\\Controllers\\UpdateStoryController@edit', 'layout' => 'admin'],
            ['uri' => 'stories/{story}', 'key' => 'stories.update', 'verb' => 'put', 'resource' => 'Nova\\Stories\\Controllers\\UpdateStoryController@update', 'layout' => 'admin'],
            ['uri' => 'stories/{id}/delete', 'key' => 'stories.delete', 'verb' => 'get', 'resource' => 'Nova\\Stories\\Controllers\\DeleteStoryController@delete', 'layout' => 'admin'],
            ['uri' => 'stories', 'key' => 'stories.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Stories\\Controllers\\DeleteStoryController@destroy', 'layout' => 'admin'],
            ['uri' => 'stories/reorder', 'key' => 'stories.reorder.show', 'verb' => 'get', 'resource' => 'Nova\\Stories\\Controllers\\ReorderStoriesController@showReorder', 'layout' => 'admin'],
            ['uri' => 'stories/reorder', 'key' => 'stories.reorder.update', 'verb' => 'post', 'resource' => 'Nova\\Stories\\Controllers\\ReorderStoriesController@reorder', 'layout' => 'admin'],

            ['uri' => 'posts/write/{post?}', 'key' => 'posts.create', 'resource' => 'Nova\\Posts\\Controllers\\CreatePostController@create', 'layout' => 'admin'],
            // ['uri' => 'posts/create', 'key' => 'posts.create', 'resource' => 'Nova\\Posts\\Controllers\\SelectPostTypeController@create', 'layout' => 'admin'],
            // ['uri' => 'posts/create/{postType:key}', 'key' => 'posts.compose', 'resource' => 'Nova\\Posts\\Controllers\\CreatePostController@create', 'layout' => 'admin'],
            // ['uri' => 'posts', 'key' => 'posts.store', 'verb' => 'post', 'resource' => 'Nova\\Posts\\Controllers\\CreatePostController@store', 'layout' => 'admin'],
            ['uri' => 'stories/{story}/posts/{post}/show', 'key' => 'posts.show', 'resource' => 'Nova\\Posts\\Controllers\\ShowPostController@show', 'layout' => 'admin'],

            ['uri' => 'forms', 'key' => 'forms.index', 'resource' => 'Nova\\Forms\\Controllers\\ShowFormController@all', 'layout' => 'admin'],
            ['uri' => 'forms/{form}/show', 'key' => 'forms.show', 'resource' => 'Nova\\Forms\\Controllers\\ShowFormController@show', 'layout' => 'admin'],
            ['uri' => 'forms/create', 'key' => 'forms.create', 'resource' => 'Nova\\Forms\\Controllers\\CreateFormController@create', 'layout' => 'admin'],
            ['uri' => 'forms', 'key' => 'forms.store', 'verb' => 'post', 'resource' => 'Nova\\Forms\\Controllers\\CreateFormController@store', 'layout' => 'admin'],
            ['uri' => 'forms/{form}/edit', 'key' => 'forms.edit', 'resource' => 'Nova\\Forms\\Controllers\\UpdateFormController@edit', 'layout' => 'admin'],
            ['uri' => 'forms/{form}', 'key' => 'forms.update', 'verb' => 'put', 'resource' => 'Nova\\Forms\\Controllers\\UpdateFormController@update', 'layout' => 'admin'],
            ['uri' => 'forms/delete', 'key' => 'forms.delete', 'verb' => 'post', 'resource' => 'Nova\\Forms\\Controllers\\DeleteFormController@confirm', 'layout' => 'admin'],
            ['uri' => 'forms/{form}', 'key' => 'forms.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Forms\\Controllers\\DeleteFormController@destroy', 'layout' => 'admin'],
            ['uri' => 'forms/{original}/duplicate', 'key' => 'forms.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Forms\\Controllers\\DuplicateFormController', 'layout' => 'admin'],
        ];

        collect($pages)->each([Page::class, 'create']);

        activity()->enableLogging();
    }

    public function down()
    {
        Page::truncate();
    }
}
