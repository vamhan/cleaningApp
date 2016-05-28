<script type="text/javascript">

  	$('.edit_plant_btn').on('click', function () {
  		$(this).attr('disabled', true);
  		var parent_id = $(this).data('parent');
  		var parent    = $(parent_id);
  		var form      = parent.find('form');

  		form.submit();
  	});
</script>