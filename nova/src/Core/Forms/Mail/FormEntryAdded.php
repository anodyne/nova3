<?php namespace Nova\Core\Forms\Mail;

use User;
use BaseMailable;

class FormEntryAdded extends BaseMailable
{
	public $entry;
	public $form;

	public function __construct($entry, $form)
	{
		parent::__construct();

		$this->entry = $entry;
		$this->form = $form;
	}

	public function build()
	{
		return $this->from($this->entry->user->email)
			->replyTo($this->entry->user->email)
			->subject($this->form->name." Entry Added in Form Center")
			->view('admin/form-center/entry-added');
	}
}
