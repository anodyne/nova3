<script>
	var vm = new Vue({
		el: '#app',
		mixins: [vue],
		http: {
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}
	})
</script>