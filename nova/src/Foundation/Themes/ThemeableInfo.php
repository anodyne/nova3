<?php namespace Nova\Foundation\Themes;

interface ThemeableInfo {

	/**
	 * Get the full name of the theme.
	 *
	 * @return	string
	 */
	public function getFullName();

	/**
	 * Get the author of the theme.
	 *
	 * @return	string
	 */
	public function getAuthor();

	/**
	 * Get the name of the theme folder or the full path to the theme.
	 *
	 * @param	bool	$raw	Get only the theme folder name?
	 * @return	string
	 */
	public function getLocation($raw = false);

	/**
	 * Get the preview image filename or an image tag to the preview image.
	 *
	 * @param	bool	$raw	Get only the theme preview filename?
	 * @param	array	$attr	Custom attributes to be added to the image tag
	 * @return	string
	 */
	public function getPreview($raw = false, array $attr = []);

	/**
	 * Get the theme credits as straight text or parsed Markdown.
	 *
	 * @param	bool	$raw	Get the unparsed credits?
	 * @return	string
	 */
	public function getCredits($raw = false);

	/**
	 * Get the version of the theme.
	 *
	 * @return	string
	 */
	public function getVersion();
}
