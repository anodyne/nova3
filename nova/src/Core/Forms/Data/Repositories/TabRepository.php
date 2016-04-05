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
		if ( ! $form->tabs)
		{
			return 0;
		}

		return $form->tabs->filter(function ($tab) use ($linkId)
		{
			return $tab->link_id === $linkId;
		})->count();
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

	public function reassignTabContent(Model $oldTab, $newTabId)
	{
		// Reassign any tabs
		$oldTab->childrenTabs->each(function ($tab) use ($newTabId)
		{
			$tab->update(['parent_id' => $newTabId]);
		});

		// Reassign any sections
		$oldTab->sections->each(function ($section) use ($newTabId)
		{
			$section->update(['tab_id' => $newTabId]);
		});

		// Reassign any fields
		$oldTab->fields->each(function ($field) use ($newTabId)
		{
			$field->update(['tab_id' => $newTabId]);
		});
	}

	public function removeTabContent(Model $tab)
	{
		// Remove any unbound fields
		$tab->fields->each(function ($field)
		{
			// First remove any data associated with the field
			$field->data->each(function ($row)
			{
				$row->delete();
			});

			// Now delete the field
			$field->delete();
		});

		// Remove any sections
		$tab->sections->each(function ($section)
		{
			// Remove any fields in the section
			$section->fields->each(function ($field)
			{
				// First remove any data associated with the field
				$field->data->each(function ($row)
				{
					$row->delete();
				});

				// Now delete the field
				$field->delete();
			});

			// Remove the section
			$section->delete();
		});

		// Remove any child tabs
		$tab->childrenTabs->each(function ($childTab)
		{
			// Remove any sections
			$childTab->sections->each(function ($section)
			{
				// First remove any fields in the section
				$section->fields->each(function ($field)
				{
					// First remove any data associated with the field
					$field->data->each(function ($row)
					{
						$row->delete();
					});

					// Now delete the field
					$field->delete();
				});

				$section->delete();
			});

			// Remove any unbound fields
			$childTab->fields->each(function ($field)
			{
				// First remove any data associated with the field
				$field->data->each(function ($row)
				{
					$row->delete();
				});

				// Now delete the field
				$field->delete();
			});

			// Remove the tab
			$childTab->delete();
		});
	}

}
