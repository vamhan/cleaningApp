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

    <script type="text/javascript">  

    $(document).ready(function(){

  $('#nav').removeClass('nav-xs');
  $('#nav').removeClass('nav-off-screen');
  $('#nav').addClass('nav-xs');

                   
    //=========== start : modal check no srial==============================                                             
      $("input[name='no_serial']").change(function(){     
            if($(this).is(':checked')){
              // alert('checked') 
               $('.have_serial').addClass("hide");
               $('#dummy').removeClass("hide"); 
               $('#div_assset_name').removeClass("hide"); 
               $('#untrack_name_asset').attr('data-parsley-required', true);
              // document.getElementById("untrack_name").readOnly = false;  
               var data_dummy = $('#dummy').val(); 
               //alert(data_dummy); 
               if(data_dummy=='dummy_null'){
                  alert('ผิดพลาด : ไม่มีข้อมูลในระบบ ไม่สามารถบันทึกข้อมูลได้');
                  $('.submit_save_untrack').attr('disabled', true);
               }else{
                  $('.submit_save_untrack').attr('disabled', false);                  
               }         
            }else{
              // alert('un-checked')   
              $('#dummy').addClass("hide");   
              $('.have_serial').removeClass("hide"); 
              $('#div_assset_name').addClass("hide"); 
              $('#untrack_name_asset').attr('data-parsley-required', false); 
              // document.getElementById("untrack_name").readOnly = true;                
            } 
      })   

     
      //=========== end : modal check no srial==============================   


   // #########################  disabled ###################################
    $('tr.tx-red').find('#Radios1,#Radios2,button,a').attr('disabled', true);

  // #########################  disabled ###################################
    
       //$('#remark_icon_'+serialx).addClass("hide");


    //########################### START :  change remark ########################
       var serialx = '';
       $('.btn_remark').on('click',function(){   
          serialx = $(this).attr('serial'); 
          // alert(serialx);
           
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
                 // alert(remark_area);
                $("#remark_"+serialx).val(remark_area);
                // alert($("#remark_"+serialx).val());
                //check icon data 
                if(remark_area){
                    $('#remark_icon_'+serialx).removeClass("text-muted");
                    $('#remark_icon_'+serialx).addClass("text-primary");  
                }else{
                    $('#remark_icon_'+serialx).removeClass("text-primary");
                    $('#remark_icon_'+serialx).addClass("text-muted");  
                }

                $('#modal-remark').modal('hide');
            });//end modal save remark

      });
  //########################### END :  hange remark ########################



  //############## start :  change status track asset ##################

         $("select[name='ft_status']").change(function(){ 
              var startus = $(this).val();
              var project_id =$('.project_id').val(); 
              var track_doc_id =$('.track_doc_id').val();
              //alert('status : '+startus+'project_id :'+project_id+'track :'+track_doc_id);

              window.top.location.href = '<?php echo site_url("__ps_asset_track/get_track_asset")?>'+'/'+project_id+'/'+track_doc_id+'/'+startus;

              // $.ajax("<?php echo site_url('__ps_asset_track/get_track_asset')?>", {
              //   type: 'post'                
              // });


       }); //end chanag

  //################### END :  change status track asset  ##########3


   //################### start :  submit to sap  ##########

    function submit_sap(msg,target){
                    //console.log('setup function : '+handlerId+' to : > '+target);
                    $(target).on('click',function(event){
                        var project_id = $(this).attr('porject-id');
                        var doc_id = $(this).attr('doc-id');
                        var msg_box = $(msg).val();
                        
                        if(msg_box=='คุณต้องการจะจบแผนงาน'){

                            $('#modal-sap-check').modal('show');                        
                            //alert(msg_box+' '+project_id+' '+doc_id);                    
                            //msg box modal
                            $('#modal-sap-check').find('.msg_sap_p').html(msg_box);   
                            $('#modal-sap-check').find('.confirm-submit-sap').on('click',function(){
                                // alert('confirm'); 
                                 window.top.location.href = '<?php echo site_url("__ps_asset_track/submit_to_sap")?>'+'/'+doc_id+'/'+project_id;                                            
                            })
                        }else{

                            $('#modal-sap-uncheck').modal('show'); 
                            $('#modal-sap-uncheck').find('.msg_sap_p').html(msg_box); 
                        }


                    });

                }
                //Raise dialog           

    submit_sap('#msg_sap','.submit-to-sap');

  //################### END :  submit to sap  ##########

