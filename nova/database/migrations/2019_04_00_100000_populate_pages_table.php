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
            ['uri' => 'dashboard', 'key' => 'dashboard', 'resource' => 'Nova\\Dashboard\\Http\\Controllers\\DashboardController'],

            ['uri' => 'themes', 'key' => 'themes.index', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ThemeController@index', 'layout' => 'admin'],
            ['uri' => 'themes/create', 'key' => 'themes.create', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ThemeController@create', 'layout' => 'admin'],
            ['uri' => 'themes', 'key' => 'themes.store', 'verb' => 'post', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ThemeController@store', 'layout' => 'admin'],
            ['uri' => 'themes/{theme}/edit', 'key' => 'themes.edit', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ThemeController@edit', 'layout' => 'admin'],
            ['uri' => 'themes/{theme}', 'key' => 'themes.update', 'verb' => 'put', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ThemeController@update', 'layout' => 'admin'],
            ['uri' => 'themes/{theme}', 'key' => 'themes.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ThemeController@destroy', 'layout' => 'admin'],
            ['uri' => 'themes/install', 'key' => 'themes.install', 'verb' => 'post', 'resource' => 'Nova\\Themes\\Http\\Controllers\\InstallThemeController', 'layout' => 'admin'],

            ['uri' => 'roles', 'key' => 'roles.index', 'resource' => 'Nova\\Roles\\Http\\Controllers\\RoleController@index', 'layout' => 'admin'],
            ['uri' => 'roles/show/{role}', 'key' => 'roles.show', 'resource' => 'Nova\\Roles\\Http\\Controllers\\RoleController@show', 'layout' => 'admin'],
            ['uri' => 'roles/create', 'key' => 'roles.create', 'resource' => 'Nova\\Roles\\Http\\Controllers\\RoleController@create', 'layout' => 'admin'],
            ['uri' => 'roles', 'key' => 'roles.store', 'verb' => 'post', 'resource' => 'Nova\\Roles\\Http\\Controllers\\RoleController@store', 'layout' => 'admin'],
            ['uri' => 'roles/{role}/edit', 'key' => 'roles.edit', 'resource' => 'Nova\\Roles\\Http\\Controllers\\RoleController@edit', 'layout' => 'admin'],
            ['uri' => 'roles/{role}', 'key' => 'roles.update', 'verb' => 'put', 'resource' => 'Nova\\Roles\\Http\\Controllers\\RoleController@update', 'layout' => 'admin'],
            ['uri' => 'roles/{role}', 'key' => 'roles.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Roles\\Http\\Controllers\\RoleController@destroy', 'layout' => 'admin'],
            ['uri' => 'roles/{originalRole}/duplicate', 'key' => 'roles.duplicate', 'verb' => 'post', 'resource' => 'Nova\\Roles\\Http\\Controllers\\DuplicateRoleController', 'layout' => 'admin'],

            ['uri' => 'users', 'key' => 'users.index', 'resource' => 'Nova\\Users\\Http\\Controllers\\UserController@index', 'layout' => 'admin'],
            ['uri' => 'users/create', 'key' => 'users.create', 'resource' => 'Nova\\Users\\Http\\Controllers\\UserController@create', 'layout' => 'admin'],
            ['uri' => 'users', 'key' => 'users.store', 'verb' => 'post', 'resource' => 'Nova\\Users\\Http\\Controllers\\UserController@store', 'layout' => 'admin'],
            ['uri' => 'users/{user}/edit', 'key' => 'users.edit', 'resource' => 'Nova\\Users\\Http\\Controllers\\UserController@edit', 'layout' => 'admin'],
            ['uri' => 'users/{user}', 'key' => 'users.update', 'verb' => 'put', 'resource' => 'Nova\\Users\\Http\\Controllers\\UserController@update', 'layout' => 'admin'],
            ['uri' => 'users/{user}', 'key' => 'users.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Users\\Http\\Controllers\\UserController@destroy', 'layout' => 'admin'],
        ];

        collect($pages)->each(function ($page) {
            Page::create($page);
        });

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
