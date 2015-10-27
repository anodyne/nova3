<script>
	var vm = new Vue({
		el: "#app",
		data: {
			loading: true,
			loadingWithError: false,
			baseUrl: "{{ Request::root() }}",
			display_name: "",
			name: "",
			permissions: []
		},
		methods: {
			resetFilters: function()
			{
				this.$set("display_name", "")
				this.$set("name", "")
			}
		},
		ready: function()
		{
			this.$http.get(this.baseUrl + '/api/access/permissions', function (data, status, request)
			{
				this.$set('permissions', data.data)
			}).error(function (data, status, request)
			{
				this.$set('loadingWithError', true)
			})
		}
	});

	vm.$watch('permissions', function (newValue, oldValue)
	{
		if (newValue.length > 0)
			this.$set('loading', false)
	})

	$(document).on('click', '.js-permissionAction', function(e)
	{
		e.preventDefault();

		var permissionId = $(this).data('id');
		var action = $(this).data('action');

		if (action == 'remove')
		{
			$('#removePermission').modal({
				remote: "{{ url('admin/access/permissions') }}/" + permissionId + "/remove"
			}).modal('show');
		}
	});
</script>