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
        pickTime: true,
        minDate: yesterday,
        defaultDate: new Date(),
        icons: {
          time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-arrow-up",
          down: "fa fa-arrow-down"
        }
    });

    var sale_order_sel = $('select.sale_order_id');

    var months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    
    $("#datetimepicker5").on("dp.change",function (e) {

      var dateObj = new Date(e.date);

      var year = dateObj.getFullYear();
      var month = months[dateObj.getMonth()];

      var title_val = $('.event_title').val();
      if (title_val == "" || title_val == undefined) {
        var title = "<?php echo freetext('equipment_requisition'); ?> ["+month+" "+year+"]";
        $('.event_title').val(title);
      }

      var type_id = $('select.job_type_id').val();
      if (type_id == "ZOR1_ZTAA") {
        var plan_month = dateObj.getMonth();
        var plan_year  = dateObj.getFullYear();

        sale_order_sel.find('option').remove();
        $('.sale_order_value[data-type="'+type_id+'"]').each(function() {          
          var date = new Date($(this).data('date'));
          var month = date.getMonth();
          var year = date.getFullYear();

          if (month == plan_month && year == plan_year) {
            sale_order_sel.append('<option value="'+$(this).val()+'">'+$(this).val()+"</option>");
            $('input.sale_order_id').val($(this).val());
          }
        });
      }

      if (sale_order_sel.val() != null) {
        $('.submit-create').removeAttr('disabled');
      } else {
        $('.submit-create').attr('disabled', true);
      }

      $('input[name="plan_date"]').css('border-color', '#d9d9d9');

    });

    $('select.job_type_id').on('change', function() {
      var type_id  = $(this).val();
      if (type_id != "") {

        var type_name = $(this).find('option[value="'+type_id+'"]').data('type');

        var job_type_part = type_id.split('_');
        $('input.order_type').val(type_name);
        $('input.job_cat_id').val(job_type_part[1]);

        sale_order_sel.find('option').remove();
        if (type_id == "ZOR1_ZTAA") {
          var today = new Date();
          var month = today.getMonth()+1;
          var year  = today.getFullYear();

          var next_year = year;
          if (month == '12') {
            next_month = '01';
            next_year  = year+1;
          } else {
            var next_month = (month+1).toString();
            if (next_month.length == 0) {
              next_month = '0'+next_month;
            }
          }

          $('#datetimepicker5').data("DateTimePicker").setMinDate(new Date(year+'-'+month+'-01'));
          $('#datetimepicker5').data("DateTimePicker").setMaxDate(new Date(next_year+'-'+next_month+'-31'));

          var plan_date = $('input[name="plan_date"]').val();
          if (plan_date != "") {
            var plan_date_parts = plan_date.split('.');
            var plan_date_txt = plan_date_parts[2]+'-'+plan_date_parts[1]+'-'+plan_date_parts[0];
            var plan_date_obj = new Date(plan_date_txt);
            var plan_month = plan_date_obj.getMonth();
            var plan_year  = plan_date_obj.getFullYear();

            $('.sale_order_value[data-type="'+type_id+'"]').each(function() {          
              var date = new Date($(this).data('date'));
              var month = date.getMonth();
              var year = date.getFullYear();

              if (month == plan_month && year == plan_year) {
                sale_order_sel.append('<option value="'+$(this).val()+'">'+$(this).val()+"</option>");
                $('input.sale_order_id').val($(this).val());
              }
            });
          }

          sale_order_sel.prop('disabled', true);
        } else {
          sale_order_sel.prop('disabled', false);
          var today = new Date();
          var max   = today.getFullYear()+100+'-12-31';
          $('#datetimepicker5').data("DateTimePicker").setMinDate('1/1/1900');
          $('#datetimepicker5').data("DateTimePicker").setMaxDate(max);
          $('.sale_order_value[data-type="'+type_id+'"]').each(function() {   
            sale_order_sel.append('<option value="'+$(this).val()+'">'+$(this).val()+"</option>");
          });

          var val = sale_order_sel.val();
          $('input.sale_order_id').val(val);
          sale_order_sel.off();
          sale_order_sel.on('change', function() {
            var val = sale_order_sel.val();
            $('input.sale_order_id').val(val);
          });
        }

        if (sale_order_sel.val() != null) {
          $('.submit-create').removeAttr('disabled');
        } else {
          $('.submit-create').attr('disabled', true);
        }
      }

    });
  
    var type_id  = $('select.job_type_id').val();  

    if (type_id != "" && type_id != undefined && type_id != null) {

      var type_name = $('select.job_type_id').find('option[value="'+type_id+'"]').data('type');
      var job_type_part = type_id.split('_');
      $('input.order_type').val(type_name);
      $('input.job_cat_id').val(job_type_part[1]);
      $('input[name="plan_date"]').val('<?php echo date("d.m.Y"); ?>');

      if (type_id == "ZOR1_ZTAA") {
        var today = new Date();
        var month = today.getMonth()+1;
        var year  = today.getFullYear();

        var next_year = year;
        if (month == '12') {
          next_month = '01';
          next_year  = year+1;
        } else {
          var next_month = (month+1).toString();
          if (next_month.length == 0) {
            next_month = '0'+next_month;
          }
        }
        
        $('#datetimepicker5').data("DateTimePicker").setMinDate(new Date(year+'-'+month+'-01'));
        $('#datetimepicker5').data("DateTimePicker").setMaxDate(new Date(next_year+'-'+next_month+'-31'));

        var plan_date = $('input[name="plan_date"]').val();

        if (plan_date != "") {
          var plan_date_parts = plan_date.split('.');
          var plan_date_txt = plan_date_parts[2]+'-'+plan_date_parts[1]+'-'+plan_date_parts[0];
          var plan_date_obj = new Date(plan_date_txt);
          var plan_month = plan_date_obj.getMonth();
          var plan_year  = plan_date_obj.getFullYear();

          $('.sale_order_value[data-type="'+type_id+'"]').each(function() {          
            var date = new Date($(this).data('date'));
            var month = date.getMonth();
            var year = date.getFullYear();

            if (month == plan_month && year == plan_year) {
              sale_order_sel.append('<option value="'+$(this).val()+'">'+$(this).val()+"</option>");
              $('input.sale_order_id').val($(this).val());
            }
          });
        }

        sale_order_sel.prop('disabled', true);
      } else {
        sale_order_sel.prop('disabled', false);
        var today = new Date();
        var max   = today.getFullYear()+100+'-12-31';
        $('#datetimepicker5').data("DateTimePicker").setMinDate('1/1/1900');
        $('#datetimepicker5').data("DateTimePicker").setMaxDate(max);
        $('.sale_order_value[data-type="'+type_id+'"]').each(function() {   
          sale_order_sel.append('<option value="'+$(this).val()+'">'+$(this).val()+"</option>");
        });

        var val = sale_order_sel.val();
        $('input.sale_order_id').val(val);

        sale_order_sel.off();
        sale_order_sel.on('change', function() {
          var val = sale_order_sel.val();
          $('input.sale_order_id').val(val);
        });
      }
    }  

    if (sale_order_sel.val() != null) {
      $('.submit-create').removeAttr('disabled');
    } else {
      sale_order_sel.attr('disabled', true);
      $('.submit-create').attr('disabled', true);
    }

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

  <script src="<?php echo theme_js().'app.plugin.js';?>"></script>


  <?php $this->load->view('__equipment_requisition/script/paging_js'); ?>
  <?php $this->load->view('__equipment_requisition/script/delete_js'); ?>
  <?php $this->load->view('__equipment_requisition/script/toggle_menu_project_js'); ?>

</body>
</html>