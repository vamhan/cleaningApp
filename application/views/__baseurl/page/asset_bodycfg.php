<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}

</style>

<?php
//=====  TODO :: set permission wage =====
$array_function_login = $this->session->userdata('function');
$temp_function_login= $array_function_login;
// echo "<pre>";
// print_r($temp_function_login);
// echo "</pre>";
$permission_view_wage =  array("MK","CR","RC", "IC", "HR", "WF","IT", "TN", "AC", "FI");// dont have ST,OP

?>


<div class="div_detail" style="padding-left:50px;padding-right:50px;padding-bottom:50px;">
<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i> รายการทรัพย์สิน งานประจำ</h4>


<?php
/// query job_type
 $data_job_type = $query_quotation->row_array();
 if(!empty($data_job_type)){      
     $job_type  = $data_job_type['job_type'];      
     $time_qt  = $data_job_type['time']; 
  }else{
    $job_type =''; 
    $time_qt  ='';  
  }

////////////////////////////////////////////////// GET data AREA:: from tbt_AREAR  //////////////////////////////////////////////////////////
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
                //$building_name[$value['building_id']] = $value['building_title'];
            }   

       }//end foreach


}//end temparea

//print_r($texture);
//################### end : GET TEXTURE ##################################
$total_space = 0;//set total_space_texture
$space_of_texture = array();
foreach($texture as $a => $a_value) {
//echo "<br>====== GET SPACT OF TEXTURE ========================================";
//echo "<br>====== index : = " . $a . ", textureid_value = ".$a_value." =========<br>";

           
            foreach($get_area->result_array() as $value){ 
              if($a_value == $value['texture_id']){
                    //echo "texture space ".$value['area_id']." ::".$value['space']."<br>";
                    $total_space =  $total_space + $value['space'];

              }
            }//end foreach

            //set double 2
            $total_space =   number_format($total_space, 2, '.', '');
            //echo "TOTAL SPACE ::".$total_space."<br>";

            //== set push arra space of texture ===
              $space_of_texture[$a_value] = $total_space; 
            //reset total_sapace
              $total_space=0;
}//end foreach texture

// echo "space_of_texture_area ||";
// print_r($space_of_texture);
// echo "<br>";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 

///////////////////////////////////////////////////////////////////
//====================== CHECK RECALCURATE ========================
///////////////////////////////////////////////////////////////////
$check_recalcurate  =0;

foreach($space_of_texture as $ar => $ar_space) {
  foreach($space_of_texture_DB as $tdb => $tdb_space) {
      if($ar == $tdb){
         // echo 'area :'.$ar.' |  area_DB :'.$tdb.'<br>';
         // echo 'tbt_area :'.$ar_space.' tbt_equipment :'.$tdb_space." ::<br>";
          if($ar_space==$tdb_space){  
              //echo " yes";
             $check_recalcurate  =0;
          }else{     
              //echo " no";
              $check_recalcurate  =1;
          }
          //echo "<br>";
      }
   }//end foreach space_of_texture DB
}//end foreach space_of_texture AREA

//echo "<br> check_recalcurate :".$check_recalcurate;

