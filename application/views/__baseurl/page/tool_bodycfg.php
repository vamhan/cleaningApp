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
<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i> ต้นทุนอุปกรณ์ งานประจำ</h4>
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
                                      
<!-- //////////////////////////////////////////////////// START : div detail table MATCHIE Z005 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- sub_total_price_Z005 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z005' name="sub_total_price_Z005"  value="<?php //echo $sub_total_price_Z005;?>">

<input type="hidden" readonly class='form-control temp_count_machine' name="temp_count_machine"  value="<?php //echo $temp_count_machine;?>">

<input type="hidden" autocomplete="off" readonly name="total_all" class="form-control text-right total_all" value="<?php echo  $total_all; ?>">
     
<!-- //////////////////////////////////////////////////// END : div detail table MATCHIE Z005 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////// START : div detail table TOOL Z002 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

              <!--########################### Start :div detail tool ::  Z002_type คุมปริมาณ  ############################-->
                  <div class="panel panel-default ">

                    <div class="panel-heading font-bold h5" style="padding-bottom :24px;">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTool_db" class="toggle_tool">
                        <div class="row" style="margin-bottom:-20px;">                 
                          <span class="margin-left-medium"><?php echo freetext('Z002_type'); ?></span>
                          <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                             <span class="input-group-addon">                             
                                <font class="pull-left">
                                <?php  echo freetext('sub_total').' : '; ?>
                                </font>                         
                             </span> 
                             <input type="text" autocomplete="off" readonly name="sub_total" class="form-control text-right sub_total_Z002_DB" value="0">
                          </span>  
                        </div>
                      </a>
                    </div>
                        <!-- <div id="collapseTool" class="panel-collapse in">  -->
                        <div  id="collapseTool_db" class="div-table panel-collapse in">                              
                            <table  class="table no-padd table_chemical">
                                <thead>
                                  <tr class="back-color-gray h5">                          
                                    <th width="400"><?php echo freetext('tool');?></th>                                        
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
//######################## start : GET TOOL TYPE Z002 ##################################
$temp_count_tool_Z002 = 0;
$sub_total_price_Z002=0;

$exist_mat = array();

