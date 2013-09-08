# Custom Skin Options

Skin developers have more freedom than ever before with Nova 3 with the ability to specificy custom options that site admins can set on their skins. This provides a wide range of new and exciting possibilities for skins moving forward.

## The Options File

In order to give site admins the ability to set options for your skin, you'll need to create an `options.json` file in the root of your skin. From there, it's simply a matter of building the options you want into the file; Nova will take care of the rest.

<pre>{
	"items": [
		{
			"label": "Sim Name",
			"key": "sim_name",
			"type": "text",
			"help": "Help text for the field"
		},
		{
			"label": "Slogan",
			"key": "slogan",
			"type": "textarea"
		},
		{
			"label": "Banner Image",
			"key": "banner_image",
			"type": "image",
			"filename": "header.jpg",
			"location": "design/images"
		},
		{
			"label": "Alert Status",
			"key": "alert_status",
			"type": "choice",
			"options": ["green", "yellow", "red", "blue", "gray"]
		}
	]
}</pre>

### Text Fields and Text Boxes

Simple text fields and larger textareas can be created with the following options:

- __Label__: The field label
- __Key__: The name of the field and how you'll retrieve the information
- __Type__: For text fields, the type is `text`, for text boxes, the type is `textarea`
- __Help__: Any text you want to be displayed below the field to help the admin fill out the field

### Choice Fields

Dropdown menus with multiple options can be created with the options available for text fields and text boxes, but you can also use this additional option:

- __Options__: This is a simple JSON array of options you want to be available to the admin

### Images

Image upload areas can be created with the options available for text fields and text boxes, but you can also use these additional options:

- __Filename__: What the uploaded file will be named, regardless of what the name of the uploaded file is
- __Location__: The directory within in the skin where the image should be uploaded to

## Retrieving Options