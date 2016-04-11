{!! HTML::style('nova/resources/css/tabdrop.css') !!}
{!! HTML::script('nova/resources/js/bootstrap-tabdrop.js') !!}
<script>
	$(function () {
		$('.nav-tabs').each(function () {
			$(this).find('li a:first').tab('show')
		})

		$('.nav-pills').each(function () {
			$(this).find('li a:first').tab('show')
		})

		$('.nav-tabs, .nav-pills').tabdrop()
	})
</script>