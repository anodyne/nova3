<?php namespace Nova\Core\Forms\Mailers;

use NovaForm, BaseMailer;

class FormCenterMailer extends BaseMailer {

	public function created($record, NovaForm $form)
	{
		return $this->send('admin/forms/form-center-created', [
			'to' => $form->email_recipients,
			'from' => $record->user,
			'subject' => $form->name." Record Created in Form Center",
		]);
	}

	public function updated($record, NovaForm $form)
	{
		return $this->send('admin/forms/form-center-updated', [
			'to' => $form->email_recipients,
			'from' => $record->user,
			'subject' => $form->name." Record Updated in Form Center",
		]);
	}

}
