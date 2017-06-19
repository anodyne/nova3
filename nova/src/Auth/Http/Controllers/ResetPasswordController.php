<?php namespace Nova\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Foundation\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function __construct()
    {
    	parent::__construct();
    	
    	$this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('pages.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function redirectTo()
	{
		return route('home');
	}
}
