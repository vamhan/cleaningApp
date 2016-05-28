    <?php
     
if( $this->act =='edit_quotation' || $this->act =='view_quotation'){
     //====start : get data quotation ship_to  =========
     $data_quotation = $query_quotation->row_array();

     if(!empty($data_quotation)){
      $sold_to_id   = $data_quotation['sold_to_id']; 
      $job_type     =$data_quotation['job_type'];
      $distribution_channel  =$data_quotation['distribution_channel'];

     }else{

      $sold_to_id ='';
      $job_type  ='';
      $distribution_channel  ='';
     }
    
    //==== get sold_to_account_group  by jobtype 
    $sold_to_account_group = '';
    if($job_type =='ZQT1'){
      $sold_to_account_group = 'Z10';
    }else if($job_type =='ZQT2'){
      $sold_to_account_group = 'Z11';
    }else{
      $sold_to_account_group = 'Z12';
    }

    //==== get ship_to_account_group  by jobtype 
    $ship_to_account_group = '';
    if($job_type =='ZQT1'){
      $ship_to_account_group = 'Z10';
    }else if($job_type =='ZQT2'){
      $ship_to_account_group = 'Z21';
    }else{
      $ship_to_account_group = 'Z22';
    }


    
}else{  
     $data_quotation = $query_prospect->row_array(); 
}//end else

    
?>


     <div class="modal fade" id="modal-date-asset-1">
         <!-- #### select date asset 1-->
          <form action='<?php //echo site_url($this->page_controller.'/create');  ?>' method="POST">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo 'Select date';?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>              
                  

                  <div class="col-sm-12 add-all-medium">
                    <div class="row no-padd">
                      <div class="col-md-4 no-padd">                        
                          <select  name='date' class="form-control date col-sm-4"  >                                 
                          <option value='1'>day 1</option>        
                          </select>
                      </div>
                      <div class="col-md-4">
                         <div class="input-group m-b">
                          <input type="text" autocomplete="off" class="form-control" readonly value="january">
                        </div>
                      </div>
                      <div class="col-md-4 no-padd">
                         <div class="input-group m-b">
                          <input type="text" autocomplete="off" class="form-control" value="24 Regular" readonly value="2014">
                        </div>
                      </div>
                    </div>
                </div>

                </div>

                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                  <button type="submit" class="btn btn-primary" name="save"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button> 
                   <!-- <input type='hidden' name="callback_url"value="<?php //echo site_url($this->page_controller.'/listview'); ?>">
                  <input type='submit' class="btn btn-primary" value="Save"> -->                                   
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </form>
      </div>


      <!--Start: modal confirm delete_uploadfile  -->
        <div class="modal fade" id="modal-sold-to"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo freetext('sold_to'); ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  
                  <div class="col-sm-12 add-all-medium">
                    
                    <div class="form-group col-sm-12 div_sold_to">
                      <label class="col-sm-2 control-label h5"><?php echo freetext('sold_to'); //echo $sold_to_id ?></label>
                      <div class="col-sm-10">

                       <!--  <select  name='sold_to' class='form-control' >
                           <option value='1'>sold_to option1</option> 
                       </select> -->
                       <select  name='sold_to' class='select2 no-padd h5' style="width:400px;">
                          <?php 
                             $count_data_sold_to = 0; 
                            $temp_bapi_sold_to = $bapi_sold_to->result_array();
                            if(!empty($temp_bapi_sold_to)){
                              foreach($bapi_sold_to->result_array() as $value){ 
                                  if($sold_to_account_group == $value['sold_to_account_group'] && $distribution_channel == $value['sold_to_distribution_channel'] ){
                           ?>
                           <option value='<?php echo $value['id']; ?>'><?php echo $value['id'].' '.$value['sold_to_name']; //echo ' '.$value['sold_to_account_group'];  echo ' '.$value['sold_to_distribution_channel']; ?></option> 
                           <?php
                                     $count_data_sold_to++;
                                  }//end if
                                }//end foreach
                              }else{ 
                            ?>
                           <!-- <option value='0'>ไม่มีข้อมูล</option>    -->                         
                           <?php }
                              if(empty($count_data_sold_to)){ echo " <option value='0'>ไม่มีข้อมูล</option>";  }
                           ?>
                       </select>                     
                      </div>
                    </div>
                  </div>
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn btn-primary save-change-sold-to" data-dismiss="modal" ><?php echo freetext('change'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm delete_uploadfile -->


        <!--Start: modal confirm delete_uploadfile  -->
        <div class="modal fade" id="modal-ship-to"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo freetext('ship_to'); ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  
                  <div class="col-sm-12 add-all-medium">
                    
                    <div class="form-group col-sm-12 div_sold_to">
                      <label class="col-sm-4 h5 control-label"><?php echo freetext('ship_to'); ?></label>
                      <div class="col-sm-8">
                       <!--  <select  name='ship_to' class='form-control' >
                           <option value='1'>ship_to option1</option> 
                       </select> -->
                       <!--  <select  name='ship_to' class='form-control' > -->
                          <select  name='ship_to' class='select2 no-padd h5' style="width:300px;">
                            <option value="0" select="selected" >กรุณาเลือก</option>
                          <?php 
                            $count_data = 0;                           
                            $temp_bapi_ship_to = $bapi_ship_to->result_array();
                            if(!empty($temp_bapi_ship_to)){
                              foreach($bapi_ship_to->result_array() as $value){ 
                                  if($sold_to_id == $value['sold_to_id']  && $ship_to_account_group==$value['ship_to_account_group'] && $distribution_channel==$value['ship_to_distribution_channel'] ){
                           ?>
                           <option value='<?php echo $value['id']; ?>'><?php echo $value['id'].' '.$value['ship_to_name'];  //echo ' '.$value['ship_to_account_group']; ?></option> 
                           <?php
                                      $count_data++;
                                  }//end if  
                                }//end foreach
                              }else{ 
                            ?>
                              <!-- <option value='0'>ไม่มีข้อมูล</option> -->                      
                           <?php } 
                             if(empty($count_data)){ echo " <option value='0'>ไม่มีข้อมูล</option>";  }
                           ?>
                       </select>  

                      </div>
                    </div>
                  </div>

                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn btn-primary save-change-ship-to" data-dismiss="modal" ><?php echo freetext('change'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm delete_uploadfile -->



        <!--Start: modal confirm delete_uploadfile  -->
        <div class="modal fade" id="modal-soldTo-prospect"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo freetext('sold_to_prospect'); ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  
                  <div class="col-sm-12 add-all-medium">
                   
                       <div class="form-group col-sm-12 div_prospect_customer">
                        <label class="col-sm-3 control-label"><?php echo freetext('sold_to_prospect'); ?></label>
                        <div class="col-sm-9">
                          <select  name='prospect_customer' class='form-control' >
                            <?php  
                            $temp_prospect = $get_prospect->result_array();
                              //print_r($temp);
                             if(!empty($temp_prospect)){                            
                               foreach($get_prospect->result_array() as $row){
                            ?>
                               <option value="<?php echo $row['id'] ?>"><?php echo $row['title']; ?></option> 
                             <?php 
                                } //end foreach
                              }else{                              
                             ?>
                              <option value="0">ไม่มีข้อมูล</option> 
                             <?php } ?>
                         </select>
                        </div>
                      </div>                 
                   </div>

                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn btn-cancel-prospect  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn btn-save-prospect btn-primary" data-dismiss="modal" ><?php echo freetext('change'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm delete_uploadfile -->



    <!--Start: modal confirm delete_uploadfile  -->
        <div class="modal fade" id="modal-delete-uploadfile"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo freetext('delete_confirm'); ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg h5'>คุณต้องการลบไฟล์นี้หรือไม่</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-delete-file  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn confirm-delete-file btn-primary" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm delete_uploadfile -->



