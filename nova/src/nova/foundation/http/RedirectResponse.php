<?php namespace Nova\Foundation\Http;

use Illuminate\Http\RedirectResponse as LaravelRedirectResponse;

class RedirectResponse extends LaravelRedirectResponse {

	/**
     * Sets the redirect target of this response.
     *
     * @param string  $url     The URL to redirect to
     *
     * @return RedirectResponse The current response.
     *
     * @throws \InvalidArgumentException
     */
    public function setTargetUrl($url)
    {
    	$parent = parent::setTargetUrl($url);

    	$parent->setContent(
            sprintf('<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="refresh" content="0;url=%1$s" />

        <title></title>
    </head>
    <body></body>
</html>', htmlspecialchars($url, ENT_QUOTES, 'UTF-8')));

    	return $parent;
    }

}