<?php namespace Nova\Core\Forms\Data;

use Model, FormFieldPresenter;
use Laracasts\Presenter\PresentableTrait;

class Field extends Model {

	use PresentableTrait;

	protected $table = 'forms_fields';

	protected $fillable = ['form_id', 'tab_id', 'section_id', 'type', 'label',
		'order', 'status', 'restrictions', 'help', 'validation_rules', 
		'label_container_class', 'attributes', 'values', 'field_container_class'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = FormFieldPresenter::class;

	protected $casts = [
		'attributes'		=> 'collection',
		'restrictions'		=> 'collection',
		'validation_rules'	=> 'collection',
		'values'			=> 'collection',
	];

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function data()
	{
		return $this->hasMany('NovaFormData');
	}

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
	| Mutators
	|---------------------------------------------------------------------------
	*/

	public function setAttributesAttribute($value)
	{
		$this->attributes['attributes'] = (is_array($value))
			? json_encode($value)
			: $value->toJson();
	}

	public function setRestrictionsAttribute($value)
	{
		$this->attributes['restrictions'] = (is_array($value))
			? json_encode($value)
			: $value->toJson();
	}

	public function setValidationRulesAttribute($value)
	{
		$this->attributes['validation_rules'] = (is_array($value))
			? json_encode($value)
			: $value->toJson();
	}

	public function setValuesAttribute($value)
	{
		$this->attributes['values'] = (is_array($value))
			? json_encode($value)
			: $value->toJson();
	}

	/*
	|---------------------------------------------------------------------------
	| Model Methods
	|---------------------------------------------------------------------------
	*/

	public function restrictionForType($type)
	{
		$restriction = $this->restrictions->where('type', $type)->first();
		
		if ($restriction) return $restriction['value'];

		return false;
	}

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
