<?php namespace Nova\Core\Repositories\Eloquent;

use UtilityTrait;
use SecurityTrait;
use SiteContentModel;
use SiteContentRepositoryInterface;

class SiteContentRepository implements SiteContentRepositoryInterface {

	use UtilityTrait;
	use SecurityTrait;

	public function all()
	{
		return SiteContentModel::all();
	}

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

	public function update($id, array $data, $setFlash = true)
	{
		// Get the content item
		$item = $this->find($id);

		if ($item)
		{
			// Update the item
			$update = $item->update($data);

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

			return $update;
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