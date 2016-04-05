<?php namespace Nova\Core\Forms\Data;

use Model, FormFieldPresenter;
use Illuminate\Support\Collection;
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
		if (is_array($value))
		{
			$this->attributes['attributes'] = json_encode($value);
		}
		elseif ($value instanceof Collection)
		{
			$this->attributes['attributes'] = $value->toJson();
		}
		else
		{
			$this->attributes['attributes'] = $value;
		}
	}

	public function setRestrictionsAttribute($value)
	{
		if (is_array($value))
		{
			$this->attributes['restrictions'] = json_encode($value);
		}
		elseif ($value instanceof Collection)
		{
			$this->attributes['restrictions'] = $value->toJson();
		}
		else
		{
			$this->attributes['restrictions'] = $value;
		}
	}

	public function setValidationRulesAttribute($value)
	{
		if (is_array($value))
		{
			$this->attributes['validation_rules'] = json_encode($value);
		}
		elseif ($value instanceof Collection)
		{
			$this->attributes['validation_rules'] = $value->toJson();
		}
		else
		{
			$this->attributes['validation_rules'] = $value;
		}
	}

	public function setValuesAttribute($value)
	{
		if (is_array($value))
		{
			$this->attributes['values'] = json_encode($value);
		}
		elseif ($value instanceof Collection)
		{
			$this->attributes['values'] = $value->toJson();
		}
		else
		{
			$this->attributes['values'] = $value;
		}
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
