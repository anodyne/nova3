<?php namespace Nova\Core\Interfaces\Repositories;

use BaseRepositoryInterface;

interface FormRepositoryInterface extends BaseRepositoryInterface {

	/**
	 * Create a form field.
	 *
	 * @param	array	$data	Data to use for creating the field
	 * @param	Form	$form	The Form object
	 * @return	Form
	 */
	public function createField(array $data, $form);

	/**
	 * Create a new FormViewer entry.
	 *
	 * @param	int		$id				The data ID to use
	 * @param	array	$data			Data to use creating the entry
	 * @param	Form	$form			Form object
	 * @param	User	$currentUser	The current user
	 * @return	void
	 */
	public function createFormViewerEntry($id, array $data, $form, $currentUser);

	/**
	 * Create a form section.
	 *
	 * @param	array	$data	Data to use for creating the section
	 * @param	Form	$form	The Form object
	 * @return	Form
	 */
	public function createSection(array $data, $form);

	/**
	 * Create a form tab.
	 *
	 * @param	array	$data	Data to use for creating the tab
	 * @param	Form	$form	The Form object
	 * @return	Form
	 */
	public function createTab(array $data, $form);

	/**
	 * Delete a form field.
	 *
	 * @param	int		$id		Field ID to delete
	 * @param	Form	$form	The Form object
	 * @return	bool
	 */
	public function deleteField($id, $form);

	/**
	 * Delete a FormViewer entry.
	 *
	 * @param	int		$id		Data ID to delete
	 * @param	Form	$form	The Form object
	 * @return	bool
	 */
	public function deleteFormViewerEntry($id, $form);

	/**
	 * Delete a form section.
	 *
	 * @param	int		$id		Section ID to delete
	 * @param	int		$newId	New section to use
	 * @param	Form	$form	The Form object
	 * @return	bool
	 */
	public function deleteSection($id, $newId, $form);

	/**
	 * Delete a form tab.
	 *
	 * @param	int		$id		Tab ID to delete
	 * @param	int		$newId	New tab to use
	 * @param	Form	$form	The Form object
	 * @return	bool
	 */
	public function deleteTab($id, $newId, $form);

	/**
	 * Find a form by its form key.
	 *
	 * @param	string	$key	The form key
	 * @return	Form
	 */
	public function findByKey($key);

	/**
	 * Get a form's data entries.
	 *
	 * @param	Form	$form	Form object
	 * @return	Collection
	 */
	public function getFormViewerDataEntries($form);

	/**
	 * Get a specific FormViewer entry.
	 *
	 * @param	int		$id		Data entry to get
	 * @param	Form	$form	Form object
	 */
	public function getFormViewerEntry($id, $form);

	/**
	 * Get a form's data entries as a paginated result set.
	 *
	 * @param	Form	$form		Form object
	 * @param	int		$perPage	Number of results per page
	 * @return	Collection
	 */
	public function getPaginatedFormViewerEntries($form, $perPage = 50);

	/**
	 * Update a form field.
	 *
	 * @param	int		$id		Field ID to update
	 * @param	array	$data	Data to use for the update
	 * @param	Form	$form	The Form object
	 * @return	Form
	 */
	public function updateField($id, array $data, $form);

	/**
	 * Update a FormViewer entry.
	 *
	 * @param	int		$id		The data ID to use
	 * @param	array	$data	Data to use updating the entry
	 * @param	Form	$form	Form object
	 * @return	void
	 */
	public function updateFormViewerEntry($id, array $data, $form);

	/**
	 * Update a form section.
	 *
	 * @param	int		$id		Section ID to update
	 * @param	array	$data	Data to use for the update
	 * @param	Form	$form	The Form object
	 * @return	Form
	 */
	public function updateSection($id, array $data, $form);

	/**
	 * Update a form tab.
	 *
	 * @param	int		$id		Tab ID to update
	 * @param	array	$data	Data to use for the update
	 * @param	Form	$form	The Form object
	 * @return	Form
	 */
	public function updateTab($id, array $data, $form);

}