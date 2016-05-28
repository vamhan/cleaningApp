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


 <?php   
  //get data fixclaim
   $data_date = $query_fixclaim->row_array();
   $raise_date =$data_date['raise_date'];

   $asset_no_pre =$data_date['material_no'];
   
   $plan_date =$data_date['plan_date'];
   $picup_date =$data_date['pick_up_date'];
   $finish_date =$data_date['finish_date'];
   $delivery_date =$data_date['delivery_date'];

 ?>

<?php 
   $ch_pre_id='0';
   $pre_id='0';
    $query_previouse = $this->__fix_claim_model->get_previouse_fix_id($asset_no_pre);
      if(!empty($query_previouse)){
         foreach ($query_previouse->result_array() as $data){                        
          $ch_pre_id='1';
           $pre_id = $data['id'];                                                                                          
        }//end foreach                                  
      }else{
          $ch_pre_id='0';
          $pre_id='0';
      }

?>


<script type="text/javascript">
/// ================ start :check datetimepicker ==========

$(document).ready(function(){

  $('#nav').removeClass('nav-xs');
  $('#nav').removeClass('nav-off-screen');
  $('#nav').addClass('nav-xs');


 //################### start :  check previouse  ##########
 var ch_pre_id = "<?php echo $ch_pre_id;?>";  
 var pre_id = "<?php echo $pre_id;?>";    
 var click_pre_id = 0;
 var check_previouse = $('.check_previouse_id').val();

 $('.check_previouse_id').on('click',function(event){ 
  
  if(check_previouse==0){
       if(click_pre_id==0){ 
          if(ch_pre_id =='1'){
              $('.previouse').val(pre_id); 
               click_pre_id=1;
          }else{
                alert('ไม่มีข้อมูลใบแจ้งซ๋อมก่อนหน้า');
          }  
          click_pre_id=1;

        }else{
           $('.previouse').val(' '); 
           // $(this).attr('placeholder').val('ไม่มีข้อมูลใบแจ้งซ๋อมก่อนหน้า');
          click_pre_id=0;
        }
}else{
     if(click_pre_id==0){ 

           $('.previouse').val(' '); 
           //$(this).attr('placeholder').val('ไม่มีข้อมูลใบแจ้งซ๋อมก่อนหน้า');          
          click_pre_id=1;
         
        }else{         

          if(ch_pre_id =='1'){
              $('.previouse').val(pre_id); 
               click_pre_id=1;
          }else{
                alert('ไม่มีข้อมูลใบแจ้งซ๋อมก่อนหน้า');
          }  
          click_pre_id=0;

        }
}

});//end onclick

//################ check previouse insert ###################

  $('.previouse_insert_id').on('click',function(){
        var asset_id =  $("input[name='serial']").val();
        var obj = $('.previouse_insert');
       // alert(asset_id);
    
      
        $.ajax({
              type: "GET",
              url: '<?php echo site_url("__ps_fix_claim/get_previouse_fix_id/");?>'+'/'+asset_id ,
              data: {},
              dataType: "json",
              success: function(data){        
                  data = data[0]; 
                  if(data.id){          
                    obj.val(data.id);
                  }else{
                    alert('ไม่มีข้อมูล');
                    $(".previouse_insert_id").removeAttr("checked");
                  }//end else
                
                },
              error:function(err){
                  alert('ผิดพลาด : กรุณาใส่รหัสเครื่องซ๋อม');
                  $(".previouse_insert_id").removeAttr("checked");
              },  
              complete:function(){
              }
            })//end ajax function
    
})//end : on click change


//################### end : check previouse  ##########

    var dateToday = "<?php echo date('Y-m-d')?>";    
    var raise_date =  $("input[name='raise_date']").val();//"<?php echo $raise_date; ?>";   
    var finish_date = $("input[name='finish_date']").val();//"<?php echo $finish_date; ?>";
    var picup_date =  $("input[name='pick_up_date']").val();//"<?php echo $picup_date; ?>";
   
    var minpicker3 = raise_date;
    var minpicker4 = raise_date;

    if(finish_date!='0000-00-00'){
      minpicker3 = finish_date;
    }
    
    if(picup_date!='0000-00-00'){
      minpicker4 = picup_date;
    }
    //alert(dateToday+'//'+raise_date+'//'+finish_date+'//'+picup_date+'//'+minpicker3+'//'+minpicker4);
    
     // $('.btn_datetimepicker3').on('click',function(event){ 
      //     var input_finish = $("input[name='finish_date']").val();
      //     if(!input_finish){
      //     //if(finish_date =='0000-00-00'){
      //          //$('[data-cms-visible="view"]').attr('disabled', 'disabled');
      //          alert('กรุณากรอกข้อมูลวันที่ซ่อมเสร็จ');
      //     }            
      // });


     $('#datetimepicker1').datetimepicker({
            pickTime: false,
            minDate:dateToday,
            icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
          }
        });

      $('#datetimepicker2').datetimepicker({
            pickTime: false,
            useCurrent: false,
            minDate:minpicker4,
            icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
          }
        });

      //check finish
  
      $('#datetimepicker3').datetimepicker({
            pickTime: false,
            useCurrent: false,
            minDate:minpicker3,
            icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
          }
      });

   

       $('#datetimepicker4').datetimepicker({
            pickTime: false,
            useCurrent: false,
            //minDate:minpicker4,
            minDate:raise_date,  
            icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
          }
        });

        $('#datetimepicker5').datetimepicker({
            pickTime: false, 
            useCurrent: false,
            minDate:raise_date,
            //minDate:raise_date,            
            icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
          }
        });

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

