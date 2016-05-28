<script type="text/javascript">
!function ($) {

    $('.save_department_group_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var form   = parent.find('.form_edit_department_group');
      $.ajax(form.attr('action'), {
        type: 'post',
        data: form.serialize(),
        beforeSend: function( ) {
          parent.find('.save_department_group_btn i').removeClass('fa-save');
          parent.find('.save_department_group_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        setTimeout(function(){
          location.reload();
        }, 1000);
      });
    });

}(window.jQuery);
</script>