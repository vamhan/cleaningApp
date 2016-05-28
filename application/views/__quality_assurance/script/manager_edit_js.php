
    <script type="text/javascript">  

    function bindFloor () {

      $('.select_floor').off();
      $('.select_floor').on('change', function() {
        var building_id = $('.select_building').val();
        var floor_id    = $(this).val();

        $('.select_area option:not(:first)').remove();

        if (building_id!=0 && floor_id != 0) {
          $.ajax("<?php echo site_url($this->page_controller.'/getArea');  ?>", {
            type: 'post',
            data: 'quotation_id=<?php echo $this->project_id; ?>',
            beforeSend: function() {
              $('.area_loading').show();
              $('.select_area').prop('disabled', true);
            }
          }).done(function (data) {
            $('.area_loading').hide();
            $('.select_area').prop('disabled', false);
            if (data != 0) {
              var result = JSON.parse(data);
              for (var i in result) {
                var area = result[i];
                
                $('.select_area').append('<option value="'+area['id']+'">'+area['title']+'</option>');
              }
              
            }
          });
        }
      });
    }

    function preventNumber(evt) {
      var theEvent = evt || window.event;
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode( key );
      var regex = /[0-9]|\./;
      if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
      }
    }

    function bindOrderIndex () {

      $('.order_index').off();
      $('.order_index').on('keypress', function() {
        preventNumber(event);
      });
    }

    function bindDeleteBtn () {

      $('.del_area_btn').off();
      $('.del_area_btn').on('click', function () {
        $(this).closest('tr').remove();;
      });
    }

    $(document).ready(function(){
      
      bindOrderIndex();
      bindDeleteBtn();

      $('.area_input').on('keyup', function() {
        var value = $(this).val();
        $('#manager_save_form input[name="area"]').val(value);
      });

      $('.submit-to-sap').on('click', function () {
        if ($('.submit_status').val() != "check") {
          alert('Cannot submit to SAP.');
          return false;
        } else {
          $('.submit_input').val(1);
          $('.save-btn').click();
        }
      });

      $('.add_area').on('click', function() {

        var building_id = $('.select_building').val();
        var building    = $('.select_building option[value="'+building_id+'"]').text();

        var floor_id = $('.select_floor').val();
        var floor    = $('.select_floor option[value="'+floor_id+'"]').text();

        var area_id = $('.select_area').val();
        var area    = $('.select_area option[value="'+area_id+'"]').text();

        var area_alias = $('.area_name_alias').val();

        if (area_id != undefined && area_id != '' && area_id != 0) {
          var count = $('#manager_table tbody tr').length;
          var row = "<tr>" +
                      "<td>"+building+"</td>"+
                      "<td>"+floor+"</td>"+
                      "<td>"+area+"</td>"+
                      "<td>" +
                      area_alias+
                      "<input type='hidden' name='area_"+count+"_"+building_id+"_"+floor_id+"_"+area_id+"[name]' value='"+area_alias+"'>" +
                      "<input type='hidden' name='area_"+count+"_"+building_id+"_"+floor_id+"_"+area_id+"[origin]' value='0'>" +
                      "</td>"+
                      "<td class='text-center'><input type='text' class='form-control order_index' maxlength='11' name='area_"+count+"_"+building_id+"_"+floor_id+"_"+area_id+"[index]'></td>"+
                      "<td class='text-center'><input type='checkbox' class='form-control' style='height:20px; margin-top:7px;' name='area_"+count+"_"+building_id+"_"+floor_id+"_"+area_id+"[select]' checked></td>"+
                      "<td class='text-center'><a href='#' class='btn btn-default del_area_btn'><i class='fa fa-trash-o'></i></a></td>"+
                    "</tr>";
          $('#manager_table tbody').append(row);

          bindOrderIndex();
          bindDeleteBtn();

          $('.select_building option:first').prop('selected', true);
          $('.select_floor option:not(:first)').remove();
          $('.select_area option:not(:first)').remove();
          $('.area_name_alias').val('');
        }

      });

      $('.select_building').on('change', function() {
        var value = $(this).val();

        $('.select_floor option:not(:first)').remove();
        $('.select_area option:not(:first)').remove();

        if (value != 0) {
          $.ajax("<?php echo site_url($this->page_controller.'/getFloor');  ?>", {
            type: 'post',
            data: 'building_id='+value,
            beforeSend: function() {
              $('.floor_loading').show();
              $('.select_floor').prop('disabled', true);
              $('.select_area').prop('disabled', true);
            }
          }).done(function (data) {
            $('.floor_loading').hide();
            $('.select_floor').prop('disabled', false);
            $('.select_area').prop('disabled', false);
            if (data != 0) {
              var result = JSON.parse(data);
              for (var i in result) {
                var floor = result[i];
                $('.select_floor').append('<option value="'+floor['id']+'">'+floor['title']+'</option>');
              }
              bindFloor();
            }
          });
        }

      });

      $('.save-btn').on('click', function() {
        $(this).attr('disabled', true);
        $('#manager_save_form').submit();
        return false;
      });
      
      $('.approve-btn').on('click', function() {
        $('.approve-btn, .save-btn').attr('disabled', true);
        $('.approve').val(1);
        $('#manager_save_form').submit();
        return false;
      }); 
  });

</script>