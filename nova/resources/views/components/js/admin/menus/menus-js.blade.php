<script>
	$('.js-menuAction').click(function (e) {
		e.preventDefault()

		var menuId = $(this).data('id')
		var action = $(this).data('action')

		if (action == 'remove') {
			$('#removeMenu').modal({
				remote: "{{ url('admin/menus') }}/" + menuId + "/remove"
			}).modal('show')
		}
	})
</script>