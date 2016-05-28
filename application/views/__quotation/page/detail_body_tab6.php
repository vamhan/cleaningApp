<form role="form" data-parsley-validate action="<?php echo site_url('__ps_quotation/update_qt_other_service/'.$this->quotation_id) ?>" method="POST"  > 

<!--########################### Start :div detail OTHER SERVICE ############################-->
    <div class="panel panel-default ">

      <div class="panel-heading" style="padding-bottom :24px;">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOther_service" class="toggle_tool">
            <?php echo freetext('other_service_title'); //Customer?>    
            <span><i class="margin-top-small-toggle icon_tool_down fa fa-caret-down  text-active pull-right"></i><i class="margin-top-small-toggle icon_tool_up fa fa-caret-up text  pull-right"></i></span>                             
             <span class="input-group m-b col-sm-3 pull-right margin-right-medium">                                                  
                 <span class="input-group-addon">                             
                    <font class="pull-left">
                    <?php  echo freetext('subtotal').' : '; ?>
                    </font>                         
                 </span> 
                 <input type="text" autocomplete="off" readonly  name="totol_of_top" class="form-control text-right" placeholder="subtotal" value=>
              </span>                     
          </a>                               
        </h4>
      </div>
          <div id="collapseOther_service" class="panel-collapse in">
                 <!-- start :body detail table machine -->
                      <div class="panel-body" style="padding:15px 0px 0px 0px;">
                        <div class="form-group col-sm-12  no-padd"  id="other_service">
                          <!-- end : table -->
                         <!--  <section class=" panel panel-default"> -->
                          <input type="hidden" name="first_conut_other_service" id="first_conut_other_service" class="form-control" value="0">
                          <input type="hidden" name="count_other_service" id="count_other_service" class="form-control" value="0">
                                <table  class="table no-padd table_other_service">
                                    <thead>
                                      <tr class="h5 back-color-gray">                         
                                        <th><?php echo freetext('service');?></th>                                        
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
                                              $temp_other_service = $query_other_service->result_array();
                                              $total = 0;
                                              if(!empty($temp_other_service)){
                                                  foreach($query_other_service->result_array() as $value){ 
                                                    $total = $total+$value['total'];
                                                     array_push($exist_mat, $value['other_service_id']);
                                                ?>
                                                <tr class="h5 service_id" id="<?php echo $value['id']; ?>">
                                                  <td><?php echo  defill($value['other_service_id']).' '.$value['other_service_title']; // echo $value['other_service_id'].' '.?></td>
                                                  <td class="tx-center"><?php echo $value['quantity'].' '.$value['quantity_unit'];?></td>
                                                  <td><?php echo number_format($value['price'],2); //echo $value['price'];?></td>
                                                  <td><?php echo number_format($value['total'],2);//echo $value['total'];?></td>                                                    
                                                  
                                                  <td class="tx-center">
                                                    <a data-toggle="tooltip" data-placement="top" title="<?php echo freetext('del_label'); ?>" class="btn btn-default delete_other_contact_service margin-left-small" 
                                                      id="<?php echo $value['id']; ?>" doc-id="<?php echo $this->quotation_id; ?>" >
                                                      <i class="fa fa-trash-o"></i>
                                                    </a>
                                                  </td>
                                                </tr>
                                                <?php
                                                    }//end foreach
                                                  }else{ 
                                                ?>                                   
                                                <tr class="empty_data h5">
                                                    <td colspan='6'><?php echo 'ไม่มีข้อมูล';?></td>                                              
                                                </tr>
                                        <?php } ?>

                                    </tbody> 
                                    <tfoot>
                                      <tr>
                                          <td>      
                                            <select  name="other_service" class='form-control other_service' >
                                              <option seleted='seleted' value='0'>กรุณาเลือกบริการ</option>
                                                <?php 
                                                    $temp_bapi_otherService= $bapi_other_service->result_array();
                                                    if(!empty($temp_bapi_otherService)){
                                                    foreach($bapi_other_service->result_array() as $value){ 
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
                                            <input type="hidden" name="other_service_name" readonly class="form-control other_service_name">
                                            <span class="tx-red text_msg1"></span>
                                          </td>
                                          <td>
                                             <center>                                            
                                               <div class="input-group m-b"  style="width:160px;">
                                                <input type="text" autocomplete="off" readonly="readonly" name="quantity" onkeypress="return isInt(event)"  class="form-control quantity" />
                                                <input type="hidden" readonly name="quantity_code"  class="form-control quantity_code" >
                                                <span class="input-group-addon code_unit"><?php echo freetext('unit'); ?></span>                                                
                                              </div>
                                              <span class="tx-red text_msg2"></span>
                                            </center>                                         
                                          </td> 
                                          <td>
                                              <span><input type='text' readonly name="price" class='form-control price'   placeholder='<?php echo freetext('price'); ?>'/></span>
                                          </td>                   
                                         <td>      
                                            <span><input type='text' readonly name="total" class='form-control total'   placeholder='<?php echo freetext('total'); ?>'/></span>
                                            <span class="tx-red text_msg3"></span>
                                          </td> 
                                          <td class="tx-center">
                                            <span  class="btn btn-primary add_other_service"><i class="fa fa-plus"></i> <?php echo freetext('add_service'); ?></span>
                                          </td>
                                      </tr>

                                      <!-- // sum total -->
                                      <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td>
                                            <input type="hidden" autocomplete="off" readonly class='form-control text-right' id='total_all' placeholder="total" value="<?php echo  $total; ?>">
                                            <!-- <div id='total_all'></div> -->
                                          </td>
                                          <td></td>
                                      </tr>
                                    </tfoot>
                                </table>
                            <!--  </section> --> <!-- end : table -->
                        </div><!-- end : col12-->
                      </div><!-- end :body detail table machine -->
          </div>
    </div>
<!--################################ end :div OTHER SERVICE ############################-->

<!-- start : form submit save -->
<div class="form-group col-sm-12 no-padd" style="margin-top:80px;">
  <div class="pull-right">
    <a href="<?php echo site_url('__ps_quotation/listview_quotation'); ?>"  class="btn btn-default"> <?php echo freetext('cancel'); ?></a>
    <button type="submit" class="btn btn-primary margin-left-small"><?php echo freetext('Save_changes'); ?></button>
  </div>
</div>
</form>
<!-- end : form submit save -->