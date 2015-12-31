<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm,
	NovaFormTab as Model,
	FormTabRepositoryInterface;

class TabRepository extends BaseFormRepository implements FormTabRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function countLinkIds(NovaForm $form, $linkId)
	{
		if ( ! $form->tabs) return 0;

		return $form->tabs->filter(function ($tab) use ($linkId)
		{
			return $tab->link_id === $linkId;
		})->count();
	}

	public function delete($resource)
	{
		// Get the resource
		$tab = $this->getResource($resource);

		if ($tab)
		{
			// If there are children tab, we need to loop through those and
			// delete all the content within that tab first
			if ($tab->childrenTabs->count() > 0)
			{
				foreach ($tab->childrenTabs as $childTab)
				{
					$this->delete($childTab);
				}
			}

			// Next, we need to remove any fields that aren't part of a
			// section, including their data and values
			$tab->fields->each(function ($field)
			{
				$field->data->each(function ($d)
				{
					$d->delete();
				});

				$field->values->each(function ($value)
				{
					$value->delete();
				});

				$field->delete();
			});

			// Up next are sections, the fields in the section and any
			// data and values associated with those fields
			$tab->sections->each(function ($section)
			{
				$section->fields->each(function ($field)
				{
					$field->data->each(function ($d)
					{
						$d->delete();
					});

					$field->values->each(function ($value)
					{
						$value->delete();
					});

					$field->delete();
				});

				$section->delete();
			});

			// Finally, remove the form tab
			$tab->delete();

			return $tab;
		}

		return false;
	}

	public function getFormTabs(NovaForm $form, array $with = [])
	{
		$with = (count($with) > 0) ? $with : ['childrenTabs', 'childrenTabs.parentTab'];

		return $form->tabs->sortBy('order')->load($with);
	}

	public function getParentTabs(NovaForm $form, array $with = [])
	{
		$with = (count($with) > 0) ? $with : ['childrenTabs', 'childrenTabs.parentTab'];
		
		return $form->tabs->filter(function ($tab)
		{
			return ! $tab->parent_id;
		})->load($with);
	}

	public function listParentTabs(NovaForm $form)
	{
		$tabs = $this->getParentTabs($form);
		
		return $this->listCollection($tabs, 'id', 'name');
	}

}