//########################### serch table  ###########################
      // $("#search_col1_table1").keyup(function(){
      //       _this = this;
      //       // Show only matching TR, hide rest of them
      //       $.each($("#table1 tbody").find("tr .col1"), function() {
      //        // $.each($(".col1"), function() {
      //             // var data = $("#table1 tbody").find("tr").attr('data');
      //             // alert(data);
      //           //console.log($(this).text());a
      //           //console.log( $("#table1 tbody").find("tr").text());
      //           //if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
      //           //alert(_this);
      //             if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1){
      //               alert($(this));
      //                $(this).hide();
      //                //$(this).find('.col2').hide(); 
      //                //$(this).find("tr .col2").hide(); 
      //                $(this).find("tr .col2").hide(); 
      //                 // $("#table1 tbody").find("tr .col3").hide(); 
      //                 //  $("#table1 tbody").find("tr .col4").hide(); 
      //                 //  $("#table1 tbody").find("tr .col5").hide(); 
      //                 //  $("#table1 tbody").find("tr .col6").hide(); 
      //                 //  $("#table1 tbody").find("tr .col7").hide();

      //            }
      //           else{
      //                $(this).show();   
      //                //$("#table1 tbody").find("tr").show();  
      //                }           
      //       });
      //   }); 

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



//################### start : DELETE UNTRACK  ##########

    function delete_untrack(target){
                    $(target).on('click',function(event){
                        var project_id = $(this).attr('porject-id');
                        var doc_id = $(this).attr('doc-id');
                        var asset_id =  $(this).attr('asset-id');  

                        $('#modal-delete-untrack').modal('show');                        
                        //alert(project_id+' '+doc_id+' '+asset_id);    

                        $('.confirm-delete').on('click',function(event){
                          //alert('delete');
                             window.top.location.href = '<?php echo site_url("__ps_asset_track/delete_untrack")?>'+'/'+project_id+'/'+doc_id+'/'+asset_id;    
                         });//end click confirm
                    });//end click taget
                }//Raise dialog           

    delete_untrack('.submit-delete-untrack');

  //################### END :  : DELETE UNTRACK  ##########
  


//############################ START : TAB active   ##################################################
 // $("p").removeClass("intro");
 // $("p:first").addClass("intro");
var untrack ="<?php echo $this->untrack; ?>";
var tab_active = false;
//alert(untrack);
if(untrack==1){
  $(".untrack").addClass("active");
  $("#untrack").addClass("active");
}else{0;
  $(".track").addClass("active");
  $("#track").addClass("active");
}

//############################ END : TAB active   ##################################################



  //################### START : check alert save asset_track #################################
  var is_Submit = false;
  //alert(is_Submit);
  $("input[type='radio']").on('click',function(event){
      is_Submit = true;
     // alert(is_Submit);     
  });

  $(".untrack").on('click',function(event){
      if(is_Submit == true){
           //alert(is_Submit); 
          //alert('คุณต้องการบันทึกการเปลี่ยนแปลงหรือไม่');                   
          $('#modal-save-assetrack').modal('show');
           $(".save-assetrack").on('click',function(event){         
              $('.submit-save').trigger('click');
          });
      }
      // else{
      //      alert(is_Submit);
      // }                 
  });
//################### end : check alert save asset_track #################################


 //################### START : alert box Question go to fixclaim #################################
        $('.link_to_fixclaim').on('click',function(event){
            var project_id = $(this).attr('porject-id');
            var doc_id = $(this).attr('doc-id');
            var asset_id =  $(this).attr('asset-id'); 
            var asset_name =  $(this).attr('asset-name');

            if(is_Submit == true){      
                $('#modal-to-fixclaim').modal('show');                        
                //alert(project_id+' '+doc_id+' '+asset_id+' '+asset_name);   

                $('.save-assetrack').on('click',function(event){ 
                    $("input[name='fixclaim_asset_id']").val(asset_id);
                    $("input[name='fixclaim_asset_name']").val(asset_name);
                    $('.submit-save').trigger('click');
                });//end click confirm

                $('.cancel-assetrack').on('click',function(event){              
                      window.top.location.href = '<?php echo site_url("__ps_fix_claim/detail/insert")?>'+'/'+project_id+'/'+doc_id+'/'+asset_id+'/'+asset_name;    
                });//end click cancel
            }else{
                    window.top.location.href = '<?php echo site_url("__ps_fix_claim/detail/insert")?>'+'/'+project_id+'/'+doc_id+'/'+asset_id+'/'+asset_name;  
            }

        });//end click taget

 //################### END : alert box Question go to fixclaim #################################









            
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


</script>




  <?php $this->load->view('__asset_track/script/toggle_menu_project_js'); ?>

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