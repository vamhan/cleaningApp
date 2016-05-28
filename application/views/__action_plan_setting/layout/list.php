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
  <link rel="stylesheet" href="<?php echo theme_js().'fuelux/fuelux.css';?>" type="text/css" />
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
  <script src="<?php echo theme_js().'fuelux/fuelux.js'?>"></script>

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



  
<?php if(!empty($footage_script))echo $footage_script; ?>


<script type="text/javascript">

//############################ start : number   ##################################################
 function isDouble(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
            return false;

         return true;
      }
//############################ END : number ##################################################

//############################ start : number   ##################################################
 function isInt(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
//############################ END : number ##################################################


$(document).ready(function(){
  // $('html, body').animate({
  //       scrollTop: $("#1210000013").offset().top
  //   }, 2000);
  // $('html, body').animate({ scrollTop: $('#1210000013').offset().top }, 'slow');
  
  $('#nav').removeClass('nav-xs');
  $('#nav').removeClass('nav-off-screen');
  $('#nav').addClass('nav-xs');

  $('.disabled_btn').on('click', function() {
    return false;
  });

  $('.datetimepicker').each(function() {
    var min_date = new Date();
    min_date.setDate(min_date.getDate() - 1);

    var end_date = new Date($(this).data('end'));
    var date     = $(this).find('input').val();

    if (date != "") {

        var day    = date.substr(0, 2);
        var month  = date.substr(3,2);
        var year   = date.substr(6);
        date = year+'-'+month+'-'+day;

        var this_month = new Date().getMonth();
        var this_year  = new Date().getFullYear();
        var plan_month = new Date(date).getMonth();
        var plan_year  = new Date(date).getFullYear();

        if ( (this_month < plan_month && this_year == plan_year) || plan_year > this_year ) {
          min_date = new Date(plan_year, plan_month, 0);
          min_date.setDate(min_date.getDate() + 1);
        }

        end_date = new Date(plan_year, plan_month +1, 0);
    }

    
    $(this).datetimepicker({
        pickTime: false,
        minDate: min_date,
        maxDate: end_date,
        useCurrent: false,
        icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
      }
    });
  });
});
</script>

