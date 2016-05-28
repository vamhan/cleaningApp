<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}


</style>

<?php  
$this->db->select('tbt_quotation.contract_id');
$this->db->where('id', $this->quotation_id);
$query = $this->db->get('tbt_quotation');
$contract = $query->row_array();
 if (!empty($contract)) {
    $contract_id = $contract['contract_id'];
  } else {
    $contract_id = 0;
  }
?>

<div class="div_detail" style="padding-left:50px;padding-right:50px;padding-bottom:50px;">
<h4 class="page-header font-bold tx-black">
<span><i class="fa fa-leaf h5"></i> ต้นทุนค่าแรง</span>
 <?php if($contract_id!=0){ ?>
  <span class="pull-right  h7">  
  <i class="fa fa-file-text h7"></i> ไฟล์ 192.191.0.31\InterfaceSAP\<?php echo $contract_id.'_'.$this->quotation_id.'.txt'; ?> 
    <a href="http://192.191.0.20/900/psgen_2014/__ps_webservice/get_hr_quotation_file/<?php echo $this->quotation_id;  ?>" target="_blank" class="btn btn-default btn-sm "><i class="fa fa-refresh h7"></i></a>
</span>
<?php } ?>
</h4>

<?php
//=====  TODO :: set permission wage =====
$array_function_login = $this->session->userdata('function');
$temp_function_login= $array_function_login;
// echo "<pre>";
// print_r($temp_function_login);
// echo "</pre>";
$permission_view_wage =  array("MK","CR","RC", "IC", "HR", "WF","IT", "TN", "AC", "FI");// dont have ST,OP

//////////////////////// GET : total staff /////////////////////////////////////////////////

// == start : query job_type ====
  $data_quotation = $query_quotation->row_array();
   if(!empty($data_quotation)){      
       $job_type  = $data_quotation['job_type'];
       //$industry ='Z001';
    }else{
       $job_type ='';
    }
// == End : query job_type ====

//################### start : GET total_staff_quotation ##################################

$temp_quotation_staff = $query_quotation->row_array();
if(!empty($temp_quotation_staff)){ 
   foreach($query_quotation->result_array() as $value){          
          $total_staff_quotation_db  = $value['total_staff_quotation'];
       }//end foreach

}else{
   $total_staff_quotation_db =0;
}

//################### start : GET TEXTURE ##################################
$texture = array();
$temp_texture = $get_area->row_array();
if(!empty($temp_texture)){   

       foreach($get_area->result_array() as $value){          
          if (in_array( $value['texture_id'], $texture, TRUE)){                
                //echo "have";
            }else{
                //echo "nohave";
                array_push($texture,$value['texture_id']);
            }   

       }//end foreach
}//end temparea

//################### end : GET TEXTURE ##################################
$total_space = 0;//set total_space_texture
$space_of_texture = array();
foreach($texture as $a => $a_value) {      
            foreach($get_area->result_array() as $value){ 
              if($a_value == $value['texture_id']){
                    $total_space =  $total_space + $value['space'];
              }
            }//end foreach
            //set double 2
            $total_space =   number_format($total_space, 2, '.', '');

            //== set push arra space of texture ===
            $space_of_texture[$a_value] = $total_space; 

}//end foreach texture

// echo "space_of_texture_area ||";
// print_r($space_of_texture);
// echo "<br>";
///////////////////// staff //////////////////////////
$total_quantity=0;
$array_material_staff =array();
$temp_count_staff = $bapi_bomb->result_array();
if(!empty($temp_count_staff)){ 
  foreach($bapi_bomb->result_array() as $value){ 
    if($value['material_no']!='000000000000070002' && $value['mat_type']=='Z017'){  

      foreach($space_of_texture as $b => $b_value) {
        if($value['texture_id']== $b){    
          // echo "<br>//////////////material_no ".$value['material_no']."//////////////////";
          // echo '<br>space :'.$b_value;
          // echo '<br>volumn :'.$value['volumn'];
          // echo '<br>quantity :'.$value['quantity'];
          $space =$b_value;
          $volumn=$value['volumn'];
          $quantity=$value['quantity'];
          //== calculate total_quantity==
          $total_quantity = calculate_quantity_staff($space,$volumn,$quantity);
          //== pusg array_material_staff
          $array_material_staff[$b] = $total_quantity; 

            }//enf if textur area = texture bomb

      }//end foreach space_of_texture
    }//end if check 
  }//end foreach
}//enf if

// echo "array_material_staff ||";
// print_r($array_material_staff);
// echo "<br>";

//////////////// final is staff_total_all ///////////////
$staff_total_all =0;
foreach($array_material_staff as $c => $c_value) { 
  $staff_total_all = $staff_total_all+$c_value;
}//end foreach
//echo '<br>staff_total_all :'.$staff_total_all;


///////////////////////////////////////////////////////////////////
//======================  CALCULATE ==============================
///////////////////////////////////////////////////////////////////

   function calculate_quantity_staff($space,$volumn,$quantity){
    //echo '<br>'.$space.' '.$volumn.' '.$quantity.'<br>';
        $total_quantity = ($space/$volumn)*$quantity;
        $total_quantity = number_format($total_quantity, 2, '.', '');
        $total_quantity = ceil( $total_quantity);
        
        //check $total_quantity < 1
        if($total_quantity<1){
          $total_quantity = 1;
        }//end if

        return $total_quantity;

    }//end function
///////////////////////////////////////////////////////////////////////////
 ?>


<!-- //=== START : GET MAN GROUP ============================================= -->
<?php

$count_man_group =0;
$group_array = array();// buiding id for qt
$count_array_group =0;
$temp_staff = $get_staff->row_array();

if(!empty($temp_staff)){ 

   foreach($get_staff->result_array() as $value){ 
            
          if (in_array( $value['man_group_id'], $group_array, TRUE)){                
                //echo "have";
            }else{
                //echo "nohave";
                array_push($group_array,$value['man_group_id']);
            }   

       }//end foreach

       $count_array_group = count($group_array);
       //==== count group ======
        if($count_array_group != 0){
            $count_man_group = $count_array_group;
        }else{
             $count_man_group = 0;
        }

}else{
  $count_man_group = 0;
}//end if

