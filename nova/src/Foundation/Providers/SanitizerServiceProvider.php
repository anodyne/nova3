<?php

namespace Nova\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use Nova\Foundation\Http\Requests\FormRequest;
use Nova\Foundation\Sanitizers\SanitizesAndFormats;

class SanitizerServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->afterResolving(FormRequest::class, function ($request) {
			if (in_array(SanitizesAndFormats::class, class_uses($request))) {
				$request->performSanitizationAndFormat();
			}
		});
	}
}
