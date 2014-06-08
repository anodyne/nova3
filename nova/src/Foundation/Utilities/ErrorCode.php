<?php namespace Nova\Core\Utilities;

class ErrorCode {

	/**
	 * Log In Error Codes - 1xx
	 */
	const LOGIN_OK 				= 100;
	const LOGIN_NOT_LOGGED_IN 	= 101;
	const LOGIN_NO_EMAIL 		= 102;
	const LOGIN_NO_PASSWORD		= 103;
	const LOGIN_NOT_FOUND		= 104;
	const LOGIN_SUSPENDED		= 105;
	const LOGIN_BANNED			= 106;
	const LOGIN_NOT_ADMIN		= 107;

	/**
	 * Admin Error Codes - 2xx
	 */
	const ADMIN_OK 				= 200;
	const ADMIN_NOT_ALLOWED 	= 201;
	const USER_CANNOT_EDIT		= 210;
	const CHAR_CANNOT_EDIT		= 220;

}