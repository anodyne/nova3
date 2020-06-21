<?php

use Nova\Pages\Page;
use Illuminate\Database\Migrations\Migration;

class PopulatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        activity()->disableLogging();

        $pages = [
            ['uri' => 'login', 'key' => 'login', 'resource' => 'Nova\\Auth\\Http\\Controllers\\LoginController@showLoginForm', 'layout' => 'auth'],
            ['uri' => 'login', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Http\\Controllers\\LoginController@login', 'layout' => 'auth'],
            ['uri' => 'logout', 'key' => 'logout', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Http\\Controllers\\LoginController@logout', 'layout' => 'auth'],

            ['uri' => 'password/reset', 'key' => 'password.request', 'resource' => 'Nova\\Auth\\Http\\Controllers\\ForgotPasswordController@showLinkRequestForm', 'layout' => 'auth'],
            ['uri' => 'password/email', 'key' => 'password.email', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Http\\Controllers\\ForgotPasswordController@sendResetLinkEmail', 'layout' => 'auth'],
            ['uri' => 'password/reset/{token}', 'key' => 'password.reset', 'resource' => 'Nova\\Auth\\Http\\Controllers\\ResetPasswordController@showResetForm', 'layout' => 'auth'],
            ['uri' => 'password/reset', 'key' => 'password.update', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Http\\Controllers\\ResetPasswordController@reset', 'layout' => 'auth'],

            ['uri' => '/', 'key' => 'home', 'resource' => 'Nova\\Foundation\\Http\\Controllers\\WelcomeController'],
            ['uri' => 'dashboard', 'key' => 'dashboard', 'resource' => 'Nova\\Dashboard\\Http\\Controllers\\DashboardController', 'layout' => 'admin'],

            ['uri' => 'site-themes', 'key' => 'themes.index', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ShowAllThemesController', 'layout' => 'admin'],
            ['uri' => 'site-themes/create', 'key' => 'themes.create', 'resource' => 'Nova\\Themes\\Http\\Controllers\\CreateThemeController@create', 'layout' => 'admin'],
            ['uri' => 'site-themes', 'key' => 'themes.store', 'verb' => 'post', 'resource' => 'Nova\\Themes\\Http\\Controllers\\CreateThemeController@store', 'layout' => 'admin'],
            ['uri' => 'site-themes/{theme}/edit', 'key' => 'themes.edit', 'resource' => 'Nova\\Themes\\Http\\Controllers\\UpdateThemeController@edit', 'layout' => 'admin'],
            ['uri' => 'site-themes/{theme}', 'key' => 'themes.update', 'verb' => 'put', 'resource' => 'Nova\\Themes\\Http\\Controllers\\UpdateThemeController@update', 'layout' => 'admin'],
            ['uri' => 'site-themes/delete', 'key' => 'themes.delete', 'verb' => 'post', 'resource' => 'Nova\\Themes\\Http\\Controllers\\DeleteThemeController@confirm', 'layout' => 'admin'],
            ['uri' => 'site-themes/{theme}', 'key' => 'themes.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Themes\\Http\\Controllers\\DeleteThemeController@destroy', 'layout' => 'admin'],
            ['uri' => 'site-themes/install', 'key' => 'themes.install', 'verb' => 'post', 'resource' => 'Nova\\Themes\\Http\\Controllers\\InstallThemeController', 'layout' => 'admin'],

            ['uri' => 'roles', 'key' => 'roles.index', 'resource' => 'Nova\\Roles\\Http\\Controllers\\ShowRoleController@all', 'layout' => 'admin'],
            ['uri' => 'roles/{role}/show', 'key' => 'roles.show', 'resource' => 'Nova\\Roles\\Http\\Controllers\\ShowRoleController@show', 'layout' => 'admin'],
            ['uri' => 'roles/create', 'key' => 'roles.create', 'resource' => 'Nova\\Roles\\Http\\Controllers\\CreateRoleController@create', 'layout' => 'admin'],
            ['uri' => 'roles', 'key' => 'roles.store', 'verb' => 'post', 'resource' => 'Nova\\Roles\\Http\\Controllers\\CreateRoleController@store', 'layout' => 'admin'],
            ['uri' => 'roles/{role}/edit', 'key' => 'roles.edit', 'resource' => 'Nova\\Roles\\Http\\Controllers\\UpdateRoleController@edit', 'layout' => 'admin'],
            ['uri' => 'roles/{role}', 'key' => 'roles.update', 'verb' => 'put', 'resource' => 'Nova\\Roles\\Http\\Controllers\\UpdateRoleController@update', 'layout' => 'admin'],
            ['uri' => 'roles/delete', 'key' => 'roles.delete', 'verb' => 'post', 'resource' => 'Nova\\Roles\\Http\\Controllers\\DeleteRoleController@confirm', 'layout' => 'admin'],
            ['uri' => 'roles/{role}', 'key' => 'roles.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Roles\\Http\\Controllers\\DeleteRoleController@destroy', 'layout' => 'admin'],
            ['uri' => 'roles/{originalRole}/duplicate', 'key' => 'roles.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Roles\\Http\\Controllers\\DuplicateRoleController', 'layout' => 'admin'],

            ['uri' => 'users', 'key' => 'users.index', 'resource' => 'Nova\\Users\\Http\\Controllers\\ShowUserController@all', 'layout' => 'admin'],
            ['uri' => 'users/{user}/show', 'key' => 'users.show', 'resource' => 'Nova\\Users\\Http\\Controllers\\ShowUserController@show', 'layout' => 'admin'],
            ['uri' => 'users/create', 'key' => 'users.create', 'resource' => 'Nova\\Users\\Http\\Controllers\\CreateUserController@create', 'layout' => 'admin'],
            ['uri' => 'users', 'key' => 'users.store', 'verb' => 'post', 'resource' => 'Nova\\Users\\Http\\Controllers\\CreateUserController@store', 'layout' => 'admin'],
            ['uri' => 'users/{user}/edit', 'key' => 'users.edit', 'resource' => 'Nova\\Users\\Http\\Controllers\\UpdateUserController@edit', 'layout' => 'admin'],
            ['uri' => 'users/{user}', 'key' => 'users.update', 'verb' => 'put', 'resource' => 'Nova\\Users\\Http\\Controllers\\UpdateUserController@update', 'layout' => 'admin'],
            ['uri' => 'users/delete', 'key' => 'users.delete', 'verb' => 'post', 'resource' => 'Nova\\Users\\Http\\Controllers\\DeleteUserController@confirm', 'layout' => 'admin'],
            ['uri' => 'users/{user}', 'key' => 'users.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Users\\Http\\Controllers\\DeleteUserController@destroy', 'layout' => 'admin'],

            ['uri' => 'notes', 'key' => 'notes.index', 'resource' => 'Nova\\Notes\\Http\\Controllers\\ShowNoteController@all', 'layout' => 'admin'],
            ['uri' => 'notes/{note}/show', 'key' => 'notes.show', 'resource' => 'Nova\\Notes\\Http\\Controllers\\ShowNoteController@show', 'layout' => 'admin'],
            ['uri' => 'notes/create', 'key' => 'notes.create', 'resource' => 'Nova\\Notes\\Http\\Controllers\\CreateNoteController@create', 'layout' => 'admin'],
            ['uri' => 'notes', 'key' => 'notes.store', 'verb' => 'post', 'resource' => 'Nova\\Notes\\Http\\Controllers\\CreateNoteController@store', 'layout' => 'admin'],
            ['uri' => 'notes/{note}/edit', 'key' => 'notes.edit', 'resource' => 'Nova\\Notes\\Http\\Controllers\\UpdateNoteController@edit', 'layout' => 'admin'],
            ['uri' => 'notes/{note}', 'key' => 'notes.update', 'verb' => 'put', 'resource' => 'Nova\\Notes\\Http\\Controllers\\UpdateNoteController@update', 'layout' => 'admin'],
            ['uri' => 'notes/delete', 'key' => 'notes.delete', 'verb' => 'post', 'resource' => 'Nova\\Notes\\Http\\Controllers\\DeleteNoteController@confirm', 'layout' => 'admin'],
            ['uri' => 'notes/{note}', 'key' => 'notes.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Notes\\Http\\Controllers\\DeleteNoteController@destroy', 'layout' => 'admin'],
            ['uri' => 'notes/{originalNote}/duplicate', 'key' => 'notes.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Notes\\Http\\Controllers\\DuplicateNoteController', 'layout' => 'admin'],

            ['uri' => 'settings/{tab?}', 'key' => 'settings.index', 'resource' => 'Nova\\Settings\\Http\\Controllers\\SettingsController@index', 'layout' => 'admin'],
            ['uri' => 'settings', 'key' => 'settings.update', 'verb' => 'put', 'resource' => 'Nova\\Settings\\Http\\Controllers\\SettingsController@update', 'layout' => 'admin'],

            ['uri' => 'ranks', 'key' => 'ranks.index', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\ShowRankOptionsController', 'layout' => 'admin'],

            ['uri' => 'ranks/groups', 'key' => 'ranks.groups.index', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Groups\\ShowRankGroupController@all', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}/show', 'key' => 'ranks.groups.show', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Groups\\ShowRankGroupController@show', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/create', 'key' => 'ranks.groups.create', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Groups\\CreateRankGroupController@create', 'layout' => 'admin'],
            ['uri' => 'ranks/groups', 'key' => 'ranks.groups.store', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Groups\\CreateRankGroupController@store', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}/edit', 'key' => 'ranks.groups.edit', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Groups\\UpdateRankGroupController@edit', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}', 'key' => 'ranks.groups.update', 'verb' => 'put', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Groups\\UpdateRankGroupController@update', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/delete', 'key' => 'ranks.groups.delete', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Groups\\DeleteRankGroupController@confirm', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{group}', 'key' => 'ranks.groups.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Groups\\DeleteRankGroupController@destroy', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/confirm-duplicate', 'key' => 'ranks.groups.confirm-duplicate', 'verb' => 'post',  'resource' => 'Nova\\Ranks\\Http\\Controllers\\Groups\\DuplicateRankGroupController@confirm', 'layout' => 'admin'],
            ['uri' => 'ranks/groups/{originalGroup}/duplicate', 'key' => 'ranks.groups.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Groups\\DuplicateRankGroupController@duplicate', 'layout' => 'admin'],

            ['uri' => 'ranks/names', 'key' => 'ranks.names.index', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Names\\ShowRankNameController@all', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}/show', 'key' => 'ranks.names.show', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Names\\ShowRankNameController@show', 'layout' => 'admin'],
            ['uri' => 'ranks/names/create', 'key' => 'ranks.names.create', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Names\\CreateRankNameController@create', 'layout' => 'admin'],
            ['uri' => 'ranks/names', 'key' => 'ranks.names.store', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Names\\CreateRankNameController@store', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}/edit', 'key' => 'ranks.names.edit', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Names\\UpdateRankNameController@edit', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}', 'key' => 'ranks.names.update', 'verb' => 'put', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Names\\UpdateRankNameController@update', 'layout' => 'admin'],
            ['uri' => 'ranks/names/delete', 'key' => 'ranks.names.delete', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Names\\DeleteRankNameController@confirm', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{name}', 'key' => 'ranks.names.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Names\\DeleteRankNameController@destroy', 'layout' => 'admin'],
            ['uri' => 'ranks/names/{originalName}/duplicate', 'key' => 'ranks.names.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Names\\DuplicateRankNameController', 'layout' => 'admin'],

            ['uri' => 'ranks/items', 'key' => 'ranks.items.index', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Items\\ShowRankItemController@all', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}/show', 'key' => 'ranks.items.show', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Items\\ShowRankItemController@show', 'layout' => 'admin'],
            ['uri' => 'ranks/items/create', 'key' => 'ranks.items.create', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Items\\CreateRankItemController@create', 'layout' => 'admin'],
            ['uri' => 'ranks/items', 'key' => 'ranks.items.store', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Items\\CreateRankItemController@store', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}/edit', 'key' => 'ranks.items.edit', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Items\\UpdateRankItemController@edit', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}', 'key' => 'ranks.items.update', 'verb' => 'put', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Items\\UpdateRankItemController@update', 'layout' => 'admin'],
            ['uri' => 'ranks/items/delete', 'key' => 'ranks.items.delete', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Items\\DeleteRankItemController@confirm', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{item}', 'key' => 'ranks.items.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Items\\DeleteRankItemController@destroy', 'layout' => 'admin'],
            ['uri' => 'ranks/items/{originalItem}/duplicate', 'key' => 'ranks.items.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Ranks\\Http\\Controllers\\Items\\DuplicateRankItemController', 'layout' => 'admin'],
        ];

        collect($pages)->each([Page::class, 'create']);

        activity()->enableLogging();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Page::truncate();
    }
}