foreach($space_of_texture as $e => $e_space) {
  //echo "<br>====== texture_id : = " .$e. "|| space = ".$e_space." =========";

  $temp_bapi_tool_Z002 = $get_db_chemical->result_array();
  if(!empty($temp_bapi_tool_Z002)){

      $texture_des ='';
      foreach($bapi_texture->result_array() as $value){
        if($e == $value['material_no']){
            $texture_des = $value['material_description'];
        }//end if
      }//end foreach texture_des


     $total_quantity = 0;
     $price = 0;
     $total_price = 0;
     $tempE_texture_id  = $e;
     $tempE_mat_type = 'Z002';
     //$count_chemical = 0;
     

     foreach($get_db_chemical->result_array() as $value){  
        if( $value['texture_id']==$e  && $value['mat_type']=='Z002'){// check น้ำยาคุมปริมาณ
          $temp_count_tool_Z002++;
          $sub_total_price_Z002 = $sub_total_price_Z002  +  $value['total_price'];
          //echo  '<br>total :'.$sub_total_price_Z002;


            // echo "<br>===== get detail bomb ::".$value['material_no']." ===";
            // echo "<br> material_no ::".$value['material_no'];
            // echo "<br> material_description ::".$value['material_description'];
            // echo "<br> volumn ::".$value['volumn'];
            // echo "<br> unit_code ::".$value['unit_code'];
            // echo "<br> quantity ::".$value['quantity'];
            // echo "<br> price ::".$value['price'];

            // $total_quantity = calculate_quantity($e_space,$value['volumn'],$value['quantity']);
            // //echo "<br> total_quantity :: ".$total_quantity; 

            // $total_price = calculate_price($total_quantity,$value['price']);
            // //echo "<br> total_price :: ".$total_price; 

            array_push($exist_mat, $value['material_no']);

?>

                                  <tr class="h5" id="<?php echo $value['material_no'];?>"> 
                                      <!-- <td></td>   -->  
                                      <td>
                                          <?php echo defill($value['material_no']).' '.$value['material_description']; ?>
                                          <input type="hidden" readonly  class='form-control texture_id' name="<?php echo "texture_id_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['texture_id'];  ?>">
                                          <input type="hidden" readonly  class='form-control material_no' name="<?php echo "material_no_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['material_no']; ?>">
                                          <input type="hidden" readonly  class='form-control mat_type' name="<?php echo "mat_type_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['mat_type']; ?>">
                                          <input type="hidden" readonly  class='form-control mat_group' name="<?php echo "mat_group_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['mat_group']; ?>">
                                      </td>                                                      
                                      <td class="tx-center">
                                        <?php echo $value['quantity'].' '.$value['quantity_unit']; ?>
                                        <input type="hidden" readonly  class='form-control space' name="<?php echo "space_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $e_space; ?>">
                                        <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['quantity']; ?>">
                                        <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['quantity_unit']; ?>">
                                      </td>
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                                      <td class="tx-center"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                                          <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['price']; ?>">
                                      </td>  
                                      <td class="tx-center">
                                        <?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>      
                                        <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['total_price']; ?>">
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
    //$sub_total_price_Z002 =   number_format($sub_total_price_Z002, 2, '.', '');

      $temp_count_tool_Z002 = $temp_count_tool_Z002;
      //echo "<br>temp_count_tool_Z002 :: ".$temp_count_tool_Z002;

     
  }else{//end temp_bapi_chemical_Z013
      //echo "<br> no data of bomb";
     // no data of bapi bomb
  }//end else  
}//enf foreach space type Z013


// echo "<br> count_chemical ::".$count_chemical;
if($temp_count_tool_Z002==0){
  echo "<tr class='no-data h5'><td calspan='6'>ไม่มีข้อมูล</td></tr>";
  //echo "<br>type:tool : no data of bomb";
}//end if count

//echo "<br>".$temp_count_space_type_Z013;
//######################## END : GET TOOL TYPE Z002 ##################################

?>
                                              </tbody>                                                  
                                              </table>
<!-- sub_total_price_Z002 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z002' name="sub_total_price_Z002"  value="<?php echo $sub_total_price_Z002;?>">

<input type="hidden" readonly class='form-control temp_count_tool_Z002' name="temp_count_tool_Z002"  value="<?php echo $temp_count_tool_Z002;?>">

                        </div>
                  </div>
              <!--################################ end :div detail tool ############################-->

<!-- //////////////////////////////////////////////////// END : div detail table TOOL Z002 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- //////////////////////////////////////////////////// START : div detail table TOOL Z014 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

              <!--########################### Start :div detail tool ::  Z014_type คุมมูลค่า  ############################-->
                  <div class="panel panel-default ">

                    <div class="panel-heading font-bold h5" style="padding-bottom :24px;">                   
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTool2_db" class="toggle_tool_2">
                        <div class="row" style="margin-bottom:-20px;">                 
                          <span class="margin-left-medium"><?php echo freetext('Z014_type'); ?></span>
                          <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                             <span class="input-group-addon">                             
                                <font class="pull-left">
                                <?php  echo freetext('sub_total').' : '; ?>
                                </font>                         
                             </span> 
                             <input type="text" autocomplete="off" readonly name="sub_total" class="form-control text-right sub_total_Z014_DB" value="0">
                          </span>  
                        </div>
                      </a>
                    </div>

                   <!--  <div id="collapseTool2" class="panel-collapse in div-table"> -->
                      <div  id="collapseTool2_db" class="div-table panel-collapse in">  
                              <table  class="table no-padd table_chemical ">
                                  <thead>
                                    <tr class="back-color-gray h5">                          
                                      <th width="400"><?php echo freetext('tool');?></th>                                        
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
$temp_count_tool_Z014 = 0;
$sub_total_price_Z014 =0;

$exist_mat = array();

foreach($space_of_texture as $h => $h_space) {
  //echo "<br>====== texture_id : = " .$h. "|| space = ".$h_space." =========";

  $temp_bapi_tool_Z014 = $get_db_chemical->result_array();
  if(!empty($temp_bapi_tool_Z014)){

      $texture_des ='';
      foreach($bapi_texture->result_array() as $value){
        if($h == $value['material_no']){
            $texture_des = $value['material_description'];
        }//end if
      }//end foreach texture_des


     $total_quantity = 0;
     $price = 0;
     $total_price = 0;
     //$count_chemical = 0;
     $tempH_texture_id = $h;
     $tempH_mat_type = 'Z014';
     
     
     foreach($get_db_chemical->result_array() as $value){  
        if( $value['texture_id']==$h  && $value['mat_type']=='Z014'){// check น้ำยาคุมปริมาณ
          $temp_count_tool_Z014++;
          $sub_total_price_Z014 =  $sub_total_price_Z014+$value['total_price'];
            // echo "<br>===== get detail bomb ::".$value['material_no']." ===";
            // echo "<br> material_no ::".$value['material_no'];
            // echo "<br> material_description ::".$value['material_description'];
            // echo "<br> volumn ::".$value['volumn'];
            // echo "<br> unit_code ::".$value['unit_code'];
            // echo "<br> quantity ::".$value['quantity'];
            // echo "<br> price ::".$value['price'];

            // $total_quantity = calculate_quantity($h_space,$value['volumn'],$value['quantity']);
            // //echo "<br> total_quantity :: ".$total_quantity; 

            // $total_price = calculate_price($total_quantity,$value['price']);
            // //echo "<br> total_price :: ".$total_price; 
            array_push($exist_mat, $value['material_no']);
?>
              <tr class="h5" id="<?php echo $value['material_no'];?>">                                                   
                    <td>
                        <?php echo defill($value['material_no']).' '.$value['material_description']; ?>
                        <input type="hidden" readonly  class='form-control texture_id' name="<?php echo "texture_id_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['texture_id'];  ?>">
                        <input type="hidden" readonly  class='form-control material_no' name="<?php echo "material_no_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['material_no']; ?>">
                        <input type="hidden" readonly  class='form-control mat_type' name="<?php echo "mat_type_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['mat_type']; ?>">
                        <input type="hidden" readonly  class='form-control mat_group' name="<?php echo "mat_group_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['mat_group']; ?>">
                    </td>                                                      
                    <td class="tx-center">
                      <?php echo $value['quantity'].' '.$value['quantity_unit']; ?>
                      <input type="hidden" readonly  class='form-control space' name="<?php echo "space_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $h_space; ?>">
                      <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['quantity']; ?>">
                      <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['quantity_unit']; ?>">
                    </td>
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                    <td class="tx-center"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                        <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['price']; ?>">
                    </td>  
                    <td class="tx-center">
                      <?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>  
                      <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['total_price']; ?>">
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

      $temp_count_tool_Z014 = $temp_count_tool_Z014;
      //echo "<br>temp_count_tool_Z014 :: ".$temp_count_tool_Z014;    

  }else{//end temp_bapi_chemical_Z013
      //echo "<br> no data of bomb";
     // no data of bapi bomb
  }//end else  
 

}//enf foreach space type Z013

// echo "<br> count_chemical ::".$count_chemical;
if($temp_count_tool_Z014==0){
  echo "<tr class='no-data h5'><td calspan='6'>ไม่มีข้อมูล</td></tr>";
   //echo "<br>type:tool : no data of bomb";
}//end if count


//echo "<br>".$temp_count_tool_Z014;
//######################## END : GET MACHINE  ##################################

?>

  </tbody> 
  </table>
<!-- sub_total_price_Z014 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z014' name="sub_total_price_Z014"  value="<?php echo $sub_total_price_Z014;?>">
<input type="hidden" readonly class='form-control temp_count_tool_Z014' name="temp_count_tool_Z014"  value="<?php echo $temp_count_tool_Z014;?>">

</div>
</div>
 <!--########################### end :div detail tool ::  Z002_type คุมมูลค่า  ############################-->
<!-- //////////////////////////////////////////////////// END : div detail table TOOL Z014 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->


</div> <!--================== end get : data get_data_form_DB ===============-->











<?php  
//START :check job_type clering ZQT1
if( $this->job_type == 'ZQT1'){ 
?>
<!-- /////////////////////////////////////////// CLEARING ///////////////////////////////////////////////// -->
<!-- // TODO :: GET CLEARING -->
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



<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i> ต้นทุนอุปกรณ์ งานเคลียร์</h4>

<!--########################### Start :div detail tool ############################-->
    <div class="panel panel-default ">

      <div class="panel-heading font-bold h5" style="padding-bottom :24px;">    
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTool_clear" class="toggle_tool">
            <div class="row" style="margin-bottom:-20px;">  
            <span class="margin-left-medium"><?php echo freetext('tool'); ?></span>
            <span><i class="margin-top-small-toggle icon_tool_down fa fa-caret-down  text-active pull-right margin-right-medium"></i>
              <i class="margin-top-small-toggle icon_tool_up fa fa-caret-up text  pull-right margin-right-medium"></i></span>                             
             <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                 <span class="input-group-addon">                             
                    <font class="pull-left">
                    <?php  echo freetext('subtotal').' : '; ?>
                    </font>                         
                 </span> 
                 <input type="text" autocomplete="off" readonly name="total_clearing_tool" class="form-control text-right total_clearing_tool" value="0">
              </span>     
              </div>                
          </a>         
      </div>
                
          <div id="collapseTool_clear" class="panel-collapse in">
            <?php
              //get : count
                $count_clearing_tool=0;
                 $temp_count_tool = $get_clearing_job->result_array();
                  if(!empty($temp_count_tool)){
                      foreach($get_clearing_job->result_array() as $value){ 
                          if($value['mat_type']=='Z014' || $value['mat_type']=='Z002' ){
                             $count_clearing_tool++;
                          }//end if
                      }//end foreach
                  }else{
                     $count_clearing_tool=0;
                  }//end else
              ?>
            <input type="hidden" readonly class="form-control count_clearing_tool" name="count_clearing_tool" value="<?php echo $count_clearing_tool; ?>"/>
                 <!-- start :body detail table machine -->
                      <div class="panel-body" style="padding:0px 0px 0px 0px;">
                        <div class="form-group col-sm-12  no-padd" >
                         <!-- start : table Z002 -->
                            <table  class="table no-padd table_clearing_tool">
                                    <thead>
                                      <tr class="back-color-gray h5">                          
                                        <th width="400">
                                          <?php echo freetext('Z002_type'); ?>                                     
                                        </th>
                                        <th width="400"><?php echo freetext('tool');?></th>
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
              //===== GET type : Z002 form DB =======
              $total_clearing_Z002 =0;
              $count_tool=0;
              $temp_clearing_Z002 = $get_clearing_job->result_array();
              if(!empty($temp_clearing_Z002)){
                  foreach($get_clearing_job->result_array() as $value){ 
                      if($value['mat_type']=='Z002'){
                         $count_tool++;
                         $total_clearing_Z002 = $total_clearing_Z002+$value['total_price'];
             ?>

                 <tr class="h5" id="<?php echo $value['material_no'] ?>">
                     <td style="width:260px;">
                      <div class="input-group m-b">
                        <span class="input-group-addon"><font class="pull-left">frequency</font></span>
                        <select disabled data-parsley-required='true' data-parsley-error-message='' class="form-control frequency" name="tool_frequency_<?php echo $count_tool;?>">
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
                    <td><?php echo defill($value['material_no']).' '.$value['material_description']; ?>
                      <input type="hidden" readonly class="form-control material_no" name="tool_material_no_<?php echo $count_tool;?>" value="<?php echo $value['material_no']; ?>">
                      <input type="hidden" readonly class="form-control mat_type" name="tool_mat_type_<?php echo $count_tool;?>" value="<?php echo $value['mat_type']; ?>">
                      <input type="hidden" readonly class="form-control mat_group" name="tool_mat_group_<?php echo $count_tool;?>" value="<?php echo $value['mat_group']; ?>">
                    </td>
                    <td class="tx-center"><?php echo $value['quantity'].' '.$value['quantity_unit']; ?>
                      <input type="hidden" readonly class="form-control quantity" name="tool_quantity_<?php echo $count_tool;?>" value="<?php echo $value['quantity']; ?>">
                      <input type="hidden" readonly class="form-control unit_code" name="tool_unit_code_<?php echo $count_tool;?>" value="<?php echo $value['quantity_unit']; ?>">
                    </td>
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                    <td class="tx-center"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                      <input type="hidden" readonly class="form-control price" name="tool_price_<?php echo $count_tool;?>" value="<?php echo $value['price']; ?>">
                    </td>
                    <td class="tx-center"><?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>
                      <input type="hidden" readonly class="form-control total_price" name="tool_total_price_<?php echo $count_tool;?>" value="<?php echo $value['total_price']; ?>">
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
                   if($count_tool==0){  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";  }
              }else{

                  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";
              }//end else
              $count_tool = $count_tool;
              ?>                               
                                </tbody>                                                                
                                </table>  
                                <input type="hidden" autocomplete="off" readonly class='form-control text-right total_tfoot total_tfoot_Z002' placeholder="total" value="<?php echo $total_clearing_Z002; ?>">
                          <!-- end : table Z002 -->

                           <!-- start : table Z014 -->
                                <table  class="table no-padd table_clearing_tool">
                                    <thead>
                                     <tr class="back-color-gray h5">                          
                                        <th width="400">
                                          <?php echo freetext('Z014_type'); ?>                                     
                                        </th>
                                        <th width="400"><?php echo freetext('tool');?></th>
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
              //===== GET type : Z014 form DB =======
              $total_clearing_Z014 =0;
              $temp_clearing_Z014 = $get_clearing_job->result_array();
              //echo '<tr>'.print_r($temp_clearing_Z014).'<tr>';
              if(!empty($temp_clearing_Z014)){
                  foreach($get_clearing_job->result_array() as $value){ 
                      if($value['mat_type']=='Z014'){
                         $count_tool++;
                         $total_clearing_Z014 = $total_clearing_Z014 +$value['total_price'];
             ?>

                 <tr class="h5" id="<?php echo $value['material_no'] ?>">
                    <td style="width:260px;">
                      <div class="input-group m-b">
                        <span class="input-group-addon"><font class="pull-left">frequency</font></span>
                        <select disabled data-parsley-required='true' data-parsley-error-message='' class="form-control frequency" name="tool_frequency_<?php echo $count_tool;?>">
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
                    <td><?php echo defill($value['material_no']).' '.$value['material_description']; ?>
                      <input type="hidden" readonly class="form-control material_no" name="tool_material_no_<?php echo $count_tool;?>" value="<?php echo $value['material_no']; ?>">
                      <input type="hidden" readonly class="form-control mat_type" name="tool_mat_type_<?php echo $count_tool;?>" value="<?php echo $value['mat_type']; ?>">
                      <input type="hidden" readonly class="form-control mat_group" name="tool_mat_group_<?php echo $count_tool;?>" value="<?php echo $value['mat_group']; ?>">
                   </td>
                    <td class="tx-center"><?php echo $value['quantity'].' '.$value['quantity_unit']; ?>
                      <input type="hidden" readonly class="form-control quantity" name="tool_quantity_<?php echo $count_tool;?>" value="<?php echo $value['quantity']; ?>">
                      <input type="hidden" readonly class="form-control unit_code" name="tool_unit_code_<?php echo $count_tool;?>" value="<?php echo $value['quantity_unit']; ?>">
                    </td>
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                    <td class="tx-center"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                      <input type="hidden" readonly class="form-control price" name="tool_price_<?php echo $count_tool;?>" value="<?php echo $value['price']; ?>">
                    </td>
                    <td class="tx-center"><?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>
                      <input type="hidden" readonly class="form-control total_price" name="tool_total_price_<?php echo $count_tool;?>" value="<?php echo $value['total_price']; ?>">
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
                  if($count_tool==0){  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";  }
              }else{

                  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";
              }//end else
              $count_tool = $count_tool;
              ?>                                                
                                </tbody>                                                            
                                </table>  
                                <input type="hidden" autocomplete="off" readonly class='form-control text-right total_tfoot total_tfoot_Z014' placeholder="total" value="<?php echo $total_clearing_Z014; ?>">
                              <!-- end : table Z014 -->
                        </div><!-- end : col12-->
                      </div><!-- end :body detail table machine -->
          </div>
    </div>

<input type="hidden" autocomplete="off" readonly class='form-control text-right total_chemical_clearing' value="0">
<input type="hidden" autocomplete="off" readonly class='form-control text-right total_tfoot_Z005' value="0">

<!--################################ end :div detail tool ############################-->
<?php  
}//END :check job_type clering ZQT1
?>





<!-- //////////////////////////////// -->
<!-- form submit -->
<div class="form-group col-sm-12 ">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview/'.$this->quotation_id); ?>"  class="btn btn-info" style="width:120px;"> <?php echo freetext('back'); ?></a>
  </div>
</div>
<!-- end : form submit -->
</div><!-- end : class div_detail -->


          











