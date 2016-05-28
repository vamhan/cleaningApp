
<?php

 //check doble 2 set comma ================ 
    // $number = 54321.56;     
    // echo "Original Number = ".$number;
    // echo "<br/>";
     
    // echo number_format($number);
    // echo "<br/>";
     
    // echo number_format($number, 2, ',', ' ');
    // echo "<br/>";
     
    // $number = 1234.5678;
     
    // echo number_format($number, 2, '.', '');
    //echo "<br/>";

    // $num = 10/3;//3.333333333
    // $result = sprintf(%.2f,$num);
    // print $result; //3.33

    // echo "<br/>";
    // $number = 234.8594;
    // $english_format_number = number_format($number, 2, '.', '');
    // echo $english_format_number;

//echo ceil( 1.50 );
//check doble 2 set comma ================ 


/// query job_type
 $data_job_type = $query_quotation->row_array();
 if(!empty($data_job_type)){      
     $job_type  = $data_job_type['job_type'];      
     $time_qt  = $data_job_type['time'];
     $acc_gr  = $data_job_type['account_group'];  
  }else{
    $job_type =''; 
    $time_qt  ='';
    $acc_gr  ='';  
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
// $check_recalcurate  =0;

// foreach($space_of_texture as $ar => $ar_space) {
//   foreach($space_of_texture_DB as $tdb => $tdb_space) {
//       if($ar == $tdb){
//          // echo 'area :'.$ar.' |  area_DB :'.$tdb.'<br>';
//          // echo 'tbt_area :'.$ar_space.' tbt_equipment :'.$tdb_space." ::<br>";
//           if($ar_space==$tdb_space){  
//               //echo " yes";
//              $check_recalcurate  =0;
//           }else{     
//               //echo " no";
//               $check_recalcurate  =1;
//           }
//           //echo "<br>";
//       }
//    }//end foreach space_of_texture DB
// }//end foreach space_of_texture AREA

// //echo "<br> check_recalcurate :".$check_recalcurate;

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



//////////////// CHECK data FROM BOMB OR DB ///////////////////////
$check_data_from_DB = 0;
$temp_data = $get_db_chemical->result_array();
if(!empty($temp_data)){
    // foreach($get_db_chemical->result_array() as $value_db){ 
    // }//end foreach
  $check_data_from_DB = 1;
}else{
  $check_data_from_DB = 0;
}//end if

//echo '<br> check : '.$check_data_from_DB;
//////////////// CHECK data FROM BOMB OR DB ///////////////////////



?>








<!-- stat : div tab3 empty -->
<div class="col-sm-12 no-padd div_tab3_empty" style="padding-top:30px;" >
  <section class="panel panel-default">
    <header class="panel-heading bg-danger lt no-border">
      <div class="clearfix">
        <span class="pull-left thumb-sm tx-white"><i class="fa fa-warning fa-3x "></i></span>
        <div class="clear margin-left-medium " style="padding-left:25px;">
          <div class="h3 m-t-xs m-b-xs text-white">
            ผิดพลาด : กรุณาเพิ่มข้อมูลให้ครบถ้วน
           <!--  <i class="fa fa-circle text-white pull-right text-xs m-t-sm"></i> -->
          </div>
          <small class="text-muted h5">กรุณาเพิ่มข้อมูลตามด้านล่าง</small>
        </div>                
      </div>
    </header>
    <ul class="list-group no-radius alt">
      <li class="list-group-item" href="#">  
      <!--   <span class="badge bg-success">25</span> -->
        <i class="fa fa-circle icon-muted"></i> 
          <span class="h5 margin-left-medium">ไม่มีข้อมูล ลูกค้า</span>
      </li>
    <?php if( $job_type !='ZQT3' && $acc_gr !='Z16'){ ?> 
      <li class="list-group-item" href="#">
       <!--  <span class="badge bg-info">16</span> -->
        <i class="fa fa-circle icon-muted"></i> 
          <span class="h5 margin-left-medium">ไม่มีข้อมูล พื้นที่</span>
      </li>
    <?php } ?>
       <!--  <li class="list-group-item" href="#">
          <i class="fa fa-circle icon-muted"></i> 
            <span class="h5 margin-left-medium">Profile visits</span>
        </li> -->
    </ul>
  </section>
<!-- end : div tab3 empty -->

</div>





 

<div class="detail_body_tab3"> 
<form role="form" action="<?php echo site_url('__ps_quotation/update_quotation_chemical/'.$this->quotation_id) ?>" method="POST" id="form_chemical"> 
<input type="hidden" class="check_data_from_DB_input" value="<?php echo $check_data_from_DB; ?>"/>  
<input type="hidden" readonly="readonly" class="job_type_chemical" name="job_type_chemical" value="<?php echo $job_type; ?>"/> 
<input type="hidden" readonly="readonly" class="acc_gr" name="acc_gr" value="<?php echo $acc_gr; ?>"/>  
<input type="hidden" readonly="readonly" class="time_chemical" value="<?php echo $time_qt; ?>"/>  
<!--################################ start :tab contract and other ############################-->
   <!-- .nav-justified -->
    <section class="panel panel-default">
      <header class="panel-heading bg-light">
        <ul class="nav nav-tabs nav-justified">
            <?php if( $job_type !='ZQT3' && $acc_gr !='Z16'){ ?> 
            <li class="h5 chemical active"><a href="#chemical" data-toggle="tab"><?php echo freetext('chemical');?></a></li>
            <?php } ?>
            <li class="h5 other_chemical"><a href="#other_chemical" data-toggle="tab"><?php if($job_type !='ZQT3' && $acc_gr !='Z16'){ echo freetext('customer_request'); }else{  echo freetext('chemical'); } ?></a></li>                           
        </ul>
      </header>
      <div class="panel-body" ><!-- style="padding:20px 0px 0px 0px;" -->
        <div class="tab-content ">
          
          <!--################## start : tab track asset ################## -->
          <div class="tab-pane active <?php if($job_type == 'ZQT3'  || $acc_gr == 'Z16'){ echo 'hide';} ?>" id="chemical"   >  

           <!--  <div class="row btn-recalcurate">
              <span <?php//if($check_recalcurate==0){ echo "disabled"; }  ?> id="recalcurate" class="btn btn-s-md btn-info pull-right margin-right-medium  ">
                 <i class="fa fa-repeat h5"></i> <?php //echo freetext('recalcurate'); ?>
              </span>
            </div><br/> -->

          <?php if($check_data_from_DB==0){ ?>
            <div class="get_data_form_bombe ">
                   <!--########################### Start :div detail chemical ############################-->
                          <div class="panel panel-default ">

                            <div class="panel-heading font-bold h5" style="padding-bottom :24px;">
                              <!-- <h4 class="panel-title"> -->
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseCemical" class="toggle_chemicals">
                                  <?php echo freetext('Chemicals_type'); //Customer?>    
                                  <span><i class="margin-top-small-toggle icon_chemicals_down fa fa-caret-down  text-active pull-right"></i><i class="margin-top-small-toggle icon_chemicals_up fa fa-caret-up text  pull-right"></i></span>                           
                                  <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                                       <span class="input-group-addon">                             
                                          <font class="pull-left">
                                          <?php  echo freetext('subtotal').' : '; ?>
                                          </font>                         
                                       </span> 
                                       <input type="text" autocomplete="off" readonly name="totol_of_chemical_top_DB_bomb" class="form-control totol_of_chemical_top_DB_bomb text-right" value="0">
                                    </span>
                                </a>                               
                             <!--  </h4> -->
                            </div>

                            <div id="collapseCemical" class="panel-collapse in">

<!-- ////////////////////////////////////////// START : div detail table chemical type Z001 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                                  
                              <!-- start :body detail table chemical -->
                                    <div class="panel-body" style="padding:15px 0px 0px 0px;">
                                      <div class="form-group col-sm-12  no-padd" >
                                        <!-- end : table -->
                                        <section class="panel panel-default section_chemical_Z001"><!-- style="padding-bottom :24px;" -->
                                          <header class="panel-heading font-bold h5 " > 
                                            <div class="row" style="margin-bottom:-15px;">                 
                                              <span class="margin-left-medium"><?php echo freetext('Z001_type'); ?></span>
                                              <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                                                 <span class="input-group-addon">                             
                                                    <font class="pull-left">
                                                    <?php  echo freetext('sub_total').' : '; ?>
                                                    </font>                         
                                                 </span> 
                                                 <input type="text" autocomplete="off" readonly name="sub_total" class="form-control sub_total_Z001_DB_bomb text-right" value="0">
                                              </span>  
                                              </div>
                                          </header>
<?php
//################### start : GET TEXTURE น้ำยาคุมปริมาณ ##################################
$temp_count_chemical = 0;
$temp_count_space = 0;
$sub_total_price_Z001_bomb =0;

$exist_mat = array();
foreach($space_of_texture as $b => $b_space) {
  //echo "<br>====== texture_id : = " .$b. "|| space = ".$b_space." =========";
 
  $temp_count_space++;
  $temp_bapi_chemical = $bapi_bomb->row_array();

  // echo "<pre>";
  // print_r($temp_bapi_chemical);
  // echo "</pre>";

  if(!empty($temp_bapi_chemical)){

    $texture_des ='';
    foreach($bapi_texture->result_array() as $value){
      if($b == $value['material_no']){
          $texture_des = $value['material_description'];
      }//end if
    }//end foreach texture_des
    
            
?>
                                            <div class="div-table">
                                            <table  class="table table_chemical" data-id="<?php echo $b; ?>">
                                                  <thead>
                                                    <tr class="back-color-gray h5">                          
                                                      <th><?php echo $texture_des." X ".$b_space." (M2) ";  //echo  $temp_count_space;   //echo freetext('Glass X 1000 M2');?></th>
                                                      <th><?php echo freetext('chemical');?></th>
                                                      <th class="tx-center"><?php echo freetext('quantity');?></th>
                                                      <th><?php echo freetext('price/area');?></th>
                                                      <th><?php echo freetext('price (THB) ');?></th>
                                                      <th class="tx-center">                              
                                                          <?php echo freetext('action');?>
                                                      </th>                          
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
     foreach($bapi_bomb->result_array() as $value){  
        if( $value['texture_id']==$b  && $value['mat_type']=='Z001'){// check น้ำยาคุมปริมาณ
          $count_chemical++;
          

            // echo "<br>===== get detail bomb ::".$value['material_no']." ===";
            // echo "<br> material_no ::".$value['material_no'];
            // echo "<br> material_description ::".$value['material_description'];
            // echo "<br> volumn ::".$value['volumn'];
            // echo "<br> unit_code ::".$value['unit_code'];
            // echo "<br> quantity ::".$value['quantity'];
            // echo "<br> price ::".$value['price'];           

            $total_quantity = calculate_quantity($b_space,$value['volumn'],$value['quantity']);
            //echo "<br> total_quantity :: ".$total_quantity; 

            $total_price = calculate_price($total_quantity,$value['price']);
            //echo "<br> total_price :: ".$total_price; 

            $sub_total_price_Z001_bomb = $sub_total_price_Z001_bomb + $total_price;

            $material_total_price += $total_price;

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
                                                        <?php echo $total_quantity.' '.$value['unit_code']; ?>
                                                        <input type="hidden" readonly  class='form-control space' name="<?php echo "space_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $b_space; ?>">
                                                        <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $total_quantity; ?>">
                                                        <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $value['unit_code']; ?>">
                                                      </td>
                                                      <td class="text-right"><?php echo "test".number_format($value['price'],2); //echo $value['price']; ?>
                                                        <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $value['price']; ?>"> 
                                                      </td> 
                                                      <td class="text-right">
                                                        <?php echo "test".number_format($total_price,2);//echo $total_price; ?>                                                        
                                                        <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $total_price; ?>">
                                                      </td>                                            
                                                      <td class="tx-center"> 
                                                          <span class="margin-left-small">
                                                            <button type="button" data-id="<?php echo $value['material_no'];?>" data-txt="<?php echo defill($value['material_no']).' '.str_replace('"', "''", $value['material_description']);?>" onclick="SomeDeleteRowFunction_total(<?php echo $total_price; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                                            </button>
                                                          </span>

                                                      </td>                          
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
                                                  <tfoot>
                                                    <tr>
                                                      <td></td>
                                                        <td>  
                                                         <select class="select2   no-padd h5 select_chemical" name="select_chemical" style="width:250px;">
                                                              <option selected='selected' value='0'>กรุณาเลือก</option>
                                                               <?php 
                                                                    $temp_bapi_chemical_Z001= $bapi_chemical_Z001->result_array();
                                                                    if(!empty($temp_bapi_chemical_Z001)){
                                                                    foreach($bapi_chemical_Z001->result_array() as $value){  
                                                                      if (!in_array($value['material_no'], $exist_mat)) {                                    
                                                                 ?>
                                                                     <option  value='<?php echo $value['material_no'] ?>'><?php echo  defill($value['material_no']).' '.$value['material_description'] //echo ' |'.$value['price']; ?></option> 
                                                                <?php                                   
                                                                      }
                                                                    }//end foreach
                                                                   }else{ ?>
                                                                     <option value='0'>ไม่มีข้อมูล</option> 
                                                                <?php } ?>
                                                          </select>  

                                                           <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                                           <input type="hidden" readonly class='form-control temp_texture_id' value="<?php if(!empty($temp_texture_id)){   echo  $temp_texture_id; }?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_type'   value="<?php if(!empty($temp_mat_type)){  echo  $temp_mat_type;   }?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_group'   value="" >

                                                           <span class="text_msg1 tx-red"></span>
                                                        </td>
                                                        <td>                                        
                                                          <center>                                            
                                                             <div class="input-group m-b"  style="width:180px;">
                                                              <input type="text" autocomplete="off" readonly onkeypress="return isDouble(event)"  name="temp_quantity" class="form-control temp_quantity" placeholder='<?php echo freetext('quantity'); ?>'>
                                                              <span class="input-group-addon text_unit"><?php echo freetext('unit'); ?></span>
                                                            </div>
                                                          </center>
                                                          <input type="hidden" readonly class='form-control temp_unit' >
                                                          <input type="hidden" readonly class='form-control temp_space' value="<?php echo $b_space; ?>">
                                                          <span class="text_msg2 tx-red"></span>                                         
                                                        </td>
                                                        <td>
                                                          <span><input type='text' readonly class='form-control price_chemical text-right'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                                          <span class="text_msg3 tx-red"></span>
                                                        </td>                    
                                                       <td>                                                         
                                                          <span><input type='text' readonly class='form-control temp_total_price text-right'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                                          <span class="text_msg4 tx-red"></span>
                                                      </td> 
                                                      <td class="tx-center">
                                                        <span  class="btn btn-primary add_chemical"><i class="fa fa-plus"></i> <?php echo freetext('add_chemical'); ?></span>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_Z001_<?php echo $b; ?>_DB_bomb' placeholder="total" value="<?php echo $material_total_price; ?>"></td>
                                                        <td></td>
                                                    </tr>
                                                  </tfoot>

                                                 
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

//################### END : GET TEXTURE ##################################
?> 
<!-- input temp_count_space_Z001 -->
<!-- <input type="text" autocomplete="off" readonly name="temp_count_space_Z001" class='form-control temp_count_space_Z001' placeholder="temp_count_space_Z001" value="<?php //echo $temp_count_space;?>">
 -->
                                           </section> <!-- end : table -->
                                      </div><!-- end : col12-->
                                    </div><!-- end :body detail table chemical -->

<!-- //////////////////////////////////////////////////// END : div detail table chemical type Z001 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->



<!-- //////////////////////////////////////////////////// START : div detail table chemical type Z013 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                                    <!-- start :body detail table chemical -->
                                    <div class="panel-body" style="padding:15px 0px 0px 0px;">
                                      <div class="form-group col-sm-12  no-padd" >
                                        <!-- end : table -->
                                        <section class=" panel panel-default section_chemical_Z013">                                         

                                           <header class="panel-heading font-bold h5 " > 
                                            <div class="row" style="margin-bottom:-15px;">                 
                                              <span class="margin-left-medium"><?php echo freetext('Z013_type'); ?></span>
                                              <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                                                 <span class="input-group-addon">                             
                                                    <font class="pull-left">
                                                    <?php  echo freetext('sub_total').' : '; ?>
                                                    </font>                         
                                                 </span> 
                                                 <input type="text" autocomplete="off" readonly name="sub_total" class="form-control sub_total_Z013_DB_bomb text-right" value="0">
                                              </span>  
                                              </div>
                                          </header>

<?php 
//################### start : GET TEXTURE น้ำยาคุมมูลค่า ##################################
$temp_count_space_type_Z013 = $temp_count_space; 
$sub_total_price_Z013_bomb =0;

$exist_mat = array();
//$count_space_Z013 =0;
foreach($space_of_texture as $c => $c_space) {
  $temp_count_space_type_Z013++;
  //$count_space_Z013++;
  //echo "<br>====== texture_id : = " .$c. "|| space = ".$c_space." =========";

  $temp_bapi_chemical_Z013 = $bapi_bomb->row_array();
  if(!empty($temp_bapi_chemical_Z013)){

      $texture_des_Z013 ='';
      foreach($bapi_texture->result_array() as $value){
        if($c == $value['material_no']){
            $texture_des_Z013 = $value['material_description'];
        }//end if
      }//end foreach texture_des
?>
                                      <div class="div-table">
                                           <table  class="table table_chemical" data-id="<?php  echo $c; ?>">
                                                  <thead>
                                                    <tr class="back-color-gray h5">                          
                                                      <th><?php echo $texture_des_Z013." X ".$c_space." (M2) ";  //echo  $temp_count_space_type_Z013;   //echo freetext('Glass X 1000 M2');?></th>
                                                      <th><?php echo freetext('chemical');?></th>
                                                      <th class="tx-center"><?php echo freetext('quantity');?></th>
                                                      <th><?php echo freetext('price/area');?></th>
                                                      <th><?php echo freetext('price (THB) ');?></th>
                                                      <th class="tx-center">                              
                                                          <?php echo freetext('action');?>
                                                      </th>                          
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
     foreach($bapi_bomb->result_array() as $value){  
        if( $value['texture_id']==$c  && $value['mat_type']=='Z013'){// check น้ำยาคุมปริมาณ
          $temp_count_chemical_Z013++;
          

            // echo "<br>===== get detail bomb ::".$value['material_no']." ===";
            // echo "<br> material_no ::".$value['material_no'];
            // echo "<br> material_description ::".$value['material_description'];
            // echo "<br> volumn ::".$value['volumn'];
            // echo "<br> unit_code ::".$value['unit_code'];
            // echo "<br> quantity ::".$value['quantity'];
            // echo "<br> price ::".$value['price'];

            

            $total_quantity = calculate_quantity($c_space,$value['volumn'],$value['quantity']);
            //echo "<br> total_quantity :: ".$total_quantity; 

            $total_price = calculate_price($total_quantity,$value['price']);  
            //echo "<br> total_price :: ".$total_price; 

            $sub_total_price_Z013_bomb = $sub_total_price_Z013_bomb +$total_price;
            $material_total_price += $total_price;

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
                                                        <?php echo $total_quantity.' '.$value['unit_code']; ?>
                                                        <input type="hidden" readonly  class='form-control space' name="<?php echo "space_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $c_space; ?>">
                                                        <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $total_quantity; ?>">
                                                        <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $value['unit_code']; ?>">
                                                      </td>
                                                      <td class="text-right"><?php echo $value['price']; ?>
                                                        <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $value['price']; ?>">
                                                      </td>  
                                                      <td class="text-right">
                                                        <?php echo $total_price; ?>  
                                                        <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $total_price; ?>">
                                                      </td>                                            
                                                      <td class="tx-center"> 
                                                          <span class="margin-left-small">
                                                            <button type="button" data-id="<?php echo $value['material_no'];?>" data-txt="<?php echo defill($value['material_no']).' '.str_replace('"', "''", $value['material_description']);?>"  onclick="SomeDeleteRowFunction_total(<?php echo $total_price; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                                            </button>
                                                          </span>                                                                
                                                      </td>                          
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
                                                  <tfoot>
                                                    <tr>
                                                      <td></td>
                                                        <td>  
                                                          
                                                          <select class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:250px;">
                                                              <option selected='selected' value='0'>กรุณาเลือก</option>
                                                                <?php 
                                                                    $temp_bapi_chemical_Z013= $bapi_chemical_Z013->result_array();
                                                                    if(!empty($temp_bapi_chemical_Z013)){
                                                                    foreach($bapi_chemical_Z013->result_array() as $value){    
                                                                      if (!in_array($value['material_no'], $exist_mat)) {                                  
                                                                 ?>
                                                                     <option  value='<?php echo $value['material_no'] ?>'><?php echo defill($value['material_no']).' '.$value['material_description']; ?></option> 
                                                                <?php        
                                                                      }  
                                                                    }//end foreach
                                                                   }else{ ?>
                                                                     <option value='0'>ไม่มีข้อมูล</option> 
                                                                <?php } ?> 
                                                          </select>                   
                    

                                                           <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                                           <input type="hidden" readonly class='form-control temp_texture_id' value="<?php if(!empty($tempC_texture_id)){  echo  $tempC_texture_id;}  ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_type'   value="<?php if(!empty($tempC_mat_type)){  echo  $tempC_mat_type;   }?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_group'   value="" >

                                                           <span class="text_msg1 tx-red"></span>
                                                        </td>
                                                        <td>                                        
                                                          <center>                                            
                                                             <div class="input-group m-b"  style="width:180px;">
                                                              <input type="text" autocomplete="off" readonly onkeypress="return isDouble(event)"  name="temp_quantity" class="form-control temp_quantity" placeholder='<?php echo freetext('quantity'); ?>'>
                                                              <span class="input-group-addon text_unit"><?php echo freetext('unit'); ?></span>
                                                            </div>
                                                          </center>
                                                          <input type="hidden" readonly class='form-control temp_unit' >
                                                          <input type="hidden" readonly class='form-control temp_space' value="<?php echo $c_space; ?>">
                                                          <span class="text_msg2 tx-red"></span>                                         
                                                        </td>
                                                        <td>
                                                          <span><input type='text' readonly class='form-control price_chemical text-right'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                                          <span class="text_msg3 tx-red"></span>
                                                        </td>                    
                                                       <td>                                                         
                                                          <span><input type='text' readonly class='form-control temp_total_price text-right'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                                          <span class="text_msg4 tx-red"></span>
                                                      </td> 
                                                      <td class="tx-center">
                                                        <span  class="btn btn-primary add_chemical"><i class="fa fa-plus"></i> <?php echo freetext('add_chemical'); ?></span>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_Z013_<?php echo $c; ?>_DB_bomb' value="<?php echo $material_total_price; ?>"></td>
                                                        <td></td>
                                                    </tr>
                                                  </tfoot>
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

//echo "<br>".$temp_count_space_type_Z013;
//################### End : GET TEXTURE น้ำยาคุมมูลค่า ##################################
?>
<!-- input temp_count_space_Z001 -->
<!-- <input type="text" autocomplete="off" readonly name="temp_count_space_Z001" class='form-control temp_count_space_Z001' placeholder="temp_count_space_Z001" value="<?php //echo $temp_count_space_type_Z013;?>">
 -->                                         
                                           </section> <!-- end : table -->
                                      </div><!-- end : col12-->
                                    </div><!-- end :body detail table chemical -->
                        </div>
                      </div>
              <!--################################ end :div detail chemical ############################-->

<!-- //////////////////////////////////////////////////// END : div detail table chemical type Z013 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->


<!-- sub_total_price_Z001 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z001_bomb' name="sub_total_price_Z001_bomb"  value="<?php echo $sub_total_price_Z001_bomb;?>">

<!-- sub_total_price_Z013 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z013_bomb' name="sub_total_price_Z013_bomb"  value="<?php echo $sub_total_price_Z013_bomb;?>">


<!-- input sub_total_chemical_DB -->
<?php  $sub_total_chemical_DB_bomb = $sub_total_price_Z001_bomb+$sub_total_price_Z013_bomb; ?>
<input type="hidden" readonly name="sub_total_chemical_DB_bomb" class='form-control sub_total_chemical_DB_bomb'  value="<?php echo $sub_total_chemical_DB_bomb;?>">
 


<!-- input temp_count_space_Z001 -->
<input type="hidden" readonly name="temp_count_space_Z001" class='form-control temp_count_space_Z001' placeholder="temp_count_space_Z001" value="<?php echo $temp_count_space_type_Z013;?>">




<!-- //////////////////////////////////////////////////// START : div detail table MATCHIE Z005 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->



               <!--########################### Start :div detail machine ############################-->
                  <div class="panel panel-default ">

                    <div class="panel-heading font-bold h5" style="padding-bottom :24px;">                   
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseMachines" class="toggle_machines">
                        <div class="row" style="margin-bottom:-20px;">                 
                          <span class="margin-left-medium"><?php echo freetext('machines'); ?></span>
                          <span ><i class="margin-top-small-toggle icon_machines_down fa fa-caret-down  text-active pull-right margin-right-medium"></i>
                                <i class="margin-top-small-toggle icon_machines_up fa fa-caret-up text  pull-right margin-right-medium"></i>
                          </span>  
                          <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                             <span class="input-group-addon">                             
                                <font class="pull-left">
                                <?php  echo freetext('sub_total').' : '; ?>
                                </font>                         
                             </span> 
                              <input type="text" autocomplete="off" readonly name="sub_total" class="form-control sub_total_Z005_DB_bomb text-right" value="0">
                          </span>  
                        </div>
                      </a>
                    </div>



                        <!-- <div id="collapseMachines" class="panel-collapse in">  -->                                                            
                        <div id="collapseMachines" class="div-table panel-collapse in">
                                  <table  class="table no-padd table_chemical">
                                      <thead>
                                        <tr class="back-color-gray h5">                          
                                          <th><?php echo freetext('group_machine');?></th>
                                          <th><?php echo freetext('machines');?></th>
                                          <th class="tx-center"><?php echo freetext('quantity');?></th>
                                          <th><?php echo freetext('price/area');?></th>
                                          <th><?php echo freetext('price (THB) ');?></th>
                                          <th class="tx-center">                              
                                              <?php echo freetext('action');?>
                                          </th>                          
                                        </tr>
                                      </thead>
                                      <tbody>



<?php 
//######################## start : GET MACHINE  ##################################
$temp_count_machine = 0;
$sub_total_price_Z005_bomb=0;

foreach($space_of_texture as $d => $d_space) {
  //echo "<br>====== texture_id : = " .$d. "|| space = ".$d_space." =========";

  $temp_bapi_machine = $bapi_bomb->row_array();
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
     foreach($bapi_bomb->result_array() as $value){  
        if( $value['texture_id']==$d  && $value['mat_type']=='Z005'){// check น้ำยาคุมปริมาณ
          $temp_count_machine++;
          

            // echo "<br>===== get detail bomb ::".$value['material_no']." ===";
            // echo "<br> material_no ::".$value['material_no'];
            // echo "<br> material_description ::".$value['material_description'];
            // echo "<br> volumn ::".$value['volumn'];
            // echo "<br> unit_code ::".$value['unit_code'];
            // echo "<br> quantity ::".$value['quantity'];
            // echo "<br> price ::".$value['price'];

            $total_quantity = calculate_quantity($d_space,$value['volumn'],$value['quantity']);
            //echo "<br> total_quantity :: ".$total_quantity; 

            $total_price = calculate_price($total_quantity,$value['price']);
            //echo "<br> total_price :: ".$total_price; 

            $sub_total_price_Z005_bomb = $sub_total_price_Z005_bomb + $total_price;


$texture_title ='';
foreach($bapi_texture->result_array() as $value_title){
  if($d == $value_title['material_no']){
      $texture_title = $value_title['material_description'];
  }//end if
}//end foreach texture_des

?>

                                              <tr class="h5" id="<?php echo $value['material_no'];?>"> 
                                                    <td><?php echo $texture_title.' ( '.$d_space.' M2)'.' , '.$value['mat_group_des'] ?>
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
                                                      <?php echo $total_quantity.' '.$value['unit_code']; ?>
                                                      <input type="hidden" readonly  class='form-control space' name="<?php echo "mach_space_".$temp_count_machine; ?>" value="<?php echo $d_space; ?>">
                                                      <input type="hidden" readonly  class='form-control quantity' name="<?php echo "mach_quantity_".$temp_count_machine; ?>" value="<?php echo $total_quantity; ?>">
                                                      <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "mach_unit_code_".$temp_count_machine; ?>" value="<?php echo $value['unit_code']; ?>">
                                                    </td>
                                                    <td class="text-right"><?php echo $value['price']; ?>
                                                      <input type="hidden" readonly  class='form-control price' name="<?php echo "mach_price_".$temp_count_machine; ?>" value="<?php echo $value['price']; ?>">
                                                    </td>  
                                                    <td class="text-right">
                                                      <?php echo $total_price; ?>   
                                                      <input type="hidden" readonly  class='form-control total_price' name="<?php echo "mach_total_price_".$temp_count_machine; ?>" value="<?php echo $total_price; ?>">
                                                    </td>                                            
                                                    <td class="tx-center"> 
                                                        <span class="margin-left-small">
                                                          <button type="button" data-id="<?php echo $value['material_no'];?>" data-txt="<?php echo defill($value['material_no']).' '.str_replace('"', "''", $value['material_description']);?>"  onclick="SomeDeleteRowFunction_total(<?php echo $total_price; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                                          </button>
                                                        </span>                                                                    
                                                    </td>                          
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
                                                  <tfoot>
                                                    <tr>
                                                      <td>
                                                        
                                                          <select class="select2 group_machines col-sm-12 no-padd h5" name="group_machines_slected" style="width:200px;">
                                                             <option selected='selected' value='0'>กรุณาเลือก</option>
                                                                <?php                                                                     
                                                                    if(!empty($bapi_mat_group)){
                                                                    foreach($bapi_mat_group as $value){                                   
                                                                 ?>
                                                                      <option  value='<?php echo $value['id'].'|'.$value['description']; ?>'><?php echo $value['description'] ?></option>
                                                                <?php                                
                                                                    }//end foreach
                                                                   }else{ ?>
                                                                     <option value='0'>ไม่มีข้อมูล</option> 
                                                                <?php } ?>
                                                          </select> 
                                                          <input type="hidden" readonly class='form-control group_machines_name' name="group_machines" >
                                                          <span class="text_msg5 tx-red"></span>
                                                                                                                    
                                                      </td>
                                                        <td>  
                                                      
                                                            <select disabled class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:220px;">
                                                             <option selected='selected' value='0'>กรุณาเลือก</option>
                                                                <?php 
                                                                    $temp_bapi_machine_selected= $bapi_machine->result_array();
                                                                    if(!empty($temp_bapi_machine_selected)){
                                                                    foreach($bapi_machine->result_array() as $value){                                      
                                                                 ?>
                                                                     <option  value='<?php echo $value['material_no'] ?>'><?php echo defill($value['material_no']).' '.$value['material_description'] ?></option> 
                                                                <?php                                   
                                                                    }//end foreach
                                                                   }else{ ?>
                                                                     <option value='0'>ไม่มีข้อมูล</option> 
                                                                <?php } ?>
                                                          </select> 
                                                          <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                                           <input type="hidden" readonly class='form-control temp_texture_id' value="<?php if(!empty($tempD_texture_id)){ echo  $tempD_texture_id; } ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_type'   value="<?php if(!empty($tempD_mat_type)){ echo  $tempD_mat_type;   } ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_group'   value="" >
                                                           <span class="text_msg1 tx-red"></span>
                                                        </td>
                                                        <td>                                        
                                                          <center>                                            
                                                             <div class="input-group m-b"  style="width:180px;">
                                                              <input type="text" autocomplete="off" readonly onkeypress="return isDouble(event)"  name="temp_quantity" class="form-control temp_quantity" placeholder='<?php echo freetext('quantity'); ?>'>
                                                              <span class="input-group-addon text_unit"><?php echo freetext('unit'); ?></span>
                                                            </div>
                                                          </center>
                                                          <input type="hidden" readonly class='form-control temp_unit' >
                                                          <input type="hidden" readonly class='form-control temp_space' value="<?php echo $d_space; ?>">
                                                          <span class="text_msg2 tx-red"></span>                                         
                                                        </td>
                                                        <td>
                                                          <span><input type='text' readonly class='form-control price_chemical text-right'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                                          <span class="text_msg3 tx-red"></span>
                                                        </td>                    
                                                       <td>                                                         
                                                          <span><input type='text' readonly class='form-control temp_total_price text-right'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                                          <span class="text_msg4 tx-red"></span>
                                                      </td>  
                                                      <td class="tx-center">
                                                        <span  class="btn btn-primary add_machine"><i class="fa fa-plus"></i> <?php echo freetext('add_machine'); ?></span>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_Z005_DB_bomb' value="0"></td>
                                                        <td></td>
                                                    </tr>
                                                  </tfoot>
                                              </table>


<!-- sub_total_price_Z005 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z005_bomb' name="sub_total_price_Z005_bomb"  value="<?php echo $sub_total_price_Z005_bomb;?>">


<input type="hidden" readonly class='form-control temp_count_machine' name="temp_count_machine"  value="<?php echo $temp_count_machine;?>">


                        </div>
                  </div>
              <!--################################ end :div detail machine ############################-->

<!-- //////////////////////////////////////////////////// END : div detail table MATCHIE Z005 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->



<!-- //////////////////////////////////////////////////// START : div detail table TOOL Z002 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

              <!--########################### Start :div detail tool ::  Z002_type คุมปริมาณ  ############################-->
                  <div class="panel panel-default ">

                    <div class="panel-heading font-bold h5" style="padding-bottom :24px;">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTool" class="toggle_tool">
                        <div class="row" style="margin-bottom:-20px;">                 
                          <span class="margin-left-medium"><?php echo freetext('Z002_type'); ?></span>
                          <span ><i class="margin-top-small-toggle icon_tool_down fa fa-caret-down  text-active pull-right margin-right-medium"></i>
                                <i class="margin-top-small-toggle icon_tool_up fa fa-caret-up text  pull-right margin-right-medium"></i>
                          </span>  
                          <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                             <span class="input-group-addon">                             
                                <font class="pull-left">
                                <?php  echo freetext('sub_total').' : '; ?>
                                </font>                         
                             </span> 
                             <input type="text" autocomplete="off" readonly name="sub_total" class="form-control text-right sub_total_Z002_DB_bomb" value="0">
                          </span>  
                        </div>
                      </a>
                    </div>
                        <!-- <div id="collapseTool" class="panel-collapse in">  -->
                        <div id="collapseTool" class="div-table panel-collapse in">                             
                            <table  class="table no-padd table_chemical">
                                <thead>
                                  <tr class="back-color-gray h5">                          
                                    <th><?php echo freetext('tool');?></th>                                        
                                    <th class="tx-center"><?php echo freetext('quantity');?></th>
                                    <th><?php echo freetext('price/area');?></th>
                                    <th><?php echo freetext('price (THB) ');?></th>                                        
                                    <th class="tx-center">                              
                                        <?php echo freetext('action');?>
                                    </th>                          
                                  </tr>
                                </thead>
                                <tbody>
                                                                          
                                                  





<?php
//######################## start : GET TOOL TYPE Z002 ##################################
$temp_count_tool_Z002 = 0;
$sub_total_price_Z002_bomb=0;

$exist_mat = array();
$temp_e_texture = array();
$temp_e_quantity = array();


foreach($space_of_texture as $e => $e_space) {
  //echo "<br>====== texture_id : = " .$e. "|| space = ".$e_space." =========";

  $temp_bapi_tool_Z002 = $bapi_bomb->row_array();
  if(!empty($temp_bapi_tool_Z002)){

     $total_quantity = 0;
     $price = 0;
     $total_price = 0;
     $tempE_texture_id  = $e;
     $tempE_mat_type = 'Z002';
     //$count_chemical = 0;


foreach($bapi_bomb->result_array() as $value){  
  if( $value['texture_id']==$e  && $value['mat_type']=='Z002'){// check น้ำยาคุมปริมาณ
    $temp_count_tool_Z002++;   
         

            // echo "<br>===== get detail bomb ::".$value['material_no']." ===";
            // echo "<br> material_no ::".$value['material_no'];
            // echo "<br> material_description ::".$value['material_description'];
            // echo "<br> volumn ::".$value['volumn'];
            // echo "<br> unit_code ::".$value['unit_code'];
            // echo "<br> quantity ::".$value['quantity'];
            // echo "<br> price ::".$value['price'];

            $total_quantity = calculate_quantity($e_space,$value['volumn'],$value['quantity']);
            //echo "<br> total_quantity :: ".$total_quantity; 

            $total_price = calculate_price($total_quantity,$value['price']);
            //echo "<br> total_price :: ".$total_price; 

             $sub_total_price_Z002_bomb = $sub_total_price_Z002_bomb  +  $total_price;

             array_push($exist_mat, $value['material_no']);

//TODO : sum data tool Z002
// if(in_array($value['material_no'],$temp_e_texture)){                
//    echo "have";
//   // echo "t :".$temp_e_texture[$value['material_no']];
//    $temp_e_quantity[$value['material_no']] += $total_quantity;
// }else{
//     echo "nohave";
//     array_push($temp_e_texture,$value['material_no']);
//     $temp_e_quantity[$value['material_no']] = $total_quantity;
// }


$texture_title ='';
foreach($bapi_texture->result_array() as $value_title){
  if($e == $value_title['material_no']){
      $texture_title = $value_title['material_description'];
  }//end if
}//end foreach texture_des


?>

                                       <tr class="h5" id="<?php echo $value['material_no'];?>"> 
                                          <!-- <td></td>   -->  
                                          <td>
                                              <?php echo $texture_title.' ( '.$e_space.' M2)'.' , '.defill($value['material_no']).' '.$value['material_description']; ?>
                                              <input type="hidden" readonly  class='form-control texture_id' name="<?php echo "texture_id_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['texture_id'];  ?>">
                                              <input type="hidden" readonly  class='form-control material_no' name="<?php echo "material_no_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['material_no']; ?>">
                                              <input type="hidden" readonly  class='form-control mat_type' name="<?php echo "mat_type_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['mat_type']; ?>">
                                              <input type="hidden" readonly  class='form-control mat_group' name="<?php echo "mat_group_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['mat_group']; ?>">
                                          </td>                                                      
                                          <td class="tx-center">
                                            <?php echo $total_quantity.' '.$value['unit_code']; ?>
                                            <input type="hidden" readonly  class='form-control space' name="<?php echo "space_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $e_space; ?>">
                                            <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $total_quantity; ?>">
                                            <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['unit_code']; ?>">
                                          </td>
                                          <td class="text-right"><?php echo $value['price']; ?>
                                              <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['price']; ?>">
                                          </td>  
                                          <td class="text-right">
                                            <?php echo $total_price; ?>      
                                            <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $total_price; ?>">
                                          </td>                                            
                                          <td class="tx-center"> 
                                              <span class="margin-left-small">
                                                <button type="button" data-id="<?php echo $value['material_no'];?>" data-txt="<?php echo defill($value['material_no']).' '.str_replace('"', "''", $value['material_description']);?>"  onclick="SomeDeleteRowFunction_total(<?php echo $total_price; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                                </button>
                                              </span>                                                                  
                                          </td>                          
                                        </tr>    

<?php

             }//end check type
     }//end foreach

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
// print_r($temp_e_texture);
// echo "<br>";
// print_r($temp_e_quantity);
?>

                                                  </tbody> 
                                                  <tfoot>
                                                    <tr>                                                      
                                                        <td>  
                                                            <select class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:300px;">
                                                              <option selected='selected' value='0'>กรุณาเลือก</option>
                                                                <?php 
                                                                    $temp_bapi_tool_Z002= $bapi_tool_Z002->result_array();
                                                                    if(!empty($temp_bapi_tool_Z002)){
                                                                    foreach($bapi_tool_Z002->result_array() as $value){   
                                                                      if (!in_array($value['material_no'], $exist_mat)) {                                   
                                                                 ?>
                                                                     <option  value='<?php echo $value['material_no'] ?>'><?php echo defill($value['material_no']).' '.$value['material_description'] ?></option> 
                                                                <?php              
                                                                      }   
                                                                    }//end foreach
                                                                   }else{ ?>
                                                                     <option value='0'>ไม่มีข้อมูล</option> 
                                                                <?php } ?>
                                                          </select> 
                                                            <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                                           <input type="hidden" readonly class='form-control temp_texture_id' value="<?php  if(!empty($tempE_texture_id)){ echo  $tempE_texture_id; } ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_type'   value="<?php  if(!empty($tempE_mat_type)){ echo  $tempE_mat_type; } ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_group'   value="" >
                                                           <span class="text_msg1 tx-red"></span>   

                                                        </td>
                                                         <td>                                        
                                                            <center>                                            
                                                               <div class="input-group m-b"  style="width:180px;">
                                                                <input type="text" autocomplete="off" readonly onkeypress="return isDouble(event)"  name="temp_quantity" class="form-control temp_quantity" placeholder='<?php echo freetext('quantity'); ?>'>
                                                                <span class="input-group-addon text_unit"><?php echo freetext('unit'); ?></span>
                                                              </div>
                                                            </center>
                                                            <input type="hidden" readonly class='form-control temp_unit' >
                                                            <input type="hidden" readonly class='form-control temp_space' value="<?php echo $e_space; ?>">
                                                            <span class="text_msg2 tx-red"></span>                                         
                                                        </td>
                                                        <td>
                                                          <span><input type='text' readonly class='form-control price_chemical text-right'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                                          <span class="text_msg3 tx-red"></span>
                                                        </td>                     
                                                       <td>                                                         
                                                          <span><input type='text' readonly class='form-control temp_total_price text-right'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                                          <span class="text_msg4 tx-red"></span>
                                                      </td>  
                                                      <td class="tx-center">
                                                        <span  class="btn btn-primary add_tool"><i class="fa fa-plus"></i> <?php echo freetext('add_tool'); ?></span>
                                                      </td>
                                                    </tr>
                                                    <tr>                                                        
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_Z002_DB_bomb' value="0"></td>
                                                        <td></td>
                                                    </tr>
                                                  </tfoot>
                                              </table>
<!-- sub_total_price_Z002 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z002_bomb' name="sub_total_price_Z002_bomb"  value="<?php echo $sub_total_price_Z002_bomb;?>">


<input type="hidden" readonly class='form-control temp_count_tool_Z002' name="temp_count_tool_Z002"  value="<?php echo $temp_count_tool_Z002;?>">

                        </div>
                  </div>
              <!--################################ end :div detail tool ############################-->

<!-- //////////////////////////////////////////////////// END : div detail table TOOL Z002 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->


<!-- //////////////////////////////////////////////////// START : div detail table TOOL Z014 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

              <!--########################### Start :div detail tool ::  Z014_type คุมมูลค่า  ############################-->
                  <div class="panel panel-default ">

                    <div class="panel-heading font-bold h5" style="padding-bottom :24px;">                   
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTool2" class="toggle_tool_2">
                        <div class="row" style="margin-bottom:-20px;">                 
                          <span class="margin-left-medium"><?php echo freetext('Z014_type'); ?></span>
                          <span ><i class="margin-top-small-toggle icon_tool_2_down fa fa-caret-down  text-active pull-right margin-right-medium"></i>
                                <i class="margin-top-small-toggle icon_tool_2_up fa fa-caret-up text  pull-right margin-right-medium"></i>
                          </span>  
                          <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                             <span class="input-group-addon">                             
                                <font class="pull-left">
                                <?php  echo freetext('sub_total').' : '; ?>
                                </font>                         
                             </span> 
                              <input type="text" autocomplete="off" readonly name="sub_total" class="form-control text-right sub_total_Z014_DB_bomb" value="0">
                          </span>  
                        </div>
                      </a>
                    </div>

                   <!--  <div id="collapseTool2" class="panel-collapse in div-table"> -->
                      <div id="collapseTool2" class="div-table panel-collapse in">  
                              <table  class="table no-padd table_chemical">
                                  <thead>
                                    <tr class="back-color-gray h5">                          
                                      <th><?php echo freetext('tool');?></th>                                        
                                      <th class="tx-center"><?php echo freetext('quantity');?></th>
                                      <th><?php echo freetext('price/area');?></th>
                                      <th><?php echo freetext('price (THB) ');?></th>                                        
                                      <th class="tx-center">                              
                                          <?php echo freetext('action');?>
                                      </th>                          
                                    </tr>
                                  </thead>
                                  <tbody>
                                                      

<?php 
//######################## start : GET MACHINE  ##################################
$temp_count_tool_Z014 = 0;
$sub_total_price_Z014_bomb =0;

$exist_mat = array();

$temp_h_texture = array();


foreach($space_of_texture as $h => $h_space) {
  //echo "<br>====== texture_id : = " .$h. "|| space = ".$h_space." =========";

  $temp_bapi_tool_Z014 = $bapi_bomb->row_array();
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


if(in_array( $h, $temp_h_texture, TRUE)){                
    //echo "have";
}else{
    //echo "nohave";
    array_push($temp_h_texture,$h);         

     foreach($bapi_bomb->result_array() as $value){  
        if( $value['texture_id']==$h  && $value['mat_type']=='Z014'){// check น้ำยาคุมปริมาณ
          $temp_count_tool_Z014++;      

            // echo "<br>===== get detail bomb ::".$value['material_no']." ===";
            // echo "<br> material_no ::".$value['material_no'];
            // echo "<br> material_description ::".$value['material_description'];
            // echo "<br> volumn ::".$value['volumn'];
            // echo "<br> unit_code ::".$value['unit_code'];
            // echo "<br> quantity ::".$value['quantity'];
            // echo "<br> price ::".$value['price'];

            $total_quantity = calculate_quantity($h_space,$value['volumn'],$value['quantity']);
            //echo "<br> total_quantity :: ".$total_quantity; 

            $total_price = calculate_price($total_quantity,$value['price']);
            //echo "<br> total_price :: ".$total_price; 

            $sub_total_price_Z014_bomb =  $sub_total_price_Z014_bomb+$total_price;

            array_push($exist_mat, $value['material_no']);

$texture_title ='';
foreach($bapi_texture->result_array() as $value_title){
  if($h == $value_title['material_no']){
      $texture_title = $value_title['material_description'];
  }//end if
}//end foreach texture_des
?>


                                <tr class="h5" id="<?php echo $value['material_no'];?>">                                                   
                                    <td>
                                        <?php   echo $texture_title.' ( '.$h_space.' M2)'.' , '.defill($value['material_no']).' '.$value['material_description']; ?>
                                        <input type="hidden" readonly  class='form-control texture_id' name="<?php echo "texture_id_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['texture_id'];  ?>">
                                        <input type="hidden" readonly  class='form-control material_no' name="<?php echo "material_no_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['material_no']; ?>">
                                        <input type="hidden" readonly  class='form-control mat_type' name="<?php echo "mat_type_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['mat_type']; ?>">
                                        <input type="hidden" readonly  class='form-control mat_group' name="<?php echo "mat_group_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['mat_group']; ?>">
                                    </td>                                                      
                                    <td class="tx-center">
                                      <?php echo $total_quantity.' '.$value['unit_code']; ?>
                                      <input type="hidden" readonly  class='form-control space' name="<?php echo "space_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $h_space; ?>">
                                      <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $total_quantity; ?>">
                                      <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['unit_code']; ?>">
                                    </td>
                                    <td class="text-right"><?php echo $value['price']; ?>
                                        <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['price']; ?>">
                                    </td>  
                                    <td class="text-right">
                                      <?php echo $total_price; ?>  
                                      <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $total_price; ?>">
                                    </td>                                            
                                    <td class="tx-center"> 
                                      <span class="margin-left-small">
                                        <button type="button" data-id="<?php echo $value['material_no'];?>" data-txt="<?php echo defill($value['material_no']).' '.str_replace('"', "''", $value['material_description']);?>"  onclick="SomeDeleteRowFunction_total(<?php echo $total_price; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                        </button>
                                      </span>                                                                
                                    </td>                          
                                </tr>


<?php

             }//end check type
     }//end foreach
}//end else checktemp_h_temp_h_texture

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
                                                  <tfoot>
                                                    <tr>                                                      
                                                        <td>                                                          
                                                          <select class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:300px;">
                                                              <option selected='selected' value='0'>กรุณาเลือก</option>
                                                                <?php 
                                                                    $temp_bapi_tool_Z014= $bapi_tool_Z014->result_array();
                                                                    if(!empty($temp_bapi_tool_Z014)){
                                                                    foreach($bapi_tool_Z014->result_array() as $value){
                                                                      if (!in_array($value['material_no'], $exist_mat)) {                                      
                                                                 ?>
                                                                     <option  value='<?php echo $value['material_no'] ?>'><?php echo defill($value['material_no']).' '.$value['material_description'] ?></option> 
                                                                <?php                             
                                                                      }  
                                                                    }//end foreach
                                                                   }else{ ?>
                                                                     <option value='0'>ไม่มีข้อมูล</option> 
                                                                <?php } ?>
                                                          </select>  
                                                           <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                                           <input type="hidden" readonly class='form-control temp_texture_id' value="<?php   if(!empty($tempH_texture_id)){ echo  $tempH_texture_id;} ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_type'   value="<?php   if(!empty($tempH_mat_type)){  echo  $tempH_mat_type;  } ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_group'   value="" >
                                                           <span class="text_msg1 tx-red"></span>  
                                                        </td>                                                       
                                                        <td>                                        
                                                            <center>                                            
                                                               <div class="input-group m-b"  style="width:180px;">
                                                                <input type="text" autocomplete="off" readonly onkeypress="return isDouble(event)"  name="temp_quantity" class="form-control temp_quantity" placeholder='<?php echo freetext('quantity'); ?>'>
                                                                <span class="input-group-addon text_unit"><?php echo freetext('unit'); ?></span>
                                                              </div>
                                                            </center>
                                                            <input type="hidden" readonly class='form-control temp_unit' >
                                                            <input type="hidden" readonly class='form-control temp_space' value="<?php echo $h_space; ?>">
                                                            <span class="text_msg2 tx-red"></span>                                         
                                                        </td>
                                                        <td>
                                                          <span><input type='text' readonly class='form-control price_chemical text-right'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                                          <span class="text_msg3 tx-red"></span>
                                                        </td>                     
                                                       <td>                                                         
                                                          <span><input type='text' readonly class='form-control temp_total_price text-right'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                                          <span class="text_msg4 tx-red"></span>
                                                      </td>  
                                                      <td class="tx-center">
                                                        <span  class="btn btn-primary add_tool"><i class="fa fa-plus"></i> <?php echo freetext('add_tool'); ?></span>
                                                      </td>
                                                    </tr>
                                                    <tr>                                                        
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_Z014_DB_bomb' value="0"></td>
                                                        <td></td>
                                                    </tr>
                                                  </tfoot>
                                              </table>

<!-- sub_total_price_Z014 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z014_bomb' name="sub_total_price_Z014_bomb"  value="<?php echo $sub_total_price_Z014_bomb;?>">

<input type="hidden" readonly class='form-control temp_count_tool_Z014' name="temp_count_tool_Z014"  value="<?php echo $temp_count_tool_Z014;?>">

                        </div>
                  </div>
               <!--########################### end :div detail tool ::  Z002_type คุมมูลค่า  ############################-->

<!-- //////////////////////////////////////////////////// END : div detail table TOOL Z014 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
          
<?php
//==set : calculatet sub_total_all
$total_all_bomb = $sub_total_price_Z001_bomb+$sub_total_price_Z013_bomb+$sub_total_price_Z005_bomb+$sub_total_price_Z002_bomb+$sub_total_price_Z014_bomb;

?>


<div class="col-sm-12 no-padd">
      <div class="col-sm-4 pull-right no-padd">
        <div class="input-group m-b">                                                  
             <span class="input-group-addon">
              <font class="pull-left"><?php  echo freetext('total_all').' : '; ?></font>
             </span> 
             <input type="text" autocomplete="off" readonly name="total_all_bomb" class="form-control text-right total_all_bomb" value="<?php echo  $total_all_bomb; ?>">
        </div>
      </div>
</div>


          </div><!-- ============== end get : data from bombe ================-->
















<?php } ?>







<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////// DB /////////////////////////////////////////////////////////////////////// -->
  

<?php if($check_data_from_DB==1){ ?>
  <!--================== start get : data get_data_form_DB ===============-->
      <div class="get_data_form_DB " >

<!--########################### Start :div detail chemical ############################-->

      <div class="panel panel-default ">

        <div class="panel-heading font-bold h5" style="padding-bottom :24px;">
          <!-- <h4 class="panel-title"> -->
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseCemical_db" class="toggle_chemicals">
              <?php echo freetext('Chemicals_type'); //Customer?>    
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
                        <div class="row" style="margin-bottom:-15px;">                 
                          <span class="margin-left-medium"><?php echo freetext('Z001_type'); ?></span>
                          <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                             <span class="input-group-addon">                             
                                <font class="pull-left">
                                <?php  echo freetext('sub_total').' : '; ?>
                                </font>                         
                             </span> 
                             <input type="text" autocomplete="off" readonly name="sub_total" class="form-control text-right sub_total_Z001_DB" value="0">
                          </span>  
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
                                        <th><?php echo $texture_des." X ".$b_space." (M2) ";  //echo  $temp_count_space;   //echo freetext('Glass X 1000 M2');?></th>
                                        <th><?php echo freetext('chemical');?></th>
                                        <th class="tx-center"><?php echo freetext('quantity');?></th>
                                        <th><?php echo freetext('price/area');?></th>
                                        <th><?php echo freetext('price (THB) ');?></th>
                                        <th class="tx-center">                              
                                            <?php echo freetext('action');?>
                                        </th>                          
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
                                              <td class="text-right"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                                                <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $value['price']; ?>"> 
                                              </td> 
                                              <td class="text-right">
                                                <?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>                                                        
                                                <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_count_space."_".$count_chemical; ?>" value="<?php echo $value['total_price']; ?>">
                                              </td>                                            
                                              <td class="tx-center"> 
                                                  <span class="margin-left-small">
                                                    <button type="button" data-id="<?php echo $value['material_no'];?>" data-txt="<?php echo defill($value['material_no']).' '.str_replace('"', "''", $value['material_description']);?>"  onclick="SomeDeleteRowFunction_total(<?php echo $value['total_price']; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                                    </button>
                                                  </span>

                                              </td>                          
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
                                                  <tfoot>
                                                    <tr>
                                                      <td></td>
                                                        <td>  
                                                         <select class="select2  no-padd h5 select_chemical" name="select_chemical" style="width:250px;">
                                                              <option selected='selected' value='0'>กรุณาเลือก</option>
                                                               <?php 
                                                                    $temp_bapi_chemical_Z001= $bapi_chemical_Z001->result_array();
                                                                    if(!empty($temp_bapi_chemical_Z001)){
                                                                    foreach($bapi_chemical_Z001->result_array() as $value){      
                                                                      if (!in_array($value['material_no'], $exist_mat)) {                                
                                                                 ?>
                                                                     <option  value='<?php echo $value['material_no'] ?>'><?php echo defill($value['material_no']).' '.$value['material_description']; ?></option> 
                                                                <?php         
                                                                      }        
                                                                    }//end foreach
                                                                   }else{ ?>
                                                                     <option value='0'>ไม่มีข้อมูล</option> 
                                                                <?php } ?>
                                                          </select>  

                                                           <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                                           <input type="hidden" readonly class='form-control temp_texture_id' value="<?php if(!empty($temp_texture_id)){   echo  $temp_texture_id; }?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_type'   value="<?php if(!empty($temp_mat_type)){  echo  $temp_mat_type;   }?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_group'   value="" >

                                                           <span class="text_msg1 tx-red"></span>
                                                        </td>
                                                        <td>                                        
                                                          <center>                                            
                                                             <div class="input-group m-b"  style="width:180px;">
                                                              <input type="text" autocomplete="off" readonly onkeypress="return isDouble(event)"  name="temp_quantity" class="form-control temp_quantity" placeholder='<?php echo freetext('quantity'); ?>'>
                                                              <span class="input-group-addon text_unit"><?php echo freetext('unit'); ?></span>
                                                            </div>
                                                          </center>
                                                          <input type="hidden" readonly class='form-control temp_unit' >
                                                          <input type="hidden" readonly class='form-control temp_space' value="<?php echo $b_space; ?>">
                                                          <span class="text_msg2 tx-red"></span>                                         
                                                        </td>
                                                        <td>
                                                          <span><input type='text' readonly class='form-control price_chemical text-right'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                                          <span class="text_msg3 tx-red"></span>
                                                        </td>                    
                                                       <td>                                                         
                                                          <span><input type='text' readonly class='form-control temp_total_price text-right'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                                          <span class="text_msg4 tx-red"></span>
                                                      </td> 
                                                      <td class="tx-center">
                                                        <span  class="btn btn-primary add_chemical"><i class="fa fa-plus"></i> <?php echo freetext('add_chemical'); ?></span>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_Z001_<?php echo $b; ?>_DB' value="<?php echo number_format($material_total_price,2);//echo $material_total_price; ?>"></td>
                                                        <td></td>
                                                    </tr>
                                                  </tfoot>

                                                 
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

//################### END : GET TEXTURE ##################################
?> 
                      </section> <!-- end : table -->
                    </div><!-- end : col12-->
                  </div><!-- end :body detail table chemical -->
      
<!-- //////////////////////////////////////////////////// END : div detail table chemical type Z001 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->


<!-- //////////////////////////////////////////////////// START : div detail table chemical type Z013 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                                    <!-- start :body detail table chemical -->
                                    <div class="panel-body" style="padding:15px 0px 0px 0px;">
                                      <div class="form-group col-sm-12  no-padd" >
                                        <!-- end : table -->
                                        <section class=" panel panel-default section_chemical_Z013">                                         

                                           <header class="panel-heading font-bold h5 " > 
                                            <div class="row" style="margin-bottom:-15px;">                 
                                              <span class="margin-left-medium"><?php echo freetext('Z013_type'); ?></span>
                                              <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                                                 <span class="input-group-addon">                             
                                                    <font class="pull-left">
                                                    <?php  echo freetext('sub_total').' : '; ?>
                                                    </font>                         
                                                 </span> 
                                                 <input type="text" autocomplete="off" readonly name="sub_total" class="form-control text-right sub_total_Z013_DB" value="0">
                                              </span>  
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
                            <th><?php echo $texture_des_Z013." X ".$c_space." (M2) ";  //echo  $temp_count_space_type_Z013;   //echo freetext('Glass X 1000 M2');?></th>
                            <th><?php echo freetext('chemical');?></th>
                            <th class="tx-center"><?php echo freetext('quantity');?></th>
                            <th><?php echo freetext('price/area');?></th>
                            <th><?php echo freetext('price (THB) ');?></th>
                            <th class="tx-center">                              
                                <?php echo freetext('action');?>
                            </th>                          
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
                                                      <td class="text-right"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                                                        <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo $value['price']; ?>">
                                                      </td>  
                                                      <td class="text-right">
                                                        <?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>  
                                                        <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_count_space_type_Z013."_".$temp_count_chemical_Z013; ?>" value="<?php echo  $value['total_price']; ?>">
                                                      </td>                                            
                                                      <td class="tx-center"> 
                                                          <span class="margin-left-small">
                                                            <button type="button" data-id="<?php echo $value['material_no'];?>" data-txt="<?php echo defill($value['material_no']).' '.str_replace('"', "''", $value['material_description']);?>"  onclick="SomeDeleteRowFunction_total(<?php echo  $value['total_price']; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                                            </button>
                                                          </span>                                                                
                                                      </td>                          
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
                                                  <tfoot>
                                                    <tr>
                                                      <td></td>
                                                        <td>  
                                                          
                                                          <select class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:250px;">
                                                              <option selected='selected' value='0'>กรุณาเลือก</option>
                                                                <?php 
                                                                    $temp_bapi_chemical_Z013= $bapi_chemical_Z013->result_array();
                                                                    if(!empty($temp_bapi_chemical_Z013)){
                                                                    foreach($bapi_chemical_Z013->result_array() as $value){  
                                                                      if (!in_array($value['material_no'], $exist_mat)) {                                    
                                                                 ?>
                                                                     <option  value='<?php echo $value['material_no'] ?>'><?php echo defill($value['material_no']).' '.$value['material_description']; ?></option>                                                                       
                                                                <?php                                   
                                                                      }
                                                                    }//end foreach
                                                                   }else{ ?>
                                                                     <option value='0'>ไม่มีข้อมูล</option> 
                                                                <?php } ?> 
                                                          </select>                   
                    

                                                           <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                                           <input type="hidden" readonly class='form-control temp_texture_id' value="<?php if(!empty($tempC_texture_id)){  echo  $tempC_texture_id;}  ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_type'   value="<?php if(!empty($tempC_mat_type)){  echo  $tempC_mat_type;   }?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_group'   value="" >

                                                           <span class="text_msg1 tx-red"></span>
                                                        </td>
                                                        <td>                                        
                                                          <center>                                            
                                                             <div class="input-group m-b"  style="width:180px;">
                                                              <input type="text" autocomplete="off" readonly onkeypress="return isDouble(event)"  name="temp_quantity" class="form-control temp_quantity" placeholder='<?php echo freetext('quantity'); ?>'>
                                                              <span class="input-group-addon text_unit"><?php echo freetext('unit'); ?></span>
                                                            </div>
                                                          </center>
                                                          <input type="hidden" readonly class='form-control temp_unit' >
                                                          <input type="hidden" readonly class='form-control temp_space' value="<?php echo $c_space; ?>">
                                                          <span class="text_msg2 tx-red"></span>                                         
                                                        </td>
                                                        <td>
                                                          <span><input type='text' readonly class='form-control price_chemical text-right'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                                          <span class="text_msg3 tx-red"></span>
                                                        </td>                    
                                                       <td>                                                         
                                                          <span><input type='text' readonly  class='form-control temp_total_price text-right'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                                          <span class="text_msg4 tx-red"></span>
                                                      </td> 
                                                      <td class="tx-center">
                                                        <span  class="btn btn-primary add_chemical"><i class="fa fa-plus"></i> <?php echo freetext('add_chemical'); ?></span>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_Z013_<?php echo $c; ?>_DB' value="<?php echo number_format($material_total_price,2);//echo $material_total_price; ?>"></td>
                                                        <td></td>
                                                    </tr>
                                                  </tfoot>
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

               <!--########################### Start :div detail machine ############################-->
                  <div class="panel panel-default ">

                    <div class="panel-heading font-bold h5" style="padding-bottom :24px;">                   
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseMachines_db" class="toggle_machines">
                        <div class="row" style="margin-bottom:-20px;">                 
                          <span class="margin-left-medium"><?php echo freetext('machines'); ?></span>
                          <span ><i class="margin-top-small-toggle icon_machines_down fa fa-caret-down  text-active pull-right margin-right-medium"></i>
                                <i class="margin-top-small-toggle icon_machines_up fa fa-caret-up text  pull-right margin-right-medium"></i>
                          </span>  
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
                                      <th><?php echo freetext('group_machine');?></th>
                                      <th><?php echo freetext('machines');?></th>
                                      <th class="tx-center"><?php echo freetext('quantity');?></th>
                                      <th><?php echo freetext('price/area');?></th>
                                      <th><?php echo freetext('price (THB) ');?></th>
                                      <th class="tx-center">                              
                                          <?php echo freetext('action');?>
                                      </th>                          
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
                                                    <td class="text-right"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                                                      <input type="hidden" readonly  class='form-control price' name="<?php echo "mach_price_".$temp_count_machine; ?>" value="<?php echo $value['price']; ?>">
                                                    </td>  
                                                    <td class="text-right">
                                                      <?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>   
                                                      <input type="hidden" readonly  class='form-control total_price' name="<?php echo "mach_total_price_".$temp_count_machine; ?>" value="<?php echo $value['total_price']; ?>">
                                                    </td>                                            
                                                    <td class="tx-center"> 
                                                        <span class="margin-left-small">
                                                          <button type="button" data-id="<?php echo $value['material_no'];?>" data-txt="<?php echo defill($value['material_no']).' '.str_replace('"', "''", $value['material_description']);?>" data-group="<?php echo $value['mat_group'].'|'.$value['mat_group_des']; ?>"  onclick="SomeDeleteRowFunction_total(<?php echo $value['total_price']; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                                          </button>
                                                        </span>                                                                    
                                                    </td>                          
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
                                                  <tfoot>
                                                    <tr>
                                                      <td>
                                                        
                                                          <select class="select2 group_machines  no-padd h5" name="group_machines_slected" style="width:200px;">
                                                             <option selected='selected' value='0'>กรุณาเลือก</option>
                                                                <?php                                                                     
                                                                    if(!empty($bapi_mat_group)){
                                                                    foreach($bapi_mat_group as $value){                                      
                                                                 ?>
                                                                     <option  value='<?php echo $value['id'].'|'.$value['description']; ?>'><?php echo $value['description'] ?></option> 
                                                                <?php                                   
                                                                    }//end foreach
                                                                   }else{ ?>
                                                                     <option value='0'>ไม่มีข้อมูล</option> 
                                                                <?php } ?>
                                                          </select> 
                                                          <input type="hidden" readonly class='form-control group_machines_name' name="group_machines" >
                                                          <span class="text_msg5 tx-red"></span>
                                                                                                                    
                                                      </td>
                                                        <td>  
                                                      
                                                            <select  disabled class=" select2 select_chemical no-padd h5" name="select_chemical" style="width:220px;">
                                                             <option selected='selected' value='0'>กรุณาเลือก</option>
                                                                <?php 
                                                                    $temp_bapi_machine_selected= $bapi_machine->result_array();
                                                                    if(!empty($temp_bapi_machine_selected)){
                                                                    foreach($bapi_machine->result_array() as $value){                                      
                                                                 ?>
                                                                     <option  value='<?php echo $value['material_no'] ?>'><?php echo defill($value['material_no']).' '.$value['material_description'] ?></option> 
                                                                <?php                                   
                                                                    }//end foreach
                                                                   }else{ ?>
                                                                     <option value='0'>ไม่มีข้อมูล</option> 
                                                                <?php } ?>
                                                          </select> 
                                                          <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                                           <input type="hidden" readonly class='form-control temp_texture_id' value="<?php if(!empty($tempD_texture_id)){ echo  $tempD_texture_id; } ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_type'   value="<?php if(!empty($tempD_mat_type)){ echo  $tempD_mat_type;   } ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_group'   value="" >
                                                           <span class="text_msg1 tx-red"></span>
                                                        </td>
                                                        <td>                                        
                                                          <center>                                            
                                                             <div class="input-group m-b"  style="width:180px;">
                                                              <input type="text" autocomplete="off" readonly onkeypress="return isDouble(event)"  name="temp_quantity" class="form-control temp_quantity" placeholder='<?php echo freetext('quantity'); ?>'>
                                                              <span class="input-group-addon text_unit"><?php echo freetext('unit'); ?></span>
                                                            </div>
                                                          </center>
                                                          <input type="hidden" readonly class='form-control temp_unit' >
                                                          <input type="hidden" readonly class='form-control temp_space' value="<?php echo $d_space; ?>">
                                                          <span class="text_msg2 tx-red"></span>                                         
                                                        </td>
                                                        <td>
                                                          <span><input type='text' readonly class='form-control price_chemical text-right'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                                          <span class="text_msg3 tx-red"></span>
                                                        </td>                    
                                                       <td>                                                         
                                                          <span><input type='text' readonly class='form-control temp_total_price text-right'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                                          <span class="text_msg4 tx-red"></span>
                                                      </td>  
                                                      <td class="tx-center">
                                                        <span  class="btn btn-primary add_machine"><i class="fa fa-plus"></i> <?php echo freetext('add_machine'); ?></span>
                                                      </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_Z005_DB' value="0"></td>
                                                        <td></td>
                                                    </tr>
                                                  </tfoot>
                                              </table>

<!-- sub_total_price_Z005 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z005' name="sub_total_price_Z005"  value="<?php echo $sub_total_price_Z005;?>">

<input type="hidden" readonly class='form-control temp_count_machine' name="temp_count_machine"  value="<?php echo $temp_count_machine;?>">


                        </div>
                  </div>
              <!--################################ end :div detail machine ############################-->

<!-- //////////////////////////////////////////////////// END : div detail table MATCHIE Z005 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- //////////////////////////////////////////////////// START : div detail table TOOL Z002 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

              <!--########################### Start :div detail tool ::  Z002_type คุมปริมาณ  ############################-->
                  <div class="panel panel-default ">

                    <div class="panel-heading font-bold h5" style="padding-bottom :24px;">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTool_db" class="toggle_tool">
                        <div class="row" style="margin-bottom:-20px;">                 
                          <span class="margin-left-medium"><?php echo freetext('Z002_type'); ?></span>
                          <span ><i class="margin-top-small-toggle icon_tool_down fa fa-caret-down  text-active pull-right margin-right-medium"></i>
                                <i class="margin-top-small-toggle icon_tool_up fa fa-caret-up text  pull-right margin-right-medium"></i>
                          </span>  
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
                                    <th><?php echo freetext('tool');?></th>                                        
                                    <th class="tx-center"><?php echo freetext('quantity');?></th>
                                    <th><?php echo freetext('price/area');?></th>
                                    <th><?php echo freetext('price (THB) ');?></th>                                        
                                    <th class="tx-center">                              
                                        <?php echo freetext('action');?>
                                    </th>                          
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
                                      <td class="text-right"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                                          <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['price']; ?>">
                                      </td>  
                                      <td class="text-right">
                                        <?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>      
                                        <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_count_tool_Z002.'_Z002'; ?>" value="<?php echo $value['total_price']; ?>">
                                      </td>                                            
                                      <td class="tx-center"> 
                                          <span class="margin-left-small">
                                            <button type="button" data-id="<?php echo $value['material_no'];?>" data-txt="<?php echo defill($value['material_no']).' '.str_replace('"', "''", $value['material_description']);?>"  onclick="SomeDeleteRowFunction_total(<?php echo $value['total_price']; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                            </button>
                                          </span>                                                                  
                                      </td>                          
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
                                                  <tfoot>
                                                    <tr>                                                      
                                                        <td>  
                                                       
                                                            <select class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:300px;">
                                                              <option selected='selected' value='0'>กรุณาเลือก</option>
                                                                <?php 
                                                                    $temp_bapi_tool_Z002= $bapi_tool_Z002->result_array();
                                                                    if(!empty($temp_bapi_tool_Z002)){
                                                                    foreach($bapi_tool_Z002->result_array() as $value){  
                                                                      if (!in_array($value['material_no'], $exist_mat)) {                                   
                                                                 ?>
                                                                     <option  value='<?php echo $value['material_no'] ?>'><?php echo defill($value['material_no']).' '.$value['material_description'] ?></option> 
                                                                <?php        
                                                                      }    
                                                                    }//end foreach
                                                                   }else{ ?>
                                                                     <option value='0'>ไม่มีข้อมูล</option> 
                                                                <?php } ?>
                                                          </select> 
                                                            <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                                           <input type="hidden" readonly class='form-control temp_texture_id' value="<?php  if(!empty($tempE_texture_id)){ echo  $tempE_texture_id; } ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_type'   value="<?php  if(!empty($tempE_mat_type)){ echo  $tempE_mat_type; } ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_group'   value="" >
                                                           <span class="text_msg1 tx-red"></span>   

                                                        </td>
                                                         <td>                                        
                                                            <center>                                            
                                                               <div class="input-group m-b"  style="width:180px;">
                                                                <input type="text" autocomplete="off" readonly onkeypress="return isDouble(event)"  name="temp_quantity" class="form-control temp_quantity" placeholder='<?php echo freetext('quantity'); ?>'>
                                                                <span class="input-group-addon text_unit"><?php echo freetext('unit'); ?></span>
                                                              </div>
                                                            </center>
                                                            <input type="hidden" readonly class='form-control temp_unit' >
                                                            <input type="hidden" readonly class='form-control temp_space' value="<?php echo $e_space; ?>">
                                                            <span class="text_msg2 tx-red"></span>                                         
                                                        </td>
                                                        <td>
                                                          <span><input type='text' readonly class='form-control price_chemical text-right'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                                          <span class="text_msg3 tx-red"></span>
                                                        </td>                     
                                                       <td>                                                         
                                                          <span><input type='text' readonly class='form-control temp_total_price text-right'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                                          <span class="text_msg4 tx-red"></span>
                                                      </td>  
                                                      <td class="tx-center">
                                                        <span  class="btn btn-primary add_tool"><i class="fa fa-plus"></i> <?php echo freetext('add_tool'); ?></span>
                                                      </td>
                                                    </tr>
                                                    <tr>                                                        
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_Z002_DB' value="0"></td>
                                                        <td></td>
                                                    </tr>
                                                  </tfoot>
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
                          <span ><i class="margin-top-small-toggle icon_tool_2_down fa fa-caret-down  text-active pull-right margin-right-medium"></i>
                                <i class="margin-top-small-toggle icon_tool_2_up fa fa-caret-up text  pull-right margin-right-medium"></i>
                          </span>  
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
                                      <th><?php echo freetext('tool');?></th>                                        
                                      <th class="tx-center"><?php echo freetext('quantity');?></th>
                                      <th><?php echo freetext('price/area');?></th>
                                      <th><?php echo freetext('price (THB) ');?></th>                                        
                                      <th class="tx-center">                              
                                          <?php echo freetext('action');?>
                                      </th>                          
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
                    <td class="text-right"><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                        <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['price']; ?>">
                    </td>  
                    <td class="text-right">
                      <?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>  
                      <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_count_tool_Z014.'_Z014'; ?>" value="<?php echo $value['total_price']; ?>">
                    </td>                                            
                    <td class="tx-center"> 
                      <span class="margin-left-small">
                        <button type="button" data-id="<?php echo $value['material_no'];?>" data-txt="<?php echo defill($value['material_no']).' '.str_replace('"', "''", $value['material_description']);?>"  onclick="SomeDeleteRowFunction_total(<?php echo $value['total_price']; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                        </button>
                      </span>                                                                
                    </td>                          
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
                                                  <tfoot>
                                                    <tr>                                                      
                                                        <td>                                                          
                                                          <select class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:300px;">
                                                              <option selected='selected' value='0'>กรุณาเลือก</option>
                                                                <?php 
                                                                    $temp_bapi_tool_Z014= $bapi_tool_Z014->result_array();
                                                                    if(!empty($temp_bapi_tool_Z014)){
                                                                    foreach($bapi_tool_Z014->result_array() as $value){   
                                                                      if (!in_array($value['material_no'], $exist_mat)) {                                   
                                                                 ?>
                                                                     <option  value='<?php echo $value['material_no'] ?>'><?php echo defill($value['material_no']).' '.$value['material_description'] ?></option> 
                                                                <?php        
                                                                      }   
                                                                    }//end foreach
                                                                   }else{ ?>
                                                                     <option value='0'>ไม่มีข้อมูล</option> 
                                                                <?php } ?>
                                                          </select>  
                                                           <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                                           <input type="hidden" readonly class='form-control temp_texture_id' value="<?php   if(!empty($tempH_texture_id)){ echo  $tempH_texture_id;} ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_type'   value="<?php   if(!empty($tempH_mat_type)){  echo  $tempH_mat_type;  } ?>" >
                                                           <input type="hidden" readonly class='form-control temp_mat_group'   value="" >
                                                           <span class="text_msg1 tx-red"></span>  
                                                        </td>                                                       
                                                        <td>                                        
                                                            <center>                                            
                                                               <div class="input-group m-b"  style="width:180px;">
                                                                <input type="text" autocomplete="off" readonly onkeypress="return isDouble(event)"  name="temp_quantity" class="form-control temp_quantity" placeholder='<?php echo freetext('quantity'); ?>'>
                                                                <span class="input-group-addon text_unit"><?php echo freetext('unit'); ?></span>
                                                              </div>
                                                            </center>
                                                            <input type="hidden" readonly class='form-control temp_unit' >
                                                            <input type="hidden" readonly class='form-control temp_space' value="<?php echo $h_space; ?>">
                                                            <span class="text_msg2 tx-red"></span>                                         
                                                        </td>
                                                        <td>
                                                          <span><input type='text' readonly class='form-control price_chemical text-right'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                                          <span class="text_msg3 tx-red"></span>
                                                        </td>                     
                                                       <td>                                                         
                                                          <span><input type='text' readonly class='form-control temp_total_price text-right'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                                          <span class="text_msg4 tx-red"></span>
                                                      </td>  
                                                      <td class="tx-center">
                                                        <span  class="btn btn-primary add_tool"><i class="fa fa-plus"></i> <?php echo freetext('add_tool'); ?></span>
                                                      </td>
                                                    </tr>
                                                    <tr>                                                        
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_Z014_DB' value="0"></td>
                                                        <td></td>
                                                    </tr>
                                                  </tfoot>
                                              </table>
<!-- sub_total_price_Z014 -->                                            
<input type="hidden" readonly class='form-control sub_total_price_Z014' name="sub_total_price_Z014"  value="<?php echo $sub_total_price_Z014;?>">

<input type="hidden" readonly class='form-control temp_count_tool_Z014' name="temp_count_tool_Z014"  value="<?php echo $temp_count_tool_Z014;?>">

                        </div>
                  </div>
               <!--########################### end :div detail tool ::  Z002_type คุมมูลค่า  ############################-->

<!-- //////////////////////////////////////////////////// END : div detail table TOOL Z014 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
            






<?php  


  //==set : calculatet sub_total_all
  $total_all = $sub_total_price_Z001+$sub_total_price_Z013+$sub_total_price_Z005+$sub_total_price_Z002+$sub_total_price_Z014;


?>
<div class="col-sm-12 no-padd">
      <div class="col-sm-4 pull-right no-padd">
        <div class="input-group m-b">                                                  
             <span class="input-group-addon">
              <font class="pull-left"><?php  echo freetext('total_all').' : '; ?></font>
             </span> 
             <input type="text" autocomplete="off" readonly name="total_all" class="form-control text-right total_all" value="<?php echo  $total_all; ?>">
        </div>
      </div>
</div>



      </div> <!--================== end get : data get_data_form_DB ===============-->


<?php }//end check_data ==1 ?>



</div>
<!--################## End : tab track asset ################## -->


<!--################## start : tab other ################## -->
<div class="tab-pane  <?php if($job_type == 'ZQT3' || $acc_gr == 'Z16' ){ echo 'active'; } ?>" id="other_chemical">
  <!-- DETAIL_CUSTOMER_REQUEST -->
  <?php $this->load->view('__quotation/page/detail_customer_request_tab3'); ?> 


</div>
<!--################## END : tab other ################## -->


</div>


</div>
</section>
  <!-- / .nav-justified -->
<!--################################ end :tab contract and other ############################-->






<!--================= form submit save ============ -->


<div class="form-group col-sm-12 no-padd">
  <div class="pull-right">
    <a href="<?php echo site_url('__ps_quotation/listview_quotation'); ?>"  class="btn btn-default"> <?php echo freetext('cancel'); ?></a>
    <button type="submit" class="btn btn-primary margin-left-small"><?php echo freetext('Save_changes'); ?></button>
  </div>
</div>


</form>
</div>
<!--============== end : form submit save ========-->








<!-- 

 <div class="input-group m-b">
      <input type="text" autocomplete="off" class="form-control">
      <span class="input-group-addon">.00</span>
    </div> -->