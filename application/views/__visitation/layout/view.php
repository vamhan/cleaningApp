<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>
    <?php #CMS
      echo (!empty($this->page_title))?$this->page_title:"CMS - Manager";
    ?>
  </title>

  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 


  <!-- TODO: Find solution for favicon -->
  <!--link rel="shortcut icon" href="<?php //theme_images().'favicon.ico'?>" type="image/x-icon"-->
  <link rel="icon" href="<?php echo theme_images().'favicon.ico'?>" type="image/x-icon">


  <link rel="stylesheet" href="<?php echo theme_css().'bootstrap.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_css().'animate.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_css().'font-awesome.min.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_css().'font.css';?>" type="text/css" />
  <!--
  <link rel="stylesheet" href="<?php //echo theme_js().'calendar/bootstrap_calendar.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php //echo theme_js().'js/fuelux/fuelux.css'?>" type="text/css"/>
  -->

  <link rel="stylesheet" href="<?php echo theme_js().'select2/select2.css'?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_js().'select2/theme.css'?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_js().'fuelux/fuelux.css'?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_js().'datepicker/datepicker.css'?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_js().'slider/slider.css'?>" type="text/css" />

  <link rel="stylesheet" href="<?php echo theme_css().'app.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo css_url().'main.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo css_url().'multi-screen.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_css().'bootstrap-datetimepicker.min.css';?>" type="text/css" />

  <!--CSS : select2-->
  <link rel="stylesheet" href="<?php echo theme_js().'select2/select2.css'?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_js().'select2/theme.css'?>" type="text/css" />


  


  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->

</head>


<body class="">


 <section class="vbox">
<!-- start : header -->
      <?php if(!empty($top_menu))echo $top_menu; ?>
  <!-- end : header -->


    <section>
      <section class="hbox stretch">

        <!-- start : side-nav -->
          <?php if(!empty($side_menu))echo $side_menu; ?>
        <!-- end : side-nav -->
       
          <section id="content">
              
              <?php if(!empty($top_project))echo $top_project;?>                

              <?php if(!empty($body))echo $body;?>

          </section>
        </section>

          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
    </section>


        <aside class="bg-light lter b-l aside-md hide" id="notes">
          <div class="wrapper">Notification</div>
        </aside>
      </section>
    </section>
  </section>





  <div id="modal_section">
  <?php if(!empty($modal))echo $modal; ?>
  </div>



  <script src="<?php echo theme_js().'jquery.min.js';?>"></script>
  <!-- Bootstrap -->
  <script src="<?php echo theme_js().'bootstrap.js';?>"></script>
  <script src="<?php echo theme_js().'file-input/bootstrap-filestyle.min.js';?>"></script>

  <!-- App -->
  <script src="<?php echo theme_js().'app.js';?>"></script> 
  <script src="<?php echo theme_js().'slimscroll/jquery.slimscroll.min.js';?>"></script>
  <script src="<?php echo theme_js().'charts/easypiechart/jquery.easy-pie-chart.js';?>"></script>
  <script src="<?php echo theme_js().'charts/sparkline/jquery.sparkline.min.js';?>"></script>
  <script src="<?php echo theme_js().'charts/flot/jquery.flot.min.js';?>"></script>
  <script src="<?php echo theme_js().'charts/flot/jquery.flot.tooltip.min.js';?>"></script>
  <script src="<?php echo theme_js().'charts/flot/jquery.flot.resize.js';?>"></script>
  <script src="<?php echo theme_js().'charts/flot/jquery.flot.grow.js';?>"></script>
  <script src="<?php echo theme_js().'charts/flot/demo.js';?>"></script>

  <script src="<?php echo theme_js().'calendar/bootstrap_calendar.js';?>"></script>
  <script src="<?php echo theme_js().'calendar/demo.js';?>"></script>

  <script src="<?php echo theme_js().'sortable/jquery.sortable.js';?>"></script>

  <script src="<?php echo theme_js().'libs/underscore-min.js'?>"></script>
  <script src="<?php echo theme_js().'fuelux/fuelux.js'?>"></script>
  <!--script src="<?php //echo theme_js().'fuelux/demo.datagrid.js'?>"></script-->



  <script src="<?php echo theme_js().'app.plugin.js';?>"></script>
  <script src="<?php echo js_url().'main_app.js';?>"></script>

   <!-- parsley -->
  <script src="<?php echo theme_js().'parsley/parsley.js'?>"></script>
   <!-- select2 -->
  <script src="<?php echo theme_js().'select2/select2.min.js'?>"></script>
 <script src="<?php echo theme_js().'moment/moment.min.js'?>"></script>
 <script src="<?php echo theme_js().'build_datepicker/bootstrap-datetimepicker.js'?>"></script>



<script type="text/javascript"> 

