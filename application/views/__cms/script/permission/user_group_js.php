<script type="text/javascript">
!function ($) {
  
    $('.edit_group_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      parent.find('.view_mode').hide();
      parent.find('.edit_mode').show();
      parent.find('.modal-title').text('<?php echo freetext("group_edit"); ?>');
    });

    $('.back_group_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      parent.find('.view_mode').show();
      parent.find('.edit_mode').hide();
      parent.find('.modal-title').text('<?php echo freetext("group_view"); ?>');
    });

    $('.save_group_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var form   = parent.find('.form_edit_group');
      $.ajax(form.attr('action'), {
        type: 'post',
        data: form.serialize(),
        beforeSend: function( ) {
          parent.find('.save_group_btn i').removeClass('fa-save');
          parent.find('.save_group_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        setTimeout(function(){
          location.reload();
        }, 1000);
      });
    });

    $('.create_group_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var form   = parent.find('.form_create_group');
      $.ajax(form.attr('action'), {
        type: 'post',
        data: form.serialize(),
        beforeSend: function( ) {
          parent.find('.create_group_btn i').removeClass('fa-plus');
          parent.find('.create_group_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        setTimeout(function(){
          location.reload()
        }, 1000);
      });
    });

    $('.del_group_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var url    = parent.data('url');
      $.ajax(url, {
        type: 'post',
        data: 'id='+id,
        beforeSend: function( ) {
          parent.find('.del_group_btn i').removeClass('fa-trash-o');
          parent.find('.del_group_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        location.reload()
      });
    });

    $('.user_view, .user_edit').on('hidden.bs.modal', function () {
      $(this).find('.view_mode').show();
      $(this).find('.edit_mode').hide();
      $(this).find('.modal-title').text('<?php echo freetext("group_view"); ?>');
    });

}(window.jQuery);
</script>