<script type="text/javascript">
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

  $('.create_module_btn, .edit_module_btn').on('click', function () {
    $('.btn').attr('disabled', true);
    var form = $(this).closest('.modal').find('form');
    var valid = form.parsley('validate');

    if (valid) {
      form.submit();
    }

    return false;
  });

  $('.del_module').on('click', function () {
      var modal_ele = $('#delete_module');
      var id = $(this).data('id');
      var txt = $(this).data('txt');

      modal_ele.find('form input[name="id"]').val(id);
      modal_ele.find('.obj_text').text(txt);

      modal_ele.modal();
  });

  $('.delete_module_btn').on('click', function () {
    $('.btn').attr('disabled', true);
      var modal_ele = $('#delete_module');
      modal_ele.find('form').submit();
  });

  $('input[name="is_menu"]').on('change', function() {
    var checked = $(this).is(':checked');
    
    var row = $(this).closest('div.row');
    var is_main_menu = row.find('input[name="is_main_menu"]');
    if (checked) {
      is_main_menu.removeAttr('disabled');
    } else {
      is_main_menu.removeAttr('checked');
      is_main_menu.attr('disabled', true);
    }
  });

  $('.nestable').nestable({
      group: 1
  });
  $('.nestable').nestable('collapseAll');

  $('.check_all').on('change', function () {
    var li = $(this).closest('li');
    var ol = li.find('ol');
    ol.find('input[type="checkbox"]').prop('checked', $(this).is(':checked'));
  });

  $('.mapping_btn').on('click', function () {
    var id = $(this).data('id');
    var txt = $(this).data('txt');

    var approve_module = [6, 8]; //6: Quality 8: Equiptment Requisition
    var action_plan    = 3;
    var project        = 1;

    $('.checkbox_line').show();
    $('.approve_line').hide();

    if (project == id) {
      $('.checkbox_line[data-action!="view"]').hide();
    } else if (approve_module.indexOf(id) >= 0) {
      $('.approve_line').show();
    }


    $.ajax('<?php echo site_url("__cms_data_manager/getDepartmentModule"); ?>', {
      type: 'post',
      data: 'id='+id,
      beforeSend: function() {
        $('#department_module_modal').modal();
        $('#department_module_modal .loading_div').show();
        $('#department_module_modal .data_div').hide();
        $('#department_module_modal .module_name').text(txt);
        $('.nestable').nestable('collapseAll');
        $('#form_map_module input[name="id"]').val(id);
        $('#form_map_module input[type="checkbox"]').prop('checked', false);

        $('.edit_btn').removeClass('hide_edit');
        $('.edit_panel').addClass('hide');
        $('.edit_btn').find('i').attr('class', 'fa fa-pencil');

        $('.edit_panel input[type="checkbox"], .edit_panel input[type="radio"]').prop('checked', "");

        $('li.dd-item[data-id="1"] > button[data-action="collapse"]').show();
        $('li.dd-item[data-id="1"] > button[data-action="expand"]').hide();

        $('li.dd-item[data-id="1"] > ol.dd-list').show();

        $('.clear_shipto').off();
        $('.action_shipto').remove();
        if (id == action_plan) {
          $('.edit_panel .checkbox_line').each(function() {
            if ($(this).css('display') != 'none') {
              var id = $(this).data('id');
              var action = $(this).data('action');
              $(this).after('<div class="action_shipto m-l-md"><input type="radio" name="shipto_'+id+'_'+action+'[]" value="all"> สถานที่ปฎิบัติงานทั้งหมด<br><input type="radio" name="shipto_'+id+'_'+action+'[]" value="related"> สถานที่ปฏิบัติงานที่เกี่ยวข้อง<br><a class="btn btn-default btn-xs pull-right clear_shipto">Clear</a></div>');
            }            
          });          
          $('.edit_panel .shipto_line').hide();
          $('.edit_panel .shipto_line input[type="radio"]').attr('disabled', 'disabled');

          $('.clear_shipto').on('click', function() {
            var parent = $(this).closest('.action_shipto');
            parent.find('input[type="radio"]').prop('checked', false);
          });
        } else {

          $('.clear_shipto').on('click', function() {
            var parent = $(this).closest('.shipto_line');
            parent.find('input[type="radio"]').prop('checked', false);
          });
          $('.edit_panel .action_shipto').remove();
          $('.edit_panel .shipto_line').show();
          $('.edit_panel .shipto_line input[type="radio"]').removeAttr('disabled');
        }
      }
    }).done(function (data) {
      if (data != 0) {
        var result = JSON.parse(data);
      
        for (var pos_id in result) {
          var obj = result[pos_id];

          for (var action in obj) {
            var value = obj[action]['value'];
            if (action != 'shipto') {
              $('#form_map_module input[type="checkbox"][name="'+action+'_'+pos_id+'"]').prop('checked', true);

              if (obj[action]['shipto'] != undefined) {
                $('#form_map_module input[type="radio"][name="shipto_'+pos_id+'_'+action+'[]"][value="'+obj[action]['shipto']+'"]').prop('checked', true);
              }
            } else {
              $('#form_map_module input[type="radio"][name="'+action+'_'+pos_id+'[]"][value="'+value+'"]').prop('checked', true);
            }
          }
          // $('#form_map_module input[type="checkbox"][name="'+obj[]+'"]').prop('checked', true);
        }
      }

      $('#department_module_modal .loading_div').hide();
      $('#department_module_modal .data_div').show();
    });

  });

  $('.map_module_btn').on('click', function () {
    $('.btn').attr('disabled', true);
    $('#form_map_module').submit();
  });

  $('.edit_btn').on('click', function () {
    var div = $(this).closest('div');

    if ($(this).hasClass('hide_edit')) {
      div.find('.edit_panel').addClass('hide');

      $(this).removeClass('hide_edit');
      $(this).find('i').addClass('fa-pencil');
      $(this).find('i').removeClass('fa-minus-square');
    } else {
      div.find('.edit_panel').removeClass('hide');

      $(this).addClass('hide_edit');
      $(this).find('i').removeClass('fa-pencil');
      $(this).find('i').addClass('fa-minus-square');
    }

  });

  $('.edit_panel input[type="checkbox"]').on('change', function () {
    if ($(this).is(':checked')) {
      var panel = $(this).closest('.edit_panel');
      panel.find('input[name^="view_"]').prop('checked', 'checked');
    }
  });

</script>