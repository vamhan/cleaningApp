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


  <script src="<?php echo theme_js().'docxtemplater/build/docxgen.js';?>"></script>
  <script src="<?php echo theme_js().'docxtemplater/vendor/FileSaver.min.js';?>"></script>
  <script src="<?php echo theme_js().'docxtemplater/vendor/jszip-utils.js';?>"></script>
<script type="text/javascript" language="javascript"  src="<?php echo asset_url().'plugin/input_mask/jquery.mask.js';?>"></script>

  <!--
  Mandatory in IE 6, 7, 8 and 9.
  -->
  <!--[if IE]>
      <script type="text/javascript" src="<?php echo theme_js().'vendor/jszip-utils-ie.js';?>"></script>
  <![endif]-->
  
<script type="text/javascript"> 
$(document).ready(function(){
$('.mask-tel').mask('00-000-0000');
$('.mask-mobile').mask('000-000-0000');
$('.mask-time').mask('00:00');


$('#nav').removeClass('nav-xs');
$('#nav').removeClass('nav-off-screen');
$('#nav').addClass('nav-xs');
// ######################### START : disabled  view_prospect input and botton ###################################
var this_act = "<?php echo $this->act; ?>";

if(this_act=="view_prospect"){

    $('.div_detail').find('input,.btn,a,select').attr('disabled', true);
    $('.div_detail').find('.create_to_quotation').removeAttr('disabled');
    //$('.div_detail').find('.create_to_quotation').hide();

}//end if

// ######################### START : disabled  view_quotation input and button ###################################

if(this_act=="view_quotation"){

    $('.div_detail').find('input,.btn,a,select').attr('disabled', true);
    $('.btn.download_btn').removeAttr('disabled');
   

}//end if


if(this_act=="edit_prospect"){
    // var temp =  $('.div_detail').find("input[name='time']").val(); 
    // alert('temp :'+temp);

   // $('.div_detail').find('convert_to_quotation').attr('disabled', true);
   

        if( $('.div_detail').find("input[name='time']").val() != '' 
            &&  $('.div_detail').find("input[name='sold_to_name1']").val() != '' 
            &&  $('.div_detail').find("input[name='sold_to_region']").val() != ''
            &&  $('.div_detail').find("input[name='sold_to_city']").val() != '' 
            &&  $('.div_detail').find("input[name='sold_to_postal_code']").val() != ''
            &&  $('.div_detail').find("input[name='sold_to_industry']").val() != ''
           // &&  $('.div_detail').find("input[name='sold_to_business_scale']").val() != ''
           // &&  $('.div_detail').find("input[name='sold_to_tel']").val() != ''
           // &&  $('.div_detail').find("input[name='sold_to_email']").val() != ''

          ){
          //$('#sold_to_region').css('border','1px solid red'); 
          //$('#msg_sold_to_region').html('กรุณาเลือกข้อมูล');
          //alert('กรุณาเลือกข้อมูล')  
           $('.div_detail').find('.create_to_quotation').attr('disabled', false);
         
        }


}//end if









//############################ start : check compititor   ##################################################
var click_competitor = 0;
 $("input[name='is_competitor']").on('click',function(){ 

      var competitor = $(this).val();
      //alert(competitor);
       //$('.div_compectitor').attr('disabled', 'disabled'); 
       $('.div_compectitor').addClass('hide'); 
       $('.selected_compectitor').attr('disabled', true);
       $('.input_compectitor').attr('disabled', true); 


      if(click_competitor==0){
          if(competitor == 0){
            $('.have_compectitor').removeClass('hide'); 
            $("select[name='competitor_id']").attr('disabled', false); 

            $("input[name='competitor_id']").attr('disabled', true);         
            $('.no_compectitor').addClass('hide');

            // $('.have_compectitor').show();
            // $('.no_compectitor').hide();
                      
          }else{
            $('.no_compectitor').removeClass('hide');
            $("input[name='competitor_id']").attr('disabled', false);  

            $("select[name='competitor_id']").attr('disabled', true);                      
            $('.have_compectitor').addClass('hide');
             // $('.no_compectitor').show();
             // $('.have_compectitor').hide();            
          }
        click_competitor=1;
      }else{

        if(competitor == 0){
            $('.no_compectitor').removeClass('hide');
            $("input[name='competitor_id']").attr('disabled', false); 

            $("select[name='competitor_id']").attr('disabled', true);                      
            $('.have_compectitor').addClass('hide');            

            // $('.no_compectitor').show();
            // $('.have_compectitor').hide();

          }else{        
            $('.have_compectitor').removeClass('hide');
             $("select[name='competitor_id']").attr('disabled', false);

            $("input[name='competitor_id']").attr('disabled', true);
            $('.no_compectitor').addClass('hide');

            // $('.have_compectitor').show();
            // $('.no_compectitor').hide();                
          }


        click_competitor=0;
      }


 });

//############################ END : check compititor     ##################################################


//############################ start : check save from     ##################################################  
$(".btn").parents('.bootstrap-filestyle').on('click',function(){ 
  
  var check_count_contract = $('#count_other_contract').val()
  //alert(check_count_contract);
  
  if(check_count_contract!=0){
    //alert('click');
    check_confirm_save()

  }// end if


});

$(".add_oter_contracts,.btn_select_sold_to,.btn_select_shipTo,.required_doc").on('click',function(){

  $("label[for='filestyle-1']").attr('disabled', true);
  $("label[for='filestyle-0']").attr('disabled', true);

  $(".btn_save_changes ").removeClass("btn-primary");
  $(".btn_save_changes ").addClass("btn-danger");

});


//  $("label[for='filestyle-1']").on('click',function(){

//    var temp_file = $(this).parents(".bootstrap-filestyle").find("input[type='text']").val();
//    alert('temp_file :'+temp_file);
//    if(temp_file!=''){
//       $(".btn_upload_other").attr('disabled', false);
//    }

// });


  $("#filestyle-1").change(function (){//$("input:file")
       var fileName = $(this).val();
      // alert(fileName);
          if(fileName!=''){
              $(".btn_upload_other").attr('disabled', false);
           }
  });

   $("#filestyle-0").change(function (){//$("input:file")
       var fileName = $(this).val();
       //alert(fileName);
          if(fileName!=''){
              $(".btn_upload_importance").attr('disabled', false);
           }
  });


  $('.customer_tab input, .customer_tab select').on('change', function () {
    //alert('HI');
     $("label[for='filestyle-1']").attr('disabled', true);
     $("label[for='filestyle-0']").attr('disabled', true);
  
     $(".btn_save_changes ").removeClass("btn-primary");
     $(".btn_save_changes ").addClass("btn-danger");
    

  });


//############################ END :  check save from      ##################################################








})// end : document


