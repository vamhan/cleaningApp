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
  
  <link rel="stylesheet" href="<?php echo theme_css().'app.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo css_url().'main.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo css_url().'jquery.gritter.css';?>" type="text/css" />

  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
  <script src="<?php echo theme_js().'jquery.min.js';?>"></script>

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
        <section id="content">
            <?php if(!empty($body))echo $body; ?>
        </section>
        <!-- start : content -->

        <!-- start : side-nav-bottom -->
        <aside class="bg-light lter b-l aside-md hide" id="notes">
          <div class="wrapper">Notification</div>
        </aside>
        <!-- end : side-nav-bottom -->


      </section>
    </section>
  </section>

  <div id="modal_section">
  <?php if(!empty($modal))echo $modal; ?>
  </div>

  
  <!-- Bootstrap -->
  <script src="<?php echo theme_js().'bootstrap.js';?>"></script>
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



  <script src="<?php echo js_url().'jquery.gritter.min.js';?>"></script>
  <script src="<?php echo theme_js().'app.plugin.js';?>"></script>


  <?php $this->load->view('__backend/script/paging_js'); ?>
  <?php $this->load->view('__backend/script/delete_js'); ?>


  <!-- TODO :: MOVE TO COMMON FOOTAGE SCRIPT LATER -->
  <script type="text/javascript">
  $(document).ready(function(){
    
    $('.menu-item').each(function(){
      var obj = $(this);
      if(obj.hasClass('active')){
        obj = obj.parent().parent();
        if(obj.hasClass('menu-group-item')){
           obj.addClass('active');
        }//end if 
      }//end if
    })//end each


      

    //Submit search    
    $('.submit-search').on('click',function(){
      $('form[name="submit-search"]').submit()
    })      
    

    
  })
  </script>
  <?php //$this->load->view('__backend/script/paging_js'); ?>
  <?php //$this->load->view('__backend/script/delete_js'); ?>

  
  <!-- TODO :: MOVE TO COMMON FOOTAGE SCRIPT LATER -->
  
  <?php if(!empty($footage_script))echo $footage_script; ?>
</body>
</html>
