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
  <link rel="stylesheet" href="<?php echo theme_js().'nestable/nestable.css';?>" type="text/css" />
  <!--
  <link rel="stylesheet" href="<?php //echo theme_js().'calendar/bootstrap_calendar.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php //echo theme_js().'js/fuelux/fuelux.css'?>" type="text/css"/>
  -->

  <link rel="stylesheet" href="<?php echo theme_css().'app.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo css_url().'main.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo css_url().'multi-screen.css';?>" type="text/css" />

   <!--CSS : datepicker-->
  <link rel="stylesheet" href="<?php echo theme_css().'bootstrap-datetimepicker.min.css';?>" type="text/css" />
  

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

        <!-- start : content -->
        <section id="content" style="width:100%;">
            <?php if(!empty($top_project))echo $top_project;?>

            <?php if(!empty($body))echo $body;?>
        </section>
        <!-- start : content -->

        <!-- start : side-nav-bottom -->
        <aside class="bg-light lter b-l aside-md hide" id="notes">
          <div class="wrapper">Notification</div>
        </aside>
        <!-- end : side-nav-bottom -->`


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

  <!--script src="<?php //echo theme_js().'fuelux/fueludemox.js'?>"></script-->
  <!--script src="<?php //echo theme_js().'fuelux/demo.datagrid.js'?>"></script-->

  <script src="<?php echo theme_js().'nestable/jquery.nestable.js';?>"></script>

  <script src="<?php echo theme_js().'app.plugin.js';?>"></script>


<!-- <script src="<?php //echo js_url().'paginator.js';?>"></script>-->
 
  <!-- parsley -->
  <script src="<?php echo theme_js().'parsley/parsley.js'?>"></script>

 <!-- datepicker-->
 <script src="<?php echo theme_js().'moment/moment.min.js'?>"></script>
 <script src="<?php echo theme_js().'build_datepicker/bootstrap-datetimepicker.js'?>"></script>





<script type="text/javascript">


$(document).ready(function(){ 

  $('#nav').removeClass('nav-xs');
  $('#nav').removeClass('nav-off-screen');
  $('#nav').addClass('nav-xs');


     var date = new Date();
     var yesterday = date.setDate(date.getDate() - 1);
     $('#datetimepicker5').datetimepicker({
        pickTime: false,
        minDate: yesterday,
        icons: {
          time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-arrow-up",
          down: "fa fa-arrow-down"
        }
    });

    var months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    
    $("#datetimepicker5").on("dp.change",function (e) {
      var dateObj = new Date(e.date);

      var year = dateObj.getFullYear();
      var month = months[dateObj.getMonth()];

      var title_val = $('.event_title').val();
      if (title_val == "" || title_val == undefined) {
        var title = "<?php echo freetext('equipment_return'); ?> for "+month+" "+year;
        $('.event_title').val(title);
      }

      if ($('select.job_type_id').val() != 0) {
        $('.submit-create').removeAttr('disabled');
      }
      
      $('input[name="plan_date"]').css('border-color', '#d9d9d9');
    });

    $('select.job_type_id option').each(function() {
        var type_id  = $(this).val();

        var job_type_part = type_id.split('_');
        var job_type = job_type_part[0];
        var cat_type = job_type_part[1];

        var min = 0;
        var max = 0;
        if (job_type == "ZOR4") {
          min = "";
          max = $('.sale_order[data-type="'+job_type+'_'+cat_type+'"]').val();
        } else {
          min = $('.sale_order[data-type="min_'+job_type+'_'+cat_type+'"]').val();
          max = $('.sale_order[data-type="max_'+job_type+'_'+cat_type+'"]').val();
        }

        if ( (min == "" || min == undefined) && max == undefined) {
          $(this).remove();
        }
    });

    if ($('select.job_type_id option').length == 0) {
      $('select.job_type_id').append('<option value="0">---- No Requisition ----</option>');
      $('.submit-create').attr('disabled', true);
    }

    $('select.job_type_id').on('change', function() {
      var type_id  = $(this).val();
      var type_name = $(this).find('option[value="'+type_id+'"]').data('type');

      var job_type_part = type_id.split('_');
      var job_type = job_type_part[0];
      var cat_type = job_type_part[1];

      $('input.order_type').val(type_name);
      $('input.job_cat_id').val(cat_type);

      var min = 0;
      var max = 0;
      if (job_type == "ZOR4") {
        min = "";
        max = $('.sale_order[data-type="'+job_type+'_'+cat_type+'"]').val();
      } else {
        min = $('.sale_order[data-type="min_'+job_type+'_'+cat_type+'"]').val();
        max = $('.sale_order[data-type="max_'+job_type+'_'+cat_type+'"]').val();
      }

      $('input.equipment_sale_order_id').val(max);
      $('input.asset_sale_order_id').val(min);
    });

    var type_id  = $('select.job_type_id').val();
    var type_name = $('select.job_type_id').find('option[value="'+type_id+'"]').data('type');

    var job_type_part = type_id.split('_');
    var job_type = job_type_part[0];
    var cat_type = job_type_part[1];
    
    $('input.order_type').val(type_name);
    $('input.job_cat_id').val(cat_type);
    $('input[name="plan_date"]').val('<?php echo date("Y-m-d"); ?>');

    var min = 0;
    var max = 0;
    if (job_type == "ZOR4") {
      min = "";
      max = $('.sale_order[data-type="'+job_type+'_'+cat_type+'"]').val();
    } else {
      min = $('.sale_order[data-type="min_'+job_type+'_'+cat_type+'"]').val();
      max = $('.sale_order[data-type="max_'+job_type+'_'+cat_type+'"]').val();
    }

    if ($('select.job_type_id').val() != 0 && $('input[name="plan_date"]').val() != "") {
      $('.submit-create').removeAttr('disabled');
    } else {
      $('.submit-create').attr('disabled', true);
    }

    $('input.equipment_sale_order_id').val(max);
    $('input.asset_sale_order_id').val(min);

    $('.submit-create').on('click', function() {
      if ($('input[name="plan_date"]').val() != null && $('input[name="plan_date"]').val() != '') {
        $('.submit-create').attr('disabled', true);
        $('#create-doc-form').submit();
      } else {
        $('input[name="plan_date"]').css('border-color', 'red');
        $('.submit-create').attr('disabled', true);
      }
    });
});
</script>
  
<?php if(!empty($footage_script))echo $footage_script; ?>

<script type="text/javascript">

  //Side Navigate
  $('.nav.lt li.active').parent().closest('li').addClass('active');
  //Permission button
  <?php
    // $unique_id = $this->session->userdata('unique_id');
    // $filename = CFGPATH."cms_config".DS."permission".DS.$unique_id.".php";
    // if (file_exists($filename)) {
    //   $permission_file = file_get_contents($filename);
    //   $permission_set = unserialize($permission_file);
    // } else {
    //   echo "<script>alert('Session has expired.'); location.href = '".site_url('__cms_permission/logout')."';</script>";
    //   die();
    // }
  ?>
  // var permission_set = '<?php echo json_encode($permission_set); ?>';
  //     permission_set = JSON.parse(permission_set); 
  // var cat_id    = "<?php if (isset($this->cat_id)) { echo $this->cat_id; } else { echo 0; } ?>";
  
  // if ( cat_id != 0 && permission_set[cat_id] && permission_set[cat_id]['view'] == '0' ) {
  //   $('*[data-cms-action="view"]').hide();
  //   $('*[data-cms-visible="view"]').attr('disabled', 'disabled');
  // }
  // if ( cat_id != 0 && permission_set[cat_id] && permission_set[cat_id]['create'] == '0' ) {
  //   $('*[data-cms-action="create"]').hide();
  //   $('*[data-cms-visible="create"]').attr('disabled', 'disabled');
  // }
  // if ( cat_id != 0 && permission_set[cat_id] && permission_set[cat_id]['update'] == '0' ) {
  //   $('*[data-cms-action="update"]').hide();
  //   $('*[data-cms-visible="update"]').attr('disabled', 'disabled');
  // }
  // if ( cat_id != 0 && permission_set[cat_id] && permission_set[cat_id]['delete'] == '0' ) {
  //   $('*[data-cms-action="delete"]').hide();
  //   $('*[data-cms-visible="delete"]').attr('disabled', 'disabled');
  // }
  // if ( cat_id != 0 && permission_set[cat_id] && permission_set[cat_id]['manage'] == '0' ) {
  //   $('*[data-cms-action="manage"]').hide();
  //   $('*[data-cms-visible="manage"]').attr('disabled', 'disabled');
  // }
</script>
 <!-- <script src="<?php //echo theme_js().'fuelux/fueludemox.js'?>"></script>
  script src="<?php //echo theme_js().'fuelux/demo.datagrid.js'?>"></script
-->

  <script src="<?php echo theme_js().'app.plugin.js';?>"></script>


  <?php $this->load->view('__equipment_requisition/script/paging_js'); ?>
  <?php $this->load->view('__equipment_requisition/script/delete_js'); ?>
  <?php $this->load->view('__equipment_requisition/script/toggle_menu_project_js'); ?>

</body>
</html>