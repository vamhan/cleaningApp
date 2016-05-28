<script type="text/javascript">
$('.btn-edit-staff').on('click', function () {
	//alert('edit');
	var quotation_id = $(this).attr('id');
	var user_name = $(this).data('user');
	var user_id = $(this).data('number');
	var title = $(this).data('title');

	$('.edit_staff_quotation').modal('show');
	$('.edit_staff_quotation').find('.quotation_id').val(quotation_id);
	$('.edit_staff_quotation').find('.title').val(title);
	$('.edit_staff_quotation').find('.staff_id').val(user_id);

	//add option project_user_id
	$('.edit_staff_quotation').find('#mySelect option[value="'+user_id+'"]').remove();
	var x = document.getElementById("mySelect");
    var option = document.createElement("option");
    option.text = user_name;
    option.value = user_id;
    x.add(option, x[0]);
    $('.edit_staff_quotation').find('#mySelect option[value="'+user_id+'"]').attr('selected', 'selected');

  	
});
</script>