////////////////////////START :: div empty staff ////////////////////
if(empty($group_array)){
?>

<!-- stat : div empty -->
<div class="col-sm-12 no-padd" style="padding-top:30px;">
  <section class="panel panel-default">
    <header class="panel-heading bg-danger lt no-border">
      <div class="clearfix">
        <span class="pull-left thumb-sm tx-white"><i class="fa fa-warning fa-3x "></i></span>
        <div class="clear margin-left-medium " style="padding-left:25px;">
          <div class="h3 m-t-xs m-b-xs text-white">
            ผิดพลาด : ไม่มีข้อมูล
          </div>
          <small class="text-muted h5">ใบสัญญายังไม่มีข้อมูล</small>
        </div>                
      </div>
    </header>
    <ul class="list-group no-radius alt">
       <li class="list-group-item" href="#">
        <i class="fa fa-circle icon-muted"></i> 
          <span class="h5 margin-left-medium">ไม่มีข้อมูล ต้นทุนค่าแรง</span>
      </li> 
    </ul>
  </section>
</div>
<!-- end : div empty -->

<?php }else{ ?>
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!--############################################ Start :GET STAFF  ##########################################################################-->
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<div class="detail_body_tab4">
<form role="form"  action="<?php echo site_url('__ps_quotation/update_quotation_staff/'.$this->quotation_id) ?>" method="POST" id="form_clone_staff"> 
<input type="hidden" name="first_conut_group" id="first_conut_group" class="form-control" value="<?php echo 0; ?>">
<input type="hidden" name="job_type" id="job_type" class="form-control" value="<?php echo $job_type; ?>">
<input type="hidden" name="count_add_group" id="count_add_group" class="form-control" value="<?php if($count_man_group==0){ echo 1; }else{ echo $count_man_group;} ?>">



 <!-- start : input group -->
<div class="col-sm-12 no-padd">                                           
  <div class="col-md-4 pull-left">
      <div class="input-group m-b">
        <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('#staff').'</font></div>'; //echo  $total_staff_quotation_db; ?></span>
        <input type="text" autocomplete="off" onkeypress="return isInt(event)" class="form-control qt_staff"  name="qt_staff"  value="<?php  if($total_staff_quotation_db!=0){ echo $total_staff_quotation_db; }else{  echo $staff_total_all; }   ?>">                  
      </div>
   </div>                       


<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>

  <div class="col-sm-3 pull-right no-padd">
    <div class="input-group m-b">                                                  
         <span class="input-group-addon">
          <font class="pull-left"><?php  echo freetext('total_all'); ?></font>
         </span> 
<?php         
// $total_all_page =0;
// $temp_total_all =$get_staff->result_array();
// if(!empty($temp_total_all)){
//  foreach($get_staff->result_array() as $value){ 
//    $total_all_page = $total_all_page + $value['subtotal'];
//  }//end foreach
// }else{
//  $total_all_page =0;
// }//end else

$this->db->select_sum('subtotal');
$this->db->where('quotation_id', $this->quotation_id);
$query = $this->db->get('tbt_man_group');
$temp_total_all = $query->row_array();  
if (!empty($temp_total_all) && !empty($temp_total_all['subtotal'])) {
  $total_all_page = $temp_total_all['subtotal'];
} else {
  $total_all_page = 0;
}


?>
         <input type="text" autocomplete="off" readonly name="qt_total" class="form-control text-right qt_total" value="<?php echo $total_all_page; ?>">
         <span class="input-group-addon"><?php  echo freetext('THB'); ?></span>
    </div>
  </div>
<?php
 break;
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>

</div>
<!-- end : input group -->  

<!--########################### Start :div Group staff #################################-->
<div class="col-sm-12 no-padd div-group-staff"> 


<?php 

$fix_mat_other = array('000000000000030023','000000000000030025','000000000000030031','000000000000030037','000000000000030038','000000000000030040','000000000000030041','000000000000030032','000000000000030039','000000000000030028');
$sub_gruop_array =array();
$exist_mat = array();
$count_sub_group = 0;
$temp_count_group =0;//no group
//print_r($group_array);//bu_id->bu_name
////////////////////////END :: div empty staff ////////////////////

foreach($group_array as $a) {
  $temp_count_group++;
  // echo "<br>############################# GROUP ID :".$a." ||GROUP NO : ".$temp_count_group." ######################## <br>";
  // echo "group-ID =" . $a ."| gr-no : " .$temp_count_group;

  foreach($get_staff->result_array() as $value){ 
    if($a == $value['man_group_id']){

         $group_title =  $value['group_title'];
         $total_man_staff   =  $value['group_total'];
         $group_total =  $value['group_total'];
         $overtime =  $value['overtime'];
         $overtime_id =  $value['overtime_id'];
         $incentive =  $value['incentive'];
         $incentive_id =  $value['incentive_id'];
         $transport_exp =  $value['transport_exp'];
         $transport_exp_id =  $value['transport_exp_id'];
         $daily_pay_rate =  $value['daily_pay_rate'];
         $daily_pay_rate_id =  $value['daily_pay_rate_id'];
         $daily_pay_rate_type =  $value['daily_pay_rate_type'];        
         $holiday =  $value['holiday'];
         $holiday_id =  $value['holiday_id'];
         $bonus =  $value['bonus'];
         $bonus_id =  $value['bonus_id'];

         $rate_position =  $value['rate_position'];
         $rate_position_id =  $value['rate_position_id'];
         $special =  $value['special'];
         $special_id =  $value['special_id'];

         $other_type1_id =  $value['other_type1_id'];
         $other_type2_id =  $value['other_type2_id'];
         $other_type3_id =  $value['other_type3_id'];
         $other_type4_id =  $value['other_type4_id'];
         $other_type5_id =  $value['other_type5_id'];
         $other_type6_id =  $value['other_type6_id'];
         $other_type7_id =  $value['other_type7_id'];
         $other_type8_id =  $value['other_type8_id'];
         $other_type9_id =  $value['other_type9_id'];
         $other_type10_id =  $value['other_type10_id'];
         $other_type1 =  $value['other_type1'];
         $other_type2 =  $value['other_type2'];
         $other_type3 =  $value['other_type3'];
         $other_type4 =  $value['other_type4'];
         $other_type5 =  $value['other_type5'];
         $other_type6 =  $value['other_type6'];
         $other_type7 =  $value['other_type7'];
         $other_type8 =  $value['other_type8'];
         $other_type9 =  $value['other_type9'];
         $other_type10 =  $value['other_type10'];
         $other_title =  $value['other_title'];
         $other_value =  $value['other_value'];
         $other_id =  $value['other_id'];

         $is_auto_ot =  $value['is_auto_ot'];
         //$is_auto_position =  $value['is_auto_position'];
         $is_auto_spacial =  $value['is_auto_spacial'];
         $is_auto_transport =  $value['is_auto_transport'];
         

         $waege =  $value['wage'];
         $benefit =  $value['benefit'];
         $wage_benefit =  $value['wage_benefit'];
         $subtotal =  $value['subtotal'];


         $level_staff = $value['employee_level_id'];
         $position = $value['position'];
         $uniform_id = $value['uniform_id'];    



         $count_other =0;

         if(!empty($other_type1)){
          array_push($exist_mat, $other_type1_id);
          $count_other++;
         }
         if(!empty($other_type2)){
          array_push($exist_mat, $other_type2_id);
          $count_other++;
         }
         if(!empty($other_type3)){
          array_push($exist_mat, $other_type3_id);
          $count_other++;
         }
          if(!empty($other_type4)){
            array_push($exist_mat, $other_type4_id);
          $count_other++;
         }

         if(!empty($other_type5)){
          array_push($exist_mat, $other_type5_id);
          $count_other++;
         }
         if(!empty($other_type6)){
          array_push($exist_mat, $other_type6_id);
          $count_other++;      
         }
        
         if(!empty($other_type7)){
          array_push($exist_mat, $other_type7_id);
          $count_other++;
         }
         if(!empty($other_type8)){
          array_push($exist_mat, $other_type8_id);
          $count_other++;
         }
         if(!empty($other_type9)){
          array_push($exist_mat, $other_type9_id);
          $count_other++;
         }
         if(!empty($other_type10)){
          array_push($exist_mat, $other_type10_id);
          $count_other++;
         }

    }//end if
  }//end foreach

   // echo "<br>";
   // echo "group_title : ".$group_title."<br>";
   // echo "total_man_staff : ".$total_man_staff."<br>";
   // echo "overtime : ".$overtime."<br>";
   // echo "incentive : ".$incentive."<br>";
   // echo "transport_exp : ".$transport_exp."<br>";
   // echo "daily_pay_rate : ".$daily_pay_rate."<br>";
   // echo "holiday : ".$holiday."<br>";
   // echo "level_staff : ".$level_staff."<br>";
   // echo "other_type1 : ".$other_type1."<br>";
   // echo "other_type2 : ".$other_type2."<br>";
   // echo "other_type3 : ".$other_type3."<br>";
   // echo "other_type4 : ".$other_type4."<br>";
   // echo "other_type5 : ".$other_type5."<br>";
   // echo "other_type6 : ".$other_type6."<br>";
   // echo "other_type7 : ".$other_type7."<br>";
   // echo "other_type8 : ".$other_type8."<br>";
   // echo "other_type9 : ".$other_type9."<br>";
   // echo "other_type10 : ".$other_type10."<br>";
   // echo "other_title : ".$other_title."<br>";
   // echo "other_value : ".$other_value."<br>";
   // echo "**count_other : ".$count_other."<br>";
   // echo "subtotal : ".$subtotal."<br>";
 
    $temp_count_sub_group =0;
    $sub_gruop_array =array();
    $count_subgroup_of_group = 0;

    foreach($get_staff->result_array() as $value){
            if($value['man_group_id'] == $a){
                  if (in_array( $value['sub_group_id'], $sub_gruop_array, TRUE)){                
                      //echo "have";
                  }else{
                      //echo "nohave";
                      array_push($sub_gruop_array,$value['sub_group_id']);
                  }   
                }
                $count_subgroup_of_group= count($sub_gruop_array);
      }//end foreach push sub group

      //echo "**count_subgroup_of_group =".$count_subgroup_of_group."<br>";  

?>

<!--################################### start :Group staff ###################################-->
<section class="back-color-blue-w panel panel-default clone_group " id="clone_group_<?php echo $temp_count_group; ?>"> 
<div class="panel-body"> 
<div class="form-group">



    <!-- start : input group -->
          <div class="col-sm-12 no-padd">   

               <div class="col-md-1 pull-left">
                 <button class="btn btn-default coppy_group" type="button"><i class="fa fa-copy"></i><?php echo ' '.freetext('copy');?></button>
             </div>

              <div class="col-md-7 pull-left ">    
              <div class="input-group m-b">
                  <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('benefits').' : '.'</font></div>'; ?></span>
                  <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" class="form-control group_title" name="group_title_gr<?php echo $temp_count_group; ?>" value="<?php echo $group_title; ?>" >                  
                </div>
             </div>    

             <div class="col-sm-3 pull-left no-padd">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon">
                <font class="pull-left"><?php  echo freetext('total_man'); ?></font>
               </span> 
               <input data-parsley-min="1" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off"  onkeypress="return isInt(event)"  class="form-control total_man" name="total_man_gr<?php echo $temp_count_group; ?>" value="<?php echo $total_man_staff; ?>">
               <!-- onkeypress="return isInt(event)" -->
                <span class="input-group-addon"><?php  echo freetext('man'); ?></span>
          </div>
        </div>

        <div class="col-md-1 pull-left del_div">
          <?php if ($temp_count_group > 1) {  ?>
                 <button class="btn btn-default delete_group  pull-right" type="button"><i class="fa fa-trash-o h4"></i></button>
              <?php } ?>
             </div>

          </div>
        <!-- end : input group -->   


        <!-- start : input group -->
          <div class="col-sm-12 no-padd from-gr-height"> 

              <div class="col-sm-4">
                  <div class="input-group m-b">                                                  
                     <span class="input-group-addon">
                      <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('level_staff').'</font></div>'; ?>
                     </span> 
                   <select class="form-control level_staff"  data-parsley-required="true" name="level_staff_gr<?php echo $temp_count_group; ?>" >
                          <option value=' '>กรุณาเลือก</option>
                            <?php 
                                $temp_bapi_level_staff= $bapi_level_staff->result_array();
                                if(!empty($temp_bapi_level_staff)){
                                foreach($bapi_level_staff->result_array() as $value){ 
                             ?>
                                 <option <?php if( $value['id'] == $level_staff ){ echo "selected";} ?>  value='<?php echo $value['id'] ?>'><?php echo $value['description']; ?></option> 
                            <?php 
                                }//end foreach
                               }else{ ?>
                                 <option value='0'>ไม่มีข้อมูล</option> 
                            <?php } ?>
                       </select>
                  </div>
              </div>


              <div class="col-sm-4">
                  <div class="input-group m-b">                                                  
                     <span class="input-group-addon">
                      <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('position').'</font></div>'; ?>
                     </span> 
                   <select class="form-control position"  data-parsley-required="true" name="position_gr<?php echo $temp_count_group; ?>" >
                          <option value=' '>กรุณาเลือก</option>
                            <?php 
                                $temp_bapi_position= $bapi_position->result_array();
                                if(!empty($temp_bapi_position)){
                                foreach($bapi_position->result_array() as $value){ 
                             ?>
                                 <option <?php if( $value['id'] == $position ){ echo "selected";} ?>  value='<?php echo $value['id'] ?>'><?php echo $value['title']; ?></option> 
                            <?php 
                                }//end foreach
                               }else{ ?>
                                 <option value='0'>ไม่มีข้อมูล</option> 
                            <?php } ?>
                       </select>
                  </div>
              </div>

               <div class="col-sm-4">
                  <div class="input-group m-b">                                                  
                     <span class="input-group-addon">
                      <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('uniform').'</font></div>'; ?>
                     </span> 
                   <select   <?php if($job_type=='ZQT1'){ echo"data-parsley-required='true' data-parsley-error-message='".freetext('required_msg')."' "; } ?>  class="form-control uniform"  name="uniform_gr<?php echo $temp_count_group; ?>" >
                      <option value=' '>กรุณาเลือก</option>
                        <?php 
                            $temp_bapi_uniform= $bapi_unifrom->result_array();
                            if(!empty($temp_bapi_uniform)){
                            foreach($bapi_unifrom->result_array() as $value){ 
                         ?>
                             <option <?php if( $value['material_no'] == $uniform_id ){ echo "selected";} ?>  value='<?php echo $value['material_no'] ?>'><?php echo $value['material_description']; ?></option> 
                        <?php 
                            }//end foreach
                           }else{ ?>
                             <option value='0'>ไม่มีข้อมูล</option> 
                        <?php } ?>
                   </select>
                  </div>
              </div>            

          </div>
        <!-- end : input group --> 


          <!-- start : input group -->
          <div class="col-sm-12 no-padd from-gr-height"> 
              <div class="col-sm-4 ">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon" style="width:180px;">    
                      <?php echo '<span ><font class="pull-left">'.freetext('daily_pay_rate').' :</font></span>'; ?>
                      <span class="">
                          <label>
                            <input  <?php if($daily_pay_rate_type=='day'){ echo "checked='checked'"; } ?>  type="radio" name="daily_pay_rate_type_gr<?php echo $temp_count_group; ?>" class="radio_pay_rate rate_day" id="rate_day_<?php echo $temp_count_group; ?>" value="day" > <?php echo freetext('day')  ?>
                          </label>
                        </span>
                        <span class="margin-left-medium">
                          <label>
                            <input  <?php if($daily_pay_rate_type=='month'){ echo "checked='checked'"; } ?> type="radio" name="daily_pay_rate_type_gr<?php echo $temp_count_group; ?>" class="radio_pay_rate rate_month" id="rate_month_<?php echo $temp_count_group; ?>" value="month" > <?php echo freetext('month')  ?>
                          </label>
                        </span> 
               </span> 
               <input type="hidden" readonly="readonly" class="form-control daily_pay_rate_id" name="daily_pay_rate_id_gr<?php echo $temp_count_group; ?>"  value="<?php echo $daily_pay_rate_id; ?>" />
               <input  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control daily_pay_rate text-right" name="daily_pay_rate_gr<?php echo $temp_count_group; ?>"  value="<?php  echo number_format($daily_pay_rate,2); //echo $daily_pay_rate; ?>" />
               <span class="input-group-addon"><?php  echo freetext('THB'); ?></span>
          </div>
          </div>

          <div class="col-sm-4 ">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon" style="width:180px;">
                <?php echo '<span ><font class="pull-left">'.freetext('overtime').' :</font></span>'; ?>
                    <label>
                      <input  <?php if($is_auto_ot==1){ echo "checked='checked'"; } ?> type="checkbox" name="is_auto_ot_gr<?php echo $temp_count_group; ?>" class="is_auto_ot" value="1" > อัตโนมัติ                    
                    </label>              
               </span> 
               <input type="hidden" readonly="readonly" class="form-control overtime_id" name="overtime_id_gr<?php echo $temp_count_group; ?>"  value="<?php echo $overtime_id; ?>" />
               <input  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control overtime text-right" name="overtime_gr<?php echo $temp_count_group; ?>" value="<?php echo number_format($overtime,2);//echo $overtime; ?>" />
               <span class="input-group-addon"><?php  echo freetext('THB/D'); ?></span>
          </div>
          </div>

          <div class="col-sm-4 ">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon">
                <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('holiday').'</font></div>'; ?>
               </span> 
               <input type="hidden" readonly="readonly" class="form-control holiday_id" name="holiday_id_gr<?php echo $temp_count_group; ?>"  value="<?php echo $holiday_id; ?>" />
               <input <?php if($daily_pay_rate_type=='day'){ echo "readonly='readonly'"; } ?> data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" onkeypress="return isDouble(event)"  class="form-control holiday text-right" name="holiday_gr<?php echo $temp_count_group; ?>" value="<?php echo number_format($holiday,2);//echo $holiday; ?>" />
                <span class="input-group-addon"><?php  echo freetext('THB/D'); ?></span>
          </div>
          </div>
          
          </div>
        <!-- end : input group --> 


        <!-- start : input group -->
          <div class="col-sm-12 no-padd from-gr-height"> 

              <div class="col-sm-4 ">
          <div class="input-group m-b">  
                <span class="input-group-addon" style="width:180px;">
                <?php echo '<span ><font class="pull-left">'.freetext('transport_exp').' :</font></span>'; ?>
                    <label>
                      <input <?php if($is_auto_transport ==1){ echo "checked='checked'"; } ?> type="checkbox" name="is_auto_transport_gr<?php echo $temp_count_group; ?>" class="is_auto_transport" value="1" > อัตโนมัติ                   
                    </label>              
               </span>
               <input type="hidden" readonly="readonly" class="form-control transport_exp_id" name="transport_exp_id_gr<?php echo $temp_count_group; ?>"  value="<?php echo $transport_exp_id; ?>" />   
               <input  type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control transport_exp text-right"  name="transport_exp_gr<?php echo $temp_count_group; ?>"  value="<?php echo number_format($transport_exp,2);//echo $transport_exp; ?>" />
               <span class="input-group-addon"><?php  echo freetext('THB/D'); ?></span>
          </div>
          </div>
              

          <div class="col-sm-4 ">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon">
                <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('incentive').'</font></div>'; ?>
               </span>
               <input type="hidden" readonly="readonly" class="form-control incentive_id" name="incentive_id_gr<?php echo $temp_count_group; ?>"  value="<?php echo $incentive_id; ?>" />  
               <input  type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control incentive text-right"  name="incentive_gr<?php echo $temp_count_group; ?>"  value="<?php echo number_format($incentive,2);//echo $incentive; ?>" />
                <span class="input-group-addon"><?php  echo freetext('THB/M'); ?></span>
          </div>
          </div>

          <div class="col-sm-4 ">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon">
                <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('bonus').'</font></div>'; ?>
               </span>
               <input type="hidden" readonly="readonly" class="form-control bonus_id" name="bonus_id_gr<?php echo $temp_count_group; ?>"  value="<?php echo $bonus_id; ?>" />   
               <input  type="text" autocomplete="off" onkeypress="return isDouble(event)"  class="form-control bonus text-right" name="bonus_gr<?php echo $temp_count_group; ?>" value="<?php echo number_format($bonus,2);//echo $bonus; ?>" />
               <span class="input-group-addon"><?php  echo freetext('THB/M'); ?></span>
          </div>
          </div>          
          </div>
        <!-- end : input group -->   

      

        <input type="hidden" class="form-control count_other_group" name="count_other_group_<?php echo $temp_count_group; ?>"  value="<?php echo $count_other; ?>" />
        <!-- start : input group -->
          
          

          <div class=" from-gr-height  div-other">              


            <div class="col-sm-4 ">
        <div class="input-group m-b">    
            <!--  <span class="input-group-addon" style="width:180px;">
              <?php //echo '<span ><font class="pull-left">'.freetext('rate_position').' :</font></span>'; ?>
                  <label>
                    <input <?php //if($is_auto_position ==1){ echo "checked='checked'"; } ?>  type="checkbox" name="is_auto_position_gr<?php //echo $temp_count_group; ?>" class="is_auto_position" value="1" > อัตโนมัติ                   
                  </label>              
             </span> -->
             <span class="input-group-addon">
              <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('rate_position').'</font></div>'; ?>
             </span>
             <input type="hidden" readonly="readonly" class="form-control rate_position_id" name="rate_position_id_gr<?php echo $temp_count_group; ?>"  value="<?php echo $rate_position_id; ?>" />   
             <input  type="text" autocomplete="off" onkeypress="return isDouble(event)"  class="form-control rate_position text-right" name="rate_position_gr<?php echo $temp_count_group; ?>" value="<?php echo number_format($rate_position,2);//echo $rate_position; ?>" />
             <span class="input-group-addon"><?php  echo freetext('THB/M'); ?></span>
        </div>
        </div>

        <div class="col-sm-4 ">
        <div class="input-group m-b"> 
             <span class="input-group-addon" style="width:180px;">
              <?php echo '<span ><font class="pull-left">'.freetext('special').' :</font></span>'; ?>
                  <label>
                    <input <?php if($is_auto_spacial ==1){ echo "checked='checked'"; } ?>  type="checkbox" name="is_auto_special_gr<?php echo $temp_count_group; ?>" class="is_auto_special" value="1" > อัตโนมัติ                    
                  </label>              
             </span>
             <input type="hidden" readonly="readonly" class="form-control special_id" name="special_id_gr<?php echo $temp_count_group; ?>"  value="<?php echo $special_id; ?>" />  
             <input  type="text" autocomplete="off" onkeypress="return isDouble(event)"  class="form-control special text-right" name="special_gr<?php echo $temp_count_group; ?>" value="<?php echo number_format($special,2);//echo $special; ?>" />
             <span class="input-group-addon"><?php  echo freetext('THB/M'); ?></span>
        </div>
        </div>      



          <div class="col-sm-4 hide">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon">
                <div class="label-width-adon"><font class="pull-left"><?php echo freetext('other'); ?></font></div>
               </span>
                    <!-- //add other type -->
                    <div   class="input-group col-sm-12 dropdown combobox">
                      <input class="form-control" name="combobox" type="text" autocomplete="off" readonly placeholder="add other type">
                      <div class="input-group-btn">
                        <button disabled type="button" class="btn btn-default dropdown-toggle " data-toggle="dropdown"><i class="fa fa-plus h5"></i></button>
                        <ul class="dropdown-menu pull-right">
                          <?php 
                
                            $count_other_select =0;
                              $temp_bapi_other_type = $bapi_other_type->result_array();
                              if(!empty($temp_bapi_other_type)){
                              foreach($bapi_other_type->result_array() as $value){ //data-selected="true"
                              if(!in_array($value['material_no'], $fix_mat_other)){
                               if (!in_array($value['material_no'], $exist_mat)) {
                              $count_other_select++; 

                           ?>
                            <li class="add-other" id="<?php echo $value['material_no']; ?>" name="<?php echo $value['material_description']; ?>" ><a href="#"><?php echo $value['material_description']; ?></a></li>
                          <?php 
                            }//end if
                            }//end if
                              }//end foreach
                              }else{//end if ?>
                               <li ><a href="#">ไม่มีข้อมูล</a></li>
                        <?php }//end else ?>
                      </ul>                     
                      </div>
                    </div>
                    <input type="hidden" class="count_ohter_select"  readonly value="<?php echo $count_other_select; ?>" />
                    <!-- /btn-group -->
          </div>
          </div>

        <?php  

          //===TODO : add other ====
          for ($j = 1; $j <= $count_other; $j++){
         $other_priec =0;
         $other_type_id = 0;
         $temp_thb ='';

         if($j==1){
            $other_priec = $other_type1;
            $other_type_id = $other_type1_id;
            if($other_type_id=='000000000000030044'){$temp_thb = freetext("THB/M");}else{ $temp_thb = freetext("THB/D");}
           }
           if($j==2){
            $other_priec = $other_type2;
            $other_type_id = $other_type2_id;
            if($other_type_id=='000000000000030044'){$temp_thb = freetext("THB/M");}else{ $temp_thb = freetext("THB/D");}
           }
           if($j==3){
            $other_priec = $other_type3;
            $other_type_id = $other_type3_id;
            if($other_type_id=='000000000000030044'){$temp_thb = freetext("THB/M");}else{ $temp_thb = freetext("THB/D");}
           }
            if($j==4){
            $other_priec = $other_type4;
            $other_type_id = $other_type4_id;
            if($other_type_id=='000000000000030044'){$temp_thb = freetext("THB/M");}else{ $temp_thb = freetext("THB/D");}
           }

           if($j==5){
            $other_priec = $other_type5;
            $other_type_id = $other_type5_id;
            if($other_type_id=='000000000000030044'){$temp_thb = freetext("THB/M");}else{ $temp_thb = freetext("THB/D");}
           }
           if($j==6){
            $other_priec = $other_type6;
            $other_type_id = $other_type6_id;
            if($other_type_id=='000000000000030044'){$temp_thb = freetext("THB/M");}else{ $temp_thb = freetext("THB/D");}
           }
          
           if($j==7){
            $other_priec = $other_type7;
            $other_type_id = $other_type7_id;
            if($other_type_id=='000000000000030044'){$temp_thb = freetext("THB/M");}else{ $temp_thb = freetext("THB/D");}
           }
           if($j==8){
            $other_priec = $other_type8;
            $other_type_id = $other_type8_id;
            if($other_type_id=='000000000000030044'){$temp_thb = freetext("THB/M");}else{ $temp_thb = freetext("THB/D");}
           }
           if($j==9){
            $other_priec = $other_type9;
            $other_type_id = $other_type9_id;
            if($other_type_id=='000000000000030044'){$temp_thb = freetext("THB/M");}else{ $temp_thb = freetext("THB/D");}
           }
           if($j==10){
            $other_priec = $other_type10;
            $other_type_id = $other_type10_id;
            if($other_type_id=='000000000000030044'){$temp_thb = freetext("THB/M");}else{ $temp_thb = freetext("THB/D");}

           }
           

        ?>
          <div class="col-sm-4 div-other-add">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon">
                <div class="label-width-adon">
                  <font class="pull-left"><?php $other_type_des=''; foreach($bapi_other_type->result_array() as $value){ if($other_type_id==$value['material_no']){ echo $value['material_description']; $other_type_des=$value['material_description'];} }    //echo $j; ?></font>
                </div>
               </span> 
               <input type="hidden" class="form-control input-other" name="<?php echo "other_typeID_".$j."_group_".$temp_count_group; ?>" value="<?php echo $other_type_id; ?>" />
               <input type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control input-other text-right" name="<?php echo "other_".$j."_group_".$temp_count_group; ?>"  value="<?php echo number_format($other_priec,2);//echo $other_priec; ?>"/>
               <span class="input-group-addon"><?php  echo $temp_thb; ?></span>
               <span class="input-group-addon btn btn-default btn-sm delete_other"  data-id="<?php echo $other_type_id;?>" data-txt="<?php echo str_replace('"', "''", $other_type_des);?>" ><i class="fa fa-trash-o h4"></i></span>
          </div>
          </div>
        <?php }//end for count_other ?>         

          </div>
        <!-- end : input group --> 

        <!-- start : input group -->
          <div class="col-sm-12 no-padd "> 
              
          <div class="col-sm-8">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon">
                <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('other').'</font></div>'; ?>
               </span> 
               <input type="text" autocomplete="off" class="form-control other_title" name="other_title_gr<?php echo $temp_count_group; ?>"   value="<?php echo $other_title; ?>" />               
          </div>
          </div>

          <div class="col-sm-4 ">
          <div class="input-group m-b">
             <input type="hidden" readonly="readonly" class="form-control other_id" name="other_id_gr<?php echo $temp_count_group; ?>"  value="<?php echo $other_id; ?>" /> 
               <input type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control other_value text-right" name="other_value_gr<?php echo $temp_count_group; ?>"   value="<?php if(!empty($other_value)){ echo number_format($other_value,2);  } //echo $other_value; ?>" />
               <span class="input-group-addon"><?php  echo freetext('THB/D'); ?></span>             
          </div>
          </div>
          </div>
        <!-- end : input group -->

<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
        <!-- start : input group -->
        <div class="col-sm-12 back-color-sumgray no-padd" style="padding-top:15px;margin-bottom:10px;"> 
            <div class="col-sm-3">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon">
                <?php echo '<div style="width:80px;"><font class="pull-left">'.freetext('waege').'</font></div>'; ?>
               </span> 
               <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" readonly class="form-control text-right waege" name="waege_gr<?php echo $temp_count_group; ?>"   value="<?php echo number_format($waege,2);//echo $waege; ?>" />              
             <!-- <span disabled class="input-group-addon btn btn-default btn-sm btn-success  btn-waege"><?php // echo freetext('THB'); ?></span>  -->
          </div>
          </div>

          <div class="col-sm-3">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon">
                <?php echo '<div style="width:100px;"><font class="pull-left">'.freetext('benefit').'</font></div>'; ?>
               </span> 
               <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" readonly class="form-control text-right benefit" name="benefit_gr<?php echo $temp_count_group; ?>"   value="<?php echo number_format($benefit,2);//echo $benefit; ?>" />
               <input  type="hidden" autocomplete="off" readonly class="form-control text-right benefit_man" name="benefit_man_gr<?php echo $temp_count_group; ?>"   value="" />                 
            <!--  <span disabled class="input-group-addon btn btn-default btn-sm btn-success btn-benefit"><?php  //echo freetext('THB'); ?></span>   -->
          </div>
          </div>

          <div class="col-sm-3">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon">
                <?php echo '<div style="width:130px;"><font class="pull-left">'.freetext('wage_benefit').'</font></div>'; ?>
               </span> 
               <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" readonly class="form-control text-right wage_benefit" name="wage_benefit_gr<?php echo $temp_count_group; ?>"   value="<?php echo number_format($wage_benefit,2);//echo $wage_benefit ; ?>" />               
            <!--  <span disabled class="input-group-addon btn btn-default btn-sm btn-success btn-wage-benefit"><?php  //echo freetext('THB'); ?></span> --> 
          </div>
          </div>

          <div class="col-sm-3">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon">
                <?php echo '<div style="width:80px;"><font class="pull-left">'.freetext('sub_total').'</font></div>'; ?>
               </span> 
               <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" readonly class="form-control text-right sub_total" name="sub_total_gr<?php echo $temp_count_group; ?>"   value="<?php echo number_format($subtotal,2);//echo $subtotal; ?>" />              
            <!--  <span disabled class="input-group-addon btn btn-default btn-sm btn-success btn-sub-total"><?php  //echo freetext('THB'); ?></span> -->  
          </div>
          </div>
        </div>
        <!-- end : input group -->
<?php
 break;
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>

    
    <!-- start : input group -->
    <div class="col-sm-12 no-padd "> 
           <input type="hidden" class="form-control count_sub_group" name="count_sub_group_<?php echo $temp_count_group; ?>"  value="<?php echo $count_subgroup_of_group; ?>" />
        </div>
        <!-- end : input group -->






    <div class="col-sm-12 no-padd"> 
  <!--################ start : div-sub-gruop ################-->    
  <div class="row div-sub-gruop">
<?php

    foreach($sub_gruop_array as $b ) {
      $temp_count_sub_group++;
       
       //echo "===== subgroup-ID =" . $b ."|| f-no : ".$temp_count_sub_group;

      foreach($get_staff->result_array() as $value){
                if($value['man_group_id'] == $a){
                  if($value['sub_group_id'] == $b){

                    $sub_staff_title =  $value['subgroup_total'];
                    $gender =  $value['gender'];
                    //$subgroup_total =  $value['subgroup_total'];                    
                    $day =  unserialize($value['day']);

                    // echo "<pre>";
                    // print_r($day);
                    // echo "</pre>";
                    $time_in =  $value['time_in'];
                    $time_out =   $value['time_out'];
                    //$position =  $value['position'];
                    //$uniform_id =  $value['uniform_id'];
                    $work_hours =  $value['work_hours'];
                    $overtime_hours =  $value['overtime_hours'];
                    $work_day = $value['work_day'];
                    $work_holiday = $value['work_holiday'];
                    $charge_overtime = $value['charge_overtime'];
                    $remark = $value['remark'];
                    $subtotal_per_person = $value['subtotal_per_person'];
                    $subtotal_per_group = $value['subtotal_per_group'];

                  }//end if group_id
                }//end if sub group
           }//end data sub group  data sub group

            //echo "<br>===== group no :".$temp_count_group."|| sub group no :".$temp_count_sub_group." ===== <br>";

           // echo "sub_staff_title : ".$sub_staff_title."<br>";
           // echo "gender : ".$gender."<br>";
           // echo "day : ".$day."<br>";
           // echo "time_in : ".$time_in."<br>";
           // echo "time_out : ".$time_out."<br>";
           // echo "position : ".$position."<br>";
           // echo "uniform_id : ".$uniform_id."<br>";
           // echo "work_hours : ".$work_hours."<br>";
           // echo "overtime_hours : ".$overtime_hours."<br>";
           // echo "work_day : ".$work_day."<br>";
           // echo "work_holiday : ".$work_holiday."<br>";
           // echo "charge_overtime : ".$charge_overtime."<br>";
           // echo "remark : ".$remark."<br>";
           // echo "subtotal_per_person : ".$subtotal_per_person."<br>";
           // echo "subtotal_per_group : ".$subtotal_per_group."<br>";

?>


 <!--################ start : DiV sub gruop ################# -->
          <div class="col-sm-6 round-large box-subgroup clone_sub_group" id="clone_sub_group_<?php echo $temp_count_sub_group; ?>">
            <section class="panel panel-default">
              <div class="panel-body">
                <!--  start : from group -->
                    <div class="col-sm-12 no-padd margin-sub-group">
                      <div class="col-sm-2 pull-left no-padd div-coppy-subgroup">  
                       <button class="btn btn-sm btn-default coppy_sub_group" type="button"><i class="fa fa-copy"></i></button>
                   </div>
                      <div class="col-sm-2 pull-right no-padd div-delete-subgroup">
                         <input type="hidden" class="form-control compress_type"  value="compress">
                             <button class="hide btn btn-sm btn-default  pull-right margin-left-small  compress" type="button"><i class="btn_compress fa fa-compress "></i><!-- <i class="btn_expand fa fa-expand "></i> --></button>
                        <?php if($temp_count_sub_group!=1){ ?>
                         <button class="btn btn-sm btn-default  pull-right delete_sub_group"  type="button"><i class="fa fa-trash-o"></i></button>
                            <?php }//end checkout temp_count_sub_group ?>
                          </div>

                           <div class="col-sm-4 no-padd pull-right div-staff-subgroup">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('#staff').'</font>'; ?></span> 
                      <input data-parsley-min ="1" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" onkeypress="return isInt(event)" name="<?php echo "sub_group_staff_subg".$temp_count_sub_group."_gr".$temp_count_group; ?>" class="form-control  sub_group_staff"  value="<?php echo $sub_staff_title;?>">
                    </div>
               </div>
                
               <div class="col-sm-2  no-padd pull-right div-gender-subgroup" >                            
                            <input type="radio" <?php if($gender=='male'){ echo "checked='checked'"; } ?> name="<?php echo "gender_subg".$temp_count_sub_group."_gr".$temp_count_group; ?>" class="gender" value="male"> M                            
                            <input type="radio" <?php if($gender=='female'){ echo "checked='checked'"; } ?> name="<?php echo "gender_subg".$temp_count_sub_group."_gr".$temp_count_group; ?>" class="gender" value="female" style="margin-left:10px;"> F                           
                          </div>

                    </div>
                <!--  end : from group -->               

                <!--  start : from group -->
                    <div class="col-sm-12 no-padd from-gr-height m-b-md">
                      <div class="col-sm-7  no-padd div-day-subgroup" >                       
                         
                         <div class="col-sm-1 text-day">
                            <div class="checkbox no-padd">
                      <label class="control-label h5 "><?php echo freetext('day'); ?></label>
                      </div>
                   </div>

                   <div class="col-sm-1">
                      <div class=" checkbox no-padd">
                      <input <?php if((is_array($day) && in_array('SUN', $day)) || (!is_array($day) && $day == 'SUN')){ echo "checked='checked'"; } ?> type="checkbox" id="<?php echo "radio1".$temp_count_sub_group.$temp_count_group; ?>" name="day_radio_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>[]"  class="day-radio radio1" value="SUN"/>SU
                    <label for="<?php echo "radio1".$temp_count_sub_group.$temp_count_group; ?>" class="radio_for1"><span></span></label>                              
                              </div>
                            </div>

                             <div class="col-sm-1" >  
                                <div class=" checkbox no-padd">
                                <input <?php if((is_array($day) && in_array('MON', $day)) || (!is_array($day) && $day == 'MON')){ echo "checked='checked'"; } ?> type="checkbox" id="<?php echo "radio2".$temp_count_sub_group.$temp_count_group; ?>" name="day_radio_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>[]"  class="day-radio radio2" value="MON"/>M
                  <label for="<?php echo "radio2".$temp_count_sub_group.$temp_count_group; ?>"  class="radio_for2"><span></span></label>                              
                                </div>
                            </div>

                             <div class="col-sm-1"> 
                                <div class=" checkbox no-padd"> 
                                <input <?php if((is_array($day) && in_array('TUE', $day)) || (!is_array($day) && $day == 'TUE')){ echo "checked='checked'"; } ?> type="checkbox" id="<?php echo "radio3".$temp_count_sub_group.$temp_count_group; ?>" name="day_radio_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>[]"  class="day-radio radio3" value="TUE"/>TU
                  <label for="<?php echo "radio3".$temp_count_sub_group.$temp_count_group; ?>"  class="radio_for3"><span></span></label>                                  
                                </div>
                            </div>

                             <div class="col-sm-1" >
                                <div class=" checkbox no-padd">  
                                 <input <?php if((is_array($day) && in_array('WED', $day)) || (!is_array($day) && $day == 'WED')){ echo "checked='checked'"; } ?> type="checkbox" id="<?php echo "radio4".$temp_count_sub_group.$temp_count_group; ?>" name="day_radio_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>[]"  class="day-radio radio4" value="WED"/>W
                   <label for="<?php echo "radio4".$temp_count_sub_group.$temp_count_group; ?>"  class="radio_for4"><span></span></label>  
                                </div>
                            </div>

                             <div class="col-sm-1" >
                                <div class=" checkbox no-padd">   
                                  <input <?php if((is_array($day) && in_array('THU', $day)) || (!is_array($day) && $day == 'THU')){ echo "checked='checked'"; } ?> type="checkbox" id="<?php echo "radio5".$temp_count_sub_group.$temp_count_group; ?>" name="day_radio_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>[]"  class="day-radio radio5" value="THU"/>TH
                    <label for="<?php echo "radio5".$temp_count_sub_group.$temp_count_group; ?>"  class="radio_for5"><span></span></label>    
                                </div>
                            </div>

                             <div class="col-sm-1">
                                <div class=" checkbox no-padd">   
                                  <input <?php if((is_array($day) && in_array('FRI', $day)) || (!is_array($day) && $day == 'FRI')){ echo "checked='checked'"; } ?> type="checkbox" id="<?php echo "radio6".$temp_count_sub_group.$temp_count_group; ?>" name="day_radio_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>[]"  class="day-radio radio6" value="FRI"/>F
                    <label for="<?php echo "radio6".$temp_count_sub_group.$temp_count_group; ?>"  class="radio_for6"><span></span></label>  
                              </div>
                            </div>

              <div class="col-sm-1" >
                  <div class=" checkbox no-padd">   
                                <input <?php if((is_array($day) && in_array('SAT', $day)) || (!is_array($day) && $day == 'SAT')){ echo "checked='checked'"; } ?> type="checkbox" id="<?php echo "radio7".$temp_count_sub_group.$temp_count_group; ?>" name="day_radio_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>[]"  class="day-radio radio7" value="SAT"/>SA
                  <label for="<?php echo "radio7".$temp_count_sub_group.$temp_count_group; ?>"  class="radio_for7"><span></span></label>   
                              </div>
                          </div>

              <div class="col-sm-1" >
                  <div class=" checkbox no-padd">   
                                 <input <?php if((is_array($day) && in_array('HOL', $day)) || (!is_array($day) && $day == 'HOL')){ echo "checked='checked'"; } ?> type="checkbox" id="<?php echo "radio8".$temp_count_sub_group.$temp_count_group; ?>" name="day_radio_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>[]"  class="day-radio radio8" value="HOL"/>HOL
                   <label for="<?php echo "radio8".$temp_count_sub_group.$temp_count_group; ?>"  class="radio_for8"><span></span></label>    
                              </div>
                           </div>
            </div>

            <div class="col-sm-5 no-padd div-time-subgroup m-b-md">
                          <label class="col-sm-2 control-label h5"><?php echo freetext('time'); ?></label>
                          <div class="col-sm-4">
                            <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" style="width:60px;" onkeypress="return isNumberTime(event)" maxlength="5" class="time_start" name="time_start_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>" value="<?php echo $time_in;?>" placeholder="00:00">
                          </div>  

                          <label class="col-sm-2 control-label h5"><?php echo freetext('to'); ?></label>
                          <div class="col-sm-4">
                            <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" style="width:60px;" onkeypress="return isNumberTime(event)" maxlength="5" class="time_end" name="time_end_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>" value="<?php echo $time_out;?>" placeholder="00:00">
                          </div>
            </div>

                  </div><!--  end : from group -->

                <!--  start : from group -->
                  <div class="col-sm-12 no-padd row ">
                </div>
                <!--  end : from group -->

                  <div class="div-datawork-group">                   

                  <!--  start : from group -->
                  <div class="col-sm-12 no-padd from-gr-height ">
                    <div class="col-sm-6 div-whrs-group">
              <div class="input-group m-b">                                                  
                   <span class="input-group-addon sbj-work-hrs">
                    <?php echo '<font class="pull-left">'.freetext('work_hrs').'</font>'; ?>
                   </span> 
                   <input data-parsley-min ="1" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" onkeypress="return isInt(event)" class="form-control work_hrs" name="work_hrs_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>" value="<?php echo $work_hours;?>" placeholder="work_hrs" >                
              </div>
            </div>
            <div class="col-sm-6  div-overhrs-group">
              <div class="input-group m-b">                                                  
                   <span class="input-group-addon sbj-over-hrs">
                    <?php echo '<font class="pull-left">'.freetext('overtime_hrs').'</font>'; ?>
                   </span> 
                   <input type="text" autocomplete="off" onkeypress="return isInt(event)" class="form-control overtime_hrs" name="overtime_hrs_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>" value="<?php echo $overtime_hours;?>" placeholder="overtime_hrs" >                
              </div>
            </div>
                  </div><!--  end : from group -->

                  <!--  start : from group -->
                  <div class="col-sm-12 no-padd from-gr-height">
                    <div class="col-sm-6">
              <div class="input-group m-b">                                                  
                   <span class="input-group-addon sbj-wday">
                    <?php echo '<font class="pull-left">'.freetext('work_day').'</font>'; ?>
                   </span> 
                   <input data-parsley-min ="1" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" onkeypress="return isInt(event)" class="form-control work_day" name="work_day_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>" value="<?php echo $work_day;?>" placeholder="work_day" >                
              </div>
            </div>
            <div class="col-sm-6">
              <div class="input-group m-b">                                                  
                   <span class="input-group-addon sbj-holiday">
                    <?php echo '<font class="pull-left">'.freetext('work_holiday').'</font>'; ?>
                   </span> 
                   <input  type="text" autocomplete="off" onkeypress="return isInt(event)" class="form-control work_holiday" name="work_holiday_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>" value="<?php echo $work_holiday;?>"  placeholder="work_holiday" >                
              </div>
            </div>
                  </div><!--  end : from group -->

                  <!--  start : from group -->
                  <div class="col-sm-12 no-padd from-gr-height">
                    <div class="col-sm-6 div-ot-subgroup">
              <div class="input-group m-b">                                                  
                   <span class="input-group-addon">
                    <?php echo '<font class="pull-left">'.freetext('charge_ot').'</font>'; ?>
                   </span> 
                   <input  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control charge_ot text-right" name="charge_ot_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>" value="<?php echo number_format($charge_overtime,2);//echo $charge_overtime;?>"  placeholder="charge_ot">                
              </div>
            </div>          

            <div class="col-sm-6  div-remark-subgroup">
              <div class="input-group m-b">                                                  
                   <span class="input-group-addon">
                    <?php echo '<font class="pull-left">'.freetext('remark').'</font>'; ?>
                   </span> 
                   <input  type="text" autocomplete="off" class="form-control remark"  name="remark_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>" value="<?php echo $remark;?>" placeholder="remark">                
              </div>
            </div>
                  </div><!--  end : from group -->

                   <!--  start : from group -->
                  <div class="col-sm-12 no-padd from-gr-height div-person-group">
                    <div class="col-sm-12">
              <div class="input-group m-b">                                                  
                   <span class="input-group-addon">
                    <?php echo '<font class="pull-left">'.freetext('per_person').'</font>'; ?>
                   </span> 
                   <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" readonly onkeypress="return isDouble(event)" class="form-control text-right per_person" name="per_person_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>" value="<?php echo number_format($subtotal_per_person,2);//echo $subtotal_per_person;?>" placeholder="per_person">                
                  <span  class="input-group-addon  "><?php  echo freetext('THB'); ?></span> 
              </div>  
            </div>
          </div><!--  end : from group -->


<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                   <!--  start : from group -->
                  <div class="col-sm-12 no-padd from-gr-height div-per-group">
            <div class="col-sm-12">
              <div class="input-group m-b">                                                  
                   <span class="input-group-addon">
                    <?php echo '<font class="pull-left">'.freetext('per_group').'</font>'; ?>
                   </span> 
                   <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" readonly onkeypress="return isDouble(event)" class="form-control text-right per_group" name="per_group_subg<?php echo $temp_count_sub_group; ?>_gr<?php echo $temp_count_group; ?>" value="<?php echo number_format($subtotal_per_group,2);//echo $subtotal_per_group;?>" placeholder="per_group">               
                 <span  class="input-group-addon "><?php  echo freetext('THB'); ?></span> 
              </div>
            </div>
                  </div><!--  end : from group -->
<?php
 break;
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>

              </div>
                                                          
              </div>
            </section>
          </div>
  <!--################ end : DiV sub gruop ################# -->



<?php
    }//end foreach sub group
?>

  </div><!-- end col-sm-12 no-padd -->
  </div>
  <!--################ end : div-sub-gruop ################--> 


  <!--===============  start : ADD SUP GROUP ===============-->
  <div class="col-sm-12 margin-top-medium hide no-padd">              
    <div class="col-sm-12">
     <button type="button" class="btn btn-info h5 pull-right add-sub-group">
        <i class="fa fa-plus-circle"></i> 
        <?php  echo freetext('ADD'); ?>
        <span class="help-block m-b-none"><?php  echo freetext('sub_gruop_man'); ?></span>
      </button>
   </div>
  </div><!-- end : ADD SUP GROUP -->
    
</div><!-- end form -->
</div><!-- end panel -->
</section>
<!--################################### end :Group staff ###################################-->


<?php
}//end foreach man group 
}//end empty 
?>








<!-- ////////////////////////////////////////////////////  form submit /////////////////////////////////////////////////////////////////// -->
<div class="form-group col-sm-12 ">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview/'.$this->quotation_id); ?>"  class="btn btn-info" style="width:120px;"> <?php echo freetext('back'); ?></a>
  </div>
</div>
<!-- end : form submit -->

<script>
// function myFunction_re() {
//     location.reload();
// }
</script>


</div><!-- end : class div_detail -->


          