$(document).ready(function(){

  $(".select2-option").select2();

  $('#nav').removeClass('nav-xs');
  $('#nav').removeClass('nav-off-screen');
  $('#nav').addClass('nav-xs');


  $('.attach_file_tab').on('click', function () {
    $('.main-tab .tab-pane').removeClass('active');
  });
  $('.tab_li').on('click', function () {
    $('.attach-tab .tab-pane').removeClass('active');
  });

  $('.view_image').on('click', function() {
    var image = $(this).data('image');
    $('#visit_image_modal img').attr('src', image);
    $('#visit_image_modal').modal();
  });

  $('.tab<?php echo $tab; ?> a').click();

  $('textarea, input, select, .add_email').attr('disabled', true);
  $('.delete_image, .upload_panel, .send_email, #cpt_start, #cpt_end, .save-form, .submit-form').remove();
  $('.cpt_start, .cpt_end').attr('type', 'text');
});


  var addEmail = function($input){
    var $text = $input.val(), $name = $input.data('name'), $pills = $input.closest('.pillbox'), $repeat = false, $repeatPill;
    if($text == "") return;
    $("li", $pills).text(function(i,v){
          if(v == $text){
            $repeatPill = $(this);
            $repeat = true;
          }
      });
      if($repeat) {
        $repeatPill.fadeOut().fadeIn();
        return;
      };
      $item = $('<li class="label bg-info" data-name="'+$name+'">'+$text+'</li> ');
    $item.insertBefore($input);
    $input.val('');
    $pills.trigger('change', $item);
  };

  <?php

    if(!empty($data_document)){
  ?>
      var email_to_cr       = "<?php echo $data_document['email_notice_cr'];?>";
      if (email_to_cr != "") {

        var div = $('#CR_email');
        var input = div.find('input');
        var email_list = email_to_cr.split(',');
        for (var i in email_list) {

          var email = email_list[i];
          input.val(email);
          input.data('name', div.find('select.email_selection option[value="'+email+'"]').text())
          addEmail(input);
          div.find('select.email_selection option[value="'+email+'"]').remove();

        }
      }

      var email_to_oper     = "<?php echo $data_document['email_notice_op'];?>";
      if (email_to_oper != "") {

        var div = $('#OP_email');
        var input = div.find('input');
        var email_list = email_to_oper.split(',');
        for (var i in email_list) {

          var email = email_list[i];
          input.val(email);
          input.data('name', div.find('select.email_selection option[value="'+email+'"]').text())
          addEmail(input);
          div.find('select.email_selection option[value="'+email+'"]').remove();

        }
      }

      var email_to_hr       = "<?php echo $data_document['email_notice_hr'];?>";
      if (email_to_hr != "") {

        var div = $('#HR_email');
        var input = div.find('input');
        var email_list = email_to_hr.split(',');
        for (var i in email_list) {

          var email = email_list[i];
          input.val(email);
          input.data('name', div.find('select.email_selection option[value="'+email+'"]').text())
          addEmail(input);
          div.find('select.email_selection option[value="'+email+'"]').remove();

        }
      }

      var email_to_training = "<?php echo $data_document['email_notice_training'];?>";
      if (email_to_training != "") {

        var div = $('#TN_email');
        var input = div.find('input');
        var email_list = email_to_training.split(',');
        for (var i in email_list) {

          var email = email_list[i];
          input.val(email);
          input.data('name', div.find('select.email_selection option[value="'+email+'"]').text())
          addEmail(input);
          div.find('select.email_selection option[value="'+email+'"]').remove();

        }
      }

      var email_to_store    = "<?php echo $data_document['email_notice_store'];?>";
      if (email_to_store != "") {

        var div = $('#IC_email');
        var input = div.find('input');
        var email_list = email_to_store.split(',');
        for (var i in email_list) {

          var email = email_list[i];
          input.val(email);
          input.data('name', div.find('select.email_selection option[value="'+email+'"]').text())
          addEmail(input);
          div.find('select.email_selection option[value="'+email+'"]').remove();

        }
      }

      var email_to_sale     = "<?php echo $data_document['email_notice_sales'];?>";
      if (email_to_sale != "") {

        var div = $('#MK_email');
        var input = div.find('input');
        var email_list = email_to_sale.split(',');
        for (var i in email_list) {

          var email = email_list[i];
          input.val(email);
          input.data('name', div.find('select.email_selection option[value="'+email+'"]').text())
          addEmail(input);
          div.find('select.email_selection option[value="'+email+'"]').remove();

        }
      }

  <?php 
    }  
  ?>

  $('.pillbox ul li').on('click', function() {
    return false;
  });

//############################ start : number   ##################################################
 function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 45 || charCode > 57))//48
            return false;

         return true;
      }
//############################ END : number ##################################################




//############################ start : check_confirm_save   ##################################################
 function check_confirm_save() {
        
       $('#modal-confirm-save').modal('show');                        
            //alert(project_id+' '+doc_id+' '+asset_id);    

      $('.confirm-save').on('click',function(event){
           $('.btn_save_changes').click();           
       });//end click confirm

  }
//############################ END : check_confirm_save ##################################################  


</script>
  
  <?php $this->load->view('__quotation/script/select_sold_to_js'); ?>
  <?php $this->load->view('__quotation/script/function_clone_area_js'); ?>
  <?php $this->load->view('__quotation/script/toggle_menu_project_js'); ?> 
  <?php $this->load->view('__quotation/script/delete_js'); ?>

   <!-- DataTables -->
    <script src="<?php echo js_url().'datatables/jquery.dataTables.js';?> "></script>
    <script src="<?php echo js_url().'datatables/TableTools/js/TableTools.min.js'; ?> "></script>   
    <script src="<?php echo js_url().'datatables/FixedColumns/FixedColumns.min.js'; ?> "></script>
    <script src="<?php echo js_url().'datatables/dataTables.bootstrap.js'; ?> "></script>
    <script src="<?php echo js_url().'datatables/jquery.dataTables.columnFilter.js'; ?> "></script>

    <script src="<?php echo js_url().'datatables/dataTables.js';?>"></script>
    <script src="<?php echo js_url().'dataTables.js';?>"></script>

 
  <?php if(!empty($footage_script))echo $footage_script; ?>




</body>
</html>