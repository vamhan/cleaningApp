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

  <!--CSS : select2-->
  <link rel="stylesheet" href="<?php echo theme_js().'select2/select2.css'?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_js().'select2/theme.css'?>" type="text/css" />


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

   <!-- select2 -->
  <script src="<?php echo theme_js().'select2/select2.min.js'?>"></script>

   <!-- datepicker-->
   <script src="<?php echo theme_js().'moment/moment.min.js'?>"></script>
   <script src="<?php echo theme_js().'build_datepicker/bootstrap-datetimepicker.js'?>"></script>

    <script type="text/javascript">


  $('#nav').removeClass('nav-xs');
  $('#nav').removeClass('nav-off-screen');
  $('#nav').addClass('nav-xs');

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
      // if ( cat_id != 0 && permission_set[cat_id] && permission_set[cat_id]['manage'] == '1' ) {
      //   $('*[data-cms-action-hide="manage"]').hide();
      // }
    </script>

    <script type="text/javascript">  
    
    var old_val = 0;
    var key     = 0;

    function isFloat(n) {
        return n === +n && n !== (n|0);
    }

    function preventNumber(ele) {

      var regex = /[0-9]|\./;
      var regex_number  = /\d{0,13}$/;
      var regex_point   = /\d{0,13}\.$/;
      var regex_decimal = /\d{0,13}\.\d{0,3}$/;

      var eleval = ele.val();
      var val = parseFloat(eleval);
      
      if( !regex.test(key) || ( val != "" && (( isFloat(val) && !regex_decimal.test(val) ) || (!isFloat(val) && !regex_number.test(val) && !regex_point.test(val) ) ) ) ) {
        ele.val(old_val);
      }
    }

    function bindQuantity() {
      $('input[name^="quantity_"]').off();
      $('input[name^="quantity_"]').on('keypress', function() {
        old_val = $(this).val();
        var theEvent = event || window.event;
        var keyVal = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( keyVal );
      });
      $('input[name^="quantity_"]').on('keyup', function() {
        preventNumber($(this));
      });
    }

    $(document).ready(function(){
        //################### start :  submit select sirail asset  ##########

          bindQuantity();

          function remark(target){
            //console.log('setup function : '+handlerId+' to : > '+target);
            $(target).off();
            $(target).on('click',function(event){  

              var type = $(this).data('type');                                           
              var code = $(this).data('code');

              var val = "";

              if ($('input[name="remark_'+type+'_'+code+'"]').length > 0) {
                val = $('input[name="remark_'+type+'_'+code+'"]').val();
              }else if ($('input.remark_input').length > 0) {
                val = $('input.remark_input').val();
              }

              $('#modal-remark #remark_area').val(val);
              $('#modal-remark').modal('show');  
              
              $('#remark_save').off();
              $('#remark_save').on('click',function(){ 
                var data = $('#modal-remark #remark_area').val();
                if (data != "") {
                  $('.remark_icon_'+type+'_'+code).removeClass('text-muted');
                  $('.remark_icon_'+type+'_'+code).addClass('text-primary');
                } else {
                  $('.remark_icon_'+type+'_'+code).addClass('text-muted');
                  $('.remark_icon_'+type+'_'+code).removeClass('text-primary');
                }

                if ($('input[name="remark_'+type+'_'+code+'"]').length > 0) {
                  $('input[name="remark_'+type+'_'+code+'"]').val(data);
                }else if ($('input.remark_input').length > 0) {
                  $('input.remark_input').val(data);
                }

                $('#modal-remark').modal('hide');

              })//end : on click save       

            });
          }        

          remark('.remark-btn-click');

        //################### END : submit select sirail asset  ##########



        //################# set datetime ################################

       var date = new Date();
       var yesterday = date.setDate(date.getDate() - 1);
        $('#datetimepicker1').datetimepicker({
          <?php
            if ($equipment_doc['return_date'] != '0000-00-00') {
          ?>
            defaultDate: new Date("<?php echo $equipment_doc['return_date']; ?>"),
          <?php
            }
          ?>
            pickTime: false,
            minDate: yesterday,
            icons: {
              time: "fa fa-clock-o",
              date: "fa fa-calendar",
              up: "fa fa-arrow-up",
              down: "fa fa-arrow-down"
            }
        });
        
        $("#datetimepicker1").on("dp.change",function (e) {
          var dateObj = new Date(e.date);
          var month = (dateObj.getMonth()+1).toString();
          if (month.length == 1) {
            month = '0'+month;
          }
          var day = dateObj.getDate().toString();
          if (day.length == 1) {
            day = '0'+day;
          }
          var date = dateObj.getFullYear()+'-'+month+'-'+day;
          $('input.return_date').val(date);
        });


        //########################### serch table  ###########################
          $("#search_col1_chem").keyup(function(){
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

            $("#search_col2_chem").keyup(function(){
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
        // Write on keyup event of keyword input element
            $("#search_col1_machines").keyup(function(){
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#table2 tbody").find("tr"), function() {
                    console.log($(this).text());
                    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
                       $(this).hide();
                    else
                         $(this).show();                
                });
            }); 

            $("#search_col2_machines").keyup(function(){
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#table2 tbody").find("tr"), function() {
                    console.log($(this).text());
                    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
                       $(this).hide();
                    else
                         $(this).show();                
                });
            }); 

        //############################
        $("#search_col1_chemicals").keyup(function(){
            _this = this;
            // Show only matching TR, hide rest of them
            $.each($("#table3 tbody").find("tr"), function() {
                console.log($(this).text());
                if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
                   $(this).hide();
                else
                     $(this).show();                
            });
        }); 

        $("#search_col2_chemicals").keyup(function(){
            _this = this;
            // Show only matching TR, hide rest of them
            $.each($("#table3 tbody").find("tr"), function() {
                console.log($(this).text());
                if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
                   $(this).hide();
                else
                     $(this).show();                
            });
        }); 

        /////////////////////////////////
        $(".select_material").select2();

       //################### start :  select_tool  ###############
        function select_tool(target){
            $(target).on('click',function(event){   
              $('#modal-select_tool tbody').hide();

              $('#search_modal_tool_col1, #search_modal_tool_col2').val('');
              var type = $(this).data('type');

              $('.table_'+type+' tbody tr').each(function() {
                var code = $(this).attr('class');
                $('#modal-select_tool .'+type+" ."+code).hide();
              });

              $('#modal-select_tool .add-btn').data('type', type);

              $('#modal-select_tool .'+type).show();
              $('#modal-select_tool').modal('show');  
              $('.radio_tool').prop('checked', false);
              $('.radio_tool').on('click',function(){ 
                  var asset_no = $(this).attr('asset_no');
                  var asset_name = $(this).attr('asset_name');
                  //alert(asset_no);                        
                  $('.select-tool-save').on('click',function(){ 
                    $("input[name='serial_tool']").val(asset_no);
                    $("input[name='asset_name_tool']").val(asset_name);
                    $('#modal-select_tool').modal('hide');
                  })//end : on click save
              });

              $.each($("#table-modal-tool tbody").find("tr"), function() {
                  $(this).show();                
              });

              $('.table_'+type+' tbody tr').each(function() {
                var code = $(this).attr('class');
                $('#modal-select_tool .'+type+" ."+code).hide();
              }); 

            });

        }
                    //Raise dialog           

        select_tool('.add_tool');

        //################### END :  select_tool  ####################
        ///////////////////////////////////////////////////////////////////////////////////////
        $("#search_modal_tool_col1").keyup(function(){
            _this = this;
            // Show only matching TR, hide rest of them
            $.each($("#table-modal-tool tbody").find("tr"), function() {
                if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
                   $(this).hide();
                else
                     $(this).show();                
            });

            var type = $('#table-modal-tool tbody:visible').attr('class');
            $('.table_'+type+' tbody tr').each(function() {
              var code = $(this).attr('class');
              $('#modal-select_tool .'+type+" ."+code).hide();
            });   
        }); 

        $("#search_modal_tool_col2").keyup(function(){
            _this = this;
            // Show only matching TR, hide rest of them
            $.each($("#table-modal-tool tbody").find("tr"), function() {
                if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
                   $(this).hide();
                else
                     $(this).show();                
            });
            
            var type = $('#table-modal-tool tbody:visible').attr('class');
            $('.table_'+type+' tbody tr').each(function() {
              var code = $(this).attr('class');
              $('#modal-select_tool .'+type+" ."+code).hide();
            });   
        }); 

        ///////////////////////////////////////////////////////////////////////////////////////

        function deleteMaterialRow () {
          $('.del-row').off();
          $('.del-row').on('click', function() {
            var code = $(this).data('code');
            var type = $(this).data('type');

            if ($('.table_'+type).length == 0) {
              type = "asset";
            }
            
            $('.table_'+type).find('tbody').find('tr.'+code).remove();

            if ($('.table_'+type).find('tbody').find('tr').length == 0) {
              var empty = $('<tr class="empty-row"><td colspan="7">Empty</td></tr>');
              $('.table_'+type).find('tbody').append(empty);
            }
          });
        }
        deleteMaterialRow();

        $('.add-btn').on('click', function() {
          var table_type = $(this).data('type');

          var body = $('.table_'+table_type).find('tbody');

          var  selectObjList = $('#modal-select_tool input[type="checkbox"]:checked');

          if (selectObjList.length > 0) {
            selectObjList.each(function() {
              
              var selectObj = $(this);
              var  code = selectObj.val();
              var  desc = selectObj.data('desc');
              var  budget         = selectObj.data('budget');
              var  type           = selectObj.data('type');
              var  unit           = selectObj.data('unit');
              var  unit_code      = selectObj.data('unitcode');


              var disabled = '';
              var quantity ='';
              var hidden   = '';
              if (type == "Z018" || type == "Z019") {
                quantity = 1;
                disabled = ' disabled';
                hidden = '<input type="hidden" name="quantity_'+type+'_'+code+'"  value="'+quantity+'"/>';
              }
              
              var data =    '<tr class="'+code+'">'+ 
                              '<td></td>' +                                                             
                              '<td>'+code+'</td>' +
                              '<td>'+desc+'<input type="hidden" name="desc_'+type+'_'+code+'"  value="'+desc+'" /></td>' +
                              '<td><input type="text" autocomplete="off" class="form-control inline text-right" name="quantity_'+type+'_'+code+'"  value="'+quantity+'"'+disabled+' style="width:100%;font-size:1em;"/>'+hidden+'</td>' +
                              '<td>' + unit +
                                '<input type="hidden" name="unit_code_'+type+'_'+code+'"  value="'+unit_code+'">' +                      
                                '<input type="hidden" name="unit_text_'+type+'_'+code+'"  value="'+unit+'">' +                      
                              '</td>' + 
                              '<td>' +
                                '<input type="hidden" class="form-control" name="remark_'+type+'_'+code+'" value="" id="l" >' +
                                '<a  class="btn btn-default remark-btn-click" data-type="'+type+'" data-code="'+code+'" > ' +
                                  '<i class="fa fa-align-justify"></i>' +
                                  '&nbsp;' +
                                  '&nbsp;' +
                                  '<i class="fa fa-circle text-muted text-xs v-middle remark_icon_'+type+'_'+code+'"></i>' +
                                '</a>' +
                              '</td>' +    
                              '<td>' +
                                '<a class="btn btn-default del-row" data-type="'+type+'" data-code="'+code+'"> ' +
                                  '<i class="fa fa-trash-o"></i>' +
                                '</a>' +
                              '</td>' +                                                             
                            '</tr>';

              body.append(data);
            });

            body.find('.empty-row').remove();

            bindQuantity();
            deleteMaterialRow();
            remark('.remark-btn-click');

            $('#modal-select_tool').modal('hide');
          }
        });
        


    var type_id  = $('.job_type_id').data('val');

    if (type_id == "ZORZ") {
      $('.equipment_sale_order_label').find('div').text('<?php echo freetext("requisition_id_for_equipment"); ?>');
      $('.asset_sale_order_label').find('div').text('<?php echo freetext("requisition_id_for_asset"); ?>');
      $('.asset_sale_order_id').removeAttr('readonly');
    } else {
      $('.equipment_sale_order_label').find('div').text('<?php echo freetext("sale_order_id_for_equipment"); ?>');
      $('.asset_sale_order_label').find('div').text('<?php echo freetext("sale_order_id_for_asset"); ?>');
    }

    $('input.asset_sale_order_id[type="text" autocomplete="off"]').on('keyup', function() {
      $('input.asset_sale_order_id[type="hidden"]').val($(this).val());
    });

    $('.submit-to-sap').on('click', function () {
      $('.submit_input').val(1);
      $('.save-btn').click();
    });
  })// end : document

    </script>
    <?php $this->load->view('__asset_track/script/toggle_menu_project_js'); ?>

   <!-- DataTables 

<script src="<?php //echo js_url().'datatables/TableTools/js/TableTools.min.js'; ?> "></script>   
<script src="<?php //echo js_url().'datatables/FixedColumns/FixedColumns.min.js'; ?> "></script>
<script src="<?php //echo js_url().'datatables/dataTables.js';?>"></script>

 -->
    <script src="<?php echo js_url().'datatables/jquery.dataTables.js';?> "></script>
    <script src="<?php echo js_url().'datatables/dataTables.bootstrap.js'; ?> "></script>
    <script src="<?php echo js_url().'datatables/jquery.dataTables.columnFilter.js'; ?> "></script>
    
    <script src="<?php echo js_url().'dataTables.js';?>"></script>

 
  <?php if(!empty($footage_script))echo $footage_script; ?>
  
</body>
</html>