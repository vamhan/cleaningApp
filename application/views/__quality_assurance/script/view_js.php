    <?php
      $track_doc_id = $this->track_doc_id;
      $project_id = $this->project_id;
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

        var area = $(this).data('area');
        var month = $(this).data('month');
        var id = $(this).data('id');
        var val = "";

        if ($('input[name="question_'+area+'_'+month+'_'+id+'[remark]"]').length > 0) {
          val = $('input[name="question_'+area+'_'+month+'_'+id+'[remark]"]').val();
        }else if ($('input.remark_input').length > 0) {
          val = $('input.remark_input').val();
        }

        $('#modal-remark #remark_area').val(val);
        $('#modal-remark').modal('show');      

      });

      $('.customer-remark-btn-click').off();
      $('.customer-remark-btn-click').on('click', function() {

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

      var subject = $('.area.active a').data('subject');
      $('.question_subject').text(subject);
    }
    
    $(document).ready(function(){
      
      remark();

      adjustMenu();

      $('.next_btn').on('click', function() {
        var visible_table = $('.question-table:visible');
        visible_table.next().show();
        visible_table.hide();

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

        adjustMenu();

        $('.next_btn').removeAttr('disabled');
        if ($('.question-table:visible').prev().length == 0) {
          $('.prev_btn').attr('disabled', true);
        }

        return false;
      });


      $('.view_image').on('click', function() {
        var month = $(this).data('month');
        var area_id = $(this).data('area');
        var q_no = $(this).data('id');
        var images = $('.question_'+area_id+'_'+month+'_'+q_no+'_images').val();

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
                              '<div class="col-sm-8"><span class="h4 text-white">'+(parseInt(i)+1)+'/'+size+'</span></div>'+
                              '<div class="col-sm-2"></div>'+
                            '</div>'+
                          '</div>';
              $('#myCarousel .carousel-inner').append(item);
            }
          }

          $('#myModal').modal({
            local: '#myCarousel'
          });
        }
      });

      $('.save-form-btn').on('click', function () {
        $(this).attr('disabled', true);
        $('#save_form').submit()
      });

      $('.kpi_score').on('keypress', function() {
        preventNumber(event);
      });

      $('.kpi_score').on('keyup', function () {
        var max = parseInt($(this).data('score'));
        var score = parseInt($(this).val());

        if (score > max) {
          $('.save-form-btn').attr('disabled', true);
          $(this).css('border-color', 'red');
        } else {
          $('.save-form-btn').removeAttr('disabled');
          $(this).css('border-color', '#d4d4d4');
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