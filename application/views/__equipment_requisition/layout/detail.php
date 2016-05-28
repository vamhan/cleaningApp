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
    </script>
<?php
    
    $permission = $this->permission[$this->cat_id];

?>
    <script type="text/javascript">  
    
    var old_val = 0;
    var key     = 0;

    function isFloat(n) {
        return n === +n && n !== (n|0);
    }

    function isDouble(evt)
    {
       var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
          return false;

       return true;
    }

    function bindQuantity() {
      $('input[name^="quantity_"]').off();
      $('input[name^="quantity_"]').on('keypress', function() {
        return isDouble(event);
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
                console.log($(this).text());
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
                console.log($(this).text());
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
            $('.table_'+type).find('tbody').find('tr.'+code).remove();

            if ($('.table_'+type).find('tbody').find('tr').length == 0) {
              var empty = "";
              <?php              
                if (array_key_exists('approve', $permission)) {
              ?>
                empty = $('<tr class="empty-row"><td colspan="13">Empty</td></tr>');              
              <?php
                } else {
              ?>
                empty = $('<tr class="empty-row"><td colspan="11">Empty</td></tr>');
              
              <?php
                }
              ?>
              $('.table_'+type).find('tbody').append(empty);
            }
          });
        }
        deleteMaterialRow();

        $('.add-btn').on('click', function() {
          var type = $(this).data('type');

          var body = $('.table_'+type).find('tbody');

          var  selectObjList = $('#modal-select_tool input[type="checkbox"]:checked');
          if (selectObjList.length > 0) {

            selectObjList.each(function() {
              
              var selectObj = $(this);
              var  code = selectObj.val();
              var  desc = selectObj.data('desc');
              var  last_count     = selectObj.data('last');
              var  this_count     = selectObj.data('this');
              var  budget         = selectObj.data('budget');
              var  unit           = selectObj.data('unit');
              var  unit_code      = selectObj.data('unitcode');
              var  request        = selectObj.data('request');

              var disabled = "";
              var value = "";
              var hidden = "";
              if (request == '1') {
                disabled = "disabled";
                value = budget;
                hidden = '<input type="hidden" class="form-control" name="quantity_'+type+'_'+code+'" value="'+value+'" />'
              }
              var data =    '<tr class="'+code+'">'+ 
                              '<td></td>' +                                                             
                              '<td>'+code+'</td>' +
                              '<td>'+desc+'<input type="hidden" name="desc_'+type+'_'+code+'"  value="'+desc+'" /></td>';

              <?php
                if (array_key_exists('approve', $permission)) {
              ?>
                  data +=   '<td><input type="text" autocomplete="off" class="form-control inline text-right" disabled value="'+budget+'" style="width:60px;font-size:0.8em;"/></td>' +
                            '<td>'+unit+'</td>';
              <?php
                }
              ?>

                  data +=     '<td><input type="text" autocomplete="off" class="form-control inline text-right" disabled value="'+last_count+'" style="width:60px;font-size:0.8em;"/></td>' +
                              '<td>'+unit+'</td>' +
                              '<td><input type="text" autocomplete="off" class="form-control inline text-right" disabled value="'+this_count+'" style="width:60px;font-size:0.8em;"/></td>' +
                              '<td>'+unit+'</td>' +
                              '<td><input type="text" autocomplete="off" class="form-control inline text-right" name="quantity_'+type+'_'+code+'"  value="'+value+'" '+disabled+' style="width:65px;font-size:0.8em;"/>'+hidden+'<input type="hidden" class="form-control" name="request_'+type+'_'+code+'" value="'+request+'" /></td>' +
                              '<td>'+unit +
                              '<input type="hidden" name="unit_text_'+type+'_'+code+'" value="'+unit+'" />' +
                              '<input type="hidden" name="unit_code_'+type+'_'+code+'" value="'+unit_code+'" />' +
                              '<input type="hidden" name="budget_'+type+'_'+code+'" value="'+budget+'" />' +
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