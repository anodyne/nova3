<?php namespace Nova\Core\Forms\Mailers;

use NovaForm, BaseMailer;

class FormCenterMailer extends BaseMailer {

	public function created($record, NovaForm $form)
	{
		return $this->send('admin/form-center/entry-added', [
			'to' => $form->email_recipients,
			'from' => $record->user,
			'subject' => $form->name." Entry Added in Form Center",
		]);
	}

	public function updated($record, NovaForm $form)
	{
		return $this->send('admin/form-center/entry-updated', [
			'to' => $form->email_recipients,
			'from' => $record->user,
			'subject' => $form->name." Entry Updated in Form Center",
		]);
	}

}
