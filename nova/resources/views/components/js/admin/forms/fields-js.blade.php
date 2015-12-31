{!! HTML::script('nova/resources/js/Sortable.min.js') !!}
<script>
	vue = {
		methods: {
			removeField: function(event)
			{
				var formKey = $(event.target).data('form-key')
				var fieldId = $(event.target).data('id')

				$('#removeField').modal({
					remote: "{{ url('admin/forms') }}/" + formKey + "/fields/" + fieldId + "/remove"
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
				var fieldOrder = new Array()

				$(event.from).children().each(function ()
				{
					fieldOrder.push($(this).data('id'))
				})

				$.ajax({
					type: "POST",
					url: "{{ route('admin.forms.fields.updateOrder') }}",
					data: { fields: fieldOrder }
				})
			}
		})
	})
</script>