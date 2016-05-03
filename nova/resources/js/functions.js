var slug = function (str) {
	var $slug = ''
	var trimmed = $.trim(str)

	$slug = trimmed.replace(/[^a-z0-9-]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '')

	return $slug.toLowerCase()
}

var byId = function (id) {
	return document.getElementById(id)
}

var byClass = function (className) {
	return document.getElementsByClassName(className)
}

var novaUrl = function (uri) {
	return Nova.system.baseUrl + uri
}