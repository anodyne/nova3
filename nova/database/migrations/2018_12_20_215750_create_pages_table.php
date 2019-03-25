<?php

use Nova\Pages\Page;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uri');
            $table->string('key')->nullable();
            $table->string('verb')->default('get');
            $table->string('resource')->nullable();
            $table->string('layout')->default('public');
            $table->timestamps();
        });

        $this->populatePagesTable();
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }

    protected function populatePagesTable()
    {
        $pages = [
            ['uri' => 'login', 'key' => 'login', 'resource' => 'Nova\\Auth\\Http\\Controllers\\LoginController@showLoginForm', 'layout' => 'auth'],
            ['uri' => 'login', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Http\\Controllers\\LoginController@login', 'layout' => 'auth'],
            ['uri' => 'logout', 'key' => 'logout', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Http\\Controllers\\LoginController@logout', 'layout' => 'auth'],

            ['uri' => 'password/reset', 'key' => 'password.request', 'resource' => 'Nova\\Auth\\Http\\Controllers\\ForgotPasswordController@showLinkRequestForm', 'layout' => 'auth'],
            ['uri' => 'password/email', 'key' => 'password.email', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Http\\Controllers\\ForgotPasswordController@sendResetLinkEmail', 'layout' => 'auth'],
            ['uri' => 'password/reset/{token}', 'key' => 'password.reset', 'resource' => 'Nova\\Auth\\Http\\Controllers\\ResetPasswordController@showResetForm', 'layout' => 'auth'],
            ['uri' => 'password/reset', 'key' => 'password.update', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Http\\Controllers\\ResetPasswordController@reset', 'layout' => 'auth'],

            ['uri' => '/', 'key' => 'home', 'resource' => 'Nova\\Foundation\\Http\\Controllers\\WelcomeController'],

            ['uri' => 'themes', 'key' => 'themes.index', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ThemeController@index', 'layout' => 'admin'],
            ['uri' => 'themes/create', 'key' => 'themes.create', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ThemeController@create', 'layout' => 'admin'],
            ['uri' => 'themes', 'key' => 'themes.store', 'verb' => 'post', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ThemeController@store', 'layout' => 'admin'],
            ['uri' => 'themes/{theme}/edit', 'key' => 'themes.edit', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ThemeController@edit', 'layout' => 'admin'],
            ['uri' => 'themes/{theme}', 'key' => 'themes.update', 'verb' => 'patch', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ThemeController@update', 'layout' => 'admin'],
            ['uri' => 'themes/{theme}', 'key' => 'themes.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Themes\\Http\\Controllers\\ThemeController@destroy', 'layout' => 'admin'],

            ['uri' => 'roles', 'key' => 'roles.index', 'resource' => 'Nova\\Authorization\\Http\\Controllers\\RoleController@index', 'layout' => 'admin'],
            ['uri' => 'roles/create', 'key' => 'roles.create', 'resource' => 'Nova\\Authorization\\Http\\Controllers\\RoleController@create', 'layout' => 'admin'],
            ['uri' => 'roles', 'key' => 'roles.store', 'verb' => 'post', 'resource' => 'Nova\\Authorization\\Http\\Controllers\\RoleController@store', 'layout' => 'admin'],
            ['uri' => 'roles/{role}/edit', 'key' => 'roles.edit', 'resource' => 'Nova\\Authorization\\Http\\Controllers\\RoleController@edit', 'layout' => 'admin'],
            ['uri' => 'roles/{role}', 'key' => 'roles.update', 'verb' => 'patch', 'resource' => 'Nova\\Authorization\\Http\\Controllers\\RoleController@update', 'layout' => 'admin'],
            ['uri' => 'roles/{role}', 'key' => 'roles.destroy', 'verb' => 'delete', 'resource' => 'Nova\\Authorization\\Http\\Controllers\\RoleController@destroy', 'layout' => 'admin'],
        ];

        collect($pages)->each(function ($page) {
            Page::create($page);
        });
    }
}
