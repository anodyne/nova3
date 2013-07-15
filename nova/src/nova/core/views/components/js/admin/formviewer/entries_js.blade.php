<script type="text/javascript">

	$(document).ready(function(){
		$('#searchEntries').quicksearch('#entriesSearch .row');
	});
	
	$(document).on('click', '.js-entry-action', function(e){
		var key = $(this).data('key');
		var action = $(this).data('action');

		if (action == 'delete')
		{
			$('#deleteEntry').modal({
				remote: "{{ URL::to('ajax/delete/formviewer_entry') }}/" + key
			}).modal('show');
		}

		e.preventDefault();
	});

</script>