///////////////////////////////////////////////////////////////////
//======================  CALCULATE ==============================
///////////////////////////////////////////////////////////////////

   function calculate_quantity($space,$volumn,$quantity){
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

  function calculate_price($quantity,$price){
    //echo '<br>'.$quantity.' '.$price.'<br>';
        $total_price = $quantity*$price;
        //$total_price = number_format($total_quantity, 2, '.', '');
        return $total_price;
        
    }//end function


//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////


?>

<!--================== start get : data get_data_form_DB ===============-->
<div class="get_data_form_DB " >

<!-- sub_total_price_Z001 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z001' name="sub_total_price_Z001"  value="<?php //echo $sub_total_price_Z001;?>">

<!-- sub_total_price_Z013 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z013' name="sub_total_price_Z013"  value="<?php //echo $sub_total_price_Z013;?>">

<!-- input sub_total_chemical_DB -->
<input type="hidden" readonly name="sub_total_chemical_DB" class='form-control sub_total_chemical_DB'  value="<?php //echo $sub_total_chemical_DB;?>">
 
<!-- input temp_count_space_Z001 -->
<input type="hidden" readonly name="temp_count_space_Z001" class='form-control temp_count_space_Z001' placeholder="temp_count_space_Z001" value="<?php //echo $temp_count_space_type_Z013;?>">
      
<input type="hidden" autocomplete="off" readonly name="total_all" class="form-control text-right total_all" value="<?php echo  $total_all; ?>">
  

<!-- //////////////////////////////////////////////////// START : div detail table MATCHIE Z005 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

               <!--########################### Start :div detail machine ############################-->
                  <div class="panel panel-default ">

                    <div class="panel-heading font-bold h5" style="padding-bottom :24px;">                   
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseMachines_db" class="toggle_machines">
                        <div class="row" style="margin-bottom:-20px;">                 
                          <span class="margin-left-medium"><?php echo freetext('machines'); ?></span>                          
                          <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                             <span class="input-group-addon">                             
                                <font class="pull-left">
                                <?php  echo freetext('sub_total').' : '; ?>
                                </font>                         
                             </span> 
                             <input type="text" autocomplete="off" readonly name="sub_total" class="form-control text-right sub_total_Z005_DB" value="0">
                          </span>  
                        </div>
                      </a>
                    </div>

                     <!-- <div id="collapseMachines" class="panel-collapse in">  -->                                                            
                        <div id="collapseMachines_db" class="div-table panel-collapse in">
                              <table  class="table no-padd table_chemical">
                                  <thead>
                                    <tr class="back-color-gray h5">                          
                                      <th width="200" ><?php echo freetext('group_machine');?></th>
                                      <th width="400"><?php echo freetext('machines');?></th>
                                      <th class="tx-center"><?php echo freetext('quantity');?></th>
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                                      <th class="tx-center"><?php echo freetext('price/area');?></th>
                                      <th class="tx-center"><?php echo freetext('price (THB) ');?></th>  
<?php
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>                
                                    </tr>
                                  </thead>
                                  <tbody>

<?php 
//######################## start : GET MACHINE  ##################################
$temp_count_machine = 0;
$sub_total_price_Z005=0;

foreach($space_of_texture as $d => $d_space) {
  //echo "<br>====== texture_id : = " .$d. "|| space = ".$d_space." =========";

  $temp_bapi_machine = $get_db_chemical->result_array();
  if(!empty($temp_bapi_machine)){

      $texture_des ='';
      foreach($bapi_texture->result_array() as $value){
        if($d == $value['material_no']){
            $texture_des = $value['material_description'];
        }//end if
      }//end foreach texture_des


     $total_quantity = 0;
     $price = 0;
     $total_price = 0;
     //$count_chemical = 0;
     $tempD_texture_id  = $d;
     $tempD_mat_type = 'Z005';

     
     foreach($get_db_chemical->result_array() as $value){  
        if( $value['texture_id']==$d  && $value['mat_type']=='Z005'){// check น้ำยาคุมปริมาณ
          $temp_count_machine++;
          $sub_total_price_Z005 = $sub_total_price_Z005 + $value['total_price'];

            // echo "<br>===== get detail bomb ::".$value['material_no']." ===";
            // echo "<br> material_no ::".$value['material_no'];
            // echo "<br> material_description ::".$value['material_description'];
            // echo "<br> volumn ::".$value['volumn'];
            // echo "<br> unit_code ::".$value['unit_code'];
            // echo "<br> quantity ::".$value['quantity'];
            // echo "<br> price ::".$value['price'];

            // $total_quantity = calculate_quantity($d_space,$value['volumn'],$value['quantity']);
            // //echo "<br> total_quantity :: ".$total_quantity; 

            // $total_price = calculate_price($total_quantity,$value['price']);
            // //echo "<br> total_price :: ".$total_price; 

?>

                                              <tr class="h5" id="<?php echo $value['material_no'];?>"> 
                                                    <td><?php echo $value['mat_group_des'] ?>
                                                        <input type='hidden' readonly class='form-control mat_group_des' name="<?php echo "mach_mat_group_des_".$temp_count_machine; ?>" value="<?php echo $value['mat_group_des']; ?>">
                                                    </td>    
                                                    <td>
                                                        <?php echo defill($value['material_no']).' '.$value['material_description']; ?>
                                                        <input type="hidden" readonly  class='form-control texture_id' name="<?php echo "mach_texture_id_".$temp_count_machine; ?>" value="<?php echo $value['texture_id'];  ?>">
                                                        <input type="hidden" readonly  class='form-control material_no' name="<?php echo "mach_material_no_".$temp_count_machine; ?>" value="<?php echo $value['material_no']; ?>">
                                                        <input type="hidden" readonly  class='form-control mat_type' name="<?php echo "mach_mat_type_".$temp_count_machine; ?>" value="<?php echo $value['mat_type']; ?>">
                                                        <input type="hidden" readonly  class='form-control mat_group' name="<?php echo "mach_mat_group_".$temp_count_machine; ?>" value="<?php echo $value['mat_group']; ?>">
                                                    </td>                                                      
                                                    <td class="tx-center">
                                                      <?php echo $value['quantity'].' '.$value['quantity_unit']; ?>
                                                      <input type="hidden" readonly  class='form-control space' name="<?php echo "mach_space_".$temp_count_machine; ?>" value="<?php echo $d_space; ?>">
                                                      <input type="hidden" readonly  class='form-control quantity' name="<?php echo "mach_quantity_".$temp_count_machine; ?>" value="<?php echo $value['quantity']; ?>">
                                                      <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "mach_unit_code_".$temp_count_machine; ?>" value="<?php echo $value['quantity_unit']; ?>">
                                                    </td>
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                                                    <td class="tx-center"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                                                      <input type="hidden" readonly  class='form-control price' name="<?php echo "mach_price_".$temp_count_machine; ?>" value="<?php echo $value['price']; ?>">
                                                    </td>  
                                                    <td class="tx-center">
                                                      <?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>   
                                                      <input type="hidden" readonly  class='form-control total_price' name="<?php echo "mach_total_price_".$temp_count_machine; ?>" value="<?php echo $value['total_price']; ?>">
                                                    </td>                                        
<?php
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>        
                                                  </tr>
<?php

             }//end check type
     }//end foreach

      $temp_count_machine = $temp_count_machine;
      //echo "<br>temp_count_chemical :: ".$temp_count_machine;    


  }else{//end temp_bapi_chemical_Z013
      //echo "<br> no data of bomb";
     // no data of bapi bomb
  }//end else  
}//enf foreach space type Z005


// echo "<br> count_chemical ::".$count_chemical;
if($temp_count_machine==0){
  echo "<tr class='no-data h5'><td calspan='7'>ไม่มีข้อมูล</td></tr>";
   //echo "<br>type:machine : no data of bomb";
}//end if count



//echo "<br>".$temp_count_machine;
//######################## END : GET MACHINE  ##################################
?>

                                            </tbody>                                                  
                                              </table>
<!-- sub_total_price_Z005 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z005' name="sub_total_price_Z005"  value="<?php echo $sub_total_price_Z005;?>">

<input type="hidden" readonly class='form-control temp_count_machine' name="temp_count_machine"  value="<?php echo $temp_count_machine;?>">


                        </div>
                  </div>
              <!--################################ end :div detail machine ############################-->

<!-- //////////////////////////////////////////////////// END : div detail table MATCHIE Z005 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- //////////////////////////////////////////////////// START : div detail table TOOL Z002 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- sub_total_price_Z002 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z002' name="sub_total_price_Z002"  value="<?php echo $sub_total_price_Z002;?>">

<input type="hidden" readonly class='form-control temp_count_tool_Z002' name="temp_count_tool_Z002"  value="<?php echo $temp_count_tool_Z002;?>">

<!-- //////////////////////////////////////////////////// END : div detail table TOOL Z002 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- //////////////////////////////////////////////////// START : div detail table TOOL Z014 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                                             
<input type="hidden" readonly class='form-control sub_total_price_Z014' name="sub_total_price_Z014"  value="<?php echo $sub_total_price_Z014;?>">
<input type="hidden" readonly class='form-control temp_count_tool_Z014' name="temp_count_tool_Z014"  value="<?php echo $temp_count_tool_Z014;?>">

<!-- //////////////////////////////////////////////////// END : div detail table TOOL Z014 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->


</div> <!--================== end get : data get_data_form_DB ===============-->












<?php  
//START :check job_type clering ZQT1
if( $this->job_type == 'ZQT1'){ 
?>
<!-- ////////////////////////////////////// clearing ///////////////////////////////// -->
<!-- // TODO :: GET CLEARING -->
<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i> รายการทรัพย์สิน งานเคลียร์</h4>

<?php
//== TODO :: get frequency area =======================
$temp_area_clearing = $get_area->row_array();
$array_frequency =array('');
if(!empty($temp_area_clearing)){ 
   foreach($get_area->result_array() as $value){ 
      if($value['is_on_clearjob']==1){
        if (in_array( $value['frequency'], $array_frequency, TRUE)){                
                //echo "have";
        }else{
            //echo "nohave";
            array_push($array_frequency,$value['frequency']);            
        }//end else 
      }//end if check clearing
   }//end foreach
}//end if
// prine 
// print_r($array_frequency);
// echo "<br>";
//== TODO :: get  area clearing =======================
?>

<!--########################### Start :div detail machine ############################-->
    <div class="panel panel-default div-machine-clearing">

       <div class="panel-heading font-bold h5" style="padding-bottom :24px;"> 
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseMachines_clear" class="toggle_machines">  
             <div class="row" style="margin-bottom:-20px;"> 
            <span class="margin-left-medium"><?php echo freetext('machines'); ?></span>
            <span><i class="margin-top-small-toggle icon_machines_down fa fa-caret-down  text-active pull-right  margin-right-medium"></i>
              <i class="margin-top-small-toggle icon_machines_up fa fa-caret-up text  pull-right  margin-right-medium"></i></span>                             
             <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                 <span class="input-group-addon">                             
                    <font class="pull-left">
                    <?php  echo freetext('subtotal').' : '; ?>
                    </font>                         
                 </span> 
                 <input type="text" autocomplete="off" readonly name="total_macheine_clearing" class="form-control text-right total_macheine_clearing" value="0">
              </span>  
            </div>                    
          </a>       
      </div>

          <div id="collapseMachines_clear" class="panel-collapse in">

                 <!-- start :body detail table machine -->
                      <div class="panel-body" style="padding:0px 0px 0px 0px;">
                        <div class="form-group col-sm-12  no-padd" >
                          <!-- end : table -->
                         <!--  <section class=" panel panel-default"> -->
                          <?php
                          //get : count
                            $count_clearing_machine=0;
                             $temp_count_machine = $get_clearing_job->result_array();
                              if(!empty($temp_count_machine)){
                                  foreach($get_clearing_job->result_array() as $value){ 
                                      if($value['mat_type']=='Z005'){
                                         $count_clearing_machine++;
                                      }//end if
                                  }//end foreach
                              }else{
                                 $count_clearing_machine=0;
                              }//end else
                          ?>
                          <input type="hidden" readonly class="form-control count_clearing_machine" name="count_clearing_machine" value="<?php echo $count_clearing_machine; ?>"/>
                                <table  class="table no-padd table_clearing_machine">
                                    <thead>
                                      <tr class="back-color-gray h5">                          
                                        <th style="width:20%;"><?php echo freetext('frequency');?></th>
                                        <th width="200"><?php echo freetext('group_machine');?></th>
                                        <th width="400"><?php echo freetext('machine');?></th>
                                        <th class="tx-center"><?php echo freetext('quantity');?></th>
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                                        <th class="tx-center"><?php echo freetext('price/area');?></th>
                                        <th class="tx-center"><?php echo freetext('price (THB) ');?></th>   
<?php
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>                   
                                      </tr>
                                    </thead>
                                    <tbody>
            <?php
              //===== GET type : Z005 form DB =======
            $total_clearing_Z005 = 0; 
             $count_machine=0;
              $temp_clearing_Z005 = $get_clearing_job->result_array();
              if(!empty($temp_clearing_Z005)){
                  foreach($get_clearing_job->result_array() as $value){ 
                      if($value['mat_type']=='Z005'){
                         $count_machine++;
                         $total_clearing_Z005 = $total_clearing_Z005+$value['total_price'];
             ?>

                 <tr class="h5" id="<?php echo $value['material_no'] ?>">
                    <td style="width:260px;">
                      <div class="input-group m-b">
                        <span class="input-group-addon"><font class="pull-left">frequency</font></span>
                        <select disabled data-parsley-required='true' data-parsley-error-message='' class="form-control frequency" name="mach_frequency_<?php echo $count_machine;?>">
                         <?php    
                            $temp_frequency= $array_frequency;
                            if(!empty($temp_frequency)){
                             foreach($array_frequency as $a => $a_value) { 
                              if($a != 0){
                          ?>
                          <option  <?php if($value['frequency']==$a_value){ echo "selected='selected'";  } ?> value="<?php echo $a_value ?>"><?php echo 'Every '.$a_value.' m'; ?></option>
                          <?php 
                              }//end if
                            }//end foreach
                           }else{ ?>
                             <option value=' '>ไม่มีข้อมูล</option> 
                        <?php } ?>
                        </select>                       
                      </div>
                    </td>
                     <td><?php echo $value['mat_group_des']; ?>
                      <input type="hidden" readonly="" class="form-control mat_group_des" name="mach_mat_group_des_<?php echo $count_machine;?>" value="<?php echo $value['mat_group_des']; ?>">
                    </td>
                    <td><?php echo defill($value['material_no']).' '.$value['material_description']; ?>
                      <input type="hidden" readonly class="form-control material_no" name="mach_material_no_<?php echo $count_machine;?>" value="<?php echo $value['material_no']; ?>">
                      <input type="hidden" readonly class="form-control mat_type" name="mach_mat_type_<?php echo $count_machine;?>" value="<?php echo $value['mat_type']; ?>">
                      <input type="hidden" readonly class="form-control mat_group" name="mach_mat_group_<?php echo $count_machine;?>" value="<?php echo $value['mat_group']; ?>">                    
                    </td>
                    <td class="tx-center"><?php echo $value['quantity'].' '.$value['quantity_unit']; ?>
                      <input type="hidden" readonly class="form-control quantity" name="mach_quantity_<?php echo $count_machine;?>" value="<?php echo $value['quantity']; ?>">
                      <input type="hidden" readonly class="form-control unit_code" name="mach_unit_code_<?php echo $count_machine;?>" value="<?php echo $value['quantity_unit']; ?>">
                    </td>
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                    <td class="tx-center"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                      <input type="hidden" readonly class="form-control price" name="mach_price_<?php echo $count_machine;?>" value="<?php echo $value['price']; ?>">
                    </td>
                    <td class="tx-center"><?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>
                      <input type="hidden" readonly class="form-control total_price" name="mach_total_price_<?php echo $count_machine;?>" value="<?php echo $value['total_price']; ?>">
                    </td>
<?php
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>
                  </tr>

              <?php          
                      }//end if                       
                  }//end foreach Z001
                  if($count_machine==0){  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";  }
              }else{

                  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";
              }//end else
              $count_machine = $count_machine;
              ?>                        
                             </tbody>                                  
                            </table>
                            <input type="hidden" autocomplete="off" readonly class='form-control text-right total_tfoot_Z005' placeholder="total" value="<?php echo $total_clearing_Z005; ?>">
                            <!--  </section> --> <!-- end : table -->
                        </div><!-- end : col12-->
                      </div><!-- end :body detail table machine -->
          </div>
    </div>
<!--################################ end :div detail machine ############################-->
<input type="hidden" autocomplete="off" readonly class='form-control text-right total_chemical_clearing' value="0">
<input type="hidden" autocomplete="off" readonly class='form-control text-right total_tfoot_Z002' value="0">
<input type="hidden" autocomplete="off" readonly class='form-control text-right total_tfoot_Z014' value="0">
<input type="hidden" autocomplete="off" readonly class='form-control text-right total_clearing_tool' value="0">



<?php  
}//END :check job_type clering ZQT1
?>





<!-- ////////////////////////////////////// -->
<!-- form submit -->
<div class="form-group col-sm-12 ">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview/'.$this->quotation_id); ?>"  class="btn btn-info" style="width:120px;"> <?php echo freetext('back'); ?></a>
  </div>
</div>
<!-- end : form submit -->
</div><!-- end : class div_detail -->


          











