<?php

namespace Nova\Foundation\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Responsable;

abstract class ServerResponse extends BaseResponsable implements Responsable
{
    /**
     * The Laravel for the response.
     *
     * @var  string
     */
    public $view;

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
        $this->passDataToContainer();

        if ($request->expectsJson()) {
            return response()->json($this->data, Response::HTTP_OK);
        }

        return response($this->render(), Response::HTTP_OK);
    }
}
