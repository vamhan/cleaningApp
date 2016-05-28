<script type="text/javascript">
!function ($) {

	function del_group () {
		$('.del_group_btn').off();
		$('.del_group_btn').on('click', function() {
			$(this).closest('tr').remove();
		});
	}

	function del_manager () {
		$('.del_manager_btn').off();
		$('.del_manager_btn').on('click', function() {
			$(this).closest('tr').remove();
		});
	}

	function del_member () {
		$('.del_member_btn').off();
		$('.del_member_btn').on('click', function() {
			$(this).closest('tr').remove();
		});
	}

	function addMember () {
		$('.add_member').off();
		$('.add_member').on('click', function () {

			var code = $('.member_list').val();
			var table = $('.member_list_table');

			if (code != "" && table.find('.member_row_'+code).length == 0) {

				var count = table.find('tbody tr').length;
				var name  = $('.member_list option[value="'+code+'"]').text();
				var row = '<tr class="member_row_'+code+'">'+
							'<td>'+name+'</td>'+
							'<td class="text-right">'+
								'<input type="hidden" name="member_'+count+'" value="'+code+'">'+
								'<a href="#" class="btn btn-sm btn-default del_member_btn"><i class="fa fa-trash-o"></i></a>'+
							'</td>'+
						  '</tr>';

				table.find('tbody').append(row);
				$('.member_list option:first').prop('selected', 'selected');
				del_member();
			}
		});
	}

	addMember();
	del_member();
	del_group();
	del_manager();

	$('.add_group').on('click', function () {

		var code = $(this).closest('.panel-collapse').find('.group_code').val();

		var table = $(this).closest('.panel-collapse').find('.group_code_table');
		if (code != "" && $(this).closest('.panel-collapse').find('.code_'+code).length == 0) {

			var count = $(this).closest('.panel-collapse').find('.group_code_table tbody tr').length;

			var row = '<tr class="code_'+code+'">'+
						'<td>'+code+'</td>'+
						'<td class="text-right">'+
							'<input type="hidden" name="group_code_'+count+'" value="'+code+'">'+
							'<a href="#" class="btn btn-sm btn-default del_group_btn"><i class="fa fa-trash-o"></i></a>'+
						'</td>'+
					  '</tr>';

			table.find('tbody').append(row);
			$(this).closest('.panel-collapse').find('.group_code').val('');
			del_group();
		}
	});

	$('.add_manager').on('click', function() {

		var employee_id = $(this).closest('.panel-collapse').find('.manager_list').val();

		var table = $(this).closest('.panel-collapse').find('.manager_table');
		if (employee_id != 0 && table.find('.manager_row_'+employee_id).length == 0) {
			var count = table.find(' tbody tr').length;
			var name = $(this).closest('.panel-collapse').find('.manager_list option[value="'+employee_id+'"]').text();
			var row = '<tr class="manager_row_'+employee_id+'">'+
						'<td>'+name+'</td>'+
						'<td class="text-right">'+
							'<input type="hidden" name="manager_'+count+'" value="'+employee_id+'">'+
							'<a href="#" class="btn btn-sm btn-default del_manager_btn"><i class="fa fa-trash-o"></i></a>'+
						'</td>'+
					  '</tr>';

			table.find('tbody').append(row);
			$(this).closest('.panel-collapse').find('.manager_list option:first').prop('selected', 'selected')
			del_manager();
		}
	});

	$('.save_permission_area_team_member_btn').on('click', function () {

		$(this).attr('disabled', true);
		$('.form_permission_area_team_member').submit();
	});

	$('input[name="title"]').on('keyup', function () {
		if ($(this).val() != "") {
			$(this).css('border-color', '#d4d4d4');
		} else {
			$(this).css('border-color', 'red');
		}
	});

	$('.create_permission_team_btn').on('click', function () {

		var parent = $($(this).data('parent'));
		var title = parent.find('input[name="title"]');
		if (title.val() == "") {
			title.css('border-color', 'red');

			return false;
		}

		$(this).attr('disabled', true);
		$('.form_create_permission_team').submit();
	});

	$('.edit_permission_team_btn').on('click', function () {
		var parent = $($(this).data('parent'));

		var title = parent.find('input[name="title"]');
		if (title.val() == "") {
			title.css('border-color', 'red');

			return false;
		}

		$(this).attr('disabled', true);
		parent.find('form').submit();
	});

	$('.del_team_btn').on('click', function () {
		var form = $(this).find('.del_team_form');
		var title = $(this).data('title');
		$('.permission_area_team_delete').find('.title').text(title);
		$('.permission_area_team_delete').modal();

		$('.del_permission_area_team_btn').off();
		$('.del_permission_area_team_btn').on('click', function () {
			$(this).attr('disabled', true);
			form.submit();
		});
	});

	$('.group_member_btn').on('click', function() {
		var team_id = $(this).data('team');
		var code    = $(this).data('code');

		$.ajax("<?php echo base_url().'index.php/__cms_permission/permission_area_team_get' ?>", {
	        type: 'post',
	        data: "id="+team_id+"&code="+code,
	        beforeSend: function() {
		      	$('.loading_div').show();
		      	$('.body_div').hide();
        		$('#permission_area_team_member').modal();
	        }
	      }).done(function (data) {

        	$('#permission_area_team_member .member_list option:not(:first)').remove();
        	$('.member_list_table tbody tr').remove();

        	$('.form_permission_area_team_member input[name="code"]').val(code);
	        if (data != 0) {
	        	var result = JSON.parse(data);

        		$('.form_permission_area_team_member input[name="dept"]').val(result['dept_name']);
	        	for (var i in result['employee_list']) {
	        		var employee = result['employee_list'][i];
	        		$('#permission_area_team_member .member_list').append('<option value="'+employee['employee_id']+'">'+employee['user_firstname']+' '+employee['user_lastname']+'</option>');
	        	}

	        	var count = 0;
	        	for (var i in result['member_list']) {
	        		var member = result['member_list'][i];
	        		var name   = member['user_firstname']+' '+member['user_lastname'];
					var row = '<tr class="member_row_'+member['employee_id']+'">'+
								'<td>'+name+'</td>'+
								'<td class="text-right">'+
									'<input type="hidden" name="member_'+count+'" value="'+member['employee_id']+'">'+
									'<a href="#" class="btn btn-sm btn-default del_member_btn"><i class="fa fa-trash-o"></i></a>'+
								'</td>'+
							  '</tr>';
	        		$('.member_list_table tbody').append(row);
	        		count++;
	        	}

	        	del_member();
	        }

	      	$('.loading_div').hide();
	      	$('.body_div').show();
	      });
	});

}(window.jQuery);
</script>