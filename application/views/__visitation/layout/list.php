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

    <!-- select2 -->
    <script src="<?php echo theme_js().'select2/select2.min.js'?>"></script>

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


      $.fn.extend({
        donetyping: function(callback,timeout){
          timeout = timeout || 1e3; // 1 second default timeout
          var timeoutReference,
          doneTyping = function(el){
            if (!timeoutReference) return;
            timeoutReference = null;
            callback.call(el);
          };
          return this.each(function(i,el){
            var $el = $(el);
              // Chrome Fix (Use keyup over keypress to detect backspace)
              // thank you @palerdot
              $el.is(':input') && $el.on('keyup keypress',function(e){
                  // This catches the backspace button in chrome, but also prevents
                  // the event from triggering too premptively. Without this line,
                  // using tab/shift+tab will make the focused element fire the callback.
                  if (e.type=='keyup' && e.keyCode!=8) return;
                  
                  // Check if timeout has been set. If it has, "reset" the clock and
                  // start over again.
                  if (timeoutReference) clearTimeout(timeoutReference);
                  timeoutReference = setTimeout(function(){
                      // if we made it here, our timeout has elapsed. Fire the
                      // callback
                      doneTyping(el);
                    }, timeout);
                }).on('blur',function(){
                  // If we can, fire the event since we're leaving the field
                  doneTyping(el);
                });
              });
}
});

function fetch_slot() {

  $('.sel-ship-to').off();
  $('.sel-ship-to').on('click', function() {

    var modal      = $(this).closest('.modal');
    var contract_id = $(this).data('id');
    var project_end = $(this).data('end');
    var ship_to    = $(this).text();

    modal.find('.ship_to_id').val(ship_to);
    modal.find('.ship_to_id').css('border-color', '#d4d4d4');
    modal.find('input[name="contract_id"]').val(contract_id);
    modal.find('div.open').removeClass('open');    

    var select_part = modal.find('select[name="sequence"]');
    select_part.find('option').remove();
    select_part.attr('disabled', true);
    modal.find('.all_parts').text('');

    var plan_date  = modal.find('.plan_date');
    var plan_date_val  = plan_date.val();
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
    var months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
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
        form.find('.event_title').css('border-color', '#d4d4d4');
      }

    });

plan_date.val('');

$('#'+date_picker_id).data("DateTimePicker").setDate(new Date().getDate()+"."+(new Date().getMonth()+1)+"."+new Date().getFullYear());      

