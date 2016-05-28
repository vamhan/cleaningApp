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

  <!--CSS : select2-->
  <link rel="stylesheet" href="<?php echo theme_js().'select2/select2.css'?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_js().'select2/theme.css'?>" type="text/css" />

  <link rel="stylesheet" href="<?php echo theme_js().'fuelux/fuelux.css'?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_js().'datepicker/datepicker.css'?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_js().'slider/slider.css'?>" type="text/css" />

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

 <!-- datepicker-->
 <script src="<?php echo theme_js().'moment/moment.min.js'?>"></script>
 <script src="<?php echo theme_js().'build_datepicker/bootstrap-datetimepicker.js'?>"></script>

<script type="text/javascript">
/// ================ start :check datetimepicker ==========

$(document).ready(function(){

  // $('#nav').removeClass('nav-xs');
  // $('#nav').removeClass('nav-off-screen');
  // $('#nav').addClass('nav-xs');


// //################### end : check previouse  ##########
//      $('#datetimepicker1').datetimepicker({
//             pickTime: false,
//             minDate:dateToday,
//             icons: {
//             time: "fa fa-clock-o",
//             date: "fa fa-calendar",
//             up: "fa fa-arrow-up",
//             down: "fa fa-arrow-down"
//           }
//         });

        // $('#datetimepicker6').datetimepicker({
        //      //format: "mm-yyyy",
        //      // viewMode: "months", 
        //      // minViewMode: "months"
        //       pickDate: true,                             //en/disables the date picker
        //       pickTime: true,                             //en/disables the time picker
        //       useMinutes: true,                           //en/disables the minutes picker
        //       useSeconds: false,                          //en/disables the seconds picker
        //       useCurrent: false,                           //when true, picker will set the value to the current date/time
        //       minuteStepping:1,                           //set the minute stepping
        //       minDate:'',                       //set a minimum date
        //       maxDate:'',                      //set a maximum date (defaults to today +100 years)
        //       showToday: false,                            //shows the today indicator
        //       anguage:'en',                               //sets language locale
        //       defaultDate:null,                             //sets a default date, accepts js dates, strings and moment objects
        //       disabledDates:[],                           //an array of dates that cannot be selected
        //       enabledDates:['2014/11','2014/12'],                            //an array of dates that can be selected          
        //       icons: {
        //           time: "fa fa-clock-o",
        //           date: "fa fa-calendar",
        //           up: "fa fa-arrow-up", 
        //           down: "fa fa-arrow-down"
        //       },
        //       useStrict: false,                           //use "strict" when validating dates
        //       sideBySide: false,                          //show the date and time picker side by side
        //       daysOfWeekDisabled:[]                       //for example use daysOfWeekDisabled: [0,6] to disable weekends          

        //  });

    
})
/// ================ end :check datetimepicker ==========


</script>


<?php $this->load->view('__complain/script/selected_ship_to_js'); ?> 
<?php $this->load->view('__complain/script/toggle_menu_project_js'); ?>


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