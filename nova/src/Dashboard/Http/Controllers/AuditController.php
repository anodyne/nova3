<?php namespace Nova\Dashboard\Http\Controllers;

use Controller;
use Spatie\Activitylog\Models\Activity;

class AuditController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('admin', 'template');
	}

	public function index()
	{
		$this->views('dashboard.audit', 'page|script');

		$this->setPageTitle('Audit');

		$this->data->logs = Activity::get();
	}
}
