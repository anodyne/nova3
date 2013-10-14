<?php namespace Nova\Core\Interfaces\Repositories;

use BaseRepositoryInterface;

interface FormRepositoryInterface extends BaseRepositoryInterface {

	/**
	 * Create a form field.
	 *
	 * @param	array	$data		Data to use for creating the field
	 * @param	Form	$form		The Form object
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Field
	 */
	public function createField(array $data, $form, $setFlash = true);

	/**
	 * Create a form field value.
	 *
	 * @param	array	$data		Data to use for creating the form field value
	 * @param	string	$formKey	The form key
	 * @param	int		$fieldId	Field ID of the value being added
	 * @return	Value
	 */
	public function createFieldValue(array $data, $formKey, $fieldId);

	public function createFormViewerEntry($id, array $data, $form, $currentUser);

	/**
	 * Create a form section.
	 *
	 * @param	array	$data		Data to use for creating the section
	 * @param	Form	$form		The Form object
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Section
	 */
	public function createSection(array $data, $form, $setFlash = true);

	/**
	 * Create a form tab.
	 *
	 * @param	array	$data		Data to use for creating the tab
	 * @param	Form	$form		The Form object
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Tab
	 */
	public function createTab(array $data, $form, $setFlash = true);

	/**
	 * Delete a form field.
	 *
	 * @param	int		$id			Field ID to delete
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	bool
	 */
	public function deleteField($id, $setFlash = true);

	/**
	 * Delete a form field value.
	 *
	 * @param	int		$id		Field value ID to delete
	 * @return	bool
	 */
	public function deleteFieldValue($id);

	public function deleteFormViewerEntry($id, $form);

	/**
	 * Delete a form section.
	 *
	 * @param	int		$id			Section ID to delete
	 * @param	int		$newId		New section to use
	 * @param	Form	$form		The Form object
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	bool
	 */
	public function deleteSection($id, $newId, $form, $setFlash = true);

	/**
	 * Delete a form tab.
	 *
	 * @param	int		$id			Tab ID to delete
	 * @param	int		$newId		New tab to use
	 * @param	Form	$form		The Form object
	 * @param	bool	$setFlash	Set flash message?
	 * @return	bool
	 */
	public function deleteTab($id, $newId, $form, $setFlash = true);

	/**
	 * Find a form by its form key.
	 *
	 * @param	string	$key	The form key
	 * @return	Form
	 */
	public function findByKey($key);

	/**
	 * Find a form field.
	 *
	 * @param	int		$id		Field ID
	 * @return	Field
	 */
	public function findField($id);
	//public function findFieldByLabel($value);
	//public function findFieldByName($value);

	/**
	 * Find a form field value.
	 *
	 * @param	int		$id		Field value ID
	 * @return	Value
	 */
	public function findFieldValue($id);

	/**
	 * Find a form section.
	 *
	 * @param	int		$id		Section ID
	 * @return	Section
	 */
	public function findSection($id);
	//public function findSectionByName($value);

	/**
	 * Find a form tab.
	 *
	 * @param	int		$id		Tab ID
	 * @return	Tab
	 */
	public function findTab($id);
	//public function findTabByName($value);

	/**
	 * Get all the form fields for a form.
	 *
	 * @param	string	$formKey	Form key
	 * @return	Collection
	 */
	public function getFormFields($formKey);

	/**
	 * Get all of a form's fields and order them by label.
	 *
	 * @param	string	$formKey	Form key
	 * @param	string	$key		Field to use as the array key
	 * @param	string	$value		Field to use as the array value
	 * @return	array
	 */
	public function getFormFieldsForDropdown($formKey, $key, $value);

	/**
	 * Get all the form sections for a form.
	 *
	 * @param	string	$formKey	Form key
	 * @return	Collection
	 */
	public function getFormSections($formKey);

	/**
	 * Get all of a form's sections and put them into an array.
	 *
	 * @param	string	$formKey	Form key
	 * @param	string	$key		Field to use as the array key
	 * @param	string	$value		Field to use as the array value
	 * @return	array
	 */
	public function getFormSectionsForDropdown($formKey, $key, $value);

	/**
	 * Get all the form tabs for a form.
	 *
	 * @param	string	$formKey	Form key
	 * @return	Collection
	 */
	public function getFormTabs($formKey);

	/**
	 * Get all of a form's tabs and put them into an array.
	 *
	 * @param	string	$formKey	Form key
	 * @param	string	$key		Field to use as the array key
	 * @param	string	$value		Field to use as the array value
	 * @return	array
	 */
	public function getFormTabsForDropdown($formKey, $key, $value);

	public function getFormViewerDataEntries($form);

	public function getFormViewerEntry($id, $form);

	public function getPaginatedFormViewerEntries($form, $perPage = 50);

	/**
	 * Update a form field.
	 *
	 * @param	int		$id			Field ID to update
	 * @param	array	$data		Data to use for the update
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Field
	 */
	public function updateField($id, array $data, $setFlash = true);

	/**
	 * Update a form field value.
	 *
	 * @param	int		$id		Value ID to update
	 * @param	array	$data	Data to use for the update
	 * @return	Value
	 */
	public function updateFieldValue($id, array $data);

	public function updateFormViewerEntry($id, array $data, $form);

	/**
	 * Update a form section.
	 *
	 * @param	int		$id			Section ID to update
	 * @param	array	$data		Data to use for the update
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Section
	 */
	public function updateSection($id, array $data, $setFlash = true);

	/**
	 * Update a form tab.
	 *
	 * @param	int		$id			Tab ID to update
	 * @param	array	$data		Data to use for the update
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Tab
	 */
	public function updateTab($id, array $data, $setFlash = true);

}