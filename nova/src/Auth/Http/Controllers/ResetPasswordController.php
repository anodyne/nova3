<?php namespace Nova\Auth\Http\Controllers;

use Nova\Foundation\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/home';

    public function __construct()
    {
    	parent::__construct();
    	
    	$this->redirectTo = route('home');

        $this->middleware('guest');
    }
}