<script type="text/javascript">  

$(document).ready(function(){
       


function defill(msg,noise){
  if(msg == '' || msg == undefined || msg == null)return msg;
  var index = 0;
  while( msg[index] == noise ){
    if(msg[index]!=noise)
      break;//stop finding index
    else
      index++;
  }//end while

return msg.substring(index);
}//end function     

 //################### start :  submit select sirail asset  ##########

    function select_asset(target){
                    

                    //console.log('setup function : '+handlerId+' to : > '+target);
                    $(target).on('click',function(event){                                              

                      $('#modal-select-asset').modal('show');  
                      $('.radio_asset').on('click',function(){ 
                          var asset_no = $(this).attr('asset_no');
                          var asset_name = $(this).attr('asset_name');
                          //alert(asset_no);
                          // var sh_asset_no = parseInt(asset_no, 10); 
                          var sh_asset_no = defill(asset_no, '0'); 
                        
                          $('.select-asset-save').on('click',function(){ 
                            $("input[name='serial']").val(asset_no);
                            $("#sh_serial").val(sh_asset_no);
                            $("input[name='asset_name']").val(asset_name);
                            $('#modal-select-asset').modal('hide');

                              //chabe prevouse_id
                               $('.previouse_insert').val('');
                               $(".previouse_insert_id").removeAttr("checked");

                          })//end : on click save
                      })    


                    });

                }
                //Raise dialog           

    select_asset('.select_asset_id');

  //################### END : submit select sirail asset  ##########

//################### start :  fix on side  ################# 
  //var is_on_side = '';
  //var click_on_side = '';
  $('.fix_on_side').on('click',function(event){ 

  if (document.getElementById('fix_on_side').checked){
        //alert('checked');
        //$(".btn_datetimepicker2").removeAttr("disabled");
        $(".data_div_picup").addClass("hide");
        $(".data_div_delivery").addClass("hide");

        $(".btn_datetimepicker5").attr('disabled', 'disabled');
        $(".btn_datetimepicker2").attr('disabled', 'disabled');
        $(".btn_datetimepicker3").attr('disabled', 'disabled'); 
        $("input[name='plan_date']").val('');
        $("input[name='pick_up_date']").val('');
        $("input[name='finish_date']").val('');
        $("input[name='delivery_date']").val('');
        
  }else{

      //alert('dont checked');
      $(".data_div_picup").removeClass("hide");
      $(".data_div_delivery").removeClass("hide"); 

      $(".btn_datetimepicker5").attr('disabled', 'disabled');
      $(".btn_datetimepicker2").attr('disabled', 'disabled');
      $(".btn_datetimepicker3").attr('disabled', 'disabled');
      $("input[name='plan_date']").val('');
      $("input[name='pick_up_date']").val('');
      $("input[name='finish_date']").val('');
      $("input[name='delivery_date']").val('');
      // if( $("input[name='pick_up_date']").val() =='' ){
      //     alert('dis');         
      // }else{
      //     alert('don dis');
      //     $(".btn_datetimepicker5").attr('disabled', 'disabled');
      // }
      // if( $("input[name='finish_date']").val() =='' ){
      //     alert('dis');         
      // }else{
      //     alert('don dis');
      //     $(".btn_datetimepicker2").attr('disabled', 'disabled');
      // }
      // if( $("input[name='delivery_date']").val() =='' ){
      //     alert('dis');         
      // }else{
      //     alert('don dis');
      //     $(".btn_datetimepicker3").attr('disabled', 'disabled');
      // }  
   

  }//end eilse

// if(click_on_side==0){

//   //alert('checked');
    
//   // if( $("input[name='plan_date']").val() =='' ){
//   //     alert('dis');         
//   // }else{
//   //     alert('don dis');
//   //     $(".btn_datetimepicker5").attr('disabled', 'disabled');
//   // }

//   // if( $("input[name='pick_up_date']").val() =='' ){
//   //     alert('dis');         
//   // }else{
//   //     alert('don dis');
//   //     $(".btn_datetimepicker2").attr('disabled', 'disabled');
//   // }

//   // if( $("input[name='finish_date']").val() =='' ){
//   //     alert('dis');         
//   // }else{
//   //     alert('don dis');
//   //     $(".btn_datetimepicker3").attr('disabled', 'disabled');
//   // }

//      is_on_side =  $('.data_is_on_side').val();
//      //alert(is_on_side);
//      if(is_on_side==0){
//           $(".data_delivery_on_side").removeClass("hide"); 
//           $(".data_picup_on_side").removeClass("hide");
//           $(".data_div_picup").addClass("hide");
//           $(".data_div_delivery").addClass("hide"); 
               
//      }else{
//           $(".data_delivery_on_side").addClass("hide"); 
//           $(".data_picup_on_side").addClass("hide");
//           $(".data_div_picup").removeClass("hide");
//           $(".data_div_delivery").removeClass("hide");  
//      } 
//     // $("input[name='is_repair_on_side']").val(1);  
//   click_on_side =1;
// }else{

//   //alert('dont checked');

//     is_on_side =  $('.data_is_on_side').val();
//      //alert(is_on_side);
//      if(is_on_side==0){
//           $(".data_delivery_on_side").addClass("hide"); 
//           $(".data_picup_on_side").addClass("hide");
//           $(".data_div_picup").removeClass("hide");
//           $(".data_div_delivery").removeClass("hide");      
//      }else{
//           $(".data_delivery_on_side").removeClass("hide"); 
//           $(".data_picup_on_side").removeClass("hide");
//           $(".data_div_picup").addClass("hide");
//           $(".data_div_delivery").addClass("hide");              
//      } 
//      //$("input[name='is_repair_on_side']").val(0);  
//   click_on_side =0;
// }

//  // $("input[name='plan_date']").val('');
//  // $("input[name='pick_up_date']").val('');
//  // $("input[name='finish_date']").val('');
//  // $("input[name='delivery_date']").val('');

});
  

/// ========================== START : check date edit by store ======================================================


// var plan_date_db = "<?php echo $plan_date; ?>";
// var pick_up_date_db = "<?php echo $pick_up_date; ?>";
// var finish_date_db = "<?php echo $finish_date; ?>";




  //== =check datetimepicker4 plandate ===
  $('#datetimepicker4').on('change', function(e){    
       
      var planDate = $("input[name='plan_date']").val();
      //var is_repair_on_side = $('.data_is_on_side').val();
     // alert('plandate :'+planDate+'is_repair_on_side ::'+is_repair_on_side);
      if(planDate){
        if (document.getElementById('fix_on_side').checked){
            //alert('checked');
            $(".btn_datetimepicker2").removeAttr("disabled");
        }else{
            //alert('dont checked');
            $(".btn_datetimepicker5").removeAttr("disabled");
        }//end eilse
      }//end if
  });


//== =check datetimepicker5 pick_up_date ===
$('#datetimepicker5').on('change', function(e){    
    var planDate = $("input[name='plan_date']").val();
    var pick_up_date = $("input[name='pick_up_date']").val();
    //var is_repair_on_side = $('.data_is_on_side').val();
    //alert('plandate :'+planDate+'is_repair_on_side ::'+is_repair_on_side);
    if(planDate && pick_up_date){
      if (document.getElementById('fix_on_side').checked){
          //alert('checked');
          //$(".btn_datetimepicker2").removeAttr("disabled");
      }else{
            
          $(".btn_datetimepicker2").removeAttr("disabled");
      }//end eilse
    }//end if
});


//== =check datetimepicker5 pick_up_date ===
$('#datetimepicker2').on('change', function(e){    
    var planDate = $("input[name='plan_date']").val();
    var pick_up_date = $("input[name='pick_up_date']").val();
    var finish_date = $("input[name='finish_date']").val();
    //var is_repair_on_side = $('.data_is_on_side').val();
    //alert('plandate :'+planDate+'is_repair_on_side ::'+is_repair_on_side);
    if(planDate && pick_up_date && finish_date){
      if (document.getElementById('fix_on_side').checked){
          //alert('checked');
          //$(".btn_datetimepicker2").removeAttr("disabled");
      }else{
          //alert('dont checked');
          $(".btn_datetimepicker3").removeAttr("disabled");
      }//end eilse
    }//end if
});


/// ========================== END : check date edit by store ======================================================
     




  //################### end :   fix on side ###################



  //################### start :  acept_delivered  ################# 
  var check_deliver = 0;
  var date ="<?php echo date('d.m.Y')?>";
  var ch_date ="<?php echo date('Y-m-d')?>";
   $('.accept_delivered').on('click',function(event){ 
    if(check_deliver==0){ 
      //alert('check');
      $("input[name='accept_delivered']").val(ch_date);
      $(".check_deliver_date").val(date);
       check_deliver =1;
    }else{
      //alert('uncheck');
       $("input[name='accept_delivered']").val('0000-00-00');
       $(".check_deliver_date").val('');
       check_deliver =0;

    }  
  });

  //################### end :  acept_delivered  ###################

    //################### start :  acept_delivered  ################# 
  var check_abort = 0;
  var date ="<?php echo date('d.m.Y')?>";
  var ch_date ="<?php echo date('Y-m-d')?>";
   $('.accept_task_abort').on('click',function(event){ 
    if(check_abort==0){ 
      //alert('check');
      $("input[name='accept_task_abort']").val(ch_date);
      $(".check_abort_date").val(date);
       check_abort =1;
    }else{
      //alert('uncheck');
       $("input[name='accept_task_abort']").val('0000-00-00');
       $(".check_abort_date").val('');
       check_abort =0;

    }  
  });

  //################### end :  acept_delivered  ###################


   //############################TABLE##################################################
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

//############################TABLE##################################################
              
//############################START: check required date is_urgent##################################################
              var date_defulte = "<?php echo date('d.m.Y', strtotime(' +15 day')); ?>";
              var ch_require_date = $("input[name='require_date']").val();
               var ch_click_urgent = $("#date_not_default").val();
               
               if(ch_require_date == ''){
                $("input[name='require_date']").val(date_defulte); 
               }
               
               if(ch_click_urgent!=1){
                  $("#date_not_default").attr('disabled', 'disabled');
                }

                var check_defulte = 0;
               $("input[name='is_urgent']").on('click',function(event){ 

                //alert('test click'); 
                 
                  if(check_defulte==0){ 
                    //alert('check');
                     $("input[name='require_date']").val('');
                     $("#date_not_default").removeAttr("disabled");
                     //document.getElementById(date_not_default).setAttribute("disabled", false);
                     
                     check_defulte =1;
                  }else{
                    //alert('uncheck');    
                    if(ch_require_date == ''){  
                      $("input[name='require_date']").val(date_defulte);  
                    }else{
                       $("input[name='require_date']").val(ch_require_date);  
                    }
                    
                    $("#date_not_default").attr('disabled', 'disabled');
                  // document.getElementById(date_not_default).setAttribute("disabled", true); 
                     check_defulte =0;
                  }  

              });
//############################END: check required date is_urgent ##################################################


   
})// end : document

</script>

<script language="JavaScript">
//=========start : check nuber ==================

 $('#ch_number').keypress(function(event){

       if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
           event.preventDefault(); //stop character from entering input
           alert('พิมพ์เฉพาะตัวเลขเท่านั้น');
       }

   });
//=========End : check nuber ==================
    </script>

  <?php $this->load->view('__fixclaim/script/toggle_menu_project_js'); ?>

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