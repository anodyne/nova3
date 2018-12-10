<?php

use Nova\Pages\Page;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('key')->nullable();
			$table->string('uri');
			$table->string('layout')->default('site')->nullable();
			$table->string('content_template')->default('basic');
			$table->string('verb')->default('get');
			$table->string('resource')->nullable();
            $table->timestamps();
		});

		$this->populatePagesTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
	}

	protected function populatePagesTable()
	{
		$pages = [
			$this->buildPageRecord(['name' => 'Home page', 'key' => 'home', 'uri' => '/', 'layout' => 'landing']),

			$this->buildPageRecord(['name' => 'Sign In', 'key' => 'sign-in', 'uri' => 'sign-in', 'layout' => 'auth', 'resource' => 'Nova\\Auth\\Http\\Controllers\\SignInController@showSignInForm']),
			$this->buildPageRecord(['name' => 'Handle Sign In', 'uri' => 'sign-in', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Http\\Controllers\\SignInController@login']),
			$this->buildPageRecord(['name' => 'Sign Out', 'key' => 'sign-out', 'uri' => 'sign-out', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Http\\Controllers\\SignInController@logout']),
			$this->buildPageRecord(['name' => 'Request New Password', 'key' => 'password.request', 'uri' => 'password/reset', 'layout' => 'auth', 'resource' => 'Nova\\Auth\\Http\\Controllers\\ForgotPasswordController@showLinkRequestForm']),
			$this->buildPageRecord(['name' => 'Send Password Reset Link', 'key' => 'password.email', 'uri' => 'password/email', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Http\\Controllers\\ForgotPasswordController@sendResetLinkEmail']),
			$this->buildPageRecord(['name' => 'Reset Password', 'key' => 'password.reset', 'uri' => 'password/reset/{token}', 'layout' => 'auth', 'resource' => 'Nova\\Auth\\Http\\Controllers\\ResetPasswordController@showResetForm']),
			$this->buildPageRecord(['name' => 'Handle Password Reset', 'uri' => 'password/reset', 'verb' => 'post', 'resource' => 'Nova\\Auth\\Http\\Controllers\\ResetPasswordController@reset']),

			$this->buildPageRecord(['name' => 'Dashboard', 'key' => 'dashboard', 'uri' => 'dashboard', 'layout' => 'app-sidebar']),
		];

		Page::insert($pages);
	}

	protected function buildPageRecord(array $data = []): array
	{
		$defaults = [
			'name' => '',
			'key' => null,
			'uri' => '',
			'layout' => null,
			'verb' => 'get',
			'resource' => null,
			'created_at' => now(),
            'updated_at' => now(),
		];

		return array_merge($defaults, $data);
	}
}
