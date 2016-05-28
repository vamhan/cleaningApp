<script type="text/javascript">

$('.create_question').on('click', function () {
	$('#create_question').modal();
});

$('.create_question_btn').on('click', function () {
	$('#create_question_form').submit();
});

$('.create_satisfaction_head_question').on('click', function () {
	$('#create_satisfaction_question_form input[name="is_for_head"]').val(1);
	$('#create_satisfaction_question').modal();
});

$('.create_satisfaction_emp_question').on('click', function () {
	$('#create_satisfaction_question_form input[name="is_for_head"]').val(0);
	$('#create_satisfaction_question').modal();
});

$('.create_satisfaction_question_btn').on('click', function () {
	$('#create_satisfaction_question_form').submit();
});

$('.edit_btn').on('click', function () {

	var id = $(this).data('id');
	var sequence = $(this).data('sequence');
	var title = $(this).data('title');
	var answer = $(this).data('answer');

	$('#edit_question_form input[name="id"]').val(id);
	$('#edit_question_form input[name="sequence_index"]').val(sequence);
	$('#edit_question_form textarea[name="title"]').val(title);
	if (answer != "") {
		$('#edit_question_form input[name="positive_label"]').val(answer['positive']['label']);
		$('#edit_question_form input[name="negative_label"]').val(answer['negative']['label']);

		var negative_remark = answer['negative']['remark'];

		$('#edit_question_form input[name="negative_remark"]').prop('checked', false);
		if (negative_remark == 'yes') {
			$('#edit_question_form input[name="negative_remark"]').prop('checked', 'checked');
		}
	}

	$('#edit_question').modal();
});

$('.edit_satisfaction_question_btn').on('click', function () {

	var id = $(this).data('id');
	var sequence = $(this).data('sequence');
	var title = $(this).data('title');
	var is_for_head = $(this).data('head');

	$('#edit_satisfaction_question_form input[name="id"]').val(id);
	$('#edit_satisfaction_question_form input[name="is_for_head"]').val(is_for_head);
	$('#edit_satisfaction_question_form input[name="sequence_index"]').val(sequence);
	$('#edit_satisfaction_question_form textarea[name="title"]').val(title);

	$('#edit_satisfaction_question').modal();
});

$('.edit_question_btn').on('click', function () {
	$('#edit_question_form').submit();
});

$('.edit_satisfaction_question_form_btn').on('click', function () {
	$('#edit_satisfaction_question_form').submit();
});

$('.del_btn').on('click', function () {

	var id = $(this).data('id');

	$('#del_question_form input[name="id"]').val(id);

	$('#del_question').modal();
});

$('.del_satisfaction_question_btn').on('click', function () {

	var id = $(this).data('id');
	var is_for_head = $(this).data('head');

	$('#del_satisfaction_question_form input[name="id"]').val(id);
	$('#del_satisfaction_question_form input[name="is_for_head"]').val(is_for_head);

	$('#del_satisfaction_question').modal();
});

$('.del_satisfaction_question_form_btn').on('click', function () {
	$('#del_satisfaction_question_form').submit();
});
</script>