<script type="text/javascript">

  function choose_employee() {

    $('.choose-employee').off();
    $('.choose-employee').on('click', function() {
      $('.radio_tool').prop('checked', false);
      $("#table-modal-tool tbody tr").show(); 
      $("#search_modal_tool_col1 option:first").prop('selected', true);
      $("#search_modal_tool_col2").val('');

      var shipto = $(this).data('shipto');
      var module = $(this).data('module');
      var index  = $(this).data('index');

      $('#modal-assign').data('shipto', shipto);
      $('#modal-assign').data('module', module);

      $('#modal-assign').modal();

      if (module == 4) {
        var emp_arr = [];
        $('input[class^="emp_id_input employee_id_'+shipto+'_4_"]').each(function() {
          emp_arr.push($(this).val());
        });        
      
        for (var i in emp_arr) {
          var id = emp_arr[i];
          $('.radio_tool[value="'+id+'"]').closest('tr').hide();
        }
      }

      $('.confirm-assign').off();
      $('.confirm-assign').on('click', function() {
        var emp_id = $('.radio_tool:checked').val();

        if (emp_id != '' && emp_id != undefined) {
          var firstname = $('.radio_tool:checked').data('firstname');
          var lastname = $('.radio_tool:checked').data('lastname');

          var shipto = $('#modal-assign').data('shipto');
          var module = $('#modal-assign').data('module');

          $('.employee_name_'+shipto+'_'+module+'_'+index).val(firstname+' '+lastname);
          $('.employee_id_'+shipto+'_'+module+'_'+index).val(emp_id);
        }

        $('#modal-assign').modal('hide');
        return false;
      });
    });
  }

  function del_visit_row () {

    $('.visit_del_emp').off();
    $('.visit_del_emp').on('click', function() {
      $(this).closest('.visitation_row').remove();
    });
  }
  function empty_member () {

    $('.empty_member').off();
    $('.empty_member').on('click', function() {
      var section = $(this).closest('.employee_section');
      section.find('.emp_id_input').val('');
    });
  }

  function bindFrequency () {

    $('.minus_freq, .plus_freq').off();

    $('.minus_freq').on('click', function() {
      var parent = $(this).closest('div');
      var input  = parent.find('input');
      var freq   = input.val();

      if (freq == "" || freq == 0) {
        input.val(0.75);
      } else if (freq > 1) {
        input.val(parseInt(freq)-1);
      } else if (freq == 1) {
        input.val(0.75);
      } else if (freq == 0.75) {
        input.val(0.5);
      } else if (freq == 0.5) {
        input.val(0.25);
      }

    });

    $('.plus_freq').on('click', function() {
      var parent = $(this).closest('div');
      var input  = parent.find('input');
      var freq   = input.val();

      if (freq == "" || freq == 0) {
        input.val(1);
      } else if (freq >= 1) {
        input.val(parseInt(freq)+1);
      } else if (freq == 0.75) {
        input.val(1);
      } else if (freq == 0.5) {
        input.val(0.75);
      } else if (freq == 0.25) {
        input.val(0.5);
      }

    });
  }

  choose_employee();
  del_visit_row();
  empty_member();
  bindFrequency();
  //Side Navigate
  $('.nav.lt li.active').parent().closest('li').addClass('active');

  $('.confirm-assign-plan').on('click', function() {
    var ele   = $(this);
    var modal = ele.closest('.modal');
    var plan_date = modal.find('.plan_date');
    var shipto = modal.data('shipto');
    var module = modal.data('module');
    var type   = modal.data('type');

    var className = 'text-muted';

    plan_date.each(function() {
      if ($(this).val() != '' && className != 'text-warning') {
        className = 'text-primary';
      } else if (className == 'text-primary' && $(this).val() == '' ) {
        className = 'text-warning';
      }
      
      var sequence   = $(this).data('sequence');
      var date   = $(this).val();
      var day    = date.substr(0, 2);
      var month  = date.substr(3,2);
      var year   = date.substr(6);

      date = year+'-'+month+'-'+day;
      if(date != '--'){
        if (type == 'clearjob') {
          var frequency = $(this).data('frequency');
          $('input[name="clearjobassign_'+shipto+'_'+module+'_'+frequency+'_'+sequence+'"]').val(date);
        } else {
          $('input[name="assign_'+shipto+'_'+module+'_'+sequence+'"]').val(date);
        }
      }
    });

    var mark = $('.mark-'+shipto+'-'+module);
    if (type == 'clearjob') {
      var frequency = modal.data('frequency');
      mark = $('.clearmark-'+shipto+'-'+module+'-'+frequency);
    }
    
    mark.removeClass('text-muted');
    mark.removeClass('text-primary');
    mark.removeClass('text-warning');
    mark.addClass(className);

    modal.modal('hide');
  });

  $("#search_modal_tool_col1").change(function(){
      _this = this;
      var search = $("#search_modal_tool_col2").val();
      // Show only matching TR, hide rest of them
      $.each($("#table-modal-tool tbody").find("tr"), function() {
          if($(_this).val() != 0 && $(this).data('dept') != $(_this).val()) {
            $(this).hide();
          } else {
            if (( (search == '') || (search != '' && $(this).text().toLowerCase().indexOf(search.toLowerCase()) > -1) )) {
              $(this).show();  
            }
          }            
      });  
  });

  $("#search_modal_tool_col2").keyup(function(){
      _this = this;
      var dept_id = $("#search_modal_tool_col1").val();
      // Show only matching TR, hide rest of them
      $.each($("#table-modal-tool tbody").find("tr"), function() {  
          if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1) {
            $(this).hide();
          } else {
            $(this).show(); 
          }
           
      });    
  }); 

  $('.submit-track').on('click', function() {

    $.ajax("<?php echo site_url($this->page_controller.'/checkPeriod');  ?>", {
      type: 'post',
      data: $('#save_track_project').serialize(),
      beforeSend: function() {
        $('.submit-track').prop('disabled', true);
      }
    }).done(function (data) {
      if (data != 1) {
        var result = JSON.parse(data);
        $('#save_track_project input[name^="assign_date"]').css('border-color', '#d9d9d9');
        for (var i in result) {
          var key = result[i];
          $('#save_track_project input[name="'+key+'"]').css('border-color', 'red');
        }
        $('.submit-track').prop('disabled', false);
      } else {
        $('#save_track_project').submit();
      }
    });

    return false;
  });

  $('.submit-untrack').on('click', function() {

    $.ajax("<?php echo site_url($this->page_controller.'/checkPeriod');  ?>", {
      type: 'post',
      data: $('#save_untrack_project').serialize(),
      beforeSend: function() {
        $('.submit-untrack').prop('disabled', true);
      }
    }).done(function (data) {
      
      if (data != 1) {
        var result = JSON.parse(data);
        $('#save_untrack_project input[name^="assign_date"]').css('border-color', '#d9d9d9');
        for (var i in result) {
          var key = result[i];
          $('#save_untrack_project input[name="'+key+'"]').css('border-color', 'red');
        }
        $('.submit-untrack').prop('disabled', false);
      } else {
        $('#save_untrack_project').submit();
      }
    });

    return false;
  });

  $('.visit_add_emp').on('click', function() {

    var row = $(this).closest('.module_row');
    var visit_row = row.find('.visitation_row:last');
    var index = parseInt(visit_row.data('index'))+1;
    var contract_id = visit_row.data('contactid');
    var module_id = visit_row.data('module');

    var row   = '<div class="wrapper-sm row m-b-xs b-b visitation_row" data-index="'+index+'" data-contactid="'+contract_id+'" data-module="'+module_id+'">'+
                  '<div class="col-sm-2">'+
                    '<a href="#" class="btn btn-xs btn-default m-l-xs visit_del_emp"><i class="fa fa-minus"></i></a>'+
                  '</div>'+
                  '<div class="row col-sm-3">'+
                      '<div class="col-sm-2 pull-right m-t-xs">'+
                        '<a href="#" class="btn btn-xs btn-default empty_member">Remove</a>'+
                      '</div>'+
                      '<div class="col-sm-10 input-group">'+
                        '<input type="hidden" class="emp_id_input employee_id_'+contract_id+'_'+module_id+'_'+index+'" name="assign_'+contract_id+'_'+module_id+'['+index+'][employee]" value="">'+
                        '<input type="text" autocomplete="off" class="form-control employee_name_'+contract_id+'_'+module_id+'_'+index+'" readonly  value="">'+
                        '<span class="input-group-btn">'+
                          '<button class="btn btn-default choose-employee" type="button" data-module="'+module_id+'" data-shipto="'+contract_id+'" data-index="'+index+'"><i class="fa fa-users"></i></button>'+
                        '</span>'+
                      '</div>'+
                  '</div>'+
                  '<div class="col-sm-5">'+                  
                    '<span style="padding-top:15px;padding-right:5px;">วางแผนความถี่</span>'+
                    '<span class="btn btn-default btn-xs minus_freq"><i class="fa fa-minus"></i></span>'+
                    '&nbsp;<input type="text" autocomplete="off" onkeypress="return false;" onkeydown="return false;" name="assign_'+contract_id+'_'+module_id+'['+index+'][period]" class="form-control inline m-l-xs m-r-xs" style="width:60px;">'+
                    '<span class="btn btn-default btn-xs plus_freq"><i class="fa fa-plus"></i></span>'+
                    '<span style="padding-left:5px;padding-top:15px;">เดือนครั้ง</span>'+
                  '</div>'+
                  '<div class="col-sm-1"><a href="#" class="btn btn-default" disabled><i class="fa fa-calendar">&nbsp;</i><i class="fa fa-circle text-danger"></i></a></div>'+
                  '<div class="col-sm-1"><a class="btn btn-default" disabled><i class="fa fa-calendar">&nbsp;</i><i class="fa fa-circle text-danger"></i></a></div>'+
                '</div>';

    visit_row.after(row);
    
    choose_employee();
    del_visit_row();
    empty_member();
    bindFrequency();

    return false;
  });

  
  $('.collapse_all').on('click', function() {

    var parent = $(this).closest('.tab-pane').attr('id');
    var status = $(this).data('status');
    if (status == 'active') {
      $('#'+parent+' .module_row').addClass('collapse');

      $('#'+parent+' .collapse_single').data('status', 'inactive');
      $('#'+parent+' .collapse_single').find('i').removeClass('fa-caret-up');
      $('#'+parent+' .collapse_single').find('i').addClass('fa-caret-down');
      $(this).data('status', 'inactive');
      $(this).find('i').removeClass('fa-caret-up');
      $(this).find('i').addClass('fa-caret-down');
    } else {
      $('#'+parent+' .module_row').removeClass('collapse');

      $('#'+parent+' .collapse_single').data('status', 'active');
      $('#'+parent+' .collapse_single').find('i').addClass('fa-caret-up');
      $('#'+parent+' .collapse_single').find('i').removeClass('fa-caret-down');
      $(this).data('status', 'active');
      $(this).find('i').addClass('fa-caret-up');
      $(this).find('i').removeClass('fa-caret-down');
    }
  });

  $('.collapse_single').on('click', function() {

    var parent = $(this).closest('.tab-pane').attr('id');
    var status = $(this).data('status');
    var target = $(this).data('target');

    if (status == 'active') {
      $('#'+parent+' tr[data-ship="'+target+'"]').addClass('collapse');
      $(this).data('status', 'inactive');
      $(this).find('i').removeClass('fa-caret-up');
      $(this).find('i').addClass('fa-caret-down');
    } else {
      $('#'+parent+' tr[data-ship="'+target+'"]').removeClass('collapse');
      $(this).data('status', 'active');
      $(this).find('i').addClass('fa-caret-up');
      $(this).find('i').removeClass('fa-caret-down');
    }

  });

</script>
 <!-- <script src="<?php //echo theme_js().'fuelux/fueludemox.js'?>"></script>
  script src="<?php //echo theme_js().'fuelux/demo.datagrid.js'?>"></script
-->

  <script src="<?php echo theme_js().'app.plugin.js';?>"></script>

  <?php $this->load->view('__projects/script/paging_js'); ?>
  <?php $this->load->view('__projects/script/delete_js'); ?>

</body>
</html>