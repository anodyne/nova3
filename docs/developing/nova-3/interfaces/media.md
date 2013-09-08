# Media Interface

By default, Nova ships with a few items that can add content to the media table (character images, user images, mission images, etc.), but as a developer, you may have some cool idea for something new to use media (or you may want something that doesn't have media to use media). Because there's a media interface, you can have your model (or any model) implement the interface for adding and managing media.

## The Interface

<pre>interface Media {
	
	public function addMedia();

	public function getAllMedia();

	public function getMediaInfo();

	public function getMediaItem();

	public function removeMedia();

}</pre>

These methods allow you to add media to the table, get all the media of that type, get media info, get a specific media item or remove media from the table. How you build these is entirely up to you, but just remember, you have to fulfill the contract exactly as its written. If there's two parameters on a method, your implementation has to have those same two parameters as well.