<?php namespace Nova\Core\Lib;

use Input;
use Session;
use Symfony\Component\Finder\Finder;

class Media {
	
	/**
	 * Acceptable MIME types.
	 */
	protected $mimes = [
		'image/jpeg',
		'image/png',
		'image/gif',
		'image/bmp',
	];

	/**
	 * The file size limit in MB.
	 */
	protected $fileSizeLimit = 1;

	/**
	 * An instance of the model being used.
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
	 * @param	string	The name of the file
	 * @return	void
	 */
	public function add($filename)
	{
		if (Input::hasFile($filename))
		{
			// Get the uploaded file
			$file = Input::file($filename);

			// Make sure it's an acceptable file type
			if (in_array($file->getMimeType(), $this->mimes))
			{
				// Make sure the file is under 1MB
				if ($file->getSize() <= '')
				{
					// Add the media
					$upload = $this->model->addMedia($file);
				}
				else
				{
					// File is too big
					$flashStatus = 'danger';
					$flashMessage = lang('error.media.fileTooBig', [$this->fileSizeLimit]);
				}
			}
			else
			{
				// Not an acceptable file type
				$flashStatus = 'danger';
				$flashMessage = lang('error.media.badFileType');
			}
		}
		else
		{
			// File couldn't be uploaded
			$flashStatus = 'danger';
			$flashMessage = lang('error.media.notUploaded');
		}

		Session::flash('flashStatus', $flashStatus);
		Session::flash('flashMessage', $flashMessage);
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