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

<script type="text/javascript">


$(document).ready(function(){
//############################ START : set date    ##################################################
// var project_start = '';

//   $(".btn_date_start").on('click',function(){
//       project_start = $(".project_start_date").val();
//       alert(project_start);
//       var myarr = project_start.split(".");
//       project_start = myarr[0]+'-'+myarr[1]+'-'+myarr[2]
//        alert(project_start);
//   });
$('#nav').removeClass('nav-xs');
$('#nav').removeClass('nav-off-screen');
$('#nav').addClass('nav-xs');

 $('#datetimepicker1').datetimepicker({
        pickTime: false,
        useCurrent: false,
        //minDate:min_Date,            
        //maxDate:end_date_project,  
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
        //minDate:project_start,            
        //maxDate:end_date_project,  
        icons: {
        time: "fa fa-clock-o",
        date: "fa fa-calendar",
        up: "fa fa-arrow-up",
        down: "fa fa-arrow-down"
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
}else{//0;
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
          $('.div_distribution').addClass("hide");       
      }else{
           $('.div_prospect_customer').addClass("hide");
           $('.div_sold_to').removeClass("hide"); 
           $('.div_distribution').removeClass("hide");
      }

})//end chage customer_source


// // ========start: checked  radio job_type ==============
// var job_type ='';

// $(".ZQT1").on('click',function(){  
//   job_type = $(".ZQT1").val();
//   var div_distribution = $("#distribution_channel").val();
//   alert(div_distribution);
//   //first sold to
//       $.ajax({
//               type: "GET",
//               //url: '<?php echo site_url("__ps_quotation/get_sap_sold_to/");?>'+job_type,
//               url: '<?php echo site_url("__ps_quotation/get_sap_sold_to");?>'+'/'+job_type+'/'+div_distribution ,
//               data: {},
//               dataType: "json",
//               success: function(data){
//                 ////console.log('return data is : ');
//                 ////console.log(data);                                       
//                   //alert('success');
//                   var obj = $('#sold_to');
//                         obj.empty();
//                         obj.append('<option value="all" >กรุณาเลือก</option>');
//                         for(var index in data){
//                           var i = data[index];
//                               obj.append('<option value="'+i.sold_to_id+'" >'+i.sold_to_name1+' '+i.sold_to_distribution_channel+'</option>');
//                               //obj.append('<option value="'+i.sold_to_id+'" >'+i.sold_to_name1+'  '+i.sold_to_account_group+'</option>');
//                         }//end for

//               },
//               error:function(err){
//                 //console.log('error : ');
//                 //console.log(err);
//               },
//               complete:function(){
//               }
//     })//end ajax function
//     //End : first sold to

// });//end click

// $(".ZQT2").on('click',function(){  
//   job_type = $(".ZQT2").val();
//    var div_distribution = $("#distribution_channel").val();
//    alert(div_distribution);
//   //alert(job_type);
//     //first sold to
//       $.ajax({
//               type: "GET",
//               //url: '<?php echo site_url("__ps_quotation/get_sap_sold_to/");?>'+job_type,
//                url: '<?php echo site_url("__ps_quotation/get_sap_sold_to");?>'+'/'+job_type+'/'+div_distribution ,
//               data: {},
//               dataType: "json",
//               success: function(data){
//                 ////console.log('return data is : ');
//                 ////console.log(data);                                       
//                   //alert('success');
//                   var obj = $('#sold_to');
//                         obj.empty();
//                         obj.append('<option value="all" >กรุณาเลือก</option>');
//                         for(var index in data){
//                           var i = data[index];
//                               obj.append('<option value="'+i.sold_to_id+'" >'+i.sold_to_name1+' '+i.sold_to_distribution_channel+'</option>');
//                               //obj.append('<option value="'+i.sold_to_id+'" >'+i.sold_to_name1+'  '+i.sold_to_account_group+'</option>');
//                         }//end for

//               },
//               error:function(err){
//                 //console.log('error : ');
//                 //console.log(err);
//               },
//               complete:function(){
//               }
//     })//end ajax function
//     //End : first sold to
// });//end click


// $(".ZQT3").on('click',function(){  
//   job_type = $(".ZQT3").val();
//    var div_distribution = $("#distribution_channel").val();
//   alert(div_distribution);
//   //alert(job_type);
//     //first sold to
//       $.ajax({
//               type: "GET",
//               //url: '<?php echo site_url("__ps_quotation/get_sap_sold_to/");?>'+job_type,
//               url: '<?php echo site_url("__ps_quotation/get_sap_sold_to");?>'+'/'+job_type+'/'+div_distribution ,
//               data: {},
//               dataType: "json",
//               success: function(data){
//                 ////console.log('return data is : ');
//                 ////console.log(data);                                       
//                   //alert('success');
//                   var obj = $('#sold_to');
//                         obj.empty();
//                         obj.append('<option value="all" >กรุณาเลือก</option>');
//                         for(var index in data){
//                           var i = data[index];
//                               obj.append('<option value="'+i.sold_to_id+'" >'+i.sold_to_name1+' '+i.sold_to_distribution_channel+'</option>');
//                               //obj.append('<option value="'+i.sold_to_id+'" >'+i.sold_to_name1+'  '+i.sold_to_account_group+'</option>');
//                         }//end for

//               },
//               error:function(err){
//                 //console.log('error : ');
//                 //console.log(err);
//               },
//               complete:function(){
//               }
//     })//end ajax function
//     //End : first sold to

// });//end click






$(".distribution_channel").change(function() { 
   var job_type = $(".job_type:checked").val();
   var div_distribution =  $(this).val();
//  alert(div_distribution+' '+job_type);
  $("#sold_to").attr('disabled', true);

  //alert(job_type);
    //first sold to
      $.ajax({
              type: "GET",
              //url: '<?php echo site_url("__ps_quotation/get_sap_sold_to/");?>'+job_type,
              url: '<?php echo site_url("__ps_quotation/get_sap_sold_to");?>'+'/'+job_type+'/'+div_distribution ,
              data: {},
              dataType: "json",
              success: function(data){
                ////console.log('return data is : ');
                ////console.log(data);                                       
                  //alert('success');
                  var obj = $('#sold_to');
                        obj.empty();
                        obj.append('<option value="0" >กรุณาเลือก</option>');
                  var count = 0;
                       for(var index in data){                         
                          var i = data[index];
                           if(i.sold_to_id){
                              count ++;
                              obj.append('<option value="'+i.sold_to_id+'" >'+i.sold_to_id+' '+i.sold_to_name+'</option>');
                             //obj.append('<option value="'+i.sold_to_id+'" >'+i.sold_to_name1+' '+i.sold_to_distribution_channel+'</option>');
                           }//end if
                        }//end for
                        
                        if(count==0){
                              obj.append('<option value="0" >ไม่มีข้อมูล</option>');
                        }//end if

                      $("#sold_to").attr('disabled', false);

              },
              error:function(err){
                $('#sold_to').append('<option value="0" >ไม่มีข้อมูล</option>');
                //console.log('error : ');
                //console.log(err);
              },
              complete:function(){
              }
    })//end ajax function
    //End : first sold to

});//end click


// ======== end : checked  radio job_type ==============

//$('.doc_type').hide('fade');
//$('.box_customer').hide();
// ===  onclick job_type
$(".job_type").on('click',function(){ 

$('#sold_to').val(0);
$('.distribution_channel').val(0);
$("#sold_to").attr('disabled', true);

$('.doc_type').show('fade');
$('.box_customer').show('fade');

});




// var doctype='';
// $('.box_customer').hide();
// // check doctype quotation or prospect
// $("input[name='doc_type']").on('click',function(){ 

//     if(job_type ==''){
//         alert('กรุณาเลือกประเภทงาน');
//     }

//       doctype = $(this).val();
//       //alert('doctype : '+doctype);
//       if(doctype==1){
//           $('.box_customer').hide('fade');
//          // $('.div_prospect_customer').hide('fade');
//       }else{
//           $('.box_customer').show('fade');
//       }//end else

// });//end click


$(".btn_insert").on('click',function(){ 
  
   var doc_type = $("input[name='doc_type']").val();
   //alert(doc_type);

   var customer_source = $('#modal-insert-quotation').find(".customer_source").val();
   var distribution_channel = $('#modal-insert-quotation').find('.distribution_channel').val();
   var sold_to = $('#modal-insert-quotation').find("#sold_to").val();
   var prospect_customer = $('#modal-insert-quotation').find(".prospect_customer").val();

   if(doc_type=='1'){

       if($("input[name='title']").val() != '' ){
         $('.btn_insert').hide();
         $('.btn_insert_hide').removeClass('hide');
        }

  }else{

      if(customer_source=='sold_to'){
            
            if($("input[name='title']").val() != '' && sold_to!=0 && distribution_channel!=0){
               $('.btn_insert').hide();
               $('.btn_insert_hide').removeClass('hide');
            }

      }else{

          if($("input[name='title']").val() != '' && prospect_customer!=0 ){
               $('.btn_insert').hide();
               $('.btn_insert_hide').removeClass('hide');
            }

      }
  }

});//end click




//======start :  check  selected sold to by job type ===


// $( "select[name='customer_source']" ).change(function() {
//   //alert(job_type);
//  //first sold to
//       $.ajax({
//               type: "GET",
//               //url: '<?php echo site_url("__ps_quotation/get_sap_sold_to/");?>'+job_type,
//               url: '<?php echo site_url("__ps_quotation/get_sap_sold_to");?>'+'/'+job_type ,
//               data: {},
//               dataType: "json",
//               success: function(data){
//                 ////console.log('return data is : ');
//                 ////console.log(data);                                       
//                   //alert('success');
//                   var obj = $('#sold_to');
//                         obj.empty();
//                         obj.append('<option value="all" >กรุณาเลือก</option>');
//                         for(var index in data){
//                           var i = data[index];
//                               obj.append('<option value="'+i.sold_to_id+'" >'+i.sold_to_name1+'</option>');
//                               //obj.append('<option value="'+i.sold_to_id+'" >'+i.sold_to_name1+'  '+i.sold_to_account_group+'</option>');
//                         }//end for

//               },
//               error:function(err){
//                 //console.log('error : ');
//                 //console.log(err);
//               },
//               complete:function(){
//               }
//     })//end ajax function
//     //End : first sold to

// });//end change



//======start :  check  selected sold to by job type ===



//############################ END :  modal  change  customer_source ##################################################



})/// ================ end : document ==========