<!--Start: modal confirm delete_uploadfile  -->
        <div class="modal fade" id="modal-delete-contact"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo freetext('delete_confirm'); ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg h5'>คุณต้องการลบผู้ติดต่อนี้หรือไม่</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-delete-contact  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn confirm-delete-contact btn-primary" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm delete_uploadfile -->


        <!--Start: modal confirm  delete-other-service -->
        <div class="modal fade" id="modal-delete-other-service"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo freetext('delete_confirm'); ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg h5'>คุณต้องการลบข้อมูลหรือไม่</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-delete-service  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn confirm-delete-service btn-primary" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm delete-other-service -->


        <!--Start: modal confirm  delete-other-service -->
        <div class="modal fade" id="modal-delete-area"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo freetext('delete_confirm'); ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg h5'>คุณต้องการลบข้อมูลหรือไม่</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-delete-service  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn confirm-delete-service btn-primary del_area_confirm" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm delete-other-service -->

        <!--Start: modal confirm delete_uploadfile  -->
        <div class="modal fade" id="modal-confirm-save"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo freetext('confirm'); ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg h5'>คุณต้องการบันทึกการเปลี่ยนแปลงหรือไม่</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-save  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn confirm-save btn-primary" data-dismiss="modal" ><?php echo freetext('save'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm delete_uploadfile -->



          <!--Start: modal confirm  modal-confirm-recal -->
        <div class="modal fade" id="modal-confirm-recal"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title">ยืนยันการรีเซทข้อมูล</h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <p class='msg h5'>คุณต้องการลบข้อมูลหรือไม่</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-confirm  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn confirm btn-primary" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm modal-confirm-recal -->