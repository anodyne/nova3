<?php

Route::group(['prefix' => 'dev'], function()
{
	Route::get('/{string?}', function()
	{
		sd(NovaTest::run());
	});
});