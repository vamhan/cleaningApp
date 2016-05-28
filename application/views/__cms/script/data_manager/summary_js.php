<script type="text/javascript">

	if ( $('.save_summary').length > 0 ) {
		$('.save_summary').on('click', function () {
			var form_id = $(this).data('parent');
			var form    = $(form_id);
			form.submit();
		});
	}

	$('.delete_summary_btn').on('click', function() {
		var id =  $(this).data('id');    
		$('#modal-delete').modal('show'); 
		$('.confirm-delete').on('click',function(event){
			window.top.location.href = '<?php echo site_url("__cms_data_manager/delete_summary_data")?>'+'/'+id;    
		});

	});

</script>
