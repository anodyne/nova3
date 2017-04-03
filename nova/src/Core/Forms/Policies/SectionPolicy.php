<?php namespace Nova\Core\Forms\Policies;

use Nova\Foundation\Policies\Policy;

class SectionPolicy extends Policy
{
	protected $createKey = 'form.create';
	protected $editKey = 'form.edit';
	protected $removeKey = 'form.remove';
}
