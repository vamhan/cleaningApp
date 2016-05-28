<script type="text/javascript">
!function ($) {

  $('.nestable').nestable({
      group: 1
  });
  $('.nestable').nestable('collapseAll');

  $('.func_sel').on('change', function () {
    var li = $(this).closest('li');
    li.find('ol select option[value="'+$(this).val()+'"]').prop('selected', true);
  });

  $('.save_btn').on('click', function () {
    $('#form_save').submit();
  });
}(window.jQuery);
</script>