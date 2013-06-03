<?php namespace Nova\Core\Lib;

use Symfony\Component\Finder\Finder;

class Media {
	
	/**
	 * @var	object	An instance of the model being used
	 */
	protected $model;

	public function __construct(string $model)
	{
		$this->model = $this->createModel($model);
	}

	/**
	 * Add a media item. Will upload the item to the appropriate
	 * location and use the passed model to ensure the media
	 * table has all the information it needs.
	 *
	 * @return void
	 */
	public function add()
	{
		# code...
	}

	/**
	 * Get a media item.
	 *
	 * @return	void
	 */
	public function get()
	{
		# code...
	}

	/**
	 * Get the info about a media item. This will return the
	 * information out of the database as well as provide file
	 * information about the media item.
	 *
	 * @return	void
	 */
	public function info()
	{
		# code...
	}

	/**
	 * Remove a media item. Will remove the information from the
	 * database and attempt to delete the file.
	 *
	 * @return	void
	 */
	public function remove()
	{
		# code...
	}

	/**
	 * Get the model instance.
	 *
	 * @return	$model
	 */
	public function getModel()
	{
		return $this->model;
	}

	/**
	 * Set the model from outside the class.
	 *
	 * @param	string	The name of the model
	 * @return	void
	 */
	public function setModel($value)
	{
		$this->model = $this->createModel($value);
	}

	/**
	 * Create a new instance of the model.
	 *
	 * @param	string	The model name
	 * @return	$model
	 */
	protected function createModel(string $model)
	{
		$class = '\\'.ltrim($model, '\\');

		return new $class;
	}

}