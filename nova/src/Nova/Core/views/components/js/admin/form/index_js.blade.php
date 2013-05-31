<script type="text/javascript">
	$(document).ready(function(){
		$(".js-form-action").click(function(){
			var key = $(this).data('key');
			var action = $(this).data('action');

			if (action == 'update')
			{
				$('#updateForm').modal({
					remote: "{{ URL::to('ajax/update/form') }}/" + key
				}).modal('show');
			}

			if (action == 'create')
			{
				$('#createForm').modal({
					remote: "{{ URL::to('ajax/update/form') }}/" + key
				}).modal('show');
			}

			return false;
		});
	});
</script>