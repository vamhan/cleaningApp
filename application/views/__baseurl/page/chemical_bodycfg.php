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
<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i> ต้นทุนน้ำยา งานประจำ</h4>
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
<!--########################### Start :div detail chemical ############################-->

      <div class="panel panel-default ">

        <div class="panel-heading font-bold h5" style="padding-bottom :24px;">
          <!-- <h4 class="panel-title"> -->
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseCemical_db" class="toggle_chemicals">
              <?php echo freetext('chemical'); //Customer?>    
              <span><i class="margin-top-small-toggle icon_chemicals_down fa fa-caret-down  text-active pull-right"></i><i class="margin-top-small-toggle icon_chemicals_up fa fa-caret-up text  pull-right"></i></span>                           
              <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                   <span class="input-group-addon">                             
                      <font class="pull-left">
                      <?php  echo freetext('subtotal').' : '; ?>
                      </font>                         
                   </span> 
                   <input type="text" autocomplete="off" readonly name="totol_of_chemical_top_DB" class="form-control text-right totol_of_chemical_top_DB" value="0">
                </span>
            </a>                               
         <!--  </h4> -->
        </div>
        <div id="collapseCemical_db" class="panel-collapse in">
<!-- //////////////////////////////////////////////////// start : div detail table chemical type Z001 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
       
                 <!-- start :body detail table chemical -->
                <div class="panel-body" style="padding:15px 0px 0px 0px;">
                  <div class="form-group col-sm-12  no-padd" >
                    <!-- end : table -->
                    <section class="panel panel-default section_chemical_Z001"><!-- style="padding-bottom :24px;" -->

                      <header class="panel-heading font-bold h5 " > 
                        <div class="row" style="margin-bottom:15px;">                 
                          <span class="margin-left-medium"><?php echo freetext('Z001_type'); ?></span>                       
                        </div>
                      </header>

<?php
//################### start : GET TEXTURE น้ำยาคุมปริมาณ ##################################
$temp_count_chemical = 0;
$temp_count_space = 0;
$sub_total_price_Z001 =0;

