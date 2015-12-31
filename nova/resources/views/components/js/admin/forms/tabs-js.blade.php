{!! HTML::script('nova/resources/js/Sortable.min.js') !!}
<script>
	vue = {
		methods: {
			removeTab: function(event)
			{
				var formKey = $(event.target).data('form-key')
				var tabId = $(event.target).data('id')

				$('#removeTab').modal({
					remote: "{{ url('admin/forms') }}/" + formKey + "/tabs/" + tabId + "/remove"
				}).modal('show')
			}
		}
	}

	Sortable.create(byId("sortable"), {
		handle: ".sortable-handle",
		onEnd: function (event)
		{
			var tabOrder = new Array()

			$(event.from).children().each(function ()
			{
				tabOrder.push($(this).data('id'))
			})

			$.ajax({
				type: "POST",
				url: "{{ route('admin.forms.tabs.updateOrder') }}",
				data: { tabs: tabOrder }
			})
		}
	})
</script>