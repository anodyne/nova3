<?php namespace Nova\Core\Lib;

use Str;
use File;
use Image;
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
	protected $fileSizeLimit = 3;

	/**
	 * An instance of the model being used.
	 */
	protected $model;

	/**
	 * Add a media item. Will upload the item to the appropriate location and 
	 * use the passed model to ensure the media table has all the information 
	 * it needs.
	 *
	 * @param	string	$destination	Destination of the file
	 * @param	array	$options		Additional options
	 * @param	string	$field			File upload field name
	 * @param	string	$filename		Final name of the file
	 * @return	bool
	 */
	public function add($destination, array $options = [], $field = 'file', $filename = false)
	{
		if (Input::hasFile($field))
		{
			// Get the uploaded file
			$file = Input::file($field);

			// Get the mime type
			$mimeType = $file->getMimeType();

			// Make sure it's an acceptable file type
			if (in_array($mimeType, $this->mimes))
			{
				// Get the file size
				$filesize = round($file->getSize() / pow(1024, 2), 2);

				// Make sure the file is under the limit
				if ($filesize <= $this->fileSizeLimit)
				{
					// Set the filename
					$newFilename = ($filename !== false) ? $filename : Str::random(32);
					$newFilename = "{$newFilename}.{$file->getClientOriginalExtension()}";

					// Upload the file
					$upload = $file->move($destination, $newFilename);

					// Make sure we have the mime type
					if ( ! array_key_exists('mime_type', $options))
						$options['mime_type'] = $mimeType;

					// Add the media
					$databaseUpload = $this->model->addMedia($newFilename, $options);
				}
				else
					throw new MediaFileTooBigException;
			}
			else
				throw new MediaBadFileTypeException;
		}
		else
			throw new MediaNoInputException;

		return true;
	}

	/**
	 * Crop an image to a square avatar.
	 *
	 * @param	Media	$media		The media object
	 * @param	string	$path		Path to where the original image is
	 * @param	array	$input		Input array
	 * @param	array	$options	Array of options for making the crop
	 * @return	bool
	 */
	public function cropSquare($media, $path, array $input, array $options)
	{
		// Get the file info and break it apart
		$fileInfo = explode('.', $media->filename);
		$filename = $fileInfo[0];
		$extension = '.'.$fileInfo[1];

		// Grab the info from the input
		$posX = $input['x1'];
		$posY = $input['y1'];
		$height = $input['height'];
		$width = $input['width'];

		/**
		 * The options array must have the following keys:
		 *
		 * size		The size (in pixels) of the final image
		 * dir		The directory inside of $path where the final image is stored
		 * retina	Is this a retina image (will attach @2x to the filename)
		 */
		foreach ($options as $o)
		{
			// Make an image from the original
			$image = Image::make($path.$filename.$extension);

			// Make sure the image is big enough to do the cropping
			if ((int) $height >= $o['size'])
			{
				// Crop the image
				$image->crop($height, $width, $posX, $posY)
					->resize($o['size'], $o['size']);

				// Build the start of the new filename
				if ($o['dir'] !== false)
					$newFilename = "{$path}{$o['dir']}/{$filename}";
				else
					$newFilename = $path.$filename;

				// If it's a retina image, add @2x to the filename
				if ($o['retina'])
					$image->save("{$newFilename}@2x{$extension}");
				else
					$image->save($newFilename.$extension);
			}
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
		return (int) $this->fileSizeLimit;
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
			return implode(',', $this->mimes);

		return $this->mimes;
	}

}