$(function () {
	$('main .nav-tabs').each(function () {
		$(this).find('li a:first').tab('show')
	})

	$('main .nav-pills').each(function () {
		$(this).find('li a:first').tab('show')
	})

	$('main .nav-tabs, main .nav-pills').tabdrop()
})