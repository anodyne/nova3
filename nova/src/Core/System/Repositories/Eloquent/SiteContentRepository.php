<?php namespace Nova\Core\System\Repositories\Eloquent;

use Str,
	UtilityTrait,
	SecurityTrait,
	SiteContentModel,
	SiteContentRepositoryInterface;

class SiteContentRepository implements SiteContentRepositoryInterface {

	use UtilityTrait,
		SecurityTrait;

	/**
	 * Get everything out of the database.
	 *
	 * @return	Collection
	 */
	public function all()
	{
		return SiteContentModel::all();
	}

	/**
	 * Create a new site content item.
	 *
	 * @param	array	$data		Data to use for creation
	 * @param	bool	$setFlash	Set the flash message?
	 * @return	SiteContent
	 */
	public function create(array $data, $setFlash = true)
	{
		$item = SiteContentModel::create($data);

		if ($setFlash)
		{
			// Set the flash info
			$status = ($item) ? 'success' : 'danger';
			$message = ($item) 
				? lang('Short.alert.success.create', langConcat('site content'))
				: lang('Short.alert.failure.create', langConcat('site content'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $item;
	}

	/**
	 * Delete a site content item.
	 *
	 * @param	int		$id			ID to delete
	 * @param	bool	$setFlash	Set the flash message?
	 * @return	SiteContent
	 */
	public function delete($id, $setFlash = true)
	{
		// Get the content item
		$item = $this->find($id);

		if ($item)
		{
			// Delete the item
			$delete = $item->delete();

			if ($setFlash)
			{
				// Set the flash info
				$status = ($delete) ? 'success' : 'danger';
				$message = ($delete) 
					? lang('Short.alert.success.delete', langConcat('site content'))
					: lang('Short.alert.failure.delete', langConcat('site content'));

				// Flash the session
				$this->setFlashMessage($status, $message);
			}

			if ($delete)
			{
				return $item;
			}
		}

		return false;
	}

	/**
	 * Find an item by its ID.
	 *
	 * @param	int		$id		ID to find
	 * @return	SiteContent
	 */
	public function find($id)
	{
		return SiteContentModel::find($this->sanitizeInt($id));
	}

	/**
	 * Find a specific item by key.
	 *
	 * @param	string	$key		Content key to use
	 * @param	bool	$valueOnly	Return just the value?
	 * @return	mixed
	 */
	public function findByKey($key, $valueOnly = true)
	{
		return SiteContentModel::getContentItem($key, $valueOnly);
	}

	/**
	 * Find content by the section and controller.
	 *
	 * @param	string	$section	The section to get
	 * @param	string	$controller	The controller to get
	 * @param	bool	$clean		Ignore the cache
	 * @return	Collection
	 */
	public function findBySection($section, $controller, $clean = false)
	{
		return SiteContentModel::getSectionContent($section, $controller, $clean);
	}

	/**
	 * Get the site content data for the admin section.
	 *
	 * ContentTypes - returns an array of types
	 * Content - returns an array of content items
	 *
	 * @param	string	$return		What to return
	 * @return	array
	 */
	public function getForAdmin($return)
	{
		// Get all the site content
		$contents = $this->all();

		foreach ($contents as $c)
		{
			// Get the type
			$contentTypes[$c->type] = ucfirst(Str::plural($c->type));

			// Get the content
			$content[$c->type][] = $c;
		}

		switch ($return)
		{
			case 'ContentTypes':
				return $contentTypes;
			break;
			
			case 'Content':
				return $content;
			break;

			default:
				return ['contentTypes' => $contenTypes, 'content' => $content];
			break;
		}
	}

	/**
	 * Update a site content item.
	 *
	 * @param	int		$id			ID to update
	 * @param	array	$data		Data to use for update
	 * @param	bool	$setFlash	Set the flash message?
	 * @return	SiteContent
	 */
	public function update($id, array $data, $setFlash = true)
	{
		// Get the content item
		$item = $this->find($id);

		if ($item)
		{
			// Update the item
			$update = $item->fill($data)->save();

			if ($setFlash)
			{
				// Set the flash info
				$status = ($update) ? 'success' : 'danger';
				$message = ($update) 
					? lang('Short.alert.success.update', langConcat('site content'))
					: lang('Short.alert.failure.update', langConcat('site content'));

				// Flash the session
				$this->setFlashMessage($status, $message);
			}

			if ($update)
			{
				return $item;
			}
		}

		return false;
	}

	/**
	 * Update the site content with a simple array.
	 *
	 * @param	array	$data	Data for the update
	 */
	public function updateByKey(array $data)
	{
		return SiteContentModel::updateSiteContent($data);
	}

	/**
	 * Update the site content items URI by the old URI.
	 *
	 * @param	string	$oldURI		The old URI
	 * @param	string	$newURI		The new URI
	 * @return	void
	 */
	public function updateUri($oldURI, $newURI)
	{
		// Get the site content
		$items = SiteContentModel::uri($oldURI)->get();

		if ($items->count() > 0)
		{
			foreach ($items as $item)
			{
				$item->update(['uri' => $newURI]);
			}
		}
	}

}