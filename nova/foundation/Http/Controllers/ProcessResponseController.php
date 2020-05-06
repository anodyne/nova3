<?php

namespace Nova\Foundation\Http\Controllers;

class ProcessResponseController
{
    public function __invoke()
    {
        return response()->json([
            'dispatchQueue' => session()->pull('nova.dispatchQueue'),
        ]);
    }
}
