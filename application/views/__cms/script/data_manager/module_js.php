<script type="text/javascript">
!function ($) {

    $('.edit_module_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      parent.find('.view_mode').hide();
      parent.find('.edit_mode').show();
      parent.find('.modal-title').text('<?php echo freetext("module_edit"); ?>');
    });

    $('.back_module_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      parent.find('.view_mode').show();
      parent.find('.edit_mode').hide();
      parent.find('.modal-title').text('<?php echo freetext("module_view"); ?>');
    });

    $('.save_module_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var form   = parent.find('.form_edit_module');
      $.ajax(form.attr('action'), {
        type: 'post',
        data: form.serialize(),
        beforeSend: function( ) {
          parent.find('.save_module_btn i').removeClass('fa-save');
          parent.find('.save_module_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        setTimeout(function(){
          location.reload()
        }, 1000);
      });
    });

    $('.create_module_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var form   = parent.find('.form_create_module');
      $.ajax(form.attr('action'), {
        type: 'post',
        data: form.serialize(),
        beforeSend: function( ) {
          parent.find('.create_module_btn i').removeClass('fa-plus');
          parent.find('.create_module_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        setTimeout(function(){
          location.reload()
        }, 1000);
      });
    });

    $('.del_module_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var url    = parent.data('url');
      $.ajax(url, {
        type: 'post',
        data: 'id='+id,
        beforeSend: function( ) {
          parent.find('.del_module_btn i').removeClass('fa-trash-o');
          parent.find('.del_module_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        location.reload()
      });
    });

    $('.module_view, .module_edit').on('hidden.bs.modal', function () {
      $(this).find('.view_mode').show();
      $(this).find('.edit_mode').hide();
      $(this).find('.modal-title').text('<?php echo freetext("module_view"); ?>');
    });

}(window.jQuery);
</script>
