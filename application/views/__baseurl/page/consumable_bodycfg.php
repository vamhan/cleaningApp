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
<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i> รายการและจำนวนวัสดุสิ้นเปลือง</h4>

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
              <div class="row" style="margin-bottom:15px;">                 
                <span class="margin-left-medium"><?php echo freetext('Z001_type'); ?></span>              
                </div>
            </header>
           

             <div class="div-table">
             
              <table  class="table no-padd table_chemical" >
                  <thead>
                    <tr class="back-color-gray h5">                          
                      <th width="400"><?php echo freetext('customer_request');?></th>                                        
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
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                          <td class="tx-center"><?php echo number_format($value_data['price'],2);//echo $value_data['price']; ?>
                            <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_no; ?>" value="<?php echo $value_data['price']; ?>"> 
                          </td> 
                          <td class="tx-center">
                            <?php echo number_format($value_data['total_price'],2);//echo $value_data['total_price']; ?>                                                        
                            <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_no; ?>" value="<?php echo $value_data['total_price']; ?>">
                          </td>                                            
<?php
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>        
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
              <div class="row" style="margin-bottom:15px;">                 
                <span class="margin-left-medium"><?php echo freetext('Z013_type'); ?></span>
                </div>
            </header>

            <div class="div-table">
            <table  class="table no-padd table_chemical">
                  <thead>
                    <tr class="back-color-gray h5">                          
                      <th width="400"><?php echo freetext('customer_request');?></th>                                        
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
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                          <td class="tx-center"><?php echo number_format($value_data['price'],2);//echo $value_data['price']; ?>
                            <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_no; ?>" value="<?php echo $value_data['price']; ?>"> 
                          </td> 
                          <td class="tx-center">
                            <?php echo number_format($value_data['total_price'],2);//echo $value_data['total_price']; ?>                                                        
                            <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_no; ?>" value="<?php echo $value_data['total_price']; ?>">
                          </td>   
<?php
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>                                       
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
                      <th width="200"><?php echo freetext('group_machine');?></th>
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
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                          <td class="tx-center"><?php echo number_format($value_data['price'],2);//echo $value_data['price']; ?>
                            <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_no; ?>" value="<?php echo $value_data['price']; ?>"> 
                          </td> 
                          <td class="tx-center">
                            <?php echo number_format($value_data['total_price'],2);//echo $value_data['total_price']; ?>                                                        
                            <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_no; ?>" value="<?php echo $value_data['total_price']; ?>">
                          </td>
<?php
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>                        
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
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                          <td class="tx-center"><?php echo number_format($value_data['price'],2);//echo $value_data['price']; ?>
                            <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_no; ?>" value="<?php echo $value_data['price']; ?>"> 
                          </td> 
                          <td class="tx-center">
                            <?php echo number_format($value_data['total_price'],2);//echo $value_data['total_price']; ?>                                                        
                            <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_no; ?>" value="<?php echo $value_data['total_price']; ?>">
                          </td>    
<?php
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>                     
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
<?php
//===== TODO :: SET PERMISSION=====
foreach($temp_function_login as $temp => $temp_value) {  
if(is_array($permission_view_wage) && in_array($temp_value, $permission_view_wage)){ //ST ,OP
?>
                          <td class="tx-center"><?php echo number_format($value_data['price'],2);//echo $value_data['price']; ?>
                            <input type="hidden" readonly  class='form-control price' name="<?php echo "price_".$temp_no; ?>" value="<?php echo $value_data['price']; ?>"> 
                          </td> 
                          <td class="tx-center">
                            <?php echo number_format($value_data['total_price'],2);//echo $value_data['total_price']; ?>                                                        
                            <input type="hidden" readonly  class='form-control total_price' name="<?php echo "total_price_".$temp_no; ?>" value="<?php echo $value_data['total_price']; ?>">
                          </td> 
<?php
}//end userdata  temp_function
}//end set permission
//===== END : SET PERMISSION =====
?>                             
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
                </table>

              <!--  sub_total_request_Z014 -->
               <input type="hidden" readonly class="form-control sub_total_request_Z014" name="sub_total_request_Z014" value="<?php echo $sub_total_request_Z014; ?>" />
               <input type="hidden" readonly class="form-control check_data" value="<?php if(!empty($have_data)){ echo $have_data;  }else{ echo 0; } ?>" />
            
           
  </div><!-- end collapseRequest tool -->
</div>
<!-- //////////////////////////////////////////////////// END : div detail table TOOL Z014 ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->






<!--/////////////// form submit ///////////////////////////-->
<div class="form-group col-sm-12 ">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview/'.$this->quotation_id); ?>"  class="btn btn-info" style="width:120px;"> <?php echo freetext('back'); ?></a>
  </div>
</div>
<!-- end : form submit -->
</div><!-- end : class div_detail -->


          











