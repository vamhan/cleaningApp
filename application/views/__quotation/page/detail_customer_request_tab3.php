
<?php

$count_request =0;

$temp_request= $get_customer_request->result_array();
if(!empty($temp_request)){
    foreach($get_customer_request->result_array() as $value_data){    
        $count_request++;                                     
    } //end foreach              
}else{
  $count_request =0;
}


/// start :: get data to db
$temp_no =0;

?>



<input type="hidden" readonly class="form-control count_request" name="count_request" value="<?php if(!empty($count_request)){ echo  $count_request;  }else{ echo 0; } ?>" />
<!-- ////////////////////////////////////////// START : div detail table chemical type Z001 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<div class="panel panel-default ">
<div class="panel-heading font-bold h5" style="padding-bottom :24px;">
  <a data-toggle="collapse" data-parent="#accordion" href="#collapseRequest" class="collapseRequest">
    <?php echo freetext('Chemicals_type');?>    
    <span><i class="margin-top-small-toggle icon_request_down fa fa-caret-down  text-active pull-right"></i><i class="margin-top-small-toggle icon_request_up fa fa-caret-up text  pull-right"></i></span>                             
     <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
         <span class="input-group-addon">                             
            <font class="pull-left">
            <?php  echo freetext('subtotal').' : '; ?>
            </font>                         
         </span> 
         <input type="text" autocomplete="off" readonly name="sub_total_request_chemical_input" class="form-control text-right sub_total_request_chemical_input" value="0">
      </span>                     
  </a>  
</div>
<div id="collapseRequest" class="panel-collapse in">

 <!-- ////////////////////////////////////////// START : div detail table chemical Z001 ////////////////////////////////// -->
