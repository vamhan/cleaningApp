<script type="text/javascript">

  $('.category_list').each(function() {
    //console.log($(this).attr('id'));
    $(this).nestable();
  });
  
  //$('#category_list').nestable().on('change', update);

  $('.create_category_child_btn').on('click', function () {
    var modal = $(this).data('target');
    var parent_id = $(this).data('parent-id');
    var module_id = $(this).data('module-id');

    $(modal+' .form_create_category input[name="module_id"]').val(module_id);
    $(modal+' .form_create_category input[name="parent_id"]').val(parent_id);
    $(modal).modal();
    return false;
  });

  $('.create_category_btn').off();
  $('.create_category_btn').on('click', function () {
    var parent = $($(this).data('parent'));
    var data = $('.form_create_category').serialize();  
    var form   = parent.find('.form_create_category');
    $.ajax(form.attr('action'), {
      type: 'post',
      data: data,
      beforeSend: function( ) {
        parent.find('.create_category_btn i').removeClass('fa-plus');
        parent.find('.create_category_btn i').addClass('fa-spinner');
        parent.find('.btn').addClass('disabled');
      }
    }).done(function () {
      location.reload();
    });
  });

  $('.edit_category_btn').on('click', function () {
    var parent = $($(this).data('parent'));
    var form   = parent.find('.form_edit_category');
    var data = form.serialize(); 
    $.ajax(form.attr('action'), {
      type: 'post',
      data: data,
      beforeSend: function( ) {
        parent.find('.edit_category_btn i').removeClass('fa-save');
        parent.find('.edit_category_btn i').addClass('fa-spinner');
        parent.find('.btn').addClass('disabled');
      }
    }).done(function () {
      location.reload();
    });
  });

  $('.del_category_btn').on('click', function () {
    var parent = $($(this).data('parent'));
    console.log(parent);
    var url     = parent.data('url');
    var id     = parent.data('id');

    $.ajax(url, {
      type: 'post',
      data: 'id='+id+"&children=false",
      beforeSend: function( ) {
        parent.find('.del_category_btn i').removeClass('fa-trash-o');
        parent.find('.del_category_btn i').addClass('fa-spinner');
        parent.find('.btn').addClass('disabled');
      }
    }).done(function () {
      location.reload();
    });
  });

  $('.del_category_children_btn').on('click', function () {
    var parent = $($(this).data('parent'));
    console.log(parent);
    var url     = parent.data('url');
    var id     = parent.data('id');

    $.ajax(url, {
      type: 'post',
      data: 'id='+id+"&children=true",
      beforeSend: function( ) {
        parent.find('.del_category_children_btn i').removeClass('fa-trash-o');
        parent.find('.del_category_children_btn i').addClass('fa-spinner');
        parent.find('.btn').addClass('disabled');
      }
    }).done(function () {
      location.reload();
    });
  });

  $('.permission_category_btn').on('click', function() {
    var parent = $($(this).data('parent'));
    var form   = parent.find('.permission_category_form');
    var data = form.serialize(); 
    $.ajax(form.attr('action'), {
      type: 'post',
      data: data,
      beforeSend: function( ) {
        parent.find('.permission_category_btn i').removeClass('fa-save');
        parent.find('.permission_category_btn i').addClass('fa-spinner');
        parent.find('.btn').addClass('disabled');
      }
    }).done(function () {
      location.reload();
    });
  });

  $('.color_picker li').on('click', function() {
    var color = $(this).data('color');
    var button = $(this).parent().prev();
    button.attr('class', 'form-control btn btn-default dropdown-toggle');
    button.addClass(color);

    var form = $(this).closest('form');
    form.find('input[name="color"]').val(color);
  });

  $('.icon_picker div').on('click', function() {

    var icon;
    var button = $(this).parent().prev();
    button.find('i.icon').attr('class', 'fa icon');

    if ($(this).find('i').length == 0) {
      icon = '';
    } else {
      icon = $(this).find('i').attr('class');
      icon = icon.replace('fa ', '');
      button.find('i.icon').addClass(icon);
    }

    var form = $(this).closest('form');
    form.find('input[name="icon"]').val(icon);
  });

</script>