$exist_mat = array();
foreach($space_of_texture as $b => $b_space) {
  //echo "<br>====== texture_id : = " .$b. "|| space = ".$b_space." =========";
 
  $temp_count_space++;
  $temp_bapi_chemical = $get_db_chemical->row_array();
  if(!empty($temp_bapi_chemical)){
   
    //echo "B:".$b.'<br>';
    $texture_des ='';
    foreach($bapi_texture->result_array() as $value){
      if($b == $value['material_no']){
          $texture_des = $value['material_description'];
      }//end if
    }//end foreach texture_des
               
?>
                            <div class="div-table">
                              <table  class="table table_chemical" data-id="<? echo $b; ?>" >
                                    <thead>
                                      <tr class="back-color-gray h5">                          
                                        <th  width="400"><?php echo $texture_des." X ".$b_space." (M2) ";  //echo  $temp_count_space;   //echo freetext('Glass X 1000 M2');?></th>
                                        <th  width="400"><?php echo freetext('chemical');?></th>
                                        <th class="tx-center"><?php echo freetext('quantity');?></th>
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                                        <th  class="tx-center"><?php echo freetext('price/area');?></th>
                                        <th  class="tx-center"><?php echo freetext('price (THB) ');?></th>    
<?php
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>            
                                      </tr>
                                    </thead>
                                    <tbody>

<?php
$material_total_price = 0;
$total_quantity = 0;
$price = 0;
$total_price = 0;
$count_chemical = 0;
$temp_texture_id = $b;
$temp_mat_type ='Z001';

foreach($get_db_chemical->result_array() as $value){  
if( $value['texture_id']==$b  && $value['mat_type']=='Z001'){// check น้ำยาคุมปริมาณ
  $count_chemical++;
  $sub_total_price_Z001 = $sub_total_price_Z001 +$value['total_price'];

  $material_total_price += $value['total_price'];
    // echo "<br>===== get detail bomb ::".$value['material_no']." ===";
    // echo "<br> material_no ::".$value['material_no'];
    // echo "<br> material_description ::".$value['material_description'];
    // echo "<br> volumn ::".$value['volumn'];
    // echo "<br> unit_code ::".$value['unit_code'];
    // echo "<br> quantity ::".$value['quantity'];
    // echo "<br> price ::".$value['price'];           

    // $total_quantity = calculate_quantity($b_space,$value['volumn'],$value['quantity']);
    // //echo "<br> total_quantity :: ".$total_quantity; 

    // $total_price = calculate_price($total_quantity,$value['price']);
    // //echo "<br> total_price :: ".$total_price; 

  array_push($exist_mat, $value['material_no']);
?>
                                          <tr class="h5" id="<?php echo $value['material_no'];?>"> 
                                              <td></td>   
                                              <td>
                                                  <?php echo defill($value['material_no']).' '.$value['material_description']; ?>
                                                  <input type="hidden" readonly  class='form-control texture_id' name="<?php echo "texture_id_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $value['texture_id'];  ?>">
                                                  <input type="hidden" readonly  class='form-control material_no' name="<?php echo "material_no_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $value['material_no']; ?>">
                                                  <input type="hidden" readonly  class='form-control mat_type' name="<?php echo "mat_type_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $value['mat_type']; ?>">
                                                  <input type="hidden" readonly  class='form-control mat_group' name="<?php echo "mat_group_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $value['mat_group']; ?>">
                                              </td>                                                      
                                              <td class="tx-center">
                                                <?php echo $value['quantity'].' '.$value['quantity_unit']; ?>
                                                <input type="hidden" readonly  class='form-control space' name="<?php echo "space_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $b_space; ?>">
                                                <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $value['quantity']; ?>">
                                                <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $value['quantity_unit']; ?>">
                                              </td>
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                                              <td class="tx-center"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                                                <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $value['price']; ?>"> 
                                              </td> 

                                              <td class="tx-center">
                                                <?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>                                                        
                                                <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $value['total_price']; ?>">
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

      $temp_count_chemical = $count_chemical;
      //echo "<br>temp_count_chemical :: ".$temp_count_chemical;

     // echo "<br> count_chemical ::".$count_chemical;
      if($count_chemical==0){
        echo "<tr class='no-data h5'><td></td><td calspan='6'>ไม่มีข้อมูล</td></tr>";
        //echo "<br>type:Z001 : no data of bomb";
      }//end if count
?> 
                                              </tbody> 
                                                                                                  
                                              </table>

                                               <input type="hidden" readonly class='form-control temp_count_chemical' name="<?php echo "temp_count_chemical_".$temp_count_space; ?>"  value="<?php echo $temp_count_chemical;?>">
                                               <input type="hidden" readonly name="temp_space_no" class='form-control temp_space_no' value="<?php echo $temp_count_space;?>">

                                             </div><!-- //div table -->

<?php

  }else{//end temparea
      echo "<tr class='no-data h5'><td></td><td calspan='6'>ไม่มีข้อมูล</td></tr>";
      //echo "<br> no data of bomb";
     // no data of bapi bomb
  }//end else

}//end foreach space_of_texture
//print_r($space_of_texture);
if(empty($space_of_texture)){
   echo "<tr><div class='h5' style='padding:10px;'>ไม่มีข้อมูล</div></tr>";
}
//################### END : GET TEXTURE ##################################
?> 
                      </section> <!-- end : table -->
                    </div><!-- end : col12-->
                  </div><!-- end :body detail table chemical -->
      
<!-- //////////////////////////////////////////////////// END : div detail table chemical type Z001 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->



<!-- //////////////////////////////////////////////////// START : div detail table chemical type Z013 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  
                                    <!-- start :body detail table chemical -->
                                    <div class="panel-body" style="padding:10px 0px 0px 0px;">
                                      <div class="form-group col-sm-12  no-padd" >
                                        <!-- end : table -->
                                        <section class=" panel panel-default section_chemical_Z013">                                         

                                           <header class="panel-heading font-bold h5 " > 
                                            <div class="row" style="margin-bottom:15px;">                 
                                              <span class="margin-left-medium"><?php echo freetext('Z013_type'); ?></span>                                         
                                            </div>
                                          </header>
<?php 
//################### start : GET TEXTURE น้ำยาคุมมูลค่า ##################################
$temp_count_space_type_Z013 = $temp_count_space; 

$sub_total_price_Z013 =0;
$exist_mat = array();
//$count_space_Z013 =0;
foreach($space_of_texture as $c => $c_space) {
  $temp_count_space_type_Z013++;
  //$count_space_Z013++;
  //echo "<br>====== texture_id : = " .$c. "|| space = ".$c_space." =========";

  $temp_bapi_chemical_Z013 = $get_db_chemical->result_array();
  if(!empty($temp_bapi_chemical_Z013)){

      $texture_des_Z013 ='';
      foreach($bapi_texture->result_array() as $value){
        if($c == $value['material_no']){
            $texture_des_Z013 = $value['material_description'];
        }//end if
      }//end foreach texture_des
?>

              <div class="div-table">
                 <table  class="table table_chemical" data-id="<? echo $c; ?>"  >
                        <thead>
                          <tr class="back-color-gray h5">                          
                            <th  width="400"><?php echo $texture_des_Z013." X ".$c_space." (M2) ";  echo  $temp_count_space_type_Z013;   //echo freetext('Glass X 1000 M2');?></th>
                            <th  width="400"> <?php echo freetext('chemical');?></th>
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

     $material_total_price = 0;
     $total_quantity = 0;
     $price = 0;
     $total_price = 0;
     //$count_chemical = 0;
     $tempC_texture_id = $c;
     $tempC_mat_type ='Z013';

     $temp_count_chemical_Z013 = 0;
     foreach($get_db_chemical->result_array() as $value){  
        if( $value['texture_id']==$c  && $value['mat_type']=='Z013'){// check น้ำยาคุมปริมาณ
          $temp_count_chemical_Z013++;
          $sub_total_price_Z013 = $sub_total_price_Z013 +$value['total_price'];

          $material_total_price += $value['total_price'];
            // echo "<br>===== get detail bomb ::".$value['material_no']." ===";
            // echo "<br> material_no ::".$value['material_no'];
            // echo "<br> material_description ::".$value['material_description'];
            // echo "<br> volumn ::".$value['volumn'];
            // echo "<br> unit_code ::".$value['unit_code'];
            // echo "<br> quantity ::".$value['quantity'];
            // echo "<br> price ::".$value['price'];

            

            // $total_quantity = calculate_quantity($c_space,$value['volumn'],$value['quantity']);
            // //echo "<br> total_quantity :: ".$total_quantity; 

            // $total_price = calculate_price($total_quantity,$value['price']);
            //echo "<br> total_price :: ".$total_price; 
          array_push($exist_mat, $value['material_no']);
?>

                                            <tr class="h5" id="<?php echo $value['material_no'];?>"> 
                                                      <td></td>   
                                                      <td>
                                                          <?php echo defill($value['material_no']).' '.$value['material_description']; ?>
                                                          <input type="hidden" readonly  class='form-control texture_id' name="<?php echo "texture_id_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $value['texture_id'];  ?>">
                                                          <input type="hidden" readonly  class='form-control material_no' name="<?php echo "material_no_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $value['material_no']; ?>">
                                                          <input type="hidden" readonly  class='form-control mat_type' name="<?php echo "mat_type_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $value['mat_type']; ?>">
                                                          <input type="hidden" readonly  class='form-control mat_group' name="<?php echo "mat_group_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $value['mat_group']; ?>">
                                                      </td>                                                      
                                                      <td class="tx-center">
                                                        <?php echo $value['quantity'].' '.$value['quantity_unit']; ?>
                                                        <input type="hidden" readonly  class='form-control space' name="<?php echo "space_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $c_space; ?>">
                                                        <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $value['quantity']; ?>">
                                                        <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $value['quantity_unit']; ?>">
                                                      </td>
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                                                      <td class="tx-center"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                                                        <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $value['price']; ?>">
                                                      </td>  
                                                      <td class="tx-center">
                                                        <?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>  
                                                        <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo  $value['total_price']; ?>">
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

      $temp_count_chemical_Z013 = $temp_count_chemical_Z013;
      //echo "<br>temp_count_chemical :: ".$temp_count_chemical_Z013;

     // echo "<br> count_chemical ::".$count_chemical;
      if($temp_count_chemical_Z013==0){
        echo "<tr class='no-data h5'><td></td><td calspan='6'>ไม่มีข้อมูล</td></tr>";
         //echo "<br>type:Z001 : no data of bomb";
      }//end if count

?>
                                            </tbody>                                                  
                                              </table>
                                              <input type="hidden" readonly class='form-control temp_count_chemical' name="<?php echo "temp_count_chemical_".$temp_count_space_type_Z013; ?>"  value="<?php echo $temp_count_chemical_Z013;?>" >
                                              <input type="hidden" readonly name="temp_space_no" class='form-control temp_space_no' value="<?php echo $temp_count_space_type_Z013;?>">

                                            </div><!-- END <div class="div-table"> -->

<?php

  }else{//end temp_bapi_chemical_Z013
     //echo "<br> no data of bomb";
       echo "<tr class='no-data h5'><td></td><td calspan='6'>ไม่มีข้อมูล</td></tr>";
     // no data of bapi bomb
  }//end else  
}//enf foreach space type Z013
//print_r($space_of_texture);
if(empty($space_of_texture)){
   echo "<tr><div class='h5' style='padding:10px;'>ไม่มีข้อมูล</div></tr>";
}
//echo "<br>".$temp_count_space_type_Z013;
//################### End : GET TEXTURE น้ำยาคุมมูลค่า ##################################
?>

        
                                           </section> <!-- end : table -->
                                      </div><!-- end : col12-->
                                    </div><!-- end :body detail table chemical -->
    </div>
</div>                      
              <!--################################ end :div detail chemical ############################-->

<!-- //////////////////////////////////////////////////// END : div detail table chemical type Z013 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- sub_total_price_Z001 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z001' name="sub_total_price_Z001"  value="<?php echo $sub_total_price_Z001;?>">

<!-- sub_total_price_Z013 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z013' name="sub_total_price_Z013"  value="<?php echo $sub_total_price_Z013;?>">


<!-- input sub_total_chemical_DB -->
<?php  $sub_total_chemical_DB = $sub_total_price_Z001+$sub_total_price_Z013; ?>
<input type="hidden" readonly name="sub_total_chemical_DB" class='form-control sub_total_chemical_DB'  value="<?php echo $sub_total_chemical_DB;?>">
 

<!-- input temp_count_space_Z001 -->
<input type="hidden" readonly name="temp_count_space_Z001" class='form-control temp_count_space_Z001' placeholder="temp_count_space_Z001" value="<?php echo $temp_count_space_type_Z013;?>">
                                      


<!-- //////////////////////////////////////////////////// START : div detail table MATCHIE Z005 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- sub_total_price_Z005 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z005' name="sub_total_price_Z005"  value="<?php echo $sub_total_price_Z005;?>">

<input type="hidden" readonly class='form-control temp_count_machine' name="temp_count_machine"  value="<?php echo $temp_count_machine;?>">

<!-- //////////////////////////////////////////////////// END : div detail table MATCHIE Z005 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- //////////////////////////////////////////////////// START : div detail table TOOL Z002 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- sub_total_price_Z002 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z002' name="sub_total_price_Z002"  value="<?php echo $sub_total_price_Z002;?>">

<input type="hidden" readonly class='form-control temp_count_tool_Z002' name="temp_count_tool_Z002"  value="<?php echo $temp_count_tool_Z002;?>">


<!-- //////////////////////////////////////////////////// END : div detail table TOOL Z002 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- //////////////////////////////////////////////////// START : div detail table TOOL Z014 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- sub_total_price_Z014 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z014' name="sub_total_price_Z014"  value="<?php echo $sub_total_price_Z014;?>">
<input type="hidden" readonly class='form-control temp_count_tool_Z014' name="temp_count_tool_Z014"  value="<?php echo $temp_count_tool_Z014;?>">

<!-- //////////////////////////////////////////////////// END : div detail table TOOL Z014 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<input type="hidden" autocomplete="off" readonly name="total_all" class="form-control text-right total_all" value="<?php echo  $total_all; ?>">

</div> <!--================== end get : data get_data_form_DB ===============-->













<?php  
//START :check job_type clering ZQT1
if( $this->job_type == 'ZQT1'){ 
?>
<!-- ///////////////////////////////////////////  CLEARING ///////////////////////////////////////////////// -->

<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i> ต้นทุนน้ำยา งานเคลียร์</h4>

<!--########################### Start :div detail chemical ############################-->
            <div class="panel panel-default ">

              <div class="panel-heading font-bold h5" style="padding-bottom :20px;">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseCemical_clear" class="toggle_clear_chemicals ">
                    <?php echo freetext('chemical'); //Customer?>                                  
                     <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                         <span class="input-group-addon">                             
                            <font class="pull-left">
                            <?php  echo freetext('sub_total').' : '; ?>
                            </font>                         
                         </span> 
                         <input type="text" autocomplete="off" readonly name="sub_total_chemical_clearing" class="form-control text-right sub_total_chemical_clearing" value="0">
                      </span>                     
                  </a>        
              </div>


              <div id="collapseCemical_clear" class="panel-collapse in">
                  <!-- start :body detail table chemical -->
                    <div class="panel-body" style="padding:0px 0px 0px 0px;">
                      <div class="form-group col-sm-12  no-padd" >  
                               <section class="panel-default  div-frequency-clearing">
                                <?php
                                //get : count
                                $count_row_frequency=0;
                                 $temp_count_row = $get_clearing_job->result_array();
                                  if(!empty($temp_count_row)){
                                      foreach($get_clearing_job->result_array() as $value){ 
                                          if($value['mat_type']=='Z001' || $value['mat_type']=='Z013'){
                                             $count_row_frequency++;
                                          }//end if
                                      }//end foreach
                                  }else{
                                     $count_row_frequency=0;
                                  }//end else
                                ?>
                                <input type="hidden" readonly class="form-control count_row_frequency" name="count_row_frequency" value="<?php echo $count_row_frequency; ?>"/>
    
<?php 
 $count_chemical =0;
 $count_clearing_number =0;
 $total_chemical_clearing =0;
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
//print_r(count($array_frequency));
// echo "<br>";
//== TODO :: get  area clearing =======================
    
$temp_clearing_type =array('');
$temp_clearing_name =array();
$temp_frequen= $array_frequency;
if(!empty($temp_frequen)){
   foreach($array_frequency as $fre => $fre_value) { 
    if($fre != 0){
?>                           
                       
                                 <header class="panel-heading font-bold h5 " style="padding-bottom :24px;">                  
                                  <span><?php echo 'Frequency '.$fre_value.' month';  //echo freetext('Frequency 3 month'); ?></span>                                 
                               </header>                               
<?php       
       //echo '<br>/////////////////// frequency : '.$fre_value.' //////////////////////';
            foreach($get_area->result_array() as $value){ 
              if($value['is_on_clearjob']==1 && $value['frequency']==$fre_value){
                  // echo '<br>///// clear_job_type_id : '.$value['clear_job_type_id'].' //////////';
                  // echo '<br>clearing_des : '.$value['clearing_des'];                  
                if (in_array( $value['clear_job_type_id'], $temp_clearing_type, TRUE)){                
                        //echo "have";
                }else{
                    //echo "nohave";
                    array_push($temp_clearing_type,$value['clear_job_type_id']);  
                    $temp_clearing_name[$value['clear_job_type_id']] = $value['clearing_des'];          
                }//end else 
                //set : $count_space_for_clearing =0;               
              }//end if check clearing
           }//end foreach  
            $count_array_clering = count($temp_clearing_name);
 ?>
 <input type="hidden" readonly class="form-control count_clearing_frequency" name="<?php echo "count_clearing_frequency_".$fre_value;?>" value="<?php echo $count_array_clering; ?>"/>
<?php 

      }//end if

          // echo "<br>";
          // echo "temp_clearing_type_name :";
          // print_r($temp_clearing_name);
          // echo "<br>";
           $total_clearing_frequency =0; 
           $count_array_clering = count($temp_clearing_name);
           $temp_count_clearing = 0;
           $count_space =0;          
           foreach($temp_clearing_name as $clear_id => $clear_value) {    
            $count_clearing_number++;        
            $temp_count_clearing++; 

              foreach($get_area->result_array() as $value){ 
                    if( $clear_id==$value['clear_job_type_id'] && $fre_value == $value['frequency']){
                      //echo '<br>space :'.$value['space'];
                      $count_space = $count_space  +$value['space'];
                    }//end if
                }//end end foreach 
               $count_space =   number_format($count_space, 2, '.', '');               
               //echo '<br>count_space : '.$count_space;
  ?>    
                 
                      <header class="panel-heading font-bold h5 " style="padding-bottom :24px;">                  
                        <span><?php  echo $clear_value.' X '.$count_space.' M2 ';//.$count_clearing_number; //echo freetext('Glass X 1000 M2');?></span>                      
                     </header>
                     <!-- start : table Z001 -->
                            <table  class="table no-padd table_chemical">
                                    <thead>
                                      <tr class="back-color-gray h5">                          
                                        <th width="400">
                                          <?php echo freetext('Z001_type'); ?>                                     
                                        </th>
                                        <th width="400"><?php echo freetext('chemical');?></th>
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
              //===== GET type : Z001 form DB =======    
              $exist_mat = array();
              $total_clearing_Z001 = 0;          
              $temp_clearing_Z001 = $get_clearing_job->result_array();
              if(!empty($temp_clearing_Z001)){
                  foreach($get_clearing_job->result_array() as $value){ 
                      if($value['mat_type']=='Z001' && $value['frequency']==$fre_value && $value['clear_type_id']==$clear_id ){
                         $count_chemical++;
                         $total_clearing_Z001 = $total_clearing_Z001+$value['total_price'];

                        array_push($exist_mat, $value['material_no']);
              ?>

                 <tr class="h5" id="<?php echo $value['material_no'] ?>">
                    <td></td>
                    <td><?php echo  defill($value['material_no']).' '.$value['material_description']; ?>
                      <input type="hidden" readonly class="form-control material_no" name="material_no_<?php echo $count_chemical;?>" value="<?php echo $value['material_no']; ?>">
                      <input type="hidden" readonly class="form-control mat_type" name="mat_type_<?php echo $count_chemical;?>" value="<?php echo $value['mat_type']; ?>">
                      <input type="hidden" readonly class="form-control mat_group" name="mat_group_<?php echo $count_chemical;?>" value="<?php echo $value['mat_group']; ?>">
                      <input type="hidden" readonly class="form-control frequency" name="frequency_<?php echo $count_chemical;?>" value="<?php echo $value['frequency']; ?>">
                      <input type="hidden" readonly class="form-control clearing_type" name="clearing_type_<?php echo $count_chemical;?>" value="<?php echo $value['clear_type_id']; ?>">
                    </td>
                    <td class="tx-center"><?php echo $value['quantity'].' '.$value['quantity_unit']; ?>
                      <input type="hidden" readonly class="form-control quantity" name="quantity_<?php echo $count_chemical;?>" value="<?php echo $value['quantity']; ?>">
                      <input type="hidden" readonly class="form-control unit_code" name="unit_code_<?php echo $count_chemical;?>" value="<?php echo $value['quantity_unit']; ?>">
                    </td>

<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                    <td class="tx-center"><?php echo number_format($value['price'],2); ?>
                      <input type="hidden" readonly class="form-control price" name="price_<?php echo $count_chemical;?>" value="<?php echo $value['price']; ?>">
                    </td>
                    <td class="tx-center"><?php echo number_format($value['total_price'],2); // echo $value['total_price']; ?>
                      <input type="hidden" readonly class="form-control total_price" name="total_price_<?php echo $count_chemical;?>" value="<?php echo $value['total_price']; ?>">
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
                     if($count_chemical==0){  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";  }
                  $count_chemical = $count_chemical;
                  $total_chemical_clearing =$total_chemical_clearing +  $total_clearing_Z001;
                  $total_clearing_frequency =$total_clearing_frequency +  $total_clearing_Z001;
              }else{

                  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";
              }//end else
              ?>
                                                           
                                    </tbody> 
                                    <tfoot>                                    
                                      <tr>
                                          <!-- <td></td>
                                          <td></td> -->
                                          <td></td>
                                          <td></td>
                                          <td><input type="hidden" autocomplete="off" readonly class='form-control text-right total_tfoot' placeholder="total" value="<?php echo $total_clearing_Z001; ?>"></td>
                                       </tr>
                                    </tfoot>                                
                                </table>  
                          <!-- end : table Z001 -->

                           <!-- start : table Z013 -->
                                <table  class="table no-padd table_chemical">
                                    <thead>
                                     <tr class="back-color-gray h5">                          
                                        <th width="400">
                                          <?php echo freetext('Z013_type'); ?>                                     
                                        </th>
                                        <th width="400"><?php echo freetext('chemical');?></th>
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
              //===== GET type : Z013 form DB =======
            $exist_mat = array();
            $total_clearing_Z013 = 0; 
              $temp_clearing_Z013 = $get_clearing_job->result_array();
              if(!empty($temp_clearing_Z013)){
                  foreach($get_clearing_job->result_array() as $value){ 
                      if($value['mat_type']=='Z013' && $value['frequency']==$fre_value && $value['clear_type_id']==$clear_id ){
                         $count_chemical++;
                         $total_clearing_Z013 = $total_clearing_Z013 + $value['total_price'];

                         array_push($exist_mat, $value['material_no']);
             ?>

                 <tr class="h5" id="<?php echo $value['material_no'] ?>">
                    <td></td>
                    <td><?php echo  defill($value['material_no']).' '.$value['material_description']; ?>
                      <input type="hidden" readonly class="form-control material_no" name="material_no_<?php echo $count_chemical;?>" value="<?php echo $value['material_no']; ?>">
                      <input type="hidden" readonly class="form-control mat_type" name="mat_type_<?php echo $count_chemical;?>" value="<?php echo $value['mat_type']; ?>">
                      <input type="hidden" readonly class="form-control mat_group" name="mat_group_<?php echo $count_chemical;?>" value="<?php echo $value['mat_group']; ?>">
                      <input type="hidden" readonly class="form-control frequency" name="frequency_<?php echo $count_chemical;?>" value="<?php echo $value['frequency']; ?>">
                      <input type="hidden" readonly class="form-control clearing_type" name="clearing_type_<?php echo $count_chemical;?>" value="<?php echo $value['clear_type_id']; ?>">
                    </td>
                    <td class="tx-center"><?php echo $value['quantity'].' '.$value['quantity_unit']; ?>
                      <input type="hidden" readonly class="form-control quantity" name="quantity_<?php echo $count_chemical;?>" value="<?php echo $value['quantity']; ?>">
                      <input type="hidden" readonly class="form-control unit_code" name="unit_code_<?php echo $count_chemical;?>" value="<?php echo $value['quantity_unit']; ?>">
                    </td>
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                    <td class="tx-center"><?php echo number_format($value['price'],2);// echo $value['price']; ?>
                      <input type="hidden" readonly class="form-control price" name="price_<?php echo $count_chemical;?>" value="<?php echo $value['price']; ?>">
                    </td>
                    <td class="tx-center"><?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>
                      <input type="hidden" readonly class="form-control total_price" name="total_price_<?php echo $count_chemical;?>" value="<?php echo $value['total_price']; ?>">
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
                  if($count_chemical==0){  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";  }
                  $count_chemical = $count_chemical;
                  $total_chemical_clearing =$total_chemical_clearing +  $total_clearing_Z013;
                  $total_clearing_frequency =$total_clearing_frequency +  $total_clearing_Z013;
              }else{

                  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";
              }//end else
              
              ?>                     
                                    </tbody> 
                                   <tfoot>
                                      <tr>
                                         <!--  <td></td>
                                          <td></td> -->
                                          <td></td>
                                          <td></td>
                                          <td><input type="hidden" readonly class='form-control text-right total_tfoot' placeholder="total" value="<?php echo $total_clearing_Z013; ?>"></td>
                                       </tr>
                                    </tfoot>                                     
                                </table>  
                              <!-- end : table Z013 -->


                                <!-- ##################### START : ALL TOTAL ###############################################  --> 
<?php
//===== GET : total_price_staff_clearing ========
$price_job =0;
// echo 'clear_id :'.$clear_id;
// echo 'fre_value :'.$fre_value;
$temp_price_staff= $get_area->result_array();
if(!empty($temp_price_staff)){
  foreach($get_area->result_array() as $value_price){  
      if($value_price['frequency']== $fre_value && $value_price['clear_job_type_id']== $clear_id){
              $staff = $value_price['staff']; 
              $job_rate = $value_price['job_rate'];              
              $price_job = ($staff*$job_rate);
              $price_job = number_format($price_job, 2, '.', '');

              $other = $value_price['other'];
              $other_value = $value_price['other_value']; 
              $total_price_staff_clear = $value_price['total_price_staff_clear'];  

      }//end if
  }// foreach
}else{
     $staff = ''; 
     $job_rate = '';  
     $price_job =0;
     $other = '';
     $other_value = ''; 
     $total_price_staff_clear = 0; 

}//end else
            
  $count_space =0;
   }//end foreach temp_clearing_name
  //set : array annd count space          
  $temp_clearing_type =array();
  $temp_clearing_name =array();

  if($fre_value!=0){
?>
<!-- /// total_clearing_frequency_ -->
<input  type="hidden" readonly class="total_clearing_frequency_<?php echo $fre_value; ?>" value="<?php echo $total_clearing_frequency; ?>" >

<?


      }//end if fre!= 0
  }//end foreach   
}//end if empty

//print_r(count($array_frequency));
if(count($array_frequency)==1){
   echo "<tr><div class='h5' style='padding:10px;'>ไม่มีข้อมูล</div></tr>";
}//array empty
?>
             
             </section> <!-- end : table -->                                            
        </div><!-- end : col12-->
      </div><!-- end :body detail table chemical -->
</div>
</div>
<!--################################ end :div detail chemical ############################-->

<!-- /// total_chemical_clearing -->
<input  type="hidden" readonly class="total_chemical_clearing" value="<?php echo $total_chemical_clearing; ?>" >
<input type="hidden" autocomplete="off" readonly class='form-control text-right total_tfoot_Z005' value="0">
<input type="hidden" autocomplete="off" readonly class='form-control text-right total_tfoot_Z002' value="0">
<input type="hidden" autocomplete="off" readonly class='form-control text-right total_tfoot_Z014' value="0">
<input type="hidden" autocomplete="off" readonly class='form-control text-right total_clearing_tool' value="0">



<?php  
}//End :check job_type clering ZQT1
?>





<!-- ////////////////////////////////////////////// -->

<!-- form submit -->
<div class="form-group col-sm-12 ">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview/'.$this->quotation_id); ?>"  class="btn btn-info" style="width:120px;"> <?php echo freetext('back'); ?></a>
  </div>
</div>
<!-- end : form submit -->
</div><!-- end : class div_detail -->


          











