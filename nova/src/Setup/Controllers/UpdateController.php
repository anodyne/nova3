<?php namespace Nova\Setup\Controllers;

use URL,
	Form,
	HTML,
	Config,
	Artisan,
	Redirect;

class UpdateController extends \SetupBaseController {

	public function getIndex()
	{
		return Redirect::to('setup');
	}
	public function postIndex()
	{
		// Make sure we don't time out
		set_time_limit(0);

		// Get up to the latest migration
		Artisan::call('migrate', ['--path' => 'nova/src/Nova/Setup/database/migrations']);

		// Register
		# TODO: need to figure out how we want to do registration

		return Redirect::to('setup/update/finalize');
	}

	public function getFinalize()
	{
		// Set the view
		$this->view = 'setup/update/finalize';

		// Set the title and header
		$this->title = 'Setup Center';
		$this->header = 'Update Nova';

		// Set the steps
		$this->steps = 'setup/steps_update';

		// Set the controls
		$this->controls = HTML::link('/', 'Back to Site', ['class' => 'btn btn-primary']);
	}

	public function getRollback()
	{
		// Set the view
		$this->view = 'setup/update/rollback';

		// Set the title and header
		$this->title = $this->header = 'Rollback Nova';

		if (version_compare(Config::get('nova.app.version'), '3.0.0', '>'))
		{
			// Set the controls
			$this->controls = HTML::link('setup', "I don't want to do this, get me out of here", [
				'class' => 'pull-right'
			]);
			$this->controls.= Form::open(['url' => 'setup/update/rollback']).
				Form::button('Rollback', [
					'class'	=> 'btn btn-danger',
					'id'	=> 'next',
					'name'	=> 'submit',
					'type'	=> 'submit',
				]).
				Form::token().
				Form::close();
		}
		else
		{
			$this->data->message = partial('common/alert', [
				'class'		=> 'alert-danger',
				'content'	=> 'You cannot rollback to a previous version of Nova. <a href="'.URL::to('setup').'">Go back</a>',
			]);
		}
	}
	public function postRollback()
	{
		// Make sure we don't time out
		set_time_limit(0);

		// Get up to the latest migration
		Artisan::call('migrate:rollback', array('--path' => 'nova/src/Nova/Setup/database/migrations'));

		// Register
		# TODO: need to figure out how we want to do registration

		return Redirect::to('setup/update/rollback/finalize');
	}

	public function getRollbackFinalize()
	{
		// Set the view
		$this->view = 'setup/update/finalize_rollback';

		// Set the title and header
		$this->title = $this->header = 'Rollback Nova';

		// Set the controls
		$this->controls = HTML::link('setup', "Back to Setup Center", ['class' => 'pull-right']);
		$this->controls.= HTML::link('/', 'Back to Site', ['class' => 'btn btn-primary']);
	}

}