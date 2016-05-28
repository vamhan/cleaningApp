


<?php // == start : query job_type ==== 
if( $this->act =='edit_quotation' ||  $this->act =='view_quotation' ){

  $data_quotation_tab = $query_quotation->row_array();
   if(!empty($data_quotation_tab)){      
       $job_type_tab  = $data_quotation_tab['job_type'];
       $industry_tab  = $data_quotation_tab['ship_to_industry'];
       $ship_to_id_tab  = $data_quotation_tab['ship_to_id'];
       $acc_gr  = $data_quotation_tab['account_group'];
       //$industry ='Z001';
    }else{
      $job_type_tab ='';
      $industry_tab ='';
      $ship_to_id_tab='';
      $acc_gr ='';
    }

   
// == End : query job_type ====

//TODO :: set disabled TAB ====
  $disabled_area = 0;

  if( empty($industry_tab)||$industry_tab==' ' ||  $ship_to_id_tab==' ' || empty($ship_to_id_tab)){// || $industry_tab == 0 ||  $ship_to_id_tab=='' || $ship_to_id_tab==0

     $disabled_area = 1;
  }

 
// === disbled cilck chemical , staff =====
  $temp_area = $get_area->row_array();
   if(!empty($temp_area)){  
        $temp_area =1;
   }else{
       $temp_area =0;
   }//end else

// === disbled cilck clearing =====
  $temp_area_clear_job = $get_area->row_array();
   if(!empty($temp_area_clear_job)){  
       foreach($get_area->result_array() as $value){
          if($value['is_on_clearjob']==1){
           $temp_area_clear_job =1;
           break;
         }else{
             $temp_area_clear_job =0;
         }//end else
       }//end foreach       
   }else{
       $temp_area_clear_job =0;
   }//end else

}//end edit_quotation




//}//end edit_quotation


?>

<script type="text/javascript">
$(document).ready(function(){

var job_type_tab ="<?php echo $job_type_tab; ?>";
var acc_gr ="<?php echo $acc_gr; ?>";
//alert(job_type_tab);
 // var  a ="<?php echo $ship_to_id_tab; ?>";
 // var  b = "<?php echo $industry_tab; ?>";
//alert("ship_to_id ::"+a+"|| industry ::"+b);
//############################ START : TAB active   ##################################################
 // $("p").removeClass("intro");
 // $("p:first").addClass("intro");
var tab ="<?php echo $this->tab_qt; ?>";
//var tab_active = false;
//alert(untrack);

 //alert('tab :'+tab);

if(tab==1){
  $(".tab1").addClass("active");
  $("#tab1").addClass("active");
}else if(tab==2){
  $(".tab2").addClass("active");
  $("#tab2").addClass("active");
}else if(tab==3){
  $(".tab3").addClass("active");
  $("#tab3").addClass("active");
}else if(tab==4){
  $(".tab4").addClass("active");
  $("#tab4").addClass("active");
}else if(tab==5){
  $(".tab5").addClass("active");
  $("#tab5").addClass("active");
}else if(tab==6){
  $(".tab6").addClass("active");
  $("#tab6").addClass("active");
}
else if(tab==7){
  $(".tab7").addClass("active");
  $("#tab7").addClass("active");
}



//TODO :: check click TAB2 ======
var  disabled_area = "<?php echo $disabled_area; ?>";
//alert(disabled_area);
if( disabled_area == 1){
  //     $('.tab2').find('a').bind('click', false);
  //     $('.tab2').find('a').on('click',function(event){
  //     alert('ไม่มีข้อมูลูกค้า');   
  //});  //end click
    $(".div_tab2_empty").show();
    $(".detail_body_tab2").hide();
}else{
 // $('.tab2').find('a').bind('click', true);
  $(".div_tab2_empty").hide();
  $(".detail_body_tab2").show();

}

//TODO :: check click TAB3 chemical ======
var temp_area = "<?php echo $temp_area; ?>";
//alert('temp_area :'+temp_area);
if( (temp_area == 0 && job_type_tab!='ZQT3' && acc_gr!='Z16' ) || disabled_area == 1){
  // $('.tab3').find('a').bind('click', false);
  //  $('.tab3').find('a').on('click',function(event){
  //     alert('ไม่มีข้อมูลพื้นที่');
  //  });  //end click
   $(".div_tab3_empty").show();
   $(".detail_body_tab3").hide();

}else{
  //$('.tab3').find('a').bind('click', true);
   $(".div_tab3_empty").hide();
   $(".detail_body_tab3").show();

}

//TODO :: check click TAB4 staff ======
var temp_area_staff = "<?php echo $temp_area; ?>";
//alert('temp_area :'+temp_area);
if( (temp_area_staff == 0 &&  job_type_tab!='ZQT3' && acc_gr!='Z16' ) || disabled_area == 1){
  // $('.tab4').find('a').bind('click', false);
  // $('.tab4').find('a').on('click',function(event){
  //     alert('ไม่มีข้อมูลพื้นที่');
  //  });  //end click
   $(".div_tab4_empty").show();
   $(".detail_body_tab4").hide();
}else{
 // $('.tab4').find('a').bind('click', true);
  $(".div_tab4_empty").hide();
   $(".detail_body_tab4").show();
}

//TODO :: check click TAB5 clearing_job ======
var temp_area_clear_job = "<?php echo $temp_area_clear_job; ?>";
//alert('temp_area_clear_job :'+temp_area_clear_job);
if(temp_area_clear_job == 0){
  // $('.tab5').find('a').bind('click', false);
  // $('.tab5').find('a').on('click',function(event){
  //     alert('ไม่มีข้อมูลพื้นที่งานเคลียร์');
  //  });  //end click
   $(".div_tab5_empty").show();
   $(".detail_body_tab5").hide();
}else{
  //$('.tab5').find('a').bind('click', true);
  $(".div_tab5_empty").hide();
  $(".detail_body_tab5").show();
}



//############################ END : TAB active   ##################################################


})// end document

</script>