//############################ start : number   ##################################################
 function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 45 || charCode > 57))//48
            return false;

         return true;
      }
//############################ END : number ##################################################



//############################ start : number   ##################################################
 function isNumberTime(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 58))
            return false;

         return true;
      }
//############################ END : number ##################################################

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



//############################ start : check_confirm_save   ##################################################
 function check_confirm_save() {
        //alert('check');
       $('#modal-confirm-save').modal('show');                        
            //alert(project_id+' '+doc_id+' '+asset_id);    

      $('.confirm-save').on('click',function(event){
           $('.btn_save_changes').click();           
       });//end click confirm

  }
//############################ END : check_confirm_save ##################################################  

 if ($('.submit_prospect').length > 0) {
    $('.submit_prospect').on('click', function() {
      $('#update_prospect_form .submit_val').val(1);
      $('#update_prospect_form').submit();
    });
 }





Number.prototype.toMoney = function(decimals, decimal_sep, thousands_sep)
{ 

  var n = this;
 
  var c = isNaN(decimals) ? 2 : Math.abs(decimals); //if decimal is zero we must take it, it means user does not want to show any decimal
  var  d = decimal_sep || '.', //if no decimal separator is passed we use the dot as default decimal separator (we MUST use a decimal separator)

   t = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep, //if you don't want to use a thousands separator you can pass empty string as thousands_sep value

   sign = (n < 0) ? '-' : '',

   //extracting the absolute value of the integer part of the number and converting to string
   i = parseInt(n = Math.abs(n).toFixed( c )) + '', 

   j = ((j = i.length) > 3) ? j % 3 : 0; 

   return sign + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : ''); 

}

