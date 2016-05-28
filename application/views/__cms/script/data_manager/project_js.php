<script type="text/javascript">
$('.btn-edit-project').on('click', function () {
	//alert('edit');
	var job_type = $(this).data('type');
	if(job_type =='ZQT1' ){
		job_type = 'งานประจำ';
	}else if(job_type =='ZQT2'){
		job_type = 'งานจร';
	}else{
		job_type = 'งานโอที';
	}
	var quotation_id = $(this).attr('id');	
	var title = $(this).data('title');
	var contract = $(this).data('contract');
	var shipto = $(this).data('shipto');
	var status = $(this).data('status');
	var start = $(this).data('start');
	var start_arr = start.split("-");
		start = start_arr[2]+'.'+start_arr[1]+'.'+start_arr[0];
	var end = $(this).data('end');
	var end_arr = end.split("-");
		end = end_arr[2]+'.'+end_arr[1]+'.'+end_arr[0];
	var abort = $(this).data('abort');
	var abort_arr = abort.split("-");
		abort = abort_arr[2]+'.'+abort_arr[1]+'.'+abort_arr[0];

	$('.edit_project').modal('show');
	$('.edit_project').find('.quotation_id').val(quotation_id);
	$('.edit_project').find('.title').val(title);
	$('.edit_project').find('.contract_id').val(contract);
	$('.edit_project').find('.ship_to_id').val(shipto);
	$('.edit_project').find('.status').val(status);
	$('.edit_project').find('.project_start').val(start);
	$('.edit_project').find('.project_end').val(end);
	$('.edit_project').find('.abort_date').val(abort);
	$('.edit_project').find('.job_type').val(job_type);

  	
});
</script>