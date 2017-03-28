<?php namespace Nova\Core\Forms\Data\Presenters;

use BasePresenter;

class EntryPresenter extends BasePresenter
{
	public function identifier()
	{
		$entry = $this->entity;
		$form = $entry->form;

		if (! empty($form->entry_identifier)) {
			$data = $entry->data->whereLoose('field_id', $form->entry_identifier);

			if ($data->count() > 0) {
				return $data->first()->present()->value;
			}
		}

		return $this->createdAt();
	}

	public function submitter()
	{
		if ($this->entity->user) {
			return $this->entity->user->present()->name;
		}

		return $this->entity->ip_address;
	}
}
