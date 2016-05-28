<script type="text/javascript">
	$('.save_btn').on('click', function () {
		var form = $(this).closest('form');
		form.submit();
	});

	$('.check_all').on('change', function () {

		$('input[type="checkbox"][name^="group_"]').off();

		var table = $(this).closest('table');
		table.find('input[type="checkbox"][name^="group_"]').prop('checked', $(this).is(':checked')).trigger("change");
		$('input[type="checkbox"][name^="group_"]').on('change', function () {
			var table = $(this).closest('table');
			table.find('.check_all').prop('checked', false);
		});
	});

</script>