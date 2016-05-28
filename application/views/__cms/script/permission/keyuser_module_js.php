<script type="text/javascript">
!function ($) {

    $('.save_keyuser_module_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var form   = parent.find('.form_edit_keyuser_module');
      $.ajax(form.attr('action'), {
        type: 'post',
        data: form.serialize(),
        beforeSend: function( ) {
          parent.find('.save_keyuser_module_btn i').removeClass('fa-save');
          parent.find('.save_keyuser_module_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        setTimeout(function(){
          location.reload();
        }, 1000);
      });
    });
    
    $('.create_keyuser_module_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var form   = parent.find('.form_create_key_user');
      $.ajax(form.attr('action'), {
        type: 'post',
        data: form.serialize(),
        beforeSend: function( ) {
          parent.find('.create_keyuser_module_btn i').removeClass('fa-plus');
          parent.find('.create_keyuser_module_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        setTimeout(function(){
          location.reload()
        }, 1000);
      });
    });

    $('.del_keyuser_module_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var url    = parent.data('url');
      $.ajax(url, {
        type: 'post',
        data: 'id='+id,
        beforeSend: function( ) {
          parent.find('.del_keyuser_module_btn i').removeClass('fa-trash-o');
          parent.find('.del_keyuser_module_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        location.reload()
      });
    });
}(window.jQuery);
</script>
