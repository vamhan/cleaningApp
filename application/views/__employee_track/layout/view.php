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

      <div class="modal fade" id="modal-remark">
         <!-- #### remark-->
         
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo freetext('remark');?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>              
                 

                  <div class="form-group  col-sm-12">
                     <textarea id="remark_area" name="remark_area"  style="width:500px;height:150px;" placeholder="" ></textarea>
                  </div>     
                </div>

                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>              
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->            
      </div>

    <!--Start: modal check -->
    <div class="modal fade" id="modal-check">           
      <form id="question_check_form" action='<?php echo site_url($this->page_controller.'/check_employee_track');  ?>' method="POST">
        <input type="hidden" name="id" id="emp_track_id" value="" />
        <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Loading data...</h4>
            </div>

            <div class="modal-body loading_div text-center">
              <img style="max-width: 20%;" src="http://fc07.deviantart.net/fs70/f/2011/299/d/9/simple_loading_wheel_by_candirokz1-d4e1shx.gif">
            </div>
            <div class="modal-body data_div" style="display:none;">
                <div class="row">
                  <div class="form-group col-sm-5">
                    <img style="width:100%" src="">
                  </div>
                  <div class="col-sm-7">
                    <div class="row col-sm-12 pull-right">
                      <div class="col-sm-6 bg-light dker font-bold text-center" style="padding:5px;">
                        <label class="control-label"><b><?php echo freetext('code'); ?></b></label>
                      </div>
                      <div class="col-sm-6 bg-light" style="height:33px;padding:5px;">
                        <label class="control-label" id="emp_code"></label>
                      </div>
                    </div>
                    <div class="row col-sm-12 pull-right m-t-sm">
                      <div class="col-sm-6 bg-light dker font-bold text-center" style="padding:5px;">
                        <label class="control-label"><b><?php echo freetext('employee_name'); ?></b></label>
                      </div>
                      <div class="col-sm-6 bg-light" style="height:33px;padding:5px;">
                        <label class="control-label" id="emp_name"></label>
                      </div>
                    </div>
                    <div class="row col-sm-12 pull-right m-t-sm">
                      <div class="col-sm-6 bg-light dker font-bold text-center" style="padding:5px;">
                        <label class="control-label"><b><?php echo freetext('course'); ?></b></label>
                      </div>
                      <div class="col-sm-6 bg-light" style="height:33px;padding:5px;">
                        <label class="control-label" id="emp_course"></label>
                      </div>
                    </div>
                    <div class="row col-sm-12 pull-right m-t-sm">
                      <div class="col-sm-6 bg-light dker font-bold text-center" style="padding:5px;">
                        <label class="control-label"><b><?php echo freetext('number_of_card'); ?></b></label>
                      </div>
                      <div class="col-sm-6 bg-light" style="height:33px;padding:5px;">
                        <label class="control-label"  id="emp_card"></label>
                      </div>
                    </div>
                    <div class="row col-sm-12 pull-right m-t-sm">
                      <div class="col-sm-6 bg-light dker font-bold text-center" style="padding:5px;height:74px;">
                        <label class="control-label"><b><?php echo freetext('remark'); ?></b></label>
                      </div>
                      <div class="col-sm-6 bg-light" style="padding:5px; height:74px;">
                        <label class="control-label"  id="emp_remark" ></label>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="question_list" class="row m-t-md">
                  <?php
                    if (!empty($query_question)) {
                      $count = 1;
                      foreach ($query_question as $question) {
                        $title = $question['title'];
                        $answer_set = json_decode($question['answer_set']);

                  ?>
                        <div class="form-group col-sm-12">
                           <label class="col-sm-7 control-label"><?php echo $title; ?></label>
                           <div class="col-sm-5">
                             <div class="col-sm-6"><input type="radio" name="question_<?php echo $question['id']; ?>" value="1"> <?php echo $answer_set->positive->label ?></div>
                             <div class="col-sm-6"><input type="radio" name="question_<?php echo $question['id']; ?>" value="0"> <?php echo $answer_set->negative->label ?></div>
                             <?php
                              if ($answer_set->negative->remark == "yes") {
                             ?>
                              <br>
                              <div class="m-t-sm"><textarea name="negative_<?php echo $question['id']; ?>" style="width:100%;"></textarea></div>
                             <?php
                              }
                             ?>
                            </div>
                        </div> 
                  <?php
                        $count++;
                      }
                    }
                  ?>
                </div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
              <button type="submit" class="btn btn-primary" name="save"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button> 
               <!-- <input type='hidden' name="callback_url"value="<?php //echo site_url($this->page_controller.'/listview'); ?>">
              <input type='submit' class="btn btn-primary" value="Save"> -->
                               
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </form>
    </div><!--end: modal check -->

     <!--Start: modal check -->
    <div class="modal fade" id="modal-satisfaction">           
      <form id="question_satisfaction_form" action='<?php echo site_url($this->page_controller.'/satisfaction_employee_track');  ?>' method="POST">
        <input type="hidden" name="id" id="emp_track_id" value="" />
        <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Loading data...</h4>
            </div>

            <div class="modal-body loading_div text-center">
              <img style="max-width: 20%;" src="http://fc07.deviantart.net/fs70/f/2011/299/d/9/simple_loading_wheel_by_candirokz1-d4e1shx.gif">
            </div>
            <div class="modal-body data_div">

                <div id="satisfaction_question_list" class="row m-t-md">
                  <?php
                    if (!empty($query_satisfaction_question)) {
                  ?>
                      <div class="form-group col-sm-12">
                         <label class="col-sm-6 control-label"></label>
                         <div class="col-sm-6">
                           <div class="col-sm-2">ดีมาก</div>
                           <div class="col-sm-2">ดี</div>
                           <div class="col-sm-2">ปานกลาง</div>
                           <div class="col-sm-2">พอใช้</div>
                           <div class="col-sm-2">ปรับปรุง</div>
                          </div>
                      </div>  
                  <?php
                      $count = 1;
                      foreach ($query_satisfaction_question as $question) {
                        $title = $question['title'];

                  ?>
                        <div class="form-group col-sm-12 question_list" data-level="<?php echo $question['is_for_head']; ?>">
                           <label class="col-sm-6 control-label"><?php echo $title; ?></label>
                           <div class="col-sm-6">
                             <div class="col-sm-2"><input type="radio" name="question_<?php echo $question['id']; ?>" value="5"></div>
                             <div class="col-sm-2"><input type="radio" name="question_<?php echo $question['id']; ?>" value="4"></div>
                             <div class="col-sm-2"><input type="radio" name="question_<?php echo $question['id']; ?>" value="3"></div>
                             <div class="col-sm-2"><input type="radio" name="question_<?php echo $question['id']; ?>" value="2"></div>
                             <div class="col-sm-2"><input type="radio" name="question_<?php echo $question['id']; ?>" value="1"></div>
                            </div>
                        </div> 
                  <?php
                        $count++;
                      }
                    }
                  ?>
                </div>
                
                <div>
                  <textarea name="opinion_satisfaction_answer" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
              <button type="submit" class="btn btn-primary" name="save"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button> 
               <!-- <input type='hidden' name="callback_url"value="<?php //echo site_url($this->page_controller.'/listview'); ?>">
              <input type='submit' class="btn btn-primary" value="Save"> -->
                               
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </form>
    </div><!--end: modal check -->
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


                   
    // //=========== start : modal check no srial==============================                                        
    //   $("input[name='no_serial']").change(function(){     
    //         if($(this).is(':checked')){
    //           // alert('checked') 

    //            $('#have_serial').addClass("hide");
    //            $('#dummy').removeClass("hide");         
    //            //document.getElementById("text").readOnly = true;
              
    //         }else{
    //           // alert('un-checked')   
    //           $('#dummy').addClass("hide");   
    //           $('#have_serial').removeClass("hide"); 
    //            //document.getElementById("text").readOnly = false;                
    //         } 
    //   })   
      //=========== End : modal check no srial==============================        

      // #########################  disabled ###################################
        $('.div_detail').find('input[type="radio"],button,a').attr('disabled', true);
        $('input[type="radio"],textarea').attr('disabled', true);

        $('.btn_check_employee, .btn_satisfaction_employee, .btn_remark').attr('disabled', false);
      // #########################  disabled ###################################



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
          $('#modal-check .modal-footer a').show();

          $('#question_check_form #emp_track_id').val(result['id']);
          $('#question_check_form .modal-title').text(result['firstname']+" "+result['lastname']);
          $('#question_check_form #emp_code').text(result['employee_id']);
          $('#question_check_form #emp_name').text(result['firstname']+" "+result['lastname']);
          $('#question_check_form #emp_course').text(result['course']);
          $('#question_check_form #emp_card').text(result['no_of_card']);
          if (result['remark'] == null) {
            result['remark'] = "";
          }
          $('#question_check_form #emp_remark').text(result['remark']);
          console.log(result);
          if (result['image'] == undefined || result['image'] == "") {
            result['image'] = "<?php echo site_url('assets/thumb/thumbnail-default.jpg') ?>";
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
          $('#modal-satisfaction .modal-footer a').show();
          
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

  //############## start :  change status track asset ##################

         $("select[name='ft_status']").change(function(){ 
              var status = $(this).val();
              var project_id =$('.project_id').val(); 
              var track_doc_id =$('.track_doc_id').val();
              //alert('status : '+status+'project_id :'+project_id+'track :'+track_doc_id);

              window.top.location.href = '<?php echo site_url("__ps_employee_track/get_track_employee")?>'+'/'+project_id+'/'+track_doc_id+'/'+status+"/view";

              // $.ajax("<?php echo site_url('__ps_asset_track/get_track_asset')?>", {
              //   type: 'post'                
              // });


       }); //end chanag

  //################### END :  change status track asset  ##########3
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
      });



            
    })// end : document

/////////////////////////////////////////////////////////////////////////////

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