<!-- start :body detail table chemical Z001 -->
    <div class="panel-body" style="padding:15px 0px 0px 0px;">
      <div class="form-group col-sm-12  no-padd" >
        <!-- end : table -->
        <section class=" panel panel-default">

          <header class="panel-heading font-bold h5 " > 
              <div class="row" style="margin-bottom:-15px;">                 
                <span class="margin-left-medium"><?php echo freetext('Z001_type'); ?></span>
                <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                   <span class="input-group-addon">                             
                      <font class="pull-left">
                      <?php  echo freetext('sub_total').' : '; ?>
                      </font>                         
                   </span> 
                   <input type="text" autocomplete="off" readonly name="sub_total_request_Z001_input" class="form-control text-right sub_total_request_Z001_input" value="0">
                </span>  
                </div>
            </header>
           

             <div class="div-table">
             
              <table  class="table no-padd table_chemical" >
                  <thead>
                    <tr class="back-color-gray h5">                          
                      <th><?php echo freetext('chemical');?></th>                                        
                      <th class="tx-center"><?php echo freetext('quantity');?></th>
                      <th><?php echo freetext('price/area');?></th>
                      <th><?php echo freetext('price (THB) ');?></th>                                        
                      <th class="tx-center">                              
                          <?php echo freetext('action');?>
                      </th>                          
                    </tr>
                  </thead>
                  <tbody >

                  <?php 
                    $exist_mat = array();
                    $have_data = 0;
                    $sub_total_request_Z001 = 0;
                    $temp_request_Z001= $get_customer_request->result_array();
                    if(!empty($temp_request_Z001)){
                    foreach($get_customer_request->result_array() as $value_data){ 
                       if($value_data['mat_type'] =='Z001' ){
                        $temp_no++;
                        $have_data = 1;
                        $sub_total_request_Z001 = $sub_total_request_Z001 + $value_data['total_price'];  

                        array_push($exist_mat, $value_data['material_no']);                                    
                   ?>
                       <tr class="h5" id="<?php echo $value_data['material_no'];?>">                           
                          <td>
                              <?php echo defill($value_data['material_no']).' '.$value_data['material_description']; ?>
                              <input type="hidden" readonly  class='form-control material_no' name="<?php echo "material_no_".$temp_no; ?>" value="<?php echo $value_data['material_no']; ?>">
                              <input type="hidden" readonly  class='form-control mat_type' name="<?php echo "mat_type_".$temp_no; ?>" value="<?php echo $value_data['mat_type']; ?>">
                              <input type="hidden" readonly  class='form-control mat_group' name="<?php echo "mat_group_".$temp_no; ?>" value="<?php echo $value_data['mat_group']; ?>">
                          </td>                                                      
                         <td class="tx-center">
                            <?php echo $value_data['quantity'].' '.$value_data['quantity_unit']; ?>
                            <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_no; ?>" value="<?php echo $value_data['quantity']; ?>">
                            <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_no; ?>" value="<?php echo $value_data['quantity_unit']; ?>">
                          </td>
                          <td class="text-right"><?php echo number_format($value_data['price'],2);//echo $value_data['price']; ?>
                            <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_no; ?>" value="<?php echo $value_data['price']; ?>"> 
                          </td> 
                          <td class="text-right">
                            <?php echo number_format($value_data['total_price'],2);//echo $value_data['total_price']; ?>                                                        
                            <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_no; ?>" value="<?php echo $value_data['total_price']; ?>">
                          </td>                                            
                          <td class="tx-center"> 
                              <span class="margin-left-small">
                                <button type="button" data-id="<?php echo $value_data['material_no']; ?>" data-txt="<?php echo defill($value_data['material_no']).' '.$value_data['material_description']; ?>" onclick="SomeDeleteRowFunction_totalRequest(<?php echo $value_data['total_price']; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                </button>
                              </span>
                          </td>                     
                      </tr>
                   <?php   
                            }//end if chek Z001                               
                          }//end foreach                           
                          /// set :: get data to db no..
                          $temp_no = $temp_no;
                          if($have_data==0){
                              echo "<tr class='h5'><td colspan='5'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr>";
                          }// no data Z001

                     }else{ 
                         echo "<tr class='h5'><td colspan='5'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr>";
                     }//end else 
                  ?>
                   

                  </tbody> 
                  <tfoot>
                      <tr>                      
                          <td>  
                           <select class="select2  no-padd h5 select_chemical" name="select_chemical" style="width:300px;">
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
                             <input type="hidden" readonly class='form-control temp_mat_type'   value="Z001" >
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
                          <span  class="btn btn-primary add_request"><i class="fa fa-plus"></i> <?php echo freetext('add_chemical'); ?></span>
                        </td>
                      </tr>
                      <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_request_Z001_input' placeholder="total"></td>
                          <td></td>
                      </tr>
                    </tfoot>
              </table>

              <!--  sub_total_request_Z001 -->
              <input type="hidden" readonly class="form-control sub_total_request_Z001" name="sub_total_request_Z001" value="<?php echo $sub_total_request_Z001; ?>" />

              <input type="hidden" readonly class="form-control check_data" value="<?php if(!empty($have_data)){ echo $have_data;  }else{ echo 0; } ?>" />
            
            </div>

           </section> <!-- end : table -->
      </div><!-- end : col12-->
    </div>
    <!-- end :body detail table chemical Z001 -->
    <!-- ////////////////////////////////////////// end : div detail table chemical Z001 ////////////////////////////////// -->




    <!-- ////////////////////////////////////////// START : div detail table chemical Z013 ////////////////////////////////// -->

    <!-- start :body detail table chemical Z013 -->
    <div class="panel-body" style="padding:15px 0px 0px 0px;">
      <div class="form-group col-sm-12  no-padd" >
        <!-- end : table -->
        <section class=" panel panel-default">

          <header class="panel-heading font-bold h5 " > 
              <div class="row" style="margin-bottom:-15px;">                 
                <span class="margin-left-medium"><?php echo freetext('Z013_type'); ?></span>
                <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                   <span class="input-group-addon">                             
                      <font class="pull-left">
                      <?php  echo freetext('sub_total').' : '; ?>
                      </font>                         
                   </span> 
                   <input type="text" autocomplete="off" readonly name="sub_total_request_Z013_input" class="form-control text-right sub_total_request_Z013_input" value="0">
                </span>  
                </div>
            </header>

            <div class="div-table">
            <table  class="table no-padd table_chemical">
                  <thead>
                    <tr class="back-color-gray h5">                          
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
                    $exist_mat = array();
                    $have_data =0;
                    $sub_total_request_Z013 = 0;
                    $temp_request_Z013= $get_customer_request->result_array();
                    if(!empty($temp_request_Z013)){
                    foreach($get_customer_request->result_array() as $value_data){ 
                       if($value_data['mat_type'] =='Z013' ){
                        $temp_no++;     
                        $have_data =1;
                        $sub_total_request_Z013 = $sub_total_request_Z013 +  $value_data['total_price'];     

                        array_push($exist_mat, $value_data['material_no']);                           
                   ?>
                       <tr class="h5" id="<?php echo $value_data['material_no'];?>">                           
                          <td>
                              <?php echo defill($value['material_no']).' '.$value_data['material_description']; ?>
                              <input type="hidden" readonly  class='form-control material_no' name="<?php echo "material_no_".$temp_no; ?>" value="<?php echo $value_data['material_no']; ?>">
                              <input type="hidden" readonly  class='form-control mat_type' name="<?php echo "mat_type_".$temp_no; ?>" value="<?php echo $value_data['mat_type']; ?>">
                              <input type="hidden" readonly  class='form-control mat_group' name="<?php echo "mat_group_".$temp_no; ?>" value="<?php echo $value_data['mat_group']; ?>">
                          </td>                                                      
                         <td class="tx-center">
                            <?php echo $value_data['quantity'].' '.$value_data['quantity_unit']; ?>
                            <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_no; ?>" value="<?php echo $value_data['quantity']; ?>">
                            <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_no; ?>" value="<?php echo $value_data['quantity_unit']; ?>">
                          </td>
                          <td class="text-right"><?php echo number_format($value_data['price'],2);//echo $value_data['price']; ?>
                            <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_no; ?>" value="<?php echo $value_data['price']; ?>"> 
                          </td> 
                          <td class="text-right">
                            <?php echo number_format($value_data['total_price'],2);//echo $value_data['total_price']; ?>                                                        
                            <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_no; ?>" value="<?php echo $value_data['total_price']; ?>">
                          </td>                                            
                          <td class="tx-center"> 
                              <span class="margin-left-small">
                                <button type="button" data-id="<?php echo $value_data['material_no']; ?>" data-txt="<?php echo defill($value_data['material_no']).' '.$value_data['material_description']; ?>"  onclick="SomeDeleteRowFunction_totalRequest(<?php echo $value_data['total_price']; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                </button>
                              </span>
                          </td>                     
                      </tr>
                   <?php   
                            }//end if chek Z013                               
                          }//end foreach                           
                          /// set :: get data to db no..
                          $temp_no = $temp_no;
                          if($have_data==0){
                              echo "<tr class='h5'><td colspan='5'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr>";
                          }// no data Z013

                     }else{ 
                         echo "<tr class='h5'><td colspan='5'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr>";
                     }//end else 
                  ?>

                     
                  </tbody> 
                  <tfoot>
                    <tr>
                        <td>                            
                          <select class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:300px;">
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
                           <input type="hidden" readonly class='form-control temp_mat_type'   value="Z013" >
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
                        <span  class="btn btn-primary add_request"><i class="fa fa-plus"></i> <?php echo freetext('add_chemical'); ?></span>
                      </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_request_Z013_input' placeholder="total"></td>
                        <td></td>
                    </tr>
                  </tfoot>
              </table>

               <!--  sub_total_request_Z013 -->
              <input type="hidden" readonly class="form-control sub_total_request_Z013" name="sub_total_request_Z013" value="<?php echo $sub_total_request_Z013; ?>" />


              <input type="hidden" readonly class="form-control check_data" value="<?php if(!empty($have_data)){ echo $have_data;  }else{ echo 0; } ?>" />
            
            </div>

           </section> <!-- end : table -->
      </div><!-- end : col12-->
    </div> 
    <!-- end :body detail table chemical Z013 -->
    <!-- ////////////////////////////////////////// end : div detail table chemical Z013 ////////////////////////////////// -->

      <!--  sub_total_request_Z0013 -->
     <?php  $sub_total_request_chemical_top = $sub_total_request_Z001 + $sub_total_request_Z013;  ?>
     <input type="hidden" readonly class="form-control sub_total_request_chemical_top" name="sub_total_request_chemical_top" value="<?php echo $sub_total_request_chemical_top; ?>" />


  </div><!-- end collapseRequest chemical -->