return false;
});
}
$(document).ready(function(){
//############################ START : set date    ##################################################

var dateToday = new Date("<?php echo date('Y-m-d')?>");
var start_date_project = new Date("<?php echo $start_date_project; ?>");
var min_Date = '';

if(start_date_project>dateToday){
  min_Date = start_date_project;
}else{
  min_Date = new Date(dateToday.getFullYear()+'-'+(dateToday.getMonth()+1)+'-01');
}

$('#datetimepicker5').datetimepicker({
  pickTime: false,
  useCurrent: false,
  minDate: min_Date,            
        //maxDate:end_date_project,  
        icons: {
          time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-arrow-up",
          down: "fa fa-arrow-down"
        }
      });

$('.event_title').on('keyup', function() {
  if ($(this).val() != "") {
   $(this).data('default', 0);
   $(this).css('border-color', '#d9d9d9');
 }
});
//############################ end : set date   ##################################################


//############################ START : TAB active   ##################################################
 // $("p").removeClass("intro");
 // $("p:first").addClass("intro");
 var tab1 ="<?php echo $this->tab; ?>";
 var tab_active = false;
//alert(untrack);
if(tab1==1){
  $(".tab1").addClass("active");
  $("#tab1").addClass("active");
}else{0;
  $(".tab2").addClass("active");
  $("#tab2").addClass("active");
}

//############################ END : TAB active   ##################################################


//############################ START :  modal  change  customer_source ##################################################

var customer_source ='';
$("select[name='customer_source']").change(function(){  

  //alert('chage customer_source');
  customer_source = $(this).val();
  if(customer_source=='customer_prospect'){
    $('.div_sold_to').addClass("hide"); 
    $('.div_prospect_customer').removeClass("hide");       
  }else{
   $('.div_prospect_customer').addClass("hide");
   $('.div_sold_to').removeClass("hide"); 
 }

})//end chage customer_source

var doctype='';
$('.box_customer').hide();
// check doctype quotation or prospect
$("input[name='doc_type']").on('click',function(){ 
  doctype = $(this).val();
      //alert('doctype : '+doctype);
      if(doctype==1){
        $('.box_customer').hide('fade');
         // $('.div_prospect_customer').hide('fade');
       }else{
        $('.box_customer').show('fade');
      }//end else

});//end click


$(".btn_insert").on('click',function(){ 
 $('.btn_insert').hide();
 $('.btn_insert_hide').removeClass('hide');

});//end click

//############################ END :  modal  change  customer_source ##################################################
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
  if (is_default == 1 && (event_cat_id != 0 && event_cat_id != 12 && event_cat_id != undefined)) {
    var event_cat    = form.find('.event_category option[value="'+event_cat_id+'"]').text();
    form.find('.event_title').val(event_cat+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
    form.find('.event_title').css('border-color', '#d4d4d4');
  }

});

$('.project_type_radio').on('change', function() {
  var type = $(this).val();
  if (type == 'prospect') {
    $('.prospect_div').show();
    $('.ship_to_div').hide();
    $('.part_div').hide();
  } else {
    $('.prospect_div').hide();
    $('.ship_to_div').show();
    $('.part_div').show();
  }


  $('.prospect_id, .ship_to_id').css('border-color', '#d4d4d4');
  $('input[name="prospect_id"], .prospect_id, input[name="contract_id"], .ship_to_id').val('');

  var modal = $(this).closest('.modal');
  var list = modal.find('ul.prospect_list');
  list.find('li').remove();
  list.parent().removeClass('open');

  var select_part = $('select[name="sequence"]');
  select_part.find('option').remove();
  select_part.attr('disabled', true);
  $('.all_parts').text('');

  modal.find('.type_alert').hide();
});

$('.department_id').change(function(){
  $('.prospect_id') .val(''); 
  $('.ship_to_id') .val(''); 
});

$('.prospect_id').donetyping(function() {

  var modal = $(this).closest('.modal');
  var prospect_id = modal.find('.prospect_id').val();
  var distribution_channel = "-1";
  if(modal.find('.distribution_channel').length > 0){
    distribution_channel = modal.find('.distribution_channel').val();
  }
  param = {prospect_id:prospect_id, distribution_channel:distribution_channel};

  if (prospect_id != "") {
    $.ajax('<?php echo site_url("__ps_action_plan/fetch_prospect") ?>', {
      type: 'post',
      data: param,
      dataType: "json",
      beforeSend: function() {
        $('.prospect_loading').show();
          // modal.find('.event_category').attr('disabled', true);
        }
      }).done(function (data) {
        $('.prospect_loading').hide();
        result      = data['prospect'];        

        var list = modal.find('ul.prospect_list');
        list.find('li').remove();
        list.parent().removeClass('open');
        if (result.length > 0) {
          list.parent().addClass('open');
          for (var i in result) {
            var obj = result[i];
            list.append('<li><a href="#" class="sel-prospect-to" data-id="'+obj['id']+'">'+obj['id']+' : '+obj['title']+'</a></li>');
          }

          $('.sel-prospect-to').off();
          $('.sel-prospect-to').on('click', function () {
            var modal      = $(this).closest('.modal');
            var prospect_id = $(this).data('id');
            var prospect     = $(this).text();

            modal.find('.prospect_id').val(prospect);
            modal.find('.prospect_id').css('border-color', '#d4d4d4');
            modal.find('input[name="prospect_id"]').val(prospect_id);
            modal.find('div.open').removeClass('open');   
          });
        }


        $('.ship_to_loading').hide();
      });
} else {
  var list = modal.find('ul.prospect_list');
  list.find('li').remove();
  list.parent().removeClass('open');
  modal.find('input[name="prospect_id"]').val('');
}
});

$('.ship_to_id').donetyping(function() {

  var modal = $(this).closest('.modal');
  var ship_to_id = modal.find('.ship_to_id').val();
  var distribution_channel = '-1';
  if(modal.find('.distribution_channel').length > 0){
    distribution_channel = modal.find('.distribution_channel').val();
  }
  param = {ship_to_id:ship_to_id, distribution_channel:distribution_channel};
  
  if (ship_to_id != "") {
    $.ajax('<?php echo site_url("__ps_action_plan/fetch_visit_project") ?>', {
      type: 'post',
      data: param,
      beforeSend: function() {
        modal.find('.ship_to_loading').show();
          // modal.find('.event_category').attr('disabled', true);
        }
      }).done(function (data) {

        // modal.find('.event_category').removeAttr('disabled');
        var result_list = JSON.parse(data);
        result      = result_list['project'];

        var list = modal.find('ul.ship_to_list');
        list.find('li').remove();
        list.parent().removeClass('open');
        if (result.length > 0) {
          list.parent().addClass('open');
          for (var i in result) {
            var obj = result[i];
            list.append('<li><a href="#" class="sel-ship-to" data-id="'+obj['contract_id']+'" data-end="'+obj['project_end']+'"> QT:'+obj['qt_id']+' | '+obj['id']+' : '+obj['name1']+'</a></li>');
          }
          fetch_slot();
        }

        modal.find('.ship_to_loading').hide();
      });
    } else {
      var list = modal.find('ul.ship_to_list');
      list.find('li').remove();
      list.parent().removeClass('open');
      modal.find('input[name="ship_to_id"]').val('');
    }
  });


$('.create_btn').on('click', function() {
  var form       = $('#modal-insert form');

  var plan_date  = form.find('input[name="plan_date"]');
  var title      = form.find('input[name="title"]');
  var check_type_ele = form.find('.project_type_radio');
  var check_type = form.find('.project_type_radio:checked');

  var pass = true;
  if (plan_date.val() == "") {
    pass = false;
    plan_date.next().find('input').css('border-color', 'red');
  }
  if (title.val() == "") {
    pass = false;
    title.css('border-color', 'red');
  }

  if (check_type_ele.length > 0 && check_type.length == 0) {
    pass = false;
    form.find('.type_alert').show();
  } else {
    var type = check_type.val();
    if (check_type_ele.length > 0 && type == 'prospect') {
      var prospect_ele = form.find('.prospect_id');
      if (prospect_ele.val() == '') {
        pass = false;
        prospect_ele.css('border-color', 'red');
      }
    } else {
      var ship_to_ele = form.find('.ship_to_id');
      if (ship_to_ele.val() == '') {
        pass = false;
        ship_to_ele.css('border-color', 'red');
      }
    }
  }

    // if (!pass) {
    //   return false
    // }

    $(this).attr('disabled', true);
    form.submit();
  });


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


<?php $this->load->view('__visitation/script/paging_js'); ?>
<?php $this->load->view('__visitation/script/delete_js'); ?>
<?php $this->load->view('__visitation/script/toggle_menu_project_js'); ?>

</body>
</html>