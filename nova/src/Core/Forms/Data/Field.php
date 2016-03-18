<?php namespace Nova\Core\Forms\Data;

use Model, FormFieldPresenter;
use Laracasts\Presenter\PresentableTrait;

class Field extends Model {

	use PresentableTrait;

	protected $table = 'forms_fields';

	protected $fillable = ['form_id', 'tab_id', 'section_id', 'type', 'label',
		'order', 'status', 'restriction', 'help', 'validation_rules', 
		'label_container_class', 'attributes', 'values'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = FormFieldPresenter::class;

	protected $casts = [
		'attributes' => 'collection',
		'validation_rules' => 'collection',
		'values' => 'collection',
	];

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function form()
	{
		return $this->belongsTo('NovaForm');
	}

	public function section()
	{
		return $this->belongsTo('NovaFormSection');
	}

	public function tab()
	{
		return $this->belongsTo('NovaFormTab');
	}

	/*
	|---------------------------------------------------------------------------
	| Model Methods
	|---------------------------------------------------------------------------
	*/

	public function validationRules()
	{
		if (count($this->validation_rules) > 0)
		{
			$ruleList = [];

			foreach ($this->validation_rules as $rule)
			{
				$ruleList[] = (empty($rule['value']))
					? $rule['type']
					: "{$rule['type']}:{$rule['value']}";
			}

			return implode('|', $ruleList);
		}

		return false;
	}
	
}
