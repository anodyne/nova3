<?php namespace Nova\Core\Lib;

class Image {

	protected $src;
	protected $input;
	protected $extension;

	public function __construct($src, $input)
	{
		$this->src = $src;
		$this->input = $input;
		$this->extension = explode('.', $this->src)[1];
	}

	/**
	 * Crop the image and save it.
	 *
	 * @param	int		$height		The height of the new image
	 * @param	int		$width		The width of the new image
	 * @param	string	$output		Where to save the new image
	 * @return	void
	 */
	public function crop($height, $width, $output)
	{
		// Create a new image for the format of the original image
		$img = $this->createFromImageFormat();

		// Create a new true color image
		$dst = imagecreatetruecolor($width, $height);

		// Get a resampled copy of the image
		imagecopyresampled(
			$dst, 
			$img, 
			0, 
			0, 
			$this->input['x1'], 
			$this->input['y1'], 
			$height, 
			$width, 
			$this->input['width'], 
			$this->input['height']
		);

		// Write the image to the proper location
		$this->createNewImage($dst, $output);
	}

	/**
	 * Create a new image from the format of the original image.
	 *
	 * @internal
	 * @return	image
	 */
	protected function createFromImageFormat()
	{
		switch ($this->extension)
		{
			case 'jpg':
			case 'jpeg':
				return imagecreatefromjpeg($this->src);
			break;

			case 'png':
				return imagecreatefrompng($this->src);
			break;

			case 'gif':
				return imagecreatefromgif($this->src);
			break;
		}
	}

	/**
	 * Create a new image.
	 *
	 * @internal
	 * @param	image	$dst
	 * @param	string	$output
	 * @return	void
	 */
	protected function createNewImage($dst, $output)
	{
		switch ($this->extension)
		{
			case 'jpg':
			case 'jpeg':
				imagejpeg($dst, $output, 75);
			break;

			case 'png':
				imagepng($dst, $output, 6);
			break;

			case 'gif':
				imagegif($dst, $output);
			break;
		}
	}

}