function isInteger( n ) {
   return n % 1 === 0;
}

function replaceComma (text) {

  text = text.toString();
  text = text.replace(',', '');
 //alert(text);
  if (text.indexOf(',') >= 0) {
    return replaceComma(text);
  } else {
    return text;
  }
}
  
 function commaSeparateNumber(val){
    while (/(\d+)(\d{3})/.test(val.toString())){
      val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
    }
    return val;
  }



function function_price(val) { 
//alert(val);
var val = val; 
val = replaceComma(val);
if(val!=''){
    var last_index = val.substr(val.length-1);
    if (last_index == '.') {
      return true;
    }

    var last_two_index = val.substr(val.length-2);
    if (last_two_index == '.0') {
      return true;
    }

    var isint = isInteger(parseFloat(val).toFixed(2));

        // console.log('# '+val);

        if (isint) {
          val = parseFloat(val).toMoney( 0 );
        } else {
          var seperator = val.indexOf('.');
          var decimal   = val.substr(seperator+1);
          val = parseFloat(val).toMoney(decimal.length);
        }

         console.log('## '+val);
      //$(this).val(val.toString());
      return val.toString();

}//end if

}


$('.insurance,.transportation,.maximum_discount,.total_variant_price,.variant_price_per_person,.rate_job,.other_price_man,.daily_pay_rate,.overtime,.holiday,.transport_exp,.incentive,.bonus,.rate_position,.special,.input-other,.other_value,.charge_ot,.pay_sunday').on('keyup', function() {
    
var val = $(this).val();
    val = replaceComma(val);

if(val!=''){
    var last_index = val.substr(val.length-1);
    if (last_index == '.') {
      return true;
    }

    var last_two_index = val.substr(val.length-2);
    if (last_two_index == '.0') {
      return true;
    }

    var isint = isInteger(parseFloat(val).toFixed(2));

         //console.log('# '+val);

        if (isint) {
          val = parseFloat(val).toMoney( 0 );
        } else {
          var seperator = val.indexOf('.');
          var decimal   = val.substr(seperator+1);
          val = parseFloat(val).toMoney(decimal.length);
        }

        // console.log('## '+val);
      $(this).val(val.toString());

}//end if

});


 





</script>

  <?php if($this->act=='edit_quotation' || $this->act=='view_quotation'){ $this->load->view('__quotation/script/tab_active_js'); } ?>

  <?php $this->load->view('__quotation/script/select_sold_to_js'); ?> 
  <?php $this->load->view('__quotation/script/delete_js'); ?>
   
  <?php $this->load->view('__quotation/script/add_other_contract_js'); ?>
  <?php $this->load->view('__quotation/script/add_other_service_js'); ?>
  <?php $this->load->view('__quotation/script/add_chemical_and_other_js'); ?>
  <?php $this->load->view('__quotation/script/add_clearing_js'); ?>
    
  <?php $this->load->view('__quotation/script/summary_js'); ?>
  
  <?php $this->load->view('__quotation/script/function_clone_area_js'); ?>
  <?php $this->load->view('__quotation/script/function_clone_staff_js'); ?>
  <?php $this->load->view('__quotation/script/toggle_menu_project_js'); ?> 
  

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