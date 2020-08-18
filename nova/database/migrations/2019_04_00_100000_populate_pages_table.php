<?php

use Nova\Pages\Page;
use Illuminate\Database\Migrations\Migration;

class PopulatePagesTable extends Migration
{
    public function up()
    {
        activity()->disableLogging();

        $pages = [
            ['uri' => 'login', 'key' => 'login', 'resource' => 'Nova\\Auth\\Controllers\\LoginController@showLoginForm', 'layout' => 'auth'],
            ['uri' => 'login', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Controllers\\LoginController@login', 'layout' => 'auth'],
            ['uri' => 'logout', 'key' => 'logout', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Controllers\\LoginController@logout', 'layout' => 'auth'],

            ['uri' => 'password/reset', 'key' => 'password.request', 'resource' => 'Nova\\Auth\\Controllers\\ForgotPasswordController@showLinkRequestForm', 'layout' => 'auth'],
            ['uri' => 'password/email', 'key' => 'password.email', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Controllers\\ForgotPasswordController@sendResetLinkEmail', 'layout' => 'auth'],
            ['uri' => 'password/reset/{token}', 'key' => 'password.reset', 'resource' => 'Nova\\Auth\\Controllers\\ResetPasswordController@showResetForm', 'layout' => 'auth'],
            ['uri' => 'password/reset', 'key' => 'password.update', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Controllers\\ResetPasswordController@reset', 'layout' => 'auth'],

            ['uri' => '/', 'key' => 'home', 'resource' => 'Nova\\Foundation\\Controllers\\WelcomeController'],
            ['uri' => 'dashboard', 'key' => 'dashboard', 'resource' => 'Nova\\Dashboard\\Controllers\\DashboardController', 'layout' => 'admin'],

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
            ['uri' => 'roles/{originalRole}/duplicate', 'key' => 'roles.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Roles\\Controllers\\DuplicateRoleController', 'layout' => 'admin'],
            ['uri' => 'roles/reorder', 'key' => 'roles.reorder', 'verb' => 'post', 'resource' => 'Nova\\Roles\\Controllers\\ReorderRolesController', 'layout' => 'admin'],

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
            ['uri' => 'notes/delete', 'key' => 'notes.delete', 'verb' => 'post', 'resource' => 'Nova\\Notes\\Controllers\\DeleteNoteController@confirm', 'layout' => 'admin'],
            ['uri' => 'notes/{note}', 'key' => 'notes.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Notes\\Controllers\\DeleteNoteController@destroy', 'layout' => 'admin'],
            ['uri' => 'notes/{originalNote}/duplicate', 'key' => 'notes.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Notes\\Controllers\\DuplicateNoteController', 'layout' => 'admin'],

            ['uri' => 'settings/{tab?}', 'key' => 'settings.index', 'resource' => 'Nova\\Settings\\Controllers\\SettingsController@index', 'layout' => 'admin'],
            ['uri' => 'settings', 'key' => 'settings.update', 'verb' => 'put', 'resource' => 'Nova\\Settings\\Controllers\\SettingsController@update', 'layout' => 'admin'],

            ['uri' => 'manage-ranks', 'key' => 'ranks.index', 'resource' => 'Nova\\Ranks\\Controllers\\ShowRankOptionsController', 'layout' => 'admin'],

            ['uri' => 'ranks/groups', 'key' => 'ranks.groups.index', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\ShowRankGroupController@all', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}/show', 'key' => 'ranks.groups.show', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\ShowRankGroupController@show', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/create', 'key' => 'ranks.groups.create', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\CreateRankGroupController@create', 'layout' => 'admin'],
            ['uri' => 'ranks/groups', 'key' => 'ranks.groups.store', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\CreateRankGroupController@store', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}/edit', 'key' => 'ranks.groups.edit', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\UpdateRankGroupController@edit', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}', 'key' => 'ranks.groups.update', 'verb' => 'put', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\UpdateRankGroupController@update', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/delete', 'key' => 'ranks.groups.delete', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\DeleteRankGroupController@confirm', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}', 'key' => 'ranks.groups.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\DeleteRankGroupController@destroy', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/confirm-duplicate', 'key' => 'ranks.groups.confirm-duplicate', 'verb' => 'post',  'resource' => 'Nova\\Ranks\\Controllers\\Groups\\DuplicateRankGroupController@confirm', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{originalGroup}/duplicate', 'key' => 'ranks.groups.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\DuplicateRankGroupController@duplicate', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/reorder', 'key' => 'ranks.groups.reorder', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Groups\\ReorderRankGroupsController', 'layout' => 'admin'],

            ['uri' => 'ranks/names', 'key' => 'ranks.names.index', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\ShowRankNameController@all', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}/show', 'key' => 'ranks.names.show', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\ShowRankNameController@show', 'layout' => 'admin'],
            ['uri' => 'ranks/names/create', 'key' => 'ranks.names.create', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\CreateRankNameController@create', 'layout' => 'admin'],
            ['uri' => 'ranks/names', 'key' => 'ranks.names.store', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\CreateRankNameController@store', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}/edit', 'key' => 'ranks.names.edit', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\UpdateRankNameController@edit', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}', 'key' => 'ranks.names.update', 'verb' => 'put', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\UpdateRankNameController@update', 'layout' => 'admin'],
            ['uri' => 'ranks/names/delete', 'key' => 'ranks.names.delete', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\DeleteRankNameController@confirm', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}', 'key' => 'ranks.names.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\DeleteRankNameController@destroy', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{originalName}/duplicate', 'key' => 'ranks.names.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\DuplicateRankNameController', 'layout' => 'admin'],
            ['uri' => 'ranks/names/reorder', 'key' => 'ranks.names.reorder', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Names\\ReorderRankNamesController', 'layout' => 'admin'],

            ['uri' => 'ranks/items', 'key' => 'ranks.items.index', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\ShowRankItemController@all', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}/show', 'key' => 'ranks.items.show', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\ShowRankItemController@show', 'layout' => 'admin'],
            ['uri' => 'ranks/items/create', 'key' => 'ranks.items.create', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\CreateRankItemController@create', 'layout' => 'admin'],
            ['uri' => 'ranks/items', 'key' => 'ranks.items.store', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\CreateRankItemController@store', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}/edit', 'key' => 'ranks.items.edit', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\UpdateRankItemController@edit', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}', 'key' => 'ranks.items.update', 'verb' => 'put', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\UpdateRankItemController@update', 'layout' => 'admin'],
            ['uri' => 'ranks/items/delete', 'key' => 'ranks.items.delete', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\DeleteRankItemController@confirm', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}', 'key' => 'ranks.items.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\DeleteRankItemController@destroy', 'layout' => 'admin'],
            ['uri' => 'ranks/items/reorder', 'key' => 'ranks.items.reorder', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Controllers\\Items\\ReorderRankItemsController', 'layout' => 'admin'],

            ['uri' => 'departments', 'key' => 'departments.index', 'resource' => 'Nova\\Departments\\Controllers\\ShowDepartmentController@all', 'layout' => 'admin'],
            ['uri' => 'departments/{department}/show', 'key' => 'departments.show', 'resource' => 'Nova\\Departments\\Controllers\\ShowDepartmentController@show', 'layout' => 'admin'],
            ['uri' => 'departments/create', 'key' => 'departments.create', 'resource' => 'Nova\\Departments\\Controllers\\CreateDepartmentController@create', 'layout' => 'admin'],
            ['uri' => 'departments', 'key' => 'departments.store', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\CreateDepartmentController@store', 'layout' => 'admin'],
            ['uri' => 'departments/{department}/edit', 'key' => 'departments.edit', 'resource' => 'Nova\\Departments\\Controllers\\UpdateDepartmentController@edit', 'layout' => 'admin'],
            ['uri' => 'departments/{department}', 'key' => 'departments.update', 'verb' => 'put', 'resource' => 'Nova\\Departments\\Controllers\\UpdateDepartmentController@update', 'layout' => 'admin'],
            ['uri' => 'departments/delete', 'key' => 'departments.delete', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\DeleteDepartmentController@confirm', 'layout' => 'admin'],
            ['uri' => 'departments/{department}', 'key' => 'departments.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Departments\\Controllers\\DeleteDepartmentController@destroy', 'layout' => 'admin'],
            ['uri' => 'departments/reorder', 'key' => 'departments.reorder', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\ReorderDepartmentsController', 'layout' => 'admin'],

            ['uri' => 'departments/{department}/positions', 'key' => 'positions.index', 'resource' => 'Nova\\Departments\\Controllers\\ShowPositionController@all', 'layout' => 'admin'],
            ['uri' => 'positions/{position}/show', 'key' => 'positions.show', 'resource' => 'Nova\\Departments\\Controllers\\ShowPositionController@show', 'layout' => 'admin'],
            ['uri' => 'positions/create', 'key' => 'positions.create', 'resource' => 'Nova\\Departments\\Controllers\\CreatePositionController@create', 'layout' => 'admin'],
            ['uri' => 'positions', 'key' => 'positions.store', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\CreatePositionController@store', 'layout' => 'admin'],
            ['uri' => 'positions/{position}/edit', 'key' => 'positions.edit', 'resource' => 'Nova\\Departments\\Controllers\\UpdatePositionController@edit', 'layout' => 'admin'],
            ['uri' => 'positions/{position}', 'key' => 'positions.update', 'verb' => 'put', 'resource' => 'Nova\\Departments\\Controllers\\UpdatePositionController@update', 'layout' => 'admin'],
            ['uri' => 'positions/delete', 'key' => 'positions.delete', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\DeletePositionController@confirm', 'layout' => 'admin'],
            ['uri' => 'positions/{position}', 'key' => 'positions.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Departments\\Controllers\\DeletePositionController@destroy', 'layout' => 'admin'],
            ['uri' => 'deparments/{department}/positions/reorder', 'key' => 'positions.reorder', 'verb' => 'post', 'resource' => 'Nova\\Departments\\Controllers\\ReorderPositionsController', 'layout' => 'admin'],

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
            ['uri' => 'post-types/reorder', 'key' => 'post-types.reorder', 'verb' => 'post', 'resource' => 'Nova\\PostTypes\\Controllers\\ReorderPostTypesController', 'layout' => 'admin'],
            ['uri' => 'post-types/{originalPostType}/duplicate', 'key' => 'post-types.duplicate', 'verb' => 'post', 'resource' => 'Nova\\PostTypes\\Controllers\\DuplicatePostTypeController', 'layout' => 'admin'],

            ['uri' => 'stories', 'key' => 'stories.index', 'resource' => 'Nova\\Stories\\Controllers\\ShowStoryController@all', 'layout' => 'admin'],
            ['uri' => 'stories/{story}/show', 'key' => 'stories.show', 'resource' => 'Nova\\Stories\\Controllers\\ShowStoryController@show', 'layout' => 'admin'],
            ['uri' => 'stories/reorder', 'key' => 'stories.reorder.show', 'verb' => 'get', 'resource' => 'Nova\\Stories\\Controllers\\ReorderStoriesController@showReorder', 'layout' => 'admin'],
            ['uri' => 'stories/reorder', 'key' => 'stories.reorder.update', 'verb' => 'post', 'resource' => 'Nova\\Stories\\Controllers\\ReorderStoriesController@reorder', 'layout' => 'admin'],
            ['uri' => 'stories/{id}/delete', 'key' => 'stories.delete', 'verb' => 'get', 'resource' => 'Nova\\Stories\\Controllers\\DeleteStoryController@delete', 'layout' => 'admin'],
            ['uri' => 'stories', 'key' => 'stories.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Stories\\Controllers\\DeleteStoryController@destroy', 'layout' => 'admin'],

            ['uri' => 'posts/create', 'key' => 'posts.create', 'resource' => 'Nova\\Posts\\Controllers\\CreatePostController@pickPostType', 'layout' => 'admin'],
            ['uri' => 'posts/create/{postType:key}', 'key' => 'posts.compose', 'resource' => 'Nova\\Posts\\Controllers\\CreatePostController@create', 'layout' => 'admin'],
        ];

        collect($pages)->each([Page::class, 'create']);

        activity()->enableLogging();
    }

    public function down()
    {
        Page::truncate();
    }
}
