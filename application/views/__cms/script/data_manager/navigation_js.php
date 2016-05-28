<script type="text/javascript">

    function updateList () {

      var list = $('#front_nav_list');
      if ($('#front_nav_list').is(':hidden')) {
        list = $('#back_nav_list');
      }

      var data = list.nestable('serialize');
          data = JSON.stringify(data);
      var url = list.data('url');

      $.ajax(url , {
        type: 'post',
        data: "json="+data,
        beforeSend: function( ) {
          $('#progress_bar').modal();
        }
      }).done(function () {
        setTimeout(function(){
          location.reload()
        }, 1000);
      });
    }

    $('#front_nav_list, #front_page_list').nestable({
      group: 1,
      maxDepth: 2
    });
    $('#front_nav_list').on('change', function (event) {
      updateList();
      $('#front_nav_list').unbind();
    });
    $('#front_page_list').on('change', function (event) {
      $('#front_nav_list').change();
    });

    $('#back_nav_list, #back_page_list').nestable({
      group: 2,
      maxDepth: 2
    });
    $('#back_nav_list').on('change', function (event) {
      updateList();
      $('#back_nav_list').unbind();
    });
    $('#back_page_list').on('change', function (event) {
      $('#back_nav_list').change();
    });

    $('.create_nav_group_btn').unbind();
    $('.create_nav_group_btn').on('click', function() {
      var parent = $($(this).data('parent'));
      var id     = parent.data('id');
      var form   = parent.find('.create_nav_group_form');
      $.ajax(form.attr('action'), {
        type: 'post',
        data: form.serialize(),
        beforeSend: function( ) {
          parent.find('.create_nav_group_btn i').removeClass('fa-plus');
          parent.find('.create_nav_group_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        setTimeout(function(){
          location.reload()
        }, 1000);
      });
    });

    $('.del_btn').unbind();

    $('.del_btn').on('mouseover', function() {
      var ele = $(this).closest('.dd-handle');
      ele.removeClass('dd-handle');
      ele.addClass('trash-handle');
    });

    $('.del_btn').on('mouseout', function() {
      var ele = $(this).closest('.trash-handle');
      ele.addClass('dd-handle');
      ele.removeClass('trash-handle');
    });

    $('.del_btn').on('click', function() {
      var id = $(this).data('id');
      $('#delete_nav_group').data('id', id);
      $('#delete_nav_group').modal();
    });

    $('.del_nav_group_btn').on('click', function () {
      var parent = $($(this).data('parent'));
      var url     = parent.data('url');
      var id     = parent.data('id');

      $.ajax(url, {
        type: 'post',
        data: 'id='+id,
        beforeSend: function( ) {
          parent.find('.del_nav_group_btn i').removeClass('fa-trash-o');
          parent.find('.del_nav_group_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        location.reload();
      });
    });


    $('.del_page_btn').unbind();

    $('.del_page_btn').on('mouseover', function() {
      var ele = $(this).closest('.dd-handle');
      ele.removeClass('dd-handle');
      ele.addClass('trash-handle');
    });

    $('.del_page_btn').on('mouseout', function() {
      var ele = $(this).closest('.trash-handle');
      ele.addClass('dd-handle');
      ele.removeClass('trash-handle');
    });

    $('.del_page_btn').on('click', function() {
      var id = $(this).data('id');
      var priority = $(this).data('priority');

      $('#delete_nav_page').data('id', id);
      $('#delete_nav_page').data('priority', priority);

      console.log($('#delete_nav_page').data('id'));
      console.log($('#delete_nav_page').data('priority'));

      $('#delete_nav_page').modal();
    });

    $('.del_nav_page_btn').on('click', function () {
      var parent = $($(this).data('parent'));
      var url         = parent.data('url');
      var id          = parent.data('id');
      var priority    = parent.data('priority');

      $.ajax(url, {
        type: 'post',
        data: 'id='+id+'&priority='+priority,
        beforeSend: function( ) {
          parent.find('.del_nav_page_btn i').removeClass('fa-trash-o');
          parent.find('.del_nav_page_btn i').addClass('fa-spinner');
          parent.find('.btn').addClass('disabled');
        }
      }).done(function () {
        location.reload();
      });
    });
</script>
