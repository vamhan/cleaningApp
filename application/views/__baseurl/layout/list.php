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
          <?php //if(!empty($side_menu))echo $side_menu; ?>
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
  <?php //if(!empty($modal))echo $modal; ?>
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

  <!-- select2 -->
  <script src="<?php echo theme_js().'select2/select2.min.js'?>"></script>

 <!-- datepicker-->
 <script src="<?php echo theme_js().'moment/moment.min.js'?>"></script>
 <script src="<?php echo theme_js().'build_datepicker/bootstrap-datetimepicker.js'?>"></script>


<script type="text/javascript">


$(document).ready(function(){



// ######################### START : disabled  view_quotation input and button ###################################
$('.div_detail').find('input,select,.coppy_group,.coppy_sub_group,.delete_other,.delete_sub_group,.delete_group').attr('disabled', true);



})/// ================ end : document ==========


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
  // if ( cat_id != 0 && permission_set[cat_id] && permission_set[cat_id]['create'] == '0' ) {
  //   $('.btn[data-action="create"]').hide();
  // }
  // if ( cat_id != 0 && permission_set[cat_id] && permission_set[cat_id]['update'] == '0' ) {
  //   $('.btn[data-action="update"]').hide();
  // }
  // if ( cat_id != 0 && permission_set[cat_id] && permission_set[cat_id]['delete'] == '0' ) {
  //   $('.btn[data-action="delete"]').hide();
  // }
</script>
 <!-- <script src="<?php //echo theme_js().'fuelux/fueludemox.js'?>"></script>
  script src="<?php //echo theme_js().'fuelux/demo.datagrid.js'?>"></script
-->

  <script src="<?php echo theme_js().'app.plugin.js';?>"></script>


  <?php $this->load->view('__quotation/script/paging_js'); ?>
  <?php $this->load->view('__quotation/script/delete_js'); ?>
  <?php $this->load->view('__quotation/script/toggle_menu_project_js'); ?>
  <?php $this->load->view('__quotation/script/select_sold_to_js'); ?>

</body>
</html>