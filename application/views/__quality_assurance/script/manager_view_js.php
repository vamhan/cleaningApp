    <?php
      $track_doc_id = $this->track_doc_id;
      $project_id = $this->project_id;
    ?>
    <script type="text/javascript">  

    function adjustMenu () {    
      var first_question = $('.result_body:visible');
      var key = first_question.attr('id');
      if (key != undefined) {

          $('.main-menu li').removeClass('active');
          $('.main-menu li > a[data-areaid="'+key+'"]').closest('li').addClass('active');
      }

      var subject = $('.main-menu li.active a').data('subject');
      $('.header_subject').text(subject);
    }
    
    $(document).ready(function(){      

      adjustMenu();

      $('.question_option').on('click', function() {
      
        $('.result_body').hide();
        var id = $(this).data('areaid');
        $('#'+id).show();

        adjustMenu();

        return false;
      });

    });

</script>