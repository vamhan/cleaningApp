<script type="text/javascript">

//############################ start : number   ##################################################
 function isDouble(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
            return false;

         return true;
      }
//############################ END : number ##################################################

//############################ start : number   ##################################################
 function isInt(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
//############################ END : number ##################################################

	
	if ( $('.create_area_question_btn').length > 0 ) {
		$('.create_area_question_btn').on('click', function () {
			var form = $('#create_question_form');
			var title = form.find('textarea[name="title"]');
			if (title.val() == "") {
				title.css('border-color', 'red');
			} else {
				title.css('border-color', '#d4d4d4');
				form.submit();
			}
		});
	}

	if ( $('.del_btn').length > 0 ) {
		$('.del_btn').on('click', function () {
			var id = $(this).data('id');

			var form = $('#del_question_form');
			form.find('input[name="id"]').val(id);

			$('#del_area_question').modal();
		});
	}

	if ( $('.del_area_question_btn').length > 0 ) {
		$('.del_area_question_btn').on('click', function () {
			var form = $('#del_question_form');
			form.submit();
		});
	}

	if ($('.edit_btn').length > 0) {
		$('.edit_btn').on('click', function () {
			var id = $(this).data('id');
			var index = $(this).data('index');
			var title = $(this).data('title');

			$('#edit_area_question input[name="id"]').val(id);
			$('#edit_area_question textarea[name="title"]').val(title);
			$('#edit_area_question input[name="sequence_index"]').val(index);
			$('#edit_area_question').modal();
		});
	}
	
	if ( $('.edit_area_question_btn').length > 0 ) {
		$('.edit_area_question_btn').on('click', function () {
			var form = $('#edit_question_form');
			var title = form.find('textarea[name="title"]');
			if (title.val() == "") {
				title.css('border-color', 'red');
			} else {
				title.css('border-color', '#d4d4d4');
				form.submit();
			}
		});
	}

	//Other Question
	if ($('.create_question').length > 0) {
		$('.create_question').on('click', function () {
			var table = $(this).data('table');
			var parent = $(this).data('parent');
			var tab = $(this).data('tab');

			$('#create_question input[name="subject_id"]').val(parent);
			$('#create_question input[name="table"]').val(table);
			$('#create_question input[name="tab"]').val(tab);
			$('#create_question').modal();
		});
	}

	if ($('.create_kpi_question').length > 0) {
		$('.create_kpi_question').on('click', function () {
			var table = $(this).data('table');
			var parent = $(this).data('parent');
			var tab = $(this).data('tab');

			$('#create_kpi_question input[name="subject_id"]').val(parent);
			$('#create_kpi_question input[name="table"]').val(table);
			$('#create_kpi_question input[name="tab"]').val(tab);
			$('#create_kpi_question').modal();
		});
	}

	if ( $('.create_question_btn').length > 0 ) {
		$('.create_question_btn').on('click', function () {
			var form = $('#create_question_form');
			var title = form.find('textarea[name="title"]');
			if (title.val() == "") {
				title.css('border-color', 'red');
			} else {
				title.css('border-color', '#d4d4d4');
				form.submit();
			}
		});
	}

	if ( $('.create_kpi_question_btn').length > 0 ) {
		$('.create_kpi_question_btn').on('click', function () {
			var form = $('#create_kpi_question_form');
			var title = form.find('textarea[name="title"]');
			if (title.val() == "") {
				title.css('border-color', 'red');
			} else {
				title.css('border-color', '#d4d4d4');
				form.submit();
			}
		});
	}

	if ($('.edit_question').length > 0) {
		$('.edit_question').on('click', function () {
			var table 	= $(this).data('table');
			var id 		= $(this).data('id');
			var tab 	= $(this).data('tab');
			var index 	= $(this).data('index');
			var title 	= $(this).data('title');
			var subject = $(this).data('subject');

			$('#edit_question input[name="id"]').val(id);
			$('#edit_question input[name="table"]').val(table);
			$('#edit_question input[name="tab"]').val(tab);
			$('#edit_question input[name="sequence_index"]').val(index);
			$('#edit_question textarea[name="title"]').val(title);
			$('#edit_question input[name="is_subject"]').prop('checked', false);
			if (subject == 1) {
				$('#edit_question input[name="is_subject"]').prop('checked', 'checked');
			}
			$('#edit_question').modal();
		});
	}

	if ($('.edit_kpi_question').length > 0) {
		$('.edit_kpi_question').on('click', function () {
			var table 	= $(this).data('table');
			var id 		= $(this).data('id');
			var tab 	= $(this).data('tab');
			var index 	= $(this).data('index');
			var title 	= $(this).data('title');
			var subject = $(this).data('subject');
			var score   = $(this).data('score');
			var hr      = $(this).data('hr');

			$('#edit_kpi_question input[name="id"]').val(id);
			$('#edit_kpi_question input[name="table"]').val(table);
			$('#edit_kpi_question input[name="tab"]').val(tab);
			$('#edit_kpi_question input[name="sequence_index"]').val(index);
			$('#edit_kpi_question textarea[name="title"]').val(title);
			$('#edit_kpi_question input[name="score"]').val(score);
			$('#edit_kpi_question input[name="is_hr_question"]').prop('checked', false);
			$('#edit_kpi_question input[name="is_subject"]').prop('checked', false);
			if (subject == 1) {
				$('#edit_kpi_question input[name="is_subject"]').prop('checked', 'checked');
			}
			if (hr == 1) {
				$('#edit_kpi_question input[name="is_hr_question"]').prop('checked', 'checked');
			}
			$('#edit_kpi_question').modal();
		});
	}

	if ( $('.edit_question_btn').length > 0 ) {
		$('.edit_question_btn').on('click', function () {
			var form = $('#edit_question_form');
			var title = form.find('textarea[name="title"]');
			if (title.val() == "") {
				title.css('border-color', 'red');
			} else {
				title.css('border-color', '#d4d4d4');
				form.submit();
			}
		});
	}

	if ( $('.edit_kpi_question_btn').length > 0 ) {
		$('.edit_kpi_question_btn').on('click', function () {
			var form = $('#edit_kpi_question_form');
			var title = form.find('textarea[name="title"]');
			if (title.val() == "") {
				title.css('border-color', 'red');
			} else {
				title.css('border-color', '#d4d4d4');
				form.submit();
			}
		});
	}
	
	if ($('.delete_question').length > 0) {
		$('.delete_question').on('click', function () {
			var table = $(this).data('table');
			var id = $(this).data('id');
			var tab = $(this).data('tab');

			$('#del_question input[name="id"]').val(id);
			$('#del_question input[name="table"]').val(table);
			$('#del_question input[name="tab"]').val(tab);
			$('#del_question').modal();
		});
	}

	if ( $('.del_question_btn').length > 0 ) {
		$('.del_question_btn').on('click', function () {
			var form = $('#del_question_form');
			form.submit();
		});
	}

	$('.edit_score').on('click', function () {
		$('#edit_customer_score').modal();
	});

	$('.edit_customer_score_btn').on('click', function () {
		$('#edit_customer_score_form').submit();
	});


</script>