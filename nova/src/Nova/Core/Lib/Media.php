<?php namespace Nova\Core\Lib;

use File;
use Input;
use Session;
use MediaNoInputException;
use MediaFileTooBigException;
use MediaBadFileTypeException;
use Symfony\Component\Finder\Finder;

class Media {
	
	/**
	 * Acceptable MIME types.
	 */
	protected $mimes = [
		'image/jpeg',
		'image/png',
		'image/gif',
	];

	/**
	 * The file size limit in MB.
	 */
	protected $fileSizeLimit = 2;

	/**
	 * An instance of the model being used.
	 */
	protected $model;

	/**
	 * Add a media item. Will upload the item to the appropriate location and 
	 * use the passed model to ensure the media table has all the information 
	 * it needs.
	 *
	 * @param	string	$filename		Final name of the file
	 * @param	string	$destination	Destination of the file
	 * @param	array	$options		Additional options
	 * @param	string	$field			File upload field name
	 * @return	bool
	 * @throws	MediaFileTooBigException
	 * @throws	MediaBadFileTypeException
	 * @throws	MediaNoInputException
	 */
	public function add($filename, $destination, array $options = [], $field = 'file')
	{
		if (Input::hasFile($field))
		{
			// Get the uploaded file
			$file = Input::file($field);

			// Make sure it's an acceptable file type
			if (in_array($file->getMimeType(), $this->mimes))
			{
				// Get the file size
				$filesize = round($file->getSize() / pow(1024, 2), 2);

				// Make sure the file is under the limit
				if ($filesize <= $this->fileSizeLimit)
				{
					// Upload the file
					$upload = $file->move($destination, $filename);

					// Add the media
					$databaseUpload = $this->model->addMedia($filename, $options);
				}
				else
				{
					throw new MediaFileTooBigException;
				}
			}
			else
			{
				throw new MediaBadFileTypeException;
			}
		}
		else
		{
			throw new MediaNoInputException;
		}

		return true;
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
	 * Get the info about a media item. This will return the information out of 
	 * the database as well as provide file information about the media item.
	 *
	 * @return	void
	 */
	public function info()
	{
		# code...
	}

	/**
	 * Remove a media item. Will remove the information from the database and 
	 * attempt to delete the file.
	 *
	 * @param	Media	$media	The media object
	 * @return	bool
	 */
	public function remove($media)
	{
		if ($media)
		{
			$finder = new Finder;
			
			// Set the criteria for finding the image(s)
			$finder->files()->in(APPPATH.'assets/images/*')->name($media->filename);

			foreach ($finder as $f)
			{
				// Remove the file
				File::delete($f->getRealPath());
			}

			// Remove the database record
			$media->delete();

			return true;
		}

		return false;
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
	 * @param	object	$value	Model instance
	 * @return	void
	 */
	public function setModel($value)
	{
		$this->model = $value;
	}

	/**
	 * Get the maximum file upload size in MB.
	 *
	 * @return	int
	 */
	public function getFileSizeLimit()
	{
		return $this->fileSizeLimit;
	}

	/**
	 * Get the acceptable MIME types for media uploads.
	 *
	 * @param	string	$format		Output format (array, csv)
	 * @return	mixed
	 */
	public function getFileFormats($format = 'array')
	{
		if ($format == 'csv')
		{
			return implode(',', $this->mimes);
		}

		return $this->mimes;
	}

}