</div>
<!-- ////////////////////////////////////////// end : div detail table chemical  ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->


<!-- //////////////////////////////////////////////////// START : div detail table MATCHIE Z005 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<div class="panel panel-default ">

<div class="panel-heading font-bold h5" style="padding-bottom :24px;">                   
  <a data-toggle="collapse" data-parent="#accordion" href="#collapseRequest_machine" class="collapseRequest_machine">
    <div class="row" style="margin-bottom:-20px;">                 
      <span class="margin-left-medium"><?php echo freetext('machines'); ?></span>
      <span ><i class="margin-top-small-toggle icon_request_mat_down fa fa-caret-down  text-active pull-right margin-right-medium"></i>
            <i class="margin-top-small-toggle icon_request_mat_up fa fa-caret-up text  pull-right margin-right-medium"></i>
      </span>  
      <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
         <span class="input-group-addon">                             
            <font class="pull-left">
            <?php  echo freetext('sub_total').' : '; ?>
            </font>                         
         </span> 
         <input type="text" autocomplete="off" readonly name="sub_total_request_Z005_input" class="form-control text-right sub_total_request_Z005_input" value="0">
      </span>  
    </div>
  </a>
</div>

 <div id="collapseRequest_machine" class="div-table panel-collapse in">

              <table  class="table no-padd table_chemical" >
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
                    $exist_mat = array();
                    $have_data = 0;
                    $sub_total_request_Z005 = 0;
                    $temp_request_Z005= $get_customer_request->result_array();                    
                    if(!empty($temp_request_Z005)){
                    foreach($get_customer_request->result_array() as $value_data){ 
                       if($value_data['mat_type'] =='Z005' ){
                        $temp_no++;    
                        $have_data =1;
                        $sub_total_request_Z005 = $sub_total_request_Z005 + $value_data['total_price']; 

                        array_push($exist_mat, $value_data['material_no']);
                   ?>
                       <tr class="h5" id="<?php echo $value_data['material_no'];?>">                           
                         <td><?php echo $value_data['mat_group_des'] ?>
                              <input type='hidden' readonly class='form-control mat_group_des' name="<?php echo "mat_group_des_".$temp_no; ?>" value="<?php echo $value_data['mat_group_des']; ?>">
                          </td> 
                          <td>
                              <?php echo defill($value['material_no']).' '.$value['material_description']; ?>
                              <input type="hidden" readonly  class='form-control material_no' name="<?php echo "material_no_".$temp_no; ?>" value="<?php echo $value_data['material_no']; ?>">
                              <input type="hidden" readonly  class='form-control mat_type' name="<?php echo "mat_type_".$temp_no; ?>" value="<?php echo $value_data['mat_type']; ?>">
                              <input type="hidden" readonly  class='form-control mat_group' name="<?php echo "mat_group_".$temp_no; ?>" value="<?php echo $value_data['mat_group']; ?>">
                          </td>                                                      
                         <td class="tx-center">
                            <?php echo $value_data['quantity'].' '.$value_data['quantity_unit']; ?>
                            <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_no; ?>" value="<?php echo $value_data['quantity']; ?>">
                            <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_no; ?>" value="<?php echo $value_data['quantity_unit']; ?>">
                          </td>
                          <td class="text-right"><?php echo number_format($value_data['price'],2);//echo $value_data['price']; ?>
                            <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_no; ?>" value="<?php echo $value_data['price']; ?>"> 
                          </td> 
                          <td class="text-right">
                            <?php echo number_format($value_data['total_price'],2);//echo $value_data['total_price']; ?>                                                        
                            <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_no; ?>" value="<?php echo $value_data['total_price']; ?>">
                          </td>                                            
                          <td class="tx-center"> 
                              <span class="margin-left-small">
                                <button type="button" data-id="<?php echo $value_data['material_no']; ?>" data-txt="<?php echo defill($value_data['material_no']).' '.$value_data['material_description']; ?>"  onclick="SomeDeleteRowFunction_totalRequest(<?php echo $value_data['total_price']; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                </button>
                              </span>
                          </td>                     
                      </tr>
                   <?php   
                            }//end if chek Z005                              
                          }//end foreach                           
                          /// set :: get data to db no..
                          $temp_no = $temp_no;
                         
                          if($have_data == 0){
                              echo "<tr class='h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr>";
                          }// no data Z005

                     }else{ 
                         echo "<tr class='h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr>";
                     }//end else 
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
                                          if (!in_array($value['material_no'], $exist_mat)) {                              
                                     ?>
                                          <option  value='<?php echo $value['id'].'|'.$value['description']; ?>'><?php echo $value['description'] ?></option>
                                    <?php        
                                          }                           
                                        }//end foreach
                                       }else{ ?>
                                         <option value='0'>ไม่มีข้อมูล</option> 
                                    <?php } ?>
                              </select> 
                              <input type="hidden" readonly class='form-control group_machines_name' name="group_machines" >
                              <span class="text_msg5 tx-red"></span>
                                                                                        
                          </td>
                            <td>  
                          
                                <select disabled class="select2 select_chemical  no-padd h5" name="select_chemical" style="width:250px;">
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
                              <span><input type='text' readonly class='form-control price_chemical text-right'   placeholder='<?php echo freetext('price'); ?>'/></span>
                              <span class="text_msg3 tx-red"></span>
                            </td>                    
                           <td>                                                         
                              <span><input type='text' readonly class='form-control temp_total_price text-right'   placeholder='<?php echo freetext('total_price'); ?>'/></span>
                              <span class="text_msg4 tx-red"></span>
                          </td>  
                          <td class="tx-center">
                            <span  class="btn btn-primary add_request"><i class="fa fa-plus"></i> <?php echo freetext('add_machine'); ?></span>
                          </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_request_Z005_input' placeholder="total"></td>
                            <td></td>
                        </tr>
                      </tfoot>
                </table>

                <!--  sub_total_request_Z005 -->
               <input type="hidden" readonly class="form-control sub_total_request_Z005" name="sub_total_request_Z005" value="<?php echo $sub_total_request_Z005; ?>" />


                <input type="hidden" readonly class="form-control check_data" value="<?php if(!empty($have_data)){ echo $have_data;  }else{ echo 0; } ?>" />
            
  
  </div><!-- end collapseRequest machine -->
