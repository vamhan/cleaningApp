    <?php
      $track_doc_id = $this->track_doc_id;
      $project_id = $this->project_id;
      $function = $this->session->userdata('function');
    ?>
    <script type="text/javascript">  

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

    function remark(){
    
      $('.remark-btn-click').off();
      $('.remark-btn-click').on('click',function(event){  

        $('#modal-remark #remark_save').removeAttr('disabled');

        <?php
          if (in_array('HR', $function)) {
        ?>
            $('#modal-remark #remark_save').attr('disabled', 'disabled');
        <?php
          }
        ?>

        var area = $(this).data('area');
        var id = $(this).data('id');
        var val = "";

        if ($('input[name="question_'+area+'_'+id+'[remark]"]').length > 0) {
          val = $('input[name="question_'+area+'_'+id+'[remark]"]').val();
        }else if ($('input.remark_input').length > 0) {
          val = $('input.remark_input').val();
        }

        $('#modal-remark #remark_area').val(val);
        $('#modal-remark').modal('show');  

        $('#remark_save').off();
        $('#remark_save').on('click',function(){ 
          var data = $('#modal-remark #remark_area').val();
          if (data != "") {
            $('.remark_icon_'+area+'_'+id).removeClass('text-muted');
            $('.remark_icon_'+area+'_'+id).addClass('text-primary');
          } else {
            $('.remark_icon_'+area+'_'+id).addClass('text-muted');
            $('.remark_icon_'+area+'_'+id).removeClass('text-primary');
          }

          if ($('input[name="question_'+area+'_'+id+'[remark]"]').length > 0) {
            $('input[name="question_'+area+'_'+id+'[remark]"]').val(data);
          }else if ($('input.remark_input').length > 0) {
            $('input.remark_input').val(data);
          }

          $('#modal-remark').modal('hide');

        })//end : on click save       

      });

      $('.customer-remark-btn-click').off();
      $('.customer-remark-btn-click').on('click', function() {

        <?php if (!empty($signature) && !empty($signature['signature'])) { ?>
          $('#modal-remark #remark_save').attr('disabled', 'disabled');
        <?php } ?>

        var id = $(this).data('id');
        var val = "";

        if ($('input[name="customer_'+id+'[remark]"]').length > 0) {
          val = $('input[name="customer_'+id+'[remark]"]').val();
        }else if ($('input.remark_input').length > 0) {
          val = $('input.remark_input').val();
        }

        $('#modal-remark #remark_area').val(val);
        $('#modal-remark').modal('show');  

        $('#remark_save').off();
        $('#remark_save').on('click',function(){ 
          var data = $('#modal-remark #remark_area').val();
          if (data != "") {
            $('.customer_remark_icon_'+id).removeClass('text-muted');
            $('.customer_remark_icon_'+id).addClass('text-primary');
          } else {
            $('.customer_remark_icon_'+id).addClass('text-muted');
            $('.customer_remark_icon_'+id).removeClass('text-primary');
          }

          if ($('input[name="customer_'+id+'[remark]"]').length > 0) {
            $('input[name="customer_'+id+'[remark]"]').val(data);
          }else if ($('input.remark_input').length > 0) {
            $('input.remark_input').val(data);
          }

          $('#modal-remark').modal('hide');


        })//end : on click save 
      });

      $('.document-remark-btn-click').off();
      $('.document-remark-btn-click').on('click', function() {

        $('#modal-remark #remark_save').removeAttr('disabled');

        <?php
          if (in_array('HR', $function)) {
        ?>
            $('#modal-remark #remark_save').attr('disabled', 'disabled');
        <?php
          }
        ?>
        var id = $(this).data('id');
        var val = "";

        if ($('input[name="document_control_'+id+'[remark]"]').length > 0) {
          val = $('input[name="document_control_'+id+'[remark]"]').val();
        }else if ($('input.remark_input').length > 0) {
          val = $('input.remark_input').val();
        }

        $('#modal-remark #remark_area').val(val);
        $('#modal-remark').modal('show');  

        $('#remark_save').off();
        $('#remark_save').on('click',function(){ 
          var data = $('#modal-remark #remark_area').val();
          if (data != "") {
            $('.document_remark_icon_'+id).removeClass('text-muted');
            $('.document_remark_icon_'+id).addClass('text-primary');
          } else {
            $('.document_remark_icon_'+id).addClass('text-muted');
            $('.document_remark_icon_'+id).removeClass('text-primary');
          }

          if ($('input[name="document_control_'+id+'[remark]"]').length > 0) {
            $('input[name="document_control_'+id+'[remark]"]').val(data);
          }else if ($('input.remark_input').length > 0) {
            $('input.remark_input').val(data);
          }

          $('#modal-remark').modal('hide');

        })//end : on click save 
      });

      $('.policy-remark-btn-click').off();
      $('.policy-remark-btn-click').on('click', function() {

        $('#modal-remark #remark_save').removeAttr('disabled');

        <?php
          if (in_array('HR', $function)) {
        ?>
            $('#modal-remark #remark_save').attr('disabled', 'disabled');
        <?php
          }
        ?>

        var id = $(this).data('id');
        var val = "";

        if ($('input[name="policy_'+id+'[remark]"]').length > 0) {
          val = $('input[name="policy_'+id+'[remark]"]').val();
        }else if ($('input.remark_input').length > 0) {
          val = $('input.remark_input').val();
        }

        $('#modal-remark #remark_area').val(val);
        $('#modal-remark').modal('show');  

        $('#remark_save').off();
        $('#remark_save').on('click',function(){ 
          var data = $('#modal-remark #remark_area').val();
          if (data != "") {
            $('.policy_remark_icon_'+id).removeClass('text-muted');
            $('.policy_remark_icon_'+id).addClass('text-primary');
          } else {
            $('.policy_remark_icon_'+id).addClass('text-muted');
            $('.policy_remark_icon_'+id).removeClass('text-primary');
          }

          if ($('input[name="policy_'+id+'[remark]"]').length > 0) {
            $('input[name="policy_'+id+'[remark]"]').val(data);
          }else if ($('input.remark_input').length > 0) {
            $('input.remark_input').val(data);
          }

          $('#modal-remark').modal('hide');

        })//end : on click save 
      });
    }    

    function del_image () {

      $('.image_delete').off();
      $('.image_delete').on('click', function () {

        $(this).attr('disabled', true);
        var form = $(this).prev();
        form.submit();
        //console.log(form.serialize());

      });
    }    

    function adjustMenu () {    
      var first_question = $('.question-table:visible');
      var first_question_key = first_question.attr('id').split('-')[2];
   
      if (first_question_key != undefined) {

          $('.main-menu li').removeClass('active');
          $('.area_list').hide();
          $('.floor_list').hide();

          $('.question_option[data-areaid="'+first_question_key+'"]').closest('li').addClass('active');
          $('.area.active a').closest('.floor_li').addClass('active');
          $('.area.active a').closest('.floor_li').find('.area_list').show();
          $('.area.active a').closest('.building_li').addClass('active');
          $('.area.active a').closest('.building_li').find('.floor_list').show();
      }

      var subject = $('.area.active a.question_option').data('subject');
      
      $('.question_subject').text(subject);
    }

    $(document).ready(function(){
      
      remark();

      adjustMenu();
      var init_visible_table = $('.question-table:visible');
      $('input[name="recent_table"]').val(init_visible_table.attr('id'));
      if ($('.question-table:visible').next().length == 0) {
        $('.next_btn').attr('disabled', true);
      }
      if ($('.question-table:visible').prev().length == 0) {
        $('.prev_btn').attr('disabled', true);
      }

      $('.next_btn').on('click', function() {
        var visible_table = $('.question-table:visible');
        visible_table.next().show();
        visible_table.hide();

        $('input[name="recent_table"]').val($('.question-table:visible').attr('id'));
        adjustMenu();

        $('.prev_btn').removeAttr('disabled');
        if ($('.question-table:visible').next().length == 0) {
          $('.next_btn').attr('disabled', true);
        }

        return false;
      });

      $('.prev_btn').on('click', function() {
        var visible_table = $('.question-table:visible');

        visible_table.prev().show();
        visible_table.hide();

        $('input[name="recent_table"]').val($('.question-table:visible').attr('id'));
        adjustMenu();

        $('.next_btn').removeAttr('disabled');
        if ($('.question-table:visible').prev().length == 0) {
          $('.prev_btn').attr('disabled', true);
        }

        return false;
      });

      <?php

        if (in_array('HR', $function)) {
      ?>
        var empty_kpi = $('.kpi_score[value=""]').length;
        if (empty_kpi == 0) {
          var text = $('.kpi_question').html();
              text += "&nbsp;<i class='fa fa-check text-success'></i>";
          $('.kpi_question').html(text);
        }

        $('input[type!="hidden"], select, textarea, .upload_btn').attr('disabled', 'disabled');
        $('.kpi_score[data-hr="1"]').removeAttr('disabled');
      <?php
        } else {
      ?>
        var empty_kpi = $('.kpi_score[data-hr="0"][value=""]').length;
        if (empty_kpi == 0) {
          var text = $('.kpi_question').html();
              text += "&nbsp;<i class='fa fa-check text-success'></i>";
          $('.kpi_question').html(text);
        }
      <?php
        }
      ?>

      var is_complete = true;
      $('.customer_question_row').each(function() {
        var checked = $(this).find('input[type="radio"]:checked');
        if (checked.length == 0) {
          is_complete = false;
        }
      });
      if (is_complete) {        
        <?php
          if (!empty($signature) && !empty($signature['signature'])) {
        ?>
          var text = $('.for_customer_question').html();
              text += "&nbsp;<i class='fa fa-check text-success'></i>";
          $('.for_customer_question').html(text);
        <?php
          }
        ?>
      }

      var is_complete = true;
      $('.document_control_question_row').each(function() {
        var checked = $(this).find('input[type="radio"]:checked');
        if (checked.length == 0) {
          is_complete = false;
        }
      });
      if (is_complete) {
        var text = $('.document_control').html();
            text += "&nbsp;<i class='fa fa-check text-success'></i>";
        $('.document_control').html(text);
      }

      var is_complete = true;
      $('.policy_row').each(function() {
        var checked = $(this).find('input[type="radio"]:checked');
        if (checked.length == 0) {
          is_complete = false;
        }
      });
      if (is_complete) {
        var text = $('.policy_question').html();
            text += "&nbsp;<i class='fa fa-check text-success'></i>";
        $('.policy_question').html(text);
      }

      $('.floor_li').each(function() {        
        if ($(this).find('.area_list > li > a').length == $(this).find('.area_list > li > a > i.fa-check').length) {
          $(this).find('a.floor').append("<i class='fa fa-check text-success'></i>");
        }
      });

      $('.building_li').each(function() {        
        if ($(this).find('.floor_list > li > a').length == $(this).find('.floor_list > li > a > i.fa-check').length) {
          $(this).find('a.building').append("<i class='fa fa-check text-success'></i>");
        }
      });

      if ($('.outer_li').length == $('.outer_li > a > i.fa-check').length) {
        $('#submit-span').show();
        $('.save-span').css('margin-top', '13%');
      }

      $('.pass_all').on('click', function (){
        var parent = $(this).closest('table');
        parent.find('.pass').prop('checked', true);
        parent.find('.not_pass_all, .not_check_all').prop('checked', false);
      });
      $('.not_pass_all').on('click', function (){
        var parent = $(this).closest('table');
        parent.find('.not_pass').prop('checked', true);
        parent.find('.pass_all, .not_check_all').prop('checked', false);
      });
      $('.not_check_all').on('click', function (){
        var parent = $(this).closest('table');
        parent.find('.not_check').prop('checked', true);
        parent.find('.not_pass_all, .pass_all').prop('checked', false);
      });

      $('.pass').on('click', function() {
        var parent = $(this).closest('table');
        parent.find('.not_pass_all').prop('checked', false);
        parent.find('.not_check_all').prop('checked', false);
      });
      $('.not_pass').on('click', function() {
        var parent = $(this).closest('table');
        parent.find('.pass_all').prop('checked', false);
        parent.find('.not_check_all').prop('checked', false);
      });
      $('.not_check').on('click', function() {
        var parent = $(this).closest('table');
        parent.find('.pass_all').prop('checked', false);
        parent.find('.not_pass_all').prop('checked', false);
      });

      $('.upload_btn').on('click', function() {
        var area_id = $(this).data('area');
        var q_id    = $(this).data('id');

        $('#upload_form input[name="area_id"]').val(area_id);
        $('#upload_form input[name="question_no"]').val(q_id);
        $('#modal-upload').modal();
      });

      $('.area_input').on('keyup', function() {
        var value = $(this).val();
        $('#save_form input[name="area"]').val(value);
      });

      $('.browse_btn').click(function() {
          // simulates a click on the file input field
          $('#fileToUpload').click();
      });

      $('#fileToUpload').on('change', function() {
        var file = $(this).val().replace(/C:\\fakepath\\/i, '');
        var file_parts  = file.split('.');

        var parts_length = file_parts.length;
        var ext = file_parts[parts_length-1].toLowerCase();

        if (ext != 'jpg' && ext != 'png' && ext != 'gif') {
          alert('Please select image');
          $(this).val('');
          $('.file_name').val('');
          $('#upload_btn').attr('disabled', true);
          return 0;
        }
        $('.file_name').val(file);
        $('#upload_btn').removeAttr('disabled');
      });

      $('#upload_btn').on('click', function () {

        $(this).attr('disabled', true);

        var form = $('#save_form');
        $.ajax(form.attr('action'), {
          type: 'post',
          data: form.serialize()+'&is_ajax=1'
        }).done(function (data) {
          $('#upload_form').submit();
        });


        return false;
      });

      $('.signature_request').on('click', function() {        
        var doc_id = $(this).data('id');

        var is_customer_complete = true;
        $('.customer_question_row').each(function() {
          var checked = $(this).find('input[type="radio"]:checked');
          if (checked.length == 0) {
            is_customer_complete = false;
          }
        });

        if (is_customer_complete) {
          $.ajax("<?php echo site_url('__ps_quality_assurance/generateSignatureCode'); ?>", {
            type: 'post',
            data: 'id='+doc_id,
          }).done(function (data) {
            $('.signature_pull').show();
            $('.signature_request').hide();
            $('textarea.request_code').val(data);
          });
        } else {
          alert('ท่านยังใส่ข้อมูลไม่ครบ');
        }

        return false;
      });

      $('.signature_pull').on('click', function () {

        $('.save-form-btn').click();

        return false;
      });

      $('.prev_month_alert').on('click', function() {
        var area_id = $(this).data('area');
        var q_no = $(this).data('id');
        var images = $('.prev_question_'+area_id+'_'+q_no+'_images').val();
        var remark = $('.prev_question_'+area_id+'_'+q_no+'_remark').val();

        $('#myPrevModal .remark').val(remark);
        $('#myPrevCarousel .carousel-inner > div').remove();
        if (images != "") {
          var images_list = images.split('|');
          var size = images_list.length;
          for (var i in images_list) {
            var active = "";
            if (i == 0) {
                active = " active";
            }
            var image = images_list[i];

            if (image != "") {
              var item = '<div class="item'+active+'">'+
                            '<img style="max-width:450px;padding: 20px;" src="'+image+'" alt="'+i+'">'+
                            '<div class="row carousel-caption">'+
                              '<div class="col-sm-2"></div>'+
                              '<div class="col-sm-8"><span class="h4 text-white">'+(parseInt(i)+1)+'/'+size+'</span></div>'+
                              '<div class="col-sm-2"></div>'+
                            '</div>'+
                          '</div>';
              $('#myPrevCarousel .carousel-inner').append(item);
            }
          }


          $('#myPrevModal').modal({
            local: '#myPrevCarousel'
          });
        } else {
          $('#myPrevModal').modal();
        }
      });

      $('.view_image').on('click', function() {
        var area_id = $(this).data('area');
        var q_no = $(this).data('id');
        var images = $('.question_'+area_id+'_'+q_no+'_images').val();

        $('#myCarousel .carousel-inner > div').remove();
        if (images != "") {
          var images_list = images.split('|');
          var size = images_list.length;
          for (var i in images_list) {
            var active = "";
            if (i == 0) {
                active = " active";
            }
            var image = images_list[i];

            if (image != "") {
              var item = '<div class="item'+active+'">'+
                            '<img style="max-width:450px;padding:10px 10px 60px 10px;" src="'+image+'" alt="'+i+'">'+
                            '<div class="row carousel-caption" style="padding-bottom:10px;">'+
                              '<div class="col-sm-2"></div>'+
                              '<div class="col-sm-8 m-t-lg"><span class="h4 text-white">'+(parseInt(i)+1)+'/'+size+'</span></div>'+
                              '<div class="col-sm-2 m-t-md text-right">'+
                                '<form action="<?php echo site_url("__ps_quality_assurance/delete_image/" ) ?>" method="post">'+
                                  '<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">'+
                                  '<input type="hidden" name="doc_id" value="<?php echo $track_doc_id; ?>">'+
                                  '<input type="hidden" name="area_id" value="'+area_id+'">'+
                                  '<input type="hidden" name="question_id" value="'+q_no+'">'+
                                  '<input type="hidden" name="path" value="'+image+'">'+
                                '</form>'+
                                '<a href="#" class="btn btn-sm btn-rounded btn-icon btn-default image_delete"><i class="fa fa-trash-o h4"></i></a>'+
                              '</div>'+
                            '</div>'+
                          '</div>';
              $('#myCarousel .carousel-inner').append(item);
            }
          }

          del_image();

          $('#myModal').modal({
            local: '#myCarousel'
          });
        }
      });

      $('.save-form-btn').on('click', function () {
        $(this).attr('disabled', true);
        $('#save_form').submit();
      });

      $('.submit-form-btn').on('click', function () {
        $(this).attr('disabled', true);
        $('#save_form').find('input[name="submit_val"]').val('1');
        $('#save_form').submit();
      });

      $('input[name*="[weight]"], .kpi_score').on('keypress', function() {
        preventNumber(event);
      });

      $('.kpi_score').on('keyup', function () {
        var max = parseInt($(this).data('score'));
        var score = parseInt($(this).val());

        if (score > max) {
          $('.save-form-btn').attr('disabled', true);
          $(this).css('border-color', 'red');
          $(this).attr('data-error', '1');
        } else {
          if ($('.kpi_score[data-error="1"]').length == 0) {
            $('.save-form-btn').removeAttr('disabled');
          }
          $(this).css('border-color', '#d4d4d4');
          $(this).attr('data-error', '0');
        }

      });

      $('.building').on('click', function() {
        $('.floor_list').hide();
        $('.building_li').removeClass('active');

        var floor_list = $(this).next();
        var is_visible = floor_list.data('visible');

        $('.floor_list').data('visible', 0);

        if (is_visible == 0) {
          $(this).closest('.building_li').addClass('active');
          floor_list.show();
          floor_list.data('visible', 1);
        } else {
          $(this).closest('.building_li').removeClass('active');
          floor_list.hide();
          floor_list.data('visible', 0);
        }

        return false;
      });

      $('.floor').on('click', function() {
        $('.area_list').hide();
        $(this).closest('.building_li').addClass('active');
        $('.floor_li').removeClass('active');

        var area_list = $(this).next();
        var is_visible = area_list.data('visible');

        $('.area_list').data('visible', 0);

        if (is_visible == 0) {
          $(this).closest('.floor_li').addClass('active');
          area_list.show();
          area_list.data('visible', 1);
        } else {
          $(this).closest('.floor_li').removeClass('active');
          area_list.hide();
          area_list.data('visible', 0);
        }

        return false;
      });

      $('.question_option').on('click', function() {

        $('.question_option').closest('li').removeClass('active');
        $('.area').removeClass('active');
        $(this).closest('li').addClass('active');

        if ($(this).data('area') == "0") {
          $('.building_li').removeClass('active');
          $('.floor_li').removeClass('active');
          $('.floor_list').data('visible', 0);
          $('.area_list').data('visible', 0);
          $('.floor_list').hide();
          $('.area_list').hide();
        }

        var subject = $(this).data('subject');
        $('.question_subject').text(subject);

        $('.question-table').hide();
        var area_id = $(this).data('areaid');

        $('#question-table-'+area_id).show();

        $('input[name="recent_table"]').val('question-table-'+area_id);

        $('.next_btn, .prev_btn').removeAttr('disabled');
        if ($('.question-table:visible').next().length == 0) {
          $('.next_btn').attr('disabled', true);
        }
        if ($('.question-table:visible').prev().length == 0) {
          $('.prev_btn').attr('disabled', true);
        }
        
        return false;
      });
    });

</script>