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


<?php  
//====start : get data project =========
  $this->db->select('tbt_quotation.*');
  $this->db->where('id',$this->project_id);
  $query_project=$this->db->get('tbt_quotation');
  $data_project = $query_project->row_array(); 

  $start_date_project = $data_project['project_start'];
  $end_date_project = $data_project['project_end'];
//====end : get data project =========
?>



<script type="text/javascript">


  $('#nav').removeClass('nav-xs');
  $('#nav').removeClass('nav-off-screen');
  $('#nav').addClass('nav-xs');

function fetch_slot() {
    
    var months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

    var modal      = $('#modal-addListEmployee');
    var contract_id = $('input[name="contract_id"]').val();
    var module_id  = "<?php echo $this->cat_id; ?>";

    var project_end = "<?php echo $project['project_end']; ?>";

    var plan_date  = modal.find('.plan_date');
    var datepicker = plan_date.next();
    var date_picker_id = datepicker.attr('id');
    datepicker.remove();

    plan_date.after('<div class="input-group date" id="'+date_picker_id+'" data-date-format="DD.MM.YYYY"><input type="text" class="form-control" disabled/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>');

    var date = new Date();
    date.setDate(date.getDate() - 1);
    $('#'+date_picker_id).datetimepicker({
        pickTime: false,
        minDate: date,
        maxDate: new Date(project_end),
        icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
      }
    });

    $('#'+date_picker_id).on("dp.change",function (e) {
      var dateObj = new Date(e.date);

      var year  = dateObj.getFullYear();
      var month = (dateObj.getMonth()+1).toString();
      if (month.length == 1) {
        month = '0'+month;
      }
      var day   = dateObj.getDate().toString();
      if (day.length == 1) {
        day = '0'+day;
      }

      $(this).find('input').css('border-color', '#d4d4d4');
      $(this).parent().find('.plan_date').val(year+'-'+month+'-'+day);

      var form = $(this).closest('form');
      var is_default = form.find('.event_title').data('default');
      var title = form.find('.event_title').val();
      var event_cat_id = form.find('.event_category').val();
      if (is_default == 1 && (event_cat_id != 0 && event_cat_id != 12 && event_cat_id != undefined)) {
        var event_cat    = form.find('.event_category option[value="'+event_cat_id+'"]').text();
        form.find('.event_title').val(event_cat+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
      }
      if (event_cat_id == 12) {

        var area_id     = form.find('.clear_job_area').val();
        if (is_default == 1 && (area_id != 0 && area_id != undefined)) {
          var area_name    = form.find('.clear_job_area option[value="'+area_id+'"]').text();
          form.find('.event_title').val(area_name+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
        } else if (is_default == 1) {
          form.find('.event_title').val('');
        }
      }
    });

    plan_date.val('');
    $('#'+date_picker_id).data("DateTimePicker").setDate(new Date().getDate()+"."+(new Date().getMonth()+1)+"."+new Date().getFullYear());

    if (contract_id != "" && module_id != 0) {
      $.ajax('<?php echo site_url("__ps_action_plan/fetch_slot") ?>', {
        type: 'post',
        data: 'contract_id='+contract_id+'&module_id='+module_id,
        beforeSend: function() {
          $('.all_parts').text('loading...');
        }
      }).done(function (data) {

        var result_list = JSON.parse(data);
            result      = result_list['project'];

        var select_part = $('select[name="sequence"]');
        select_part.find('option').remove();
        select_part.attr('disabled', true);
        $('.all_parts').text('');
        if (data != 0) {
          var result_list = JSON.parse(data);

          var part_list = result_list['user_marked'];
          var all_user_marked = result_list['all_user_marked'];
          if (part_list != 0) {
            select_part.removeAttr('disabled');
            for (var i in part_list) {
              var part = part_list[i];
              select_part.append('<option value="'+part['sequence']+'">'+part['sequence']+'</option>');
            }

            $('.all_parts').text('/ '+all_user_marked);
            $('.part_alert').hide();
          } else {
            select_part.attr('disabled', true);
            $('.all_parts').text('there is no available slot left.');
          }
        }
      });
    }
}

<?php
  $position_list = $this->session->userdata('position');

  $children = array();
  foreach ($position_list as $key => $position) {
      $children = $this->__ps_project_query->getPositionChild($children, $position);
  }
?>

$(document).ready(function(){

    var dateToday = new Date("<?php echo date('Y-m-d')?>");
    var start_date_project = new Date("<?php echo $start_date_project; ?>");
    var end_date_project = new Date("<?php echo $end_date_project; ?>");
    var min_Date = '';

    if(start_date_project>dateToday){
        min_Date = start_date_project;
    }else{
        min_Date = new Date(dateToday.getFullYear()+'-'+(dateToday.getMonth()+1)+'-01');
    }
    
    $('#datetimepicker5').datetimepicker({
        pickTime: false,
        minDate: min_Date,
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

      var year  = dateObj.getFullYear();
      var month = (dateObj.getMonth()+1).toString();
      if (month.length == 1) {
        month = '0'+month;
      }
      var day   = dateObj.getDate().toString();
      if (day.length == 1) {
        day = '0'+day;
      }

      $(this).find('input').css('border-color', '#d4d4d4');
      $(this).parent().find('.plan_date').val(year+'-'+month+'-'+day);
      
      var form = $(this).closest('form');
      var is_default = form.find('.event_title').data('default');
      var title = form.find('.event_title').val();
      var event_cat_id = form.find('.event_category').val();
      if (is_default == 1 && (event_cat_id != 0 && event_cat_id != undefined)) {
        var event_cat    = form.find('.event_category option[value="'+event_cat_id+'"]').text();
        form.find('.event_title').val(event_cat+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
      }
    });

    $('.event_category').on('change', function() {

      var form = $(this).closest('form');
      var is_default = form.find('.event_title').data('default');
      var title = form.find('.event_title').val();
      var event_cat_id = form.find('.event_category').val();
      var date = form.find('.plan_date').val();
      var dateObj = new Date(date);

      if (is_default == 1 && (event_cat_id != 0 && event_cat_id != undefined)) {
        var event_cat    = form.find('.event_category option[value="'+event_cat_id+'"]').text();
        form.find('.event_title').val(event_cat+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
      }
      
    });

    var date = new Date();
    $('#datetimepicker5').data("DateTimePicker").setDate(date.getDate()+"."+(date.getMonth()+1)+"."+date.getFullYear());

    $('.event_title').on('keyup', function() {
      if ($(this).val() != "") {
       $(this).data('default', 0);
        $(this).css('border-color', '#d9d9d9');
      }
    });

    <?php

        if (empty($children)) {
    ?>  
          $('select[name="sequence"]').closest('div.form-group').show();
          fetch_slot();
    <?php
        } else {
    ?>
          $('select[name="sequence"]').closest('div.form-group').hide();
    <?php
        }
    ?>


    $('.create_btn').on('click', function() {
      var form       = $('#modal-addListEmployee form');
      var sequence   = form.find('select[name="sequence"]');
      var ship_to_id = form.find('input[name="ship_to_id"]');
      var plan_date  = form.find('input[name="plan_date"]');
      var title      = form.find('input[name="title"]');

      var pass = true;
      if (ship_to_id.val() == "") {
        pass = false;
        form.find('.ship_to_id').css('border-color', 'red');
      }
      if (plan_date.val() == "") {
        pass = false;
        $('#datetimepicker5 input').css('border-color', 'red');
      }
      if (title.val() == "") {
        pass = false;
        title.css('border-color', 'red');
      }
      <?php
        if (empty($children)) {
      ?>
          if (sequence.val() == "" || sequence.val() == null) {
            pass = false;
            $('#modal-addActionplan form .part_alert').show();
          }
      <?php
        }
      ?>

      if (!pass) {
        return false
      }

      $(this).attr('disabled', true);
      form.submit();
    });

});
/// ================ end :check toggle menu top project ==========


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


  <?php $this->load->view('__quality_assurance/script/paging_js'); ?>
  <?php $this->load->view('__quality_assurance/script/delete_js'); ?>
  <?php $this->load->view('__quality_assurance/script/toggle_menu_project_js'); ?>

</body>
</html>