</div>
<!-- //////////////////////////////////////////////////// END : div detail table MATCHIE Z005 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->


<!-- //////////////////////////////////////////////////// START : div detail table TOOL Z002 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<div class="panel panel-default ">

<div class="panel-heading font-bold h5" style="padding-bottom :24px;">                   
  <a data-toggle="collapse" data-parent="#accordion" href="#collapseRequest_tool_Z002" class="collapseRequest_tool_Z002">
    <div class="row" style="margin-bottom:-20px;">                 
      <span class="margin-left-medium"><?php echo freetext('Z002_type'); ?></span>
      <span ><i class="margin-top-small-toggle icon_request_tool1_down fa fa-caret-down  text-active pull-right margin-right-medium"></i>
            <i class="margin-top-small-toggle icon_request_tool1_up fa fa-caret-up text  pull-right margin-right-medium"></i>
      </span>  
      <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
         <span class="input-group-addon">                             
            <font class="pull-left">
            <?php  echo freetext('sub_total').' : '; ?>
            </font>                         
         </span> 
         <input type="text" autocomplete="off" readonly name="sub_total_request_Z002_input" class="form-control text-right sub_total_request_Z002_input" value="0">
      </span>  
    </div>
  </a>
</div>

<div id="collapseRequest_tool_Z002" class="div-table panel-collapse in">
              <table  class="table no-padd table_chemical" >
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
                    $exist_mat = array();
                    $have_data = 0;
                     $sub_total_request_Z002 = 0;
                    $temp_request_Z002= $get_customer_request->result_array();
                    if(!empty($temp_request_Z002)){
                    foreach($get_customer_request->result_array() as $value_data){ 
                       if($value_data['mat_type'] =='Z002' ){
                        $temp_no++;   
                        $have_data =1;
                        $sub_total_request_Z002 = $sub_total_request_Z002 + $value_data['total_price'];   

                        array_push($exist_mat, $value_data['material_no']);                                
                   ?>
                       <tr class="h5" id="<?php echo $value_data['material_no'];?>">                           
                          <td>
                              <?php echo defill($value['material_no']).' '.$value_data['material_description']; ?>
                              <input type="hidden" readonly  class='form-control material_no' name="<?php echo "material_no_".$temp_no; ?>" value="<?php echo $value_data['material_no']; ?>">
                              <input type="hidden" readonly  class='form-control mat_type' name="<?php echo "mat_type_".$temp_no; ?>" value="<?php echo $value_data['mat_type']; ?>">
                              <input type="hidden" readonly  class='form-control mat_group' name="<?php echo "mat_group_".$temp_no; ?>" value="<?php echo $value_data['mat_group']; ?>">
                          </td>                                                      
                         <td class="tx-center">
                            <?php echo $value_data['quantity'].' '.$value_data['quantity_unit']; ?>
                            <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_no; ?>" value="<?php echo $value_data['quantity']; ?>">
                            <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_no; ?>" value="<?php echo $value_data['quantity_unit']; ?>">
                          </td>
                          <td class="text-right"><?php echo number_format($value_data['price'],2);//echo $value_data['price']; ?>
                            <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_no; ?>" value="<?php echo $value_data['price']; ?>"> 
                          </td> 
                          <td class="text-right">
                            <?php echo number_format($value_data['total_price'],2);//echo $value_data['total_price']; ?>                                                        
                            <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_no; ?>" value="<?php echo $value_data['total_price']; ?>">
                          </td>                                            
                          <td class="tx-center"> 
                              <span class="margin-left-small">
                                <button type="button" data-id="<?php echo $value_data['material_no']; ?>" data-txt="<?php echo defill($value_data['material_no']).' '.$value_data['material_description']; ?>"  onclick="SomeDeleteRowFunction_totalRequest(<?php echo $value_data['total_price']; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                </button>
                              </span>
                          </td>                     
                      </tr>
                  <?php   
                            }//end if chek Z002                              
                          }//end foreach                           
                          /// set :: get data to db no..
                          $temp_no = $temp_no;
                          if($have_data==0){
                              echo "<tr class='h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr>";
                          }// no data Z002

                     }else{ 
                         echo "<tr class='h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr>";
                     }//end else 
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
                             <input type="hidden" readonly class='form-control temp_mat_type'   value="Z002" >
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
                          <span  class="btn btn-primary add_request"><i class="fa fa-plus"></i> <?php echo freetext('add_tool'); ?></span>
                        </td>
                      </tr>
                      <tr>                                                        
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><input type="text" autocomplete="off" readonly class='form-control text-right sub_total_request_Z002_input' placeholder="total"></td>
                          <td></td>
                      </tr>
                    </tfoot>
                </table>   

                 <!--  sub_total_request_Z002 -->
               <input type="hidden" readonly class="form-control sub_total_request_Z002" name="sub_total_request_Z002" value="<?php echo $sub_total_request_Z002; ?>" />


                <input type="hidden" readonly class="form-control check_data" value="<?php if(!empty($have_data)){ echo $have_data;  }else{ echo 0; } ?>" />
            
  </div><!-- end collapseRequest tool -->
