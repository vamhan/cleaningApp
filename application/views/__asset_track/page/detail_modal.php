    <?php
    $data = $query_track->row_array();
    // $actor_id =$data['actor_id'];
    // $actor_name =$data['actor_name'];
    // $actor_surname =$data['actor_surname'];

    //get asset
    $track_doc_id = $data['asset_track_document_id'];
    $project_id=$data['quotation_id'];
    $ship_to_id=$data['ship_to_id'];

    ?>


     <div class="modal fade" id="modal-date-asset-1">
         <!-- #### select date asset 1-->
          <form action='<?php echo site_url($this->page_controller.'/create');  ?>' method="POST">
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
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> Cancel</a>
                  <button type="submit" class="btn btn-primary" name="save"><i class="fa fa-save h5"></i> Save</button> 
                   <!-- <input type='hidden' name="callback_url"value="<?php echo site_url($this->page_controller.'/listview'); ?>">
                  <input type='submit' class="btn btn-primary" value="Save"> -->                                   
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </form>
      </div>



      <div class="modal fade" id="modal-date-asset-2">
         <!-- #### select date asset 2-->
          <form action='<?php echo site_url($this->page_controller.'/create');  ?>' method="POST">
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
                          <input type="text" autocomplete="off" class="form-control" readonly value="febuary">
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
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> Cancel</a>
                  <button type="submit" class="btn btn-primary" name="save"><i class="fa fa-save h5"></i> Save</button> 
                   <!-- <input type='hidden' name="callback_url"value="<?php echo site_url($this->page_controller.'/listview'); ?>">
                  <input type='submit' class="btn btn-primary" value="Save"> -->                                   
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </form>
      </div>



      <div class="modal fade" id="modal-remark">
         <!-- #### remark-->
         
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo freetext('remark');?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>              
                 

                  <div class="form-group  col-sm-12">
                     <textarea  maxlength="765" id="remark_area" name="remark_area"  style="width:500px;height:150px;" placeholder="ใส่ข้อความ" ></textarea>
                  </div>

                </div>

                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                  <button type="submit" class="btn btn-primary" name="save" id="remark_save">
                    <i class="fa fa-save h5"></i> <?php echo freetext('save'); ?>
                  </button>                                   
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

      </div>









        <div class="modal fade" id="modal-add-Untrack">
          <!-- #### add asset-->

          <form action='<?php echo site_url($this->page_controller.'/create_untrack_asset'); ?>' method="POST" data-parsley-validate>        
            <input type="hidden" name="untrack_doc_id" value="<?php echo $this->track_doc_id; ?>"/>
            <input type="hidden" name="untrack_project_id" value="<?php echo $this->project_id; ?>"/>
            <input type="hidden" name="untrack_ship_to_id" value="<?php echo $ship_to_id; ?>"/>

            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo freetext('add_untrack'); ?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>

                  <div class="form-group col-sm-12">                     
                      <div class="col-sm-9">
                        <div class="checkbox h5">
                          <label>
                            <input type="checkbox"  name="no_serial" value="1">
                            <?php echo freetext('no_have_serial_code'); //No have serial code?>                            
                          </label>
                        </div>
                      </div>
                  </div>

                  <div class="form-group col-sm-12">
                      <label class="col-sm-3 control-label"><?php echo freetext('serial'); ?></label>
                      <div class="col-sm-9">
                       <!--  <select id="select2-option" name="site_name" style="width:100%">  -->
                         <select  name='untrack_serial' class="have_serial"  id="select2-option" style="width:100%">
                          <!-- <option value=''></option> --> 
                         <?php 
                            foreach ($query_asset_no->result_array() as $row){
                              $asset_no=$row['ASSET_NO'];
                              $asset_name=$row['ASSET_NAME'];
                              if($row['MTART'] == 'Z018' || $row['MTART'] == 'Z019'){
                                if( $row['dummy'] != '1899'){
                          ?>
                            <option class="select_asset" unName="<?php echo $asset_name;?>" value='<?php echo $asset_no;?>'>
                                <?php echo "ID: ".defill($asset_no)." , NAME: ".$asset_name;?> 
                            </option>
                          <?php 
                                }//edn if
                              }//end if
                            }//end foreach
                          ?> 
                        </select>

         <!--  ############################################## GET dummy ################################################# -->

                        <!-- <select  name='untrack_serial_dummy' class="form-control  hide"  id="dummy" readonly>
                              <option value='dummy'>Dummy</option> 
                        </select> -->
                         <?php 

                           
                           $asset_dummy = $query_asset_dummy->row_array();
                           //$asset_dummy='';
                                if(!empty($asset_dummy)){
                                    ////////////////////////////////////////////////////////
                                      $untrack_dummy = $query_untrack_dummy->row_array();
                                     ///////////////////////////////////
                                     $dummy_code =array();
                                      if(!empty($untrack_dummy)){
                                         foreach ($query_untrack_dummy->result_array() as $row_untrack){
                                            //echo $row_untrack['ASSET_NO'].'<br>';                                 
                                            if(!in_array($row_untrack['ASSET_NO'],$dummy_code) ){
                                              array_push($dummy_code,$row_untrack['ASSET_NO']);
                                             }//end if in_array
                                           }//end foreach                       
                                      // echo '<pre>';
                                      // print_r ($dummy_code);
                                      // echo '<pre>';
                                      ////////////////////CHECK SELECT DUMMY /////////////////////////
                                       foreach ($query_asset_dummy->result_array() as $row){
                                        $asset_no=$row['ASSET_NO'];
                                        $asset_name=$row['ASSET_NAME'];    
                                          if(!in_array($asset_no,$dummy_code) ){                            
                                            $dummy_no = $asset_no;
                                            $dummy_name = $asset_name;  
                                            break;
                                          }//end if in_array   
                                        }//end foreach
                                         echo "<select  name='untrack_serial_dummy' class='form-control hide'  id='dummy' readonly>
                                                 <option value='$dummy_no'>ID: $dummy_no ,NAME: $dummy_name </option> 
                                             </select>";
                                   }else{   
                                        $dummy_no =0;
                                        foreach ($query_asset_dummy->result_array() as $row){
                                        $asset_no=$row['ASSET_NO'];
                                        $asset_name=$row['ASSET_NAME'];                                 
                                            $dummy_no = $asset_no;
                                            $dummy_name = $asset_name;                                  
                                        break;
                                        }//end foreach
                                        echo "<select  name='untrack_serial_dummy' class='form-control hide'  id='dummy' readonly>
                                                 <option value='$dummy_no'>ID: $dummy_no ,NAME: $dummy_name </option> 
                                             </select>"; 
                                      }//end else                             
                                  ////////////////////////////////////////////////////////////////////////////////////////
                                    }else{//end if checkout asset_dummy
                                        echo "<select  name='untrack_serial_dummy' class='form-control hide'  id='dummy' readonly>
                                                 <option value='dummy_null'>ไม่มีข้อมูล dummy ในระบบ</option> 
                                             </select>"; 

                                    }//end elsecheckout asset_dummy
                                  ?>                             

                       

     <!--  ############################################################################################################### -->

                      </div>
                    </div>

                    <div class="form-group col-sm-12  hide" id="div_assset_name">
                      <label class="col-sm-3 control-label"><?php echo freetext('asset_name'); ?></label>
                     <div class="col-sm-9">
                        <input data-parsley-required="false" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" class="form-control" name="untrack_name_asset" id="untrack_name_asset" >
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <label class="col-sm-3 control-label"><?php echo freetext('input_by'); ?></label>
                     <div class="col-sm-9">
                        <input type="text" autocomplete="off" readonly class="form-control" name="untrack_name" value="<?php echo $this->session->userdata('actual_name'); ?>">
                        <input type="hidden" class="form-control" name="untrack_input_by_id" value="<?php echo $this->session->userdata('id'); ?>">
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <label class="col-sm-3 control-label"><?php echo freetext('remark'); ?></label>
                      <div class="col-sm-9">
                         <textarea  maxlength="765" id="untrack_remark" name="untrack_remark"  style="width:370px;height:150px;" placeholder="Text input"></textarea>
                       </div>
                    </div>              
                            
                </div>

                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                  <button type="submit" class="btn btn-primary submit_save_untrack" name="save"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button> 
                  <!-- <input type='hidden' name="callback_url"value="<?php //echo site_url($this->page_controller.'/listview'); ?>">
                  <input type='submit' class="btn btn-primary" value="Save"> -->
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </form>
            </div>












      <!--Start: modal confirm sap all check -->
        <div class="modal fade" id="modal-sap-check"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo freetext('confirm_submit'); ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg_sap_p h5'></p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-submit-sap  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn confirm-submit-sap btn-primary" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm sap all check -->


     <!--Start: modal confirm sap uncheck -->
        <div class="modal fade" id="modal-sap-uncheck"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo freetext('confirm_submit'); ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg_sap_p h5'></p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">                
                  <span class="btn cancel-submit-sap  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel_submit'); ?></span>
                 </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm sap uncheck -->




         <!--Start: modal confirm delete untrack -->
        <div class="modal fade" id="modal-delete-untrack"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo freetext('delete_confirm'); ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg h5'>คุณต้องการลบข้อมูลนี้หรือไม่</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-delete  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn confirm-delete btn-primary" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm delete untrack-->



          <!--Start: modal  save assetrack -->
        <div class="modal fade" id="modal-save-assetrack"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo 'ยืนยันการบันทึก'; ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg h5'>ระบบจะทำการบันทึกการเปลี่ยนแปลง</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <!-- <span class="btn cancel-assetrack  btn-default" data-dismiss="modal" aria-hidden="true"><?php //echo freetext('cancel'); ?></span> -->
                  <span class="btn save-assetrack btn-primary" data-dismiss="modal" ><?php echo freetext('cancel_submit'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal   save assetrack-->



           <!--Start: modal  save assetrack -->
        <div class="modal fade" id="modal-to-fixclaim"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h3 class="title"><?php echo 'ย้ายไปหน้าการแจ้งซ่อม'; ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg h5'>คุณต้องการบันทึกการเปลี่ยนแปลง ก่อนย้ายไปหน้าแจ้งซ่อมหรือไม่</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-assetrack  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('unsaved'); ?></span>
                  <span class="btn save-assetrack btn-primary" data-dismiss="modal" ><?php echo freetext('save'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal   save assetrack-->








