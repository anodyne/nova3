<?php namespace Nova\Core\Forms\Policies;

use User,
	NovaForm as Form;

class FormPolicy {

	public function create(User $user)
	{
		return $user->can('form.create');
	}

	public function edit(User $user)
	{
		return $user->can('form.edit');
	}

	public function manage(User $user)
	{
		return ($this->create($user) or $this->edit($user) or $this->remove($user));
	}

	public function remove(User $user, Form $form)
	{
		return $user->can('form.remove') and ! $form->protected;
	}

}
