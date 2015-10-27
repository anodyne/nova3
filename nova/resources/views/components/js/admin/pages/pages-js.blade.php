<script>
	var vm = new Vue({
		el: "#app",
		data: {
			loading: true,
			loadingWithError: false,
			baseUrl: "{{ Request::root() }}",
			name: "",
			key: "",
			uri: "",
			verbs: [],
			pages: []
		},
		methods: {
			resetFilters: function()
			{
				this.$set("name", "")
				this.$set("key", "")
				this.$set("uri", "")
				this.$set("verbs", [])
			}
		},
		ready: function()
		{
			this.$http.get(this.baseUrl + '/api/pages', function (data, status, request)
			{
				this.$set('pages', data.data)
			}).error(function (data, status, request)
			{
				this.$set('loadingWithError', true)
			})
		}
	});

	vm.$watch('pages', function (newValue, oldValue)
	{
		if (newValue.length > 0)
			this.$set('loading', false)
	})

	$(document).on('click', '.js-pageAction', function(e)
	{
		e.preventDefault();

		var pageId = $(this).data('id');
		var action = $(this).data('action');

		if (action == 'remove')
		{
			$('#removePage').modal({
				remote: "{{ url('admin/pages') }}/" + pageId + "/remove"
			}).modal('show');
		}
	});
</script>