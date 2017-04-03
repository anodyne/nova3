<?php namespace Nova\Core\Forms\Policies;

use Nova\Foundation\Policies\Policy;

class FieldPolicy extends Policy
{
	protected $createKey = 'form.create';
	protected $editKey = 'form.edit';
	protected $removeKey = 'form.remove';
}
