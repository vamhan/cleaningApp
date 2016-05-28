<script type="text/javascript">
!function ($) {

    $('.edit_user_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      parent.find('.view_mode').hide();
      parent.find('.edit_mode').show();
      parent.find('.modal-title').text('<?php echo freetext("user_edit"); ?>');
    });

    $('.back_user_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      parent.find('.view_mode').show();
      parent.find('.edit_mode').hide();
      parent.find('.modal-title').text('<?php echo freetext("user_view"); ?>');
    });

    $('.save_user_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var form   = parent.find('.form_edit_user');
      $.ajax(form.attr('action'), {
        type: 'post',
        data: form.serialize(),
        beforeSend: function( ) {
          parent.find('.save_user_btn i').removeClass('fa-save');
          parent.find('.save_user_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        setTimeout(function(){
          location.reload()
        }, 1000);
      });
    });

    $('.create_user_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var form   = parent.find('.form_create_user');
      $.ajax(form.attr('action'), {
        type: 'post',
        data: form.serialize(),
        beforeSend: function( ) {
          parent.find('.create_user_btn i').removeClass('fa-plus');
          parent.find('.create_user_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        setTimeout(function(){
          location.reload()
        }, 1000);
      });
    });

    $('.del_user_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var url    = parent.data('url');
      $.ajax(url, {
        type: 'post',
        data: 'id='+id,
        beforeSend: function( ) {
          parent.find('.del_user_btn i').removeClass('fa-trash-o');
          parent.find('.del_user_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        location.reload()
      });
    });

    $('.reset_password_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var url    = parent.data('url');
      $.ajax(url, {
        type: 'post',
        data: 'id='+id,
        beforeSend: function( ) {
          parent.find('.loading').show();
          parent.find('.reset_password_btn i').removeClass('fa-key');
          parent.find('.reset_password_btn i').addClass('fa-spinner');
          parent.find('.reset_password_btn').addClass('disabled');
          parent.find('.reset_password_btn').next().addClass('disabled');
        }
      }).done(function () {
        location.reload()
      });
    });

    $('.user_view, .user_edit').on('hidden.bs.modal', function () {
      $(this).find('.view_mode').show();
      $(this).find('.edit_mode').hide();
      $(this).find('.modal-title').text('<?php echo freetext("user_view"); ?>');
    });

}(window.jQuery);
</script>