//////////////////////////////// CHECK insert Quotation :  fieldCheck_insert_qt ///////////////////////////////////
 function fieldCheck_insert_qt(){
   //alert('insert qt');
   var customer_source = $('#modal-insert-quotation').find(".customer_source").val();
   var distribution_channel = $('#modal-insert-quotation').find('.distribution_channel').val();
   var sold_to = $('#modal-insert-quotation').find("#sold_to").val();
   var prospect_customer = $('#modal-insert-quotation').find(".prospect_customer").val();

      if(customer_source=='sold_to'){
          if(distribution_channel == 0 || distribution_channel=='' ){
            $('.distribution_channel').css('border','1px solid red');         
            return false;
          }//end if

           if(sold_to == 0 || sold_to=='' ){
            $('#sold_to').css('border','1px solid red');         
            return false;
          }//end if
          

      }else{

         if(prospect_customer == 0 || prospect_customer=='' ){
            $('.prospect_customer').css('border','1px solid red');         
            return false;
          }//end if

      }



}//eind fieldcheck
//////////////////////////////// END : CHECK insert Quotation :  fieldCheck_insert_qt ///////////////////////////////////


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


  <?php $this->load->view('__quotation/script/paging_js'); ?>
  <?php $this->load->view('__quotation/script/delete_js'); ?>
  <?php $this->load->view('__quotation/script/toggle_menu_project_js'); ?>
  <?php $this->load->view('__quotation/script/select_sold_to_js'); ?>

</body>
</html>