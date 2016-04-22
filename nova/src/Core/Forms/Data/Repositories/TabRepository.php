<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm,
	NovaFormTab as Model,
	FormTabRepositoryContract,
	FormFieldRepositoryContract,
	FormSectionRepositoryContract;
use Nova\Core\Forms\Events;

class TabRepository extends BaseFormRepository implements FormTabRepositoryContract {

	protected $model;
	protected $fieldRepo;
	protected $sectionRepo;

	public function __construct(Model $model,
			FormFieldRepositoryContract $fields,
			FormSectionRepositoryContract $sections)
	{
		$this->model = $model;
		$this->fieldRepo = $fields;
		$this->sectionRepo = $sections;
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

	public function create(array $data)
	{
		$tab = parent::create($data);

		event(new Events\FormTabCreated($tab));

		return $tab;
	}

	public function delete($resource)
	{
		$tab = parent::delete($resource);

		event(new Events\FormTabDeleted($tab->id, $tab->name, $tab->form->key));

		return $tab;
	}

	public function getFormTabs(NovaForm $form, array $relations = [], $allTabs = false)
	{
		$relations = (count($relations) > 0) 
			? $relations 
			: ['childrenTabs', 'childrenTabs.parentTab'];

		$relationship = ($allTabs) ? 'tabsAll' : 'tabs';

		return $form->{$relationship}->load($relations);
	}

	public function getParentTabs(NovaForm $form, array $relations = [], $allTabs = false)
	{
		$relations = (count($relations) > 0) 
			? $relations 
			: ['childrenTabs', 'childrenTabs.parentTab'];

		$relationship = ($allTabs) ? 'parentTabsAll' : 'parentTabs';

		return $form->{$relationship}->load($relations);
	}

	public function listParentTabs()
	{
		return $this->listAllBy('parent_id', 0, 'name', 'id');
	}

	public function reassignTabContent(Model $oldTab, $newTabId)
	{
		// Grab the repositories
		$tabRepo = $this;
		$fieldRepo = $this->fieldRepo;
		$sectionRepo = $this->sectionRepo;

		// Reassign any tabs
		$oldTab->childrenTabs->each(function ($tab) use ($newTabId, $tabRepo)
		{
			$tabRepo->update($tab, ['parent_id' => $newTabId]);
		});

		// Reassign any sections
		$oldTab->sections->each(function ($section) use ($newTabId, $sectionRepo)
		{
			$sectionRepo->update($section, ['tab_id' => $newTabId]);
		});

		// Reassign any fields
		$oldTab->fields->each(function ($field) use ($newTabId, $fieldRepo)
		{
			$fieldRepo->update($field, ['tab_id' => $newTabId]);
		});
	}

	public function removeTabContent(Model $tab)
	{
		// Grab the repositories
		$tabRepo = $this;
		$fieldRepo = $this->fieldRepo;
		$sectionRepo = $this->sectionRepo;

		// Remove all fields
		$tab->fieldsAll->each(function ($field) use ($fieldRepo)
		{
			// First remove any data associated with the field
			$field->data->each(function ($row)
			{
				$row->delete();
			});

			// Now delete the field
			$fieldRepo->delete($field);
		});

		// Remove any sections
		$tab->sectionsAll->each(function ($section) use ($sectionRepo, $fieldRepo)
		{
			// Remove any fields in the section
			$section->fieldsAll->each(function ($field) use ($fieldRepo)
			{
				// First remove any data associated with the field
				$field->data->each(function ($row)
				{
					$row->delete();
				});

				// Now delete the field
				$fieldRepo->delete($field);
			});

			// Remove the section
			$sectionRepo->delete($section);
		});

		// Remove any child tabs
		$tab->childrenTabsAll->each(function ($childTab) use ($sectionRepo, $fieldRepo)
		{
			// Remove any sections
			$childTab->sectionsAll->each(function ($section) use ($sectionRepo, $fieldRepo)
			{
				// First remove any fields in the section
				$section->fieldsAll->each(function ($field) use ($fieldRepo)
				{
					// First remove any data associated with the field
					$field->data->each(function ($row)
					{
						$row->delete();
					});

					// Now delete the field
					$fieldRepo->delete($field);
				});

				$sectionRepo->delete($section);
			});

			// Remove any unbound fields
			$childTab->fieldsAll->each(function ($field) use ($tabRepo, $fieldRepo)
			{
				// First remove any data associated with the field
				$field->data->each(function ($row)
				{
					$row->delete();
				});

				// Now delete the field
				$fieldRepo->delete($field);
			});

			// Remove the tab
			$tabRepo->delete($childTab);
		});
	}

	public function update($resource, array $data)
	{
		$tab = parent::update($resource, $data);

		event(new Events\FormTabUpdated($tab));

		return $tab;
	}

	public function updateOrder($resource, $newOrder)
	{
		$tab = parent::updateOrder($resource, $newOrder);

		event(new Events\FormTabOrderUpdated($tab));

		return $tab;
	}

}
