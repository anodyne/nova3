<?php

namespace Nova\Foundation\Http\Responses;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Responsable;

abstract class InertiaResponse extends BaseResponsable implements Responsable
{
    /**
     * The Inertia component for the response.
     *
     * @var  string
     */
    public $component;

    /**
     * Handle converting this to a response object that Laravel knows what
     * to do with.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    final public function toResponse($request)
    {
        Inertia::setRootView('app-client');

        $this->data = $this->prepareData();

        $response = Inertia::render($this->component, $this->data);

        return $response->toResponse($request);
    }
}
