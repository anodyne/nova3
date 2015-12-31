{!! HTML::script('nova/resources/js/Sortable.min.js') !!}
<script>
	vue = {
		methods: {
			removeSection: function(event)
			{
				var formKey = $(event.target).data('form-key')
				var sectionId = $(event.target).data('id')

				$('#removeSection').modal({
					remote: "{{ url('admin/forms') }}/" + formKey + "/sections/" + sectionId + "/remove"
				}).modal('show')
			}
		}
	}

	$('.data-table').each(function ()
	{
		Sortable.create(this, {
			handle: '.sortable-handle',
			onEnd: function (event)
			{
				var sectionOrder = new Array()

				$(event.from).children().each(function ()
				{
					sectionOrder.push($(this).data('id'))
				})

				$.ajax({
					type: "POST",
					url: "{{ route('admin.forms.sections.updateOrder') }}",
					data: { sections: sectionOrder }
				})
			}
		})
	})
</script>