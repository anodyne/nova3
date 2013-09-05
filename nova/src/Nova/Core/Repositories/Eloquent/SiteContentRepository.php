<?php namespace Nova\Core\Repositories\Eloquent;

use SiteContent;
use SecurityTrait;
use SiteContentRepositoryInterface;

class SiteContentRepository implements SiteContentRepositoryInterface {

	use SecurityTrait;

	public function all()
	{
		return SiteContent::all();
	}

	public function create(array $data)
	{
		return SiteContent::create($data);
	}

	public function delete($id)
	{
		$id = $this->sanitizeInt($id);

		// Get the content item
		$item = $this->find($id);

		if ($item)
			return $item->delete();

		return false;
	}

	public function find($id)
	{
		$id = $this->sanitizeInt($id);

		return SiteContent::find($id);
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
		return SiteContent::getContentItem($key, $valueOnly);
	}

	/**
	 * Find content by the section and controller.
	 *
	 * @param	string	$section	The section to get
	 * @param	string	$controller	The controller to get
	 * @return	Collection
	 */
	public function findBySection($section, $controller)
	{
		return SiteContent::getSectionContent($section, $controller);
	}

	public function update($id, array $data)
	{
		$id = $this->sanitizeInt($id);

		// Get the content item
		$item = $this->find($id);

		if ($item)
			return $item->update($data);

		return false;
	}

}