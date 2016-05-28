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

    <script type="text/javascript">  

    $(document).ready(function(){

  $('#nav').removeClass('nav-xs');
  $('#nav').removeClass('nav-off-screen');
  $('#nav').addClass('nav-xs');

                   
      $('.submit-to-sap').on('click', function () {
        if ($('.submit_status').val() != "check") {
          alert('Cannot submit to SAP.');
          return false;
        } else {
          $('.submit_input').val(1);
          $('.save-btn').click();
        }
      });

   // #########################  disabled ###################################
    $('tr.tx-red').find('input,button,a').attr('disabled', true);

  // #########################  disabled ###################################



    //########################### START :  hange remark ########################
       var serialx = '';
       $('.btn_remark').on('click',function(){   
          serialx = $(this).attr('serial'); 
          var ele = $(this);
          var status_icon = ele.find('.fa-circle');
          //alert(serialx);
           
          $('#modal-remark').modal('show');

          var remark = $("#remark_"+serialx).val();
          //alert(remark);         
           var remark_modal = $('#remark_area');

            if(remark!=''||remark!=null){
                remark_modal.val(remark);
            }

            //#############  modal save remark ###########
            $('#remark_save').on('click',function(){ 
               // alert(serialx);
                var remark_area = remark_modal.val();


                if (remark_area != "") {
                  status_icon.removeClass('text-muted');
                  status_icon.addClass('text-primary');
                } else {
                  status_icon.addClass('text-muted');
                  status_icon.removeClass('text-primary');
                }
                
                //alert(remark_area);
                $("#remark_"+serialx).val(remark_area);

                $('#modal-remark').modal('hide');
            });//end modal save remark

      });
  //########################### END :  hange remark ########################

  //############################ Start : Check Employee
  $('.btn_check_employee').on('click', function() {
    var doc_id = $(this).data('doc');
    var code = $(this).attr('serial');
    $.ajax("<?php echo site_url($this->page_controller.'/get_employee_info');  ?>", {
      type: 'post',
      data: 'id='+code+"&doc="+doc_id,
      beforeSend: function() {
        $('#modal-check').modal();
        $('#question_check_form .modal-title').text('Loading data...');
        $('#modal-check .loading_div').show();
        $('#modal-check .data_div').hide();
        $('#modal-check .modal-footer a, #modal-check .modal-footer button').hide();
      }
    }).done(function (data) {
      if (data.length > 0) {
        setTimeout(function() {
          var result = JSON.parse(data);

          $('#modal-check .loading_div').hide();
          $('#modal-check .modal-footer a, #modal-check .modal-footer button').show();

          $('#question_check_form #doc_id').val(result['doc_id']);
          $('#question_check_form #employee_id').val(result['employee_id']);
          $('#question_check_form .modal-title').text(result['firstname']+" "+result['lastname']);
          $('#question_check_form #emp_code').text(result['employee_id']);
          $('#question_check_form #emp_name').text(result['firstname']+" "+result['lastname']);
          $('#question_check_form #emp_course').text(result['course']);
          $('#question_check_form #emp_card').text(result['no_of_card']);
          if (result['remark'] == null) {
            result['remark'] = "";
          }
          $('#question_check_form #emp_remark').text(result['remark']);

          if (result['image_path'] == undefined || result['image_path'] == "") {
            result['image_path'] = "<?php echo site_url('assets/thumb/thumbnail-default.jpg') ?>";
          }

          $('#question_check_form input[name^="question_"]').prop('checked', false);
          $('#question_check_form textarea').val('');
          $('#question_check_form textarea').hide;

          if (result['answer'] != null) {
            for(var i in result['answer']) {
              var obj = result['answer'][i];
              $('#question_check_form input[name="question_'+i+'"][value="'+obj['answer']+'"]').prop('checked', true);
              if (obj['remark'] != "") {
                $('#question_check_form textarea[name="negative_'+i+'"]').val(obj['remark']);
                $('#question_check_form textarea[name="negative_'+i+'"]').show();
              }
            }
          }

          $('#question_check_form textarea').each(function() {
            if ($(this).val() == "") {
              $(this).hide();
            }
          });

          $('.negative_input').unbind();
          $('.negative_input').on('change', function() {
            var id = $(this).data('id');
            if($('textarea[name="negative_'+id+'"]').length > 0) {
              $('textarea[name="negative_'+id+'"]').show();
            }
          });

          $('.positive_input').unbind();
          $('.positive_input').on('change', function() {
            var id = $(this).data('id');
            if($('textarea[name="negative_'+id+'"]').length > 0) {
              $('textarea[name="negative_'+id+'"]').val('');
              $('textarea[name="negative_'+id+'"]').hide();
            }
          });

          $('#question_check_form .form-group img').attr('src', result['image']);

          $('#modal-check .data_div').show();
        }, 1000);
      }
    });

    return false;
  });
  //############################ End : Check Employee

  //############################ Start : Satisfaction Employee
  $('.btn_satisfaction_employee').on('click', function() {
    var code = $(this).attr('serial');
    var doc_id = $(this).data('doc');

    $.ajax("<?php echo site_url($this->page_controller.'/get_employee_info');  ?>", {
      type: 'post',
      data: 'id='+code+"&doc="+doc_id,
      beforeSend: function() {
        $('#modal-satisfaction').modal();
        $('#question_satisfaction_form .modal-title').text('Loading data...');
        $('#modal-satisfaction .loading_div').show();
        $('#modal-satisfaction .data_div').hide();
        $('#modal-satisfaction .modal-footer a, #modal-satisfaction .modal-footer button').hide();
      }
    }).done(function (data) {
      if (data.length > 0) {
        setTimeout(function() {

          $('#modal-satisfaction .loading_div').hide();
          $('#modal-satisfaction .modal-footer a, #modal-satisfaction .modal-footer button').show();

          var result = JSON.parse(data);

          var level = result['level'];
          if (level == 'หัวหน้างาน') {
            level = 1;
          } else {
            level = 0;
          }
          $('#question_satisfaction_form .question_list').show();
          $('#question_satisfaction_form .question_list[data-level!="'+level+'"]').hide();

          $('#question_satisfaction_form #doc_id').val(result['doc_id']);
          $('#question_satisfaction_form #employee_id').val(result['employee_id']);
          $('#question_satisfaction_form .modal-title').text(result['firstname']+" "+result['lastname']);
          $('#question_satisfaction_form textarea[name="opinion_satisfaction_answer"]').val(result['opinion_satisfaction_answer']);

          $('#question_satisfaction_form input[name^="question_"]').prop('checked', false);


          if (result['satisfaction_answer'] != null) {
            for(var i in result['satisfaction_answer']) {
              var obj = result['satisfaction_answer'][i];
              $('#question_satisfaction_form input[name="question_'+i+'"][value="'+obj['answer']+'"]').prop('checked', true);
            }
          }

          $('#modal-satisfaction .data_div').show();

        }, 1000);
      }
    });

    return false;
  });
  //############################ End : Satisfaction Employee

  $('#question_check_form').on('submit', function() {
    console.log('submit');

    var status = true;
    $('.negative_input:checked').each(function() {
      var id = $(this).data('id');
      if($('textarea[name="negative_'+id+'"]').length > 0 && $('textarea[name="negative_'+id+'"]').val() == "") {
        $('textarea[name="negative_'+id+'"]').css('border', 'solid 1px red');
        $('textarea[name="negative_'+id+'"]').unbind();
        $('textarea[name="negative_'+id+'"]').on('keyup', function() {
          if ($(this).val() != "") {
            $('textarea[name="negative_'+id+'"]').css('border', '');
          } else {
            $('textarea[name="negative_'+id+'"]').css('border', 'solid 1px red');
          }
        });
        status = false;
      }
    });
    if (!status) {
      return false;
    }

    console.log('status');

    var form = $(this);
    var emp_id = form.find('input[name="employee_id"]').val();
    var count = $('.negative_input:checked').length + $('.positive_input:checked').length;
    $.ajax(form.attr('action'), {
      type: 'post',
      data: form.serialize(),
      beforeSend: function() {
        form.find('button[type="submit"] i').removeClass('fa-save');
        form.find('button[type="submit"] i').addClass('fa-spinner');
        form.find('button[type="submit"]').prop('disabled', true);
      }
    }).done(function () {
      console.log('done');
      form.find('button[type="submit"] i').addClass('fa-save');
      form.find('button[type="submit"] i').removeClass('fa-spinner');
      form.find('button[type="submit"]').prop('disabled', false);
      $('#modal-check').modal('hide');
      if (count > 0) {
        var icon = $('.btn_check_employee[data-empid="'+emp_id+'"]').find('i.fa-circle');
        icon.removeClass('text-muted');
        icon.addClass('text-primary');
      }
    });

    return false;
  });
  

  $('#question_satisfaction_form').on('submit', function() {    
    var form = $(this);
    var emp_id = form.find('input[name="employee_id"]').val();
    var count = form.find('input[name^="question_"]:checked').length;
    if (form.find('textarea[name="opinion_satisfaction_answer"]').val() != "") {
      count = 1;
    }
    $.ajax(form.attr('action'), {
      type: 'post',
      data: form.serialize(),
      beforeSend: function() {
        form.find('button[type="submit"] i').removeClass('fa-save');
        form.find('button[type="submit"] i').addClass('fa-spinner');
        form.find('button[type="submit"]').prop('disabled', true);
      }
    }).done(function () {
      form.find('button[type="submit"] i').addClass('fa-save');
      form.find('button[type="submit"] i').removeClass('fa-spinner');
      form.find('button[type="submit"]').prop('disabled', false);
      $('#modal-satisfaction').modal('hide');
      if (count > 0) {
        var icon = $('.btn_satisfaction_employee[data-empid="'+emp_id+'"]').find('i.fa-circle');
        icon.removeClass('text-muted');
        icon.addClass('text-primary');
      }
    });

    return false;
  });


//########################### serch table  ###########################    

        $("#search_col1_table1").keyup(function(){
            _this = this;
            // Show only matching TR, hide rest of them
            $.each($("#table1 tbody").find("tr"), function() {
                console.log($(this).text());
                if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
                   $(this).hide();
                else
                     $(this).show();                
            });
        }); 

        $("#search_col2_table1").keyup(function(){
            _this = this;
            // Show only matching TR, hide rest of them
            $.each($("#table1 tbody").find("tr"), function() {
                console.log($(this).text());
                if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
                   $(this).hide();
                else
                     $(this).show();                
            });
        }); 

         $("#search_col3_table1").keyup(function(){
            _this = this;
            // Show only matching TR, hide rest of them
            $.each($("#table1 tbody").find("tr"), function() {
                console.log($(this).text());
                if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
                   $(this).hide();
                else
                     $(this).show();                
            });
        }); 

//############################
  
  $('#ft_status').on('change', function () {
    window.location = "<?php echo site_url('__ps_employee_track/detail/save/'.$this->project_id.'/'.$this->track_doc_id); ?>/"+$(this).val();
  });


            
  })// end : document
////////////////////////////////////////////////////////////////////////////////////
//############################ start : number   ##################################################
 function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
//############################ END : number ##################################################

</script>


  <?php $this->load->view('__asset_track/script/toggle_menu_project_js'); ?>

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