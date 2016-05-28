




<!-- stat : div tab5 empty -->
<div class="col-sm-12 no-padd div_tab5_empty" style="padding-top:30px;" >
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
       <!--  <span class="badge bg-info">16</span> -->
        <i class="fa fa-circle icon-muted"></i> 
          <span class="h5 margin-left-medium">ไม่มีข้อมูล พื้นที่ -> งานเคลียร์</span>
      </li>
       <!--  <li class="list-group-item" href="#">
          <i class="fa fa-circle icon-muted"></i> 
            <span class="h5 margin-left-medium">Profile visits</span>
        </li> -->
    </ul>
  </section>
</div>
<!-- end : div tab5 empty -->









<div class="detail_body_tab5">
<form role="form"   action="<?php echo site_url('__ps_quotation/update_quotation_clearing/'.$this->quotation_id) ?>" method="POST" id="form_clearing" > 
<!-- onSubmit="return fieldCheck_clearing();" -->



<!--########################### Start :div detail chemical ############################-->
            <div class="panel panel-default ">

             <!--  <div class="panel-heading" style="padding-bottom :24px;">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseCemical_clear" class="toggle_clear_chemicals">
                    <?php echo freetext('chemical'); //Customer?>    
                    <span><i class="margin-top-small-toggle icon_clear_chemicals_down fa fa-caret-down  text-active pull-right"></i><i class="margin-top-small-toggle icon_clear_chemicals_up fa fa-caret-up text  pull-right"></i></span>                             
                     <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                         <span class="input-group-addon">                             
                            <font class="pull-left">
                            <?php  echo freetext('sub_total').' : '; ?>
                            </font>                         
                         </span> 
                         <input type="text" autocomplete="off" readonly name="sub_total_chemical_clearing" class="form-control text-right sub_total_chemical_clearing" value="0">
                      </span>                     
                  </a>                               
                </h4>
              </div> -->

      <!--         <div id="collapseCemical_clear" class="panel-collapse in"> -->
                  <!-- start :body detail table chemical -->
                   <!--  <div class="panel-body" style="padding:0px 0px 0px 0px;">
                      <div class="form-group col-sm-12  no-padd" >  --> 
                               <section class="panel-default  div-frequency-clearing">
                                <?php
                                //get : count
                                $count_row_frequency=0;
                                 $temp_count_row = $get_clearing_job->result_array();
                                  if(!empty($temp_count_row)){
                                      foreach($get_clearing_job->result_array() as $value){ 
                                          if($value['mat_type']=='Z001' || $value['mat_type']=='Z013'|| $value['mat_type']=='Z005' || $value['mat_type']=='Z002' || $value['mat_type']=='Z014'){
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
 //$total_chemical_clearing =0;
 $total_all_page_db =0;
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
    
$temp_clearing_type =array('');
$temp_clearing_name =array();
$temp_frequen= $array_frequency;
if(!empty($temp_frequen)){
   foreach($array_frequency as $fre => $fre_value) { 
    if($fre != 0){
?>                           
                        
                                 <header class="panel-heading font-bold h5 " style="padding-bottom :24px;  background-color: #C0D5F0;">                  
                                  <span><?php echo 'Frequency '.$fre_value.' month';  //echo freetext('Frequency 3 month'); ?></span>
                                  <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                                     <span class="input-group-addon">                             
                                        <font class="pull-left">
                                        <?php  echo freetext('sub_total').' : '; ?>
                                        </font>                         
                                     </span> 
                                     <input type="text" autocomplete="off" readonly name="sub_total_frequency" class="form-control text-right sub_total_frequency_<?php echo $fre_value; ?>" value="0">
                                  </span>  
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
                 
                      <header class="panel-heading font-bold h5 " style="padding-bottom :24px; background-color: #EFF7FF;">                  
                        <span><?php  echo $clear_value.' X '.$count_space.' M2 ';//.$count_clearing_number; //echo freetext('Glass X 1000 M2');?></span>                      
                     </header>



                  
                  <!-- .droptoglemenu -->
                  <div class="panel-body">
                  <section class="panel panel-default pos-rlt clearfix"  >
                    <header class="panel-heading">
                      <ul class="nav nav-pills pull-right">
                        <li>
                          <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
                        </li>
                      </ul>
                       <span class="h4"><?php echo freetext('chemical'); //Customer?></span>   
                      <!--  <span class="input-group m-b col-sm-3 pull-right  margin-right-medium" style="margin-top:-5px;">                                                  
                         <span class="input-group-addon">                             
                            <font class="pull-left">
                            <?php // echo freetext('sub_total').' : '; ?>
                            </font>                         
                         </span> 
                         <input type="text" autocomplete="off" readonly name="sub_total_chemical_clearing" class="form-control input-sm text-right sub_total_chemical_clearing " value="0">
                      </span>  -->
                    </header>
                    <div class="panel-body clearfix no-padd">


                     <!-- start : table Z001 -->
                            <table  class="table no-padd table_chemical">
                                    <thead>
                                      <tr class="back-color-gray h5">                          
                                        <th>
                                          <?php echo freetext('Z001_type'); ?>                                     
                                        </th>
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
                    <td><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                      <input type="hidden" readonly class="form-control price" name="price_<?php echo $count_chemical;?>" value="<?php echo $value['price']; ?>">
                    </td>
                    <td><?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>
                      <input type="hidden" readonly class="form-control total_price" name="total_price_<?php echo $count_chemical;?>" value="<?php echo $value['total_price']; ?>">
                    </td>
                    <td class="tx-center">
                      <span class="margin-left-small">
                      <button type="button" onclick="SomeDeleteRowFunction_clearing(<?php echo $value['total_price']; ?>,this);" class="btn btn-default "><i class="fa fa-trash-o"></i></button>
                      </span>
                    </td>
                  </tr>

              <?php          
                      }//end if                    
                  }//end foreach Z001
                     if($count_chemical==0){  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";  }
                  $count_chemical = $count_chemical;
                  //$total_chemical_clearing =$total_chemical_clearing +  $total_clearing_Z001;
                  $total_clearing_frequency =$total_clearing_frequency +  $total_clearing_Z001;
                  $total_all_page_db = $total_all_page_db+$total_clearing_Z001;
              }else{

                  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";
              }//end else
              ?>
                                                           
                                    </tbody> 
                                    <tfoot>
                                      <tr>
                                        <td></td>
                                          <td>  
                                            <select class="select2   no-padd h5 select_chemical" name="select_chemical" style="width:250px;">
                                            <option selected='selected' value='0'>กรุณาเลือก</option>
                                                 <?php 
                                                      $temp_Z001= $bapi_chemical_Z001->result_array();
                                                      if(!empty($temp_Z001)){
                                                      foreach($bapi_chemical_Z001->result_array() as $value_chemical){   
                                                        if (!in_array($value_chemical['material_no'], $exist_mat)) {                                   
                                                   ?>
                                                       <option  value='<?php echo $value_chemical['material_no'] ?>'><?php echo  defill($value_chemical['material_no']).' '.$value_chemical['material_description']; ?></option> 
                                                  <?php        
                                                        }                           
                                                      }//end foreach
                                                     }else{ ?>
                                                       <option value='0'>ไม่มีข้อมูล</option> 
                                                  <?php } ?>
                                            </select>
                                             <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                             <input type="hidden" readonly class='form-control temp_mat_type'   value="Z001" >
                                             <input type="hidden" readonly class='form-control temp_mat_group'   value="" >
                                             <input type="hidden" readonly class='form-control temp_frequency' value="<?php echo $fre_value; ?>" >
                                             <input type="hidden"   readonly class="form-control clearing_type" value="<?php echo $clear_id; ?>">
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
                                              <span class="text_msg2 tx-red"></span>                                         
                                          </td> 
                                          <td>
                                              <span><input type='text' readonly class='form-control price_chemical'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                              <span class="text_msg3 tx-red"></span>
                                          </td>                    
                                          <td>                                                         
                                              <span><input type='text' readonly class='form-control temp_total_price'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                              <span class="text_msg4 tx-red"></span>
                                          </td> 
                                          <td class="tx-center">
                                            <span  class="btn btn-primary add_chimical_clearing"><i class="fa fa-plus"></i> <?php echo freetext('add_chemical'); ?></span>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td><input type="text" autocomplete="off" readonly class='form-control text-right total_tfoot' placeholder="total" value="<?php echo number_format($total_clearing_Z001,2); ?>"></td>
                                          <td></td>
                                      </tr>
                                    </tfoot>                                
                                </table>  
                          <!-- end : table Z001 -->

                           <!-- start : table Z013 -->
                                <table  class="table no-padd table_chemical">
                                    <thead>
                                     <tr class="back-color-gray h5">                          
                                        <th>
                                          <?php echo freetext('Z013_type'); ?>                                     
                                        </th>
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
                    <td><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                      <input type="hidden" readonly class="form-control price" name="price_<?php echo $count_chemical;?>" value="<?php echo $value['price']; ?>">
                    </td>
                    <td><?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>
                      <input type="hidden" readonly class="form-control total_price" name="total_price_<?php echo $count_chemical;?>" value="<?php echo $value['total_price']; ?>">
                    </td>
                    <td class="tx-center">
                      <span class="margin-left-small">
                      <button type="button" onclick="SomeDeleteRowFunction_clearing(<?php echo $value['total_price']; ?>,this);" class="btn btn-default "><i class="fa fa-trash-o"></i></button>
                      </span>
                    </td>
                  </tr>

              <?php          
                      }//end if                       

                  }//end foreach Z001
                  if($count_chemical==0){  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";  }
                  $count_chemical = $count_chemical;
                  //$total_chemical_clearing =$total_chemical_clearing +  $total_clearing_Z013;
                  $total_clearing_frequency =$total_clearing_frequency +  $total_clearing_Z013;
                  $total_all_page_db = $total_all_page_db+$total_clearing_Z013;
              }else{

                  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";
              }//end else
              
              ?>                     
                                    </tbody> 
                                   <tfoot>
                                      <tr>
                                        <td></td>
                                          <td>  
                                            <select class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:260px;">
                                              <option selected='selected' value='0'>กรุณาเลือก</option>
                                                  <?php 
                                                      $temp_bapi_chemical_Z013= $bapi_chemical_Z013->result_array();
                                                      if(!empty($temp_bapi_chemical_Z013)){
                                                      foreach($bapi_chemical_Z013->result_array() as $value_chemical){       
                                                        if (!in_array($value_chemical['material_no'], $exist_mat)) {                               
                                                   ?>
                                                       <option  value='<?php echo $value_chemical['material_no'] ?>'><?php echo defill($value_chemical['material_no']).' '.$value_chemical['material_description']; ?></option> 
                                                  <?php       
                                                        }                            
                                                      }//end foreach
                                                     }else{ ?>
                                                       <option value='0'>ไม่มีข้อมูล</option> 
                                                  <?php } ?> 
                                            </select>  
                                             <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                             <input type="hidden" readonly class='form-control temp_mat_type'   value="Z013" >
                                             <input type="hidden" readonly class='form-control temp_mat_group'   value="" >
                                             <input type="hidden" readonly class='form-control temp_frequency' value="<?php echo $fre_value; ?>" >
                                             <input type="hidden" readonly class="form-control clearing_type" value="<?php echo $clear_id; ?>">
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
                                              <span class="text_msg2 tx-red"></span>                                         
                                          </td> 
                                          <td>
                                              <span><input type='text' readonly class='form-control price_chemical'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                              <span class="text_msg3 tx-red"></span>
                                          </td>                    
                                          <td>                                                         
                                              <span><input type='text' readonly class='form-control temp_total_price'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                              <span class="text_msg4 tx-red"></span>
                                          </td> 
                                          <td class="tx-center">
                                            <span  class="btn btn-primary add_chimical_clearing"><i class="fa fa-plus"></i> <?php echo freetext('add_chemical'); ?></span>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td><input type="text " readonly class='form-control text-right total_tfoot' placeholder="total" value="<?php echo number_format($total_clearing_Z013,2); ?>"></td>
                                          <td></td>
                                      </tr>
                                    </tfoot>                                     
                                </table>  
                              <!-- end : table Z013 -->
               
                      
                    </div>
                  </section>
                  </div>
                  <!-- / .droptoglemenu -->


                  <!--############################### start : table Z005 #############################-->
                  <!-- .droptoglemenu -->
                  <div class="panel-body">
                  <section class="panel panel-default pos-rlt clearfix"  >
                    <header class="panel-heading">
                      <ul class="nav nav-pills pull-right">
                        <li>
                          <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
                        </li>
                      </ul>
                       <span class="h4"><?php echo freetext('machines'); //Customer?></span>   
                       <!-- <span class="input-group m-b col-sm-3 pull-right  margin-right-medium" style="margin-top:-5px;">                                                  
                         <span class="input-group-addon">                             
                            <font class="pull-left">
                            <?php // echo freetext('sub_total').' : '; ?>
                            </font>                         
                         </span> 
                         <input type="text" autocomplete="off" readonly name="sub_total_chemical_clearing" class="form-control input-sm text-right sub_total_chemical_clearing " value="0">
                      </span>  -->
                    </header>
                    <div class="panel-body clearfix no-padd">
                      <!-- start : table Z005 -->
                         <table  class="table no-padd table_chemical">
                                    <thead>
                                     <tr class="back-color-gray h5">                          
                                        <th><?php echo freetext('group_machine');?></th>
                                        <th><?php echo freetext('machine');?></th>
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
                              //===== GET type : Z005 form DB =======
                            $exist_mat = array();
                            $total_clearing_Z005_n = 0; 
                              $temp_clearing_Z005_n = $get_clearing_job->result_array();
                              if(!empty($temp_clearing_Z005_n)){
                                  foreach($get_clearing_job->result_array() as $value){ 
                                      if($value['mat_type']=='Z005' && $value['frequency']==$fre_value && $value['clear_type_id']==$clear_id ){
                                         $count_chemical++;
                                         $total_clearing_Z005_n = $total_clearing_Z005_n + $value['total_price'];

                                         array_push($exist_mat, $value['material_no']);
                             ?>

                                 <tr class="h5" id="<?php echo $value['material_no'] ?>">
                                    <td><?php echo $value['mat_group_des']; ?>
                                      <input type="hidden" readonly="" class="form-control mat_group_des" name="mach_mat_group_des_<?php echo $count_chemical;?>" value="<?php echo $value['mat_group_des']; ?>">
                                    </td>
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
                                    <td><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                                      <input type="hidden" readonly class="form-control price" name="price_<?php echo $count_chemical;?>" value="<?php echo $value['price']; ?>">
                                    </td>
                                    <td><?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>
                                      <input type="hidden" readonly class="form-control total_price" name="total_price_<?php echo $count_chemical;?>" value="<?php echo $value['total_price']; ?>">
                                    </td>
                                    <td class="tx-center">
                                      <span class="margin-left-small">
                                      <button type="button" onclick="SomeDeleteRowFunction_clearing(<?php echo $value['total_price']; ?>,this);" class="btn btn-default "><i class="fa fa-trash-o"></i></button>
                                      </span>
                                    </td>

                                  </tr>

                              <?php          
                                      }//end if                       

                                  }//end foreach Z001
                                  if($count_chemical==0){  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";  }
                                  $count_chemical = $count_chemical;
                                  //$total_chemical_clearing =$total_chemical_clearing +  $total_clearing_Z005_n;
                                  $total_clearing_frequency =$total_clearing_frequency +  $total_clearing_Z005_n;
                                  $total_all_page_db = $total_all_page_db+$total_clearing_Z005_n;
                              }else{

                                  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";
                              }//end else
                              
                              ?>      

                                    </tbody>       
                                    <tfoot>
                                      <tr>
                                        <td >
                                          
                                            <select class="select2 group_machines  no-padd h5" name="group_machines_slected" style="width:120px;">
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
                                        
                                              <select disabled class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:200px;" data-type="clearing_mach">
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
                                             <input type="hidden" readonly class='form-control temp_mat_type'   value="Z005" >
                                             <input type="hidden" readonly class='form-control temp_mat_group'   value="" >
                                             <input type="hidden" readonly class='form-control temp_frequency' value="<?php echo $fre_value; ?>" >
                                             <input type="hidden" readonly class="form-control clearing_type" value="<?php echo $clear_id; ?>">
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
                                            <span class="text_msg2 tx-red"></span>                                         
                                          </td>
                                          <td>
                                            <span><input type='text' readonly class='form-control price_chemical'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                            <span class="text_msg3 tx-red"></span>
                                          </td>                    
                                         <td>                                                         
                                            <span><input type='text' readonly class='form-control temp_total_price'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                            <span class="text_msg4 tx-red"></span>
                                        </td>  
                                        <td class="tx-center">
                                          <span  class="btn btn-primary add_clearing_machine_news"><i class="fa fa-plus"></i> <?php echo freetext('add_machine'); ?></span>
                                        </td>
                                      </tr>
                                      <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td><input type="text" autocomplete="off" readonly class='form-control text-right total_tfoot' placeholder="total" value="<?php echo number_format($total_clearing_Z005_n,2); ?>"></td>
                                          <td></td>
                                      </tr>
                                    </tfoot>


                                </table>  
                              <!-- end : table Z005 -->

                    </div>
                  </section>
                  </div>
                  <!-- / .droptoglemenu -->
                  <!--############################### END : table Z005 #############################-->




                   <!--############################### start : table TOOL #############################-->
                  <!-- .droptoglemenu -->
                  <div class="panel-body">
                  <section class="panel panel-default pos-rlt clearfix"  >
                    <header class="panel-heading">
                      <ul class="nav nav-pills pull-right">
                        <li>
                          <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
                        </li>
                      </ul>
                       <span class="h4"><?php echo freetext('tool'); //Customer?></span>   
                       <!-- <span class="input-group m-b col-sm-3 pull-right  margin-right-medium" style="margin-top:-5px;">                                                  
                         <span class="input-group-addon">                             
                            <font class="pull-left">
                            <?php  //echo freetext('sub_total').' : '; ?>
                            </font>                         
                         </span> 
                         <input type="text" autocomplete="off" readonly name="sub_total_chemical_clearing" class="form-control input-sm text-right sub_total_chemical_clearing " value="0">
                      </span> --> 
                    </header>
                    <div class="panel-body clearfix no-padd">
                         <!-- start : table Z002 -->
                         <table  class="table no-padd table_chemical">
                                    <thead>
                                      <tr class="back-color-gray h5">                          
                                        <th>
                                          <?php echo freetext('Z002_type'); ?>                                     
                                        </th>
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
                                //===== GET type : Z002 form DB =======
                              $exist_mat = array();
                              $total_clearing_Z002_n = 0; 
                                $temp_clearing_Z002_n = $get_clearing_job->result_array();
                                if(!empty($temp_clearing_Z002_n)){
                                    foreach($get_clearing_job->result_array() as $value){ 
                                        if($value['mat_type']=='Z002' && $value['frequency']==$fre_value && $value['clear_type_id']==$clear_id ){
                                           $count_chemical++;
                                           $total_clearing_Z002_n = $total_clearing_Z002_n + $value['total_price'];

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
                                      <td><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                                        <input type="hidden" readonly class="form-control price" name="price_<?php echo $count_chemical;?>" value="<?php echo $value['price']; ?>">
                                      </td>
                                      <td><?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>
                                        <input type="hidden" readonly class="form-control total_price" name="total_price_<?php echo $count_chemical;?>" value="<?php echo $value['total_price']; ?>">
                                      </td>
                                      <td class="tx-center">
                                        <span class="margin-left-small">
                                        <button type="button" onclick="SomeDeleteRowFunction_clearing(<?php echo $value['total_price']; ?>,this);" class="btn btn-default "><i class="fa fa-trash-o"></i></button>
                                        </span>
                                      </td>
                                    </tr>

                                <?php          
                                        }//end if                       

                                    }//end foreach Z001
                                    if($count_chemical==0){  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";  }
                                    $count_chemical = $count_chemical;
                                    //$total_chemical_clearing =$total_chemical_clearing +  $total_clearing_Z002_n;
                                    $total_clearing_frequency =$total_clearing_frequency +  $total_clearing_Z002_n;
                                    $total_all_page_db = $total_all_page_db+$total_clearing_Z002_n;
                                }else{

                                    echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";
                                }//end else
                                
                                ?>     
                            
                                    </tbody>   
                                    <tfoot>
                                      <tr>
                                        <td></td>
                                          <td>  
                                            <select class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:260px;">
                                                <option selected='selected' value='0'>กรุณาเลือก</option>
                                                  <?php 
                                                      $temp_bapi_tool_Z002= $bapi_tool_Z002->result_array();
                                                      if(!empty($temp_bapi_tool_Z002)){
                                                      foreach($bapi_tool_Z002->result_array() as $value){                                      
                                                   ?>
                                                       <option  value='<?php echo $value['material_no'] ?>'><?php echo defill($value['material_no']).' '.$value['material_description'] ?></option> 
                                                  <?php                                   
                                                      }//end foreach
                                                     }else{ ?>
                                                       <option value='0'>ไม่มีข้อมูล</option> 
                                                  <?php } ?>
                                            </select>
                                             <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                             <input type="hidden" readonly class='form-control temp_mat_type'   value="Z002" >
                                             <input type="hidden" readonly class='form-control temp_mat_group'   value="" >
                                             <input type="hidden" readonly class='form-control temp_frequency' value="<?php echo $fre_value; ?>" >
                                             <input type="hidden" readonly class="form-control clearing_type" value="<?php echo $clear_id; ?>">
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
                                              <span class="text_msg2 tx-red"></span>                                         
                                          </td> 
                                          <td>
                                              <span><input type='text' readonly class='form-control price_chemical'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                              <span class="text_msg3 tx-red"></span>
                                          </td>                    
                                          <td>                                                         
                                              <span><input type='text' readonly class='form-control temp_total_price'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                              <span class="text_msg4 tx-red"></span>
                                          </td> 
                                          <td class="tx-center">
                                            <span  class="btn btn-primary add_clearing_tool_news"><i class="fa fa-plus"></i> <?php echo freetext('add_chemical'); ?></span>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td><input type="text" autocomplete="off" readonly class='form-control text-right total_tfoot total_tfoot_Z002' placeholder="total" value="<?php echo number_format($total_clearing_Z002_n,2); ?>"></td>
                                          <td></td>
                                      </tr>
                                    </tfoot> 
                                </table>  
                              <!-- end : table Z002 -->


                              <!-- start : table Z014 -->
                              <table  class="table no-padd table_chemical">
                                    <thead>
                                      <tr class="back-color-gray h5">                          
                                        <th>
                                          <?php echo freetext('Z014_type'); ?>                                     
                                        </th>
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
                                //===== GET type : Z014 form DB =======
                              $exist_mat = array();
                              $total_clearing_Z014_n = 0; 
                                $temp_clearing_Z014_n = $get_clearing_job->result_array();
                                if(!empty($temp_clearing_Z014_n)){
                                    foreach($get_clearing_job->result_array() as $value){ 
                                        if($value['mat_type']=='Z014' && $value['frequency']==$fre_value && $value['clear_type_id']==$clear_id ){
                                           $count_chemical++;
                                           $total_clearing_Z014_n = $total_clearing_Z014_n + $value['total_price'];

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
                                      <td><?php echo number_format($value['price'],2);//echo $value['price']; ?>
                                        <input type="hidden" readonly class="form-control price" name="price_<?php echo $count_chemical;?>" value="<?php echo $value['price']; ?>">
                                      </td>
                                      <td><?php echo number_format($value['total_price'],2);//echo $value['total_price']; ?>
                                        <input type="hidden" readonly class="form-control total_price" name="total_price_<?php echo $count_chemical;?>" value="<?php echo $value['total_price']; ?>">
                                      </td>
                                      <td class="tx-center">
                                        <span class="margin-left-small">
                                        <button type="button" onclick="SomeDeleteRowFunction_clearing(<?php echo $value['total_price']; ?>,this);" class="btn btn-default "><i class="fa fa-trash-o"></i></button>
                                        </span>
                                      </td>
                                    </tr>

                                <?php          
                                        }//end if                       

                                    }//end foreach Z001
                                    if($count_chemical==0){  echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";  }
                                    $count_chemical = $count_chemical;
                                   // $total_chemical_clearing =$total_chemical_clearing +  $total_clearing_Z014_n;
                                    $total_clearing_frequency =$total_clearing_frequency +  $total_clearing_Z014_n;
                                    $total_all_page_db = $total_all_page_db+$total_clearing_Z014_n;
                                }else{

                                    echo "<tr class='data_null h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr> ";
                                }//end else
                                
                                ?>     
                             
                            
                                    </tbody>   
                                    <tfoot>
                                      <tr>
                                        <td></td>
                                          <td>  
                                             <select class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:220px;">
                                                  <option selected='selected' value='0'>กรุณาเลือก</option>
                                                    <?php 
                                                        $temp_bapi_tool_Z014= $bapi_tool_Z014->result_array();
                                                        if(!empty($temp_bapi_tool_Z014)){
                                                        foreach($bapi_tool_Z014->result_array() as $value){                                      
                                                     ?>
                                                         <option  value='<?php echo $value['material_no'] ?>'><?php echo defill($value['material_no']).' '.$value['material_description'] ?></option> 
                                                    <?php                                   
                                                        }//end foreach
                                                       }else{ ?>
                                                         <option value='0'>ไม่มีข้อมูล</option> 
                                                    <?php } ?>
                                              </select>   
                                             <input type="hidden" readonly class='form-control select_chemical_name' value="" >
                                             <input type="hidden" readonly class='form-control temp_mat_type'   value="Z014" >
                                             <input type="hidden" readonly class='form-control temp_mat_group'   value="" >
                                             <input type="hidden" readonly class='form-control temp_frequency' value="<?php echo $fre_value; ?>" >
                                             <input type="hidden" readonly class="form-control clearing_type" value="<?php echo $clear_id; ?>">
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
                                              <span class="text_msg2 tx-red"></span>                                         
                                          </td> 
                                          <td>
                                              <span><input type='text' readonly class='form-control price_chemical'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                              <span class="text_msg3 tx-red"></span>
                                          </td>                    
                                          <td>                                                         
                                              <span><input type='text' readonly class='form-control temp_total_price'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                                              <span class="text_msg4 tx-red"></span>
                                          </td> 
                                          <td class="tx-center" style="width:100px;">
                                            <span  class="btn btn-primary add_clearing_tool_news"><i class="fa fa-plus"></i> <?php echo freetext('add_chemical'); ?></span>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td><input type="text" autocomplete="off" readonly class='form-control text-right total_tfoot total_tfoot_Z014' placeholder="total" value="<?php echo number_format($total_clearing_Z014_n,2); ?>"></td>
                                          <td></td>
                                      </tr>
                                    </tfoot>  
                                </table>  
                              <!-- end : table Z014 -->

                    </div>
                  </section>
                  </div>
                  <!-- / .droptoglemenu -->
                  <!--############################### END : table TOOL #############################-->











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

?><hr>
                               <div class="row padd-top-medium  div-calcurate-clearing">
                                    <!-- start : input group -->
                                    <div class="col-sm-8 pull-right "> 
                                         
                                        <div class="col-md-4">
                                           <div class="input-group m-b">                                                  
                                               <span class="input-group-addon">
                                                  <font class="pull-left">
                                                  <?php  echo freetext('staff_clearing').' : '; ?>
                                                  </font>
                                               </span> <!-- data-parsley-min ="1" -->
                                               <input   data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" onkeypress="return isInt(event)" name="<?php echo "staff_clearing_".$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number; ?>" class="form-control staff_clearing" value="<?php  if(!empty($staff)){ echo $staff; } ?>" >
                                          </div>
                                        </div>

                                        <div class="col-md-4">
                                           <div class="input-group m-b">                                                  
                                               <span class="input-group-addon">
                                                  <font class="pull-left">
                                                  <?php  echo freetext('rate/job').' : '; ?>
                                                  </font>
                                               </span> <!-- data-parsley-min ="1" -->
                                               <input   data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" onkeypress="return isDouble(event)"  name="<?php echo "rate_job_".$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number; ?>" class="form-control text-right rate_job" value="<?php  echo number_format($job_rate,2); ?>">
                                          </div>
                                        </div>

                                        <div class="col-md-4">
                                           <div class="input-group m-b">                                                  
                                               <span class="input-group-addon">
                                                  <font class="pull-left">
                                                  <?php  echo freetext('price').' : '; ?>
                                                  </font>
                                               </span> <!-- data-parsley-min ="1" -->
                                               <input   data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" readonly  name="<?php echo "price_job_".$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number; ?>" class="form-control text-right price_job" value="<?php echo number_format($price_job,2); //echo $price_job; ?>">
                                          </div>
                                        </div>

                                    </div>
                                  <!-- end : input group -->

                                  <!-- start : input group -->
                                    <div class="col-sm-8 pull-right "> 
                                        <div class="col-md-4">
                                          <div class="input-group m-b">
                                            <span class="input-group-addon">
                                              <?php echo freetext('other'); ?>
                                            </span>
                                            <input type="text" placeholder="exp:ค่าเดินทาง" autocomplete="off" class="form-control other"  name="<?php echo "other_".$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number; ?>"  value="<?php echo $other; ?>">                                              
                                          </div>
                                        </div>

                                        <div class="col-md-4">
                                           <div class="input-group m-b">                                                  
                                               <span class="input-group-addon">
                                                  <font class="pull-left">
                                                  <?php  echo freetext('other_price_man').' : '; ?>
                                                  </font>
                                               </span> 
                                               <input type="text" onkeypress="return isDouble(event)" autocomplete="off" name="<?php echo "other_price_man_".$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number; ?>" class="form-control text-right other_price_man" value="<?php $temp_other_value=0; if(!empty($other_value)){  $temp_other_value =  round(($other_value/$staff),2);  echo number_format($temp_other_value,2);} ?>">
                                          </div>
                                        </div>

                                        <div class="col-md-4">
                                           <div class="input-group m-b">                                                  
                                               <span class="input-group-addon">
                                                  <font class="pull-left">
                                                  <?php  echo freetext('price').' : '; ?>
                                                  </font>
                                               </span> 
                                               <input  type="text" readonly autocomplete="off"  onkeypress="return isDouble(event)"  name="<?php echo "other_price_".$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number; ?>" class="form-control text-right other_price" value="<?php if(!empty($other_value)){ echo number_format(($temp_other_value*$staff),2);} // echo $other_value; } ?>">
                                          </div>
                                        </div>

                                    </div>
                                  <!-- end : input group -->
                                   <!-- start : input group -->
                                    <div class="col-sm-8 pull-right ">                                          
                                        <div class="col-md-5 pull-right">
                                            <input type="text" autocomplete="off" readonly name="<?php echo "total_price_".$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number; ?>" class="form-control text-right total_price" placeholder="total" value="<?php echo number_format($total_price_staff_clear,2);//echo $total_price_staff_clear; ?>">
                                        </div>
                                    </div>

                                  <!-- end : input group -->
                              </div><!-- end : row -->
                              <br>
                              
                        <!-- ##################### end : ALL TOTAL ###############################################  -->
  <?php                     
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


?>
             
             </section> <!-- end : table -->                                            
        <!-- </div> --><!-- end : col12-->
      <!-- </div> --><!-- end :body detail table chemical -->
<!-- </div> -->
</div>
<!--################################ end :div detail chemical ############################-->

<!-- /// total_chemical_clearing -->
<!-- <input  type="text" readonly class="total_chemical_clearing" value="<?php //echo number_format($total_chemical_clearing,2); ?>" > -->



<!--////////////////////////////////////// form submit save ////////////////////////////////////////-->
  
<div class="col-sm-12 no-padd">
    <div class="col-sm-12 no-padd">

        <div class="col-sm-4 pull-right no-padd">
          <div class="input-group m-b">                                                  
               <span class="input-group-addon">
                <font class="pull-left"><?php  echo freetext('total_all').' : '; ?></font>
               </span> 
               <input type="text" autocomplete="off" readonly name="total_all_clearing" class="form-control text-right" placeholder=" " value="<?php echo number_format($total_all_page_db,2); ?>">
          </div>
        </div>

    </div>
</div>

<div class="form-group col-sm-12 no-padd">
  <div class="pull-right">
    <button type="submit" class="btn btn-default"><?php echo freetext('cancel'); ?></button>
    <button type="submit" class="btn btn-primary margin-left-small save-btn-clearing"><?php echo freetext('Save_changes'); ?></button>
  </div>
</div>
<!-- end : form submit save -->

</form>
</div>

