</div>
<!-- //////////////////////////////////////////////////// END : div detail table TOOL Z002 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->


<!-- //////////////////////////////////////////////////// START : div detail table TOOL Z014 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<div class="panel panel-default ">

<div class="panel-heading font-bold h5" style="padding-bottom :24px;">                   
  <a data-toggle="collapse" data-parent="#accordion" href="#collapseRequest_tool_Z014" class="collapseRequest_tool_Z014">
    <div class="row" style="margin-bottom:-20px;">                 
      <span class="margin-left-medium"><?php echo freetext('Z014_type'); ?></span>
      <span ><i class="margin-top-small-toggle icon_request_tool2_down fa fa-caret-down  text-active pull-right margin-right-medium"></i>
            <i class="margin-top-small-toggle icon_request_tool2_up fa fa-caret-up text  pull-right margin-right-medium"></i>
      </span>  
      <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
         <span class="input-group-addon">                             
            <font class="pull-left">
            <?php  echo freetext('sub_total').' : '; ?>
            </font>                         
         </span> 
         <input type="text" autocomplete="off" readonly name="sub_total_request_Z014_input" class="form-control text-right sub_total_request_Z014_input" value="0">
      </span>  
    </div>
  </a>
</div>

<div id="collapseRequest_tool_Z014" class="div-table panel-collapse in">
              <table  class="table no-padd table_chemical" >
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
                    $exist_mat = array();
                    $have_data = 0;
                    $sub_total_request_Z014 = 0;
                    $temp_request_Z014= $get_customer_request->result_array();
                    if(!empty($temp_request_Z014)){
                    foreach($get_customer_request->result_array() as $value_data){ 
                       if($value_data['mat_type'] =='Z014' ){
                        $temp_no++;    
                       $have_data =1;
                       $sub_total_request_Z014 = $sub_total_request_Z014 + $value_data['total_price'];         

                       array_push($exist_mat, $value_data['material_no']);                          
                   ?>
                       <tr class="h5" id="<?php echo $value_data['material_no'];?>">                           
                          <td>
                              <?php echo defill($value['material_no']).' '.$value_data['material_description']; ?>
                              <input type="hidden" readonly  class='form-control material_no' name="<?php echo "material_no_".$temp_no; ?>" value="<?php echo $value_data['material_no']; ?>">
                              <input type="hidden" readonly  class='form-control mat_type' name="<?php echo "mat_type_".$temp_no; ?>" value="<?php echo $value_data['mat_type']; ?>">
                              <input type="hidden" readonly  class='form-control mat_group' name="<?php echo "mat_group_".$temp_no; ?>" value="<?php echo $value_data['mat_group']; ?>">
                          </td>                                                      
                         <td class="tx-center">
                            <?php echo $value_data['quantity'].' '.$value_data['quantity_unit']; ?>
                            <input type="hidden" readonly  class='form-control quantity' name="<?php echo "quantity_".$temp_no; ?>" value="<?php echo $value_data['quantity']; ?>">
                            <input type="hidden" readonly  class='form-control unit_code' name="<?php echo "unit_code_".$temp_no; ?>" value="<?php echo $value_data['quantity_unit']; ?>">
                          </td>
                          <td class="text-right"><?php echo number_format($value_data['price'],2);//echo $value_data['price']; ?>
                            <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_no; ?>" value="<?php echo $value_data['price']; ?>"> 
                          </td> 
                          <td class="text-right">
                            <?php echo number_format($value_data['total_price'],2);//echo $value_data['total_price']; ?>                                                        
                            <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_no; ?>" value="<?php echo $value_data['total_price']; ?>">
                          </td>                                            
                          <td class="tx-center"> 
                              <span class="margin-left-small">
                                <button type="button" data-id="<?php echo $value_data['material_no']; ?>" data-txt="<?php echo defill($value_data['material_no']).' '.$value_data['material_description']; ?>"  onclick="SomeDeleteRowFunction_totalRequest(<?php echo $value_data['total_price']; ?>,this);"  class="btn btn-default"><i class="fa fa-trash-o"></i>
                                </button>
                              </span>
                          </td>                     
                      </tr>
                  <?php   
                            }//end if chek Z014                               
                          }//end foreach                           
                          /// set :: get data to db no..
                          $temp_no = $temp_no;
                          if($have_data==0){
                              echo "<tr class='h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr>";
                          }// no data Z014

                     }else{ 
                         echo "<tr class='h5'><td colspan='6'>ไม่มีข้อมูล กรุณาเพิ่มข้อมูล</td></tr>";
                     }//end else 
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
                               <input type="hidden" readonly class='form-control temp_mat_type'   value="Z014" >
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
                            <span  class="btn btn-primary add_request"><i class="fa fa-plus"></i> <?php echo freetext('add_tool'); ?></span>
                          </td>
                        </tr>
                        <tr>                                                        
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input  autocomplete="off" readonly class='form-control text-right sub_total_request_Z014_input' placeholder="total"></td>
                            <td></td>
                        </tr>
                      </tfoot>
                </table>

              <!--  sub_total_request_Z014 -->
               <input type="hidden" readonly class="form-control sub_total_request_Z014" name="sub_total_request_Z014" value="<?php echo $sub_total_request_Z014; ?>" />


                <input type="hidden" readonly class="form-control check_data" value="<?php if(!empty($have_data)){ echo $have_data;  }else{ echo 0; } ?>" />
            
           
  </div><!-- end collapseRequest tool -->
</div>
<!-- //////////////////////////////////////////////////// END : div detail table TOOL Z014 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<?php  
//==set : calculatet sub_total_all
$total_all_request = $sub_total_request_Z001+$sub_total_request_Z013+$sub_total_request_Z005+$sub_total_request_Z002+$sub_total_request_Z014; 

?>
<div class="col-sm-12 no-padd">
      <div class="col-sm-4 pull-right no-padd">
        <div class="input-group m-b">                                                  
             <span class="input-group-addon">
              <font class="pull-left"><?php  echo freetext('total_all').' : '; ?></font>
             </span> 
             <input type="text" autocomplete="off" readonly name="total_all_request" class="form-control text-right total_all_request" value="<?php echo  $total_all_request; ?>">
        </div>
      </div>
</div>


<!-- 
<button class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tooltip on top">Tooltip on top</button> -->