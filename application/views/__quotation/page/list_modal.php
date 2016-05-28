
         <!--Start: modal confirm delete -->
        <div class="modal fade" id="modal-delete"  is-confirm='0'>                  
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
        </div><!--end: modal confirm delete -->

        

        <div class="modal fade" id="modal-insert-quotation">
          <form action='<?php echo site_url($this->page_controller.'/insert_quotation');  ?>' method="POST" data-parsley-validate onSubmit="return fieldCheck_insert_qt();">         
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo freetext('remark');?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>  

                   <div class="form-group col-sm-12">
                      <label class="col-sm-3 control-label"><?php echo freetext('title'); ?></label>
                      <div class="col-sm-9">
                         <input type="text" autocomplete="off" class="form-control" name="title" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" />
                      </div>
                    </div>  
                   
                   <div class="form-group col-sm-12">
                    <label class="col-sm-3 control-label"><?php echo freetext('job_type'); ?></label>
                     <div class="col-sm-9">
                        <div class="col-sm-3">
                          <label>
                            <input type='radio' name='job_type' class="ZQT1 job_type" value='ZQT1' checked='checked'>
                            <?php echo freetext('ZQT1'); //No have serial code?>                            
                          </label>
                        </div>
                        <div class="col-sm-3"> 
                          <label >
                           <input type='radio' name='job_type' class="ZQT2 job_type" value='ZQT2'>
                            <?php echo freetext('ZQT2'); //No have serial code?>                            
                          </label>
                        </div>
                        <div class="col-sm-3"> 
                          <label >
                           <input type='radio' name='job_type' class="ZQT2_extra job_type" value='ZQT2_extra'>
                            <?php echo freetext('ZQT2_extra'); //No have serial code?>                            
                          </label>
                        </div>
                        <div class="col-sm-3"> 
                          <label >
                           <input type='radio' name='job_type' class="ZQT3 job_type" value='ZQT3'>
                            <?php echo freetext('ZQT3'); //No have serial code?>                            
                          </label>
                        </div>
                      </div>                  
                    </div>

                    <div class="form-group col-sm-12 doc_type">
                    <label class="col-sm-3 control-label"><?php echo freetext('doc_type'); ?></label>
                     <div class="col-sm-9">                       
                        <div class="col-sm-4"> 
                          <label >
                           <input type='radio' name='doc_type'  value='2' checked='checked'>
                            <?php echo freetext('quotation'); //No have serial code?>                            
                          </label>
                        </div>
                      </div>
                    </div>


                 <div class="box_customer col-sm-12 no-padd">                 

                    <div class="form-group col-sm-12">
                      <label class="col-sm-3 control-label"><?php echo freetext('customer_source'); ?></label>
                      <div class="col-sm-9">
                        <select  name='customer_source' class='form-control customer_source' >
                          <option value='customer_prospect' selected='selected'><?php echo freetext('prospect_customer'); ?></option> 
                           <option value='sold_to' ><?php echo freetext('sold_to_qt'); ?></option>                            
                       </select>
                      </div>
                    </div>

                    <?php
                     $permission = $this->permission[$this->cat_id];
                     $distribution_channel =  $this->session->userdata('distribution_channel');

                     // echo '<br>distribution_channel : ';
                     // print_r($distribution_channel);
                    ?>

                    <div class="form-group col-sm-12 div_distribution hide">
                      <label class="col-sm-3 control-label"><?php echo freetext('distribution_channel'); ?></label>
                      <div class="col-sm-9">
                          
                          <select  name='distribution_channel' class='form-control distribution_channel' id="distribution_channel">
                           <option selected='selected' value='0'>กรุณาเลือก</option>
                              <?php 

                                if ($permission['shipto']['value'] == 'all') {                          
                                  foreach($bapi_distribution->result_array() as $value){ 
                                 ?>
                                     <option  value='<?php echo $value['id'] ?>'><?php echo $value['distribution_channel_description'] ?></option> 
                                <?php 
                                  }//end foreach
                                } else {

                                  foreach($distribution_channel as $a => $a_value) {
                                    $temp_bapi_distribution = $bapi_distribution->result_array();                                  
                                    if(!empty($temp_bapi_distribution)){                                
                                      foreach($bapi_distribution->result_array() as $value){ 
                                        if($a_value == $value['id']){
                                 ?>
                                     <option  value='<?php echo $value['id'] ?>'><?php echo $value['distribution_channel_description'] ?></option> 
                                <?php 
                                        }//end if
                                      }//end foreach
                                    }else{ 
                                ?>
                                     <option value='0'>ไม่มีข้อมูล</option> 
                                <?php 
                                    }//end else
                                  }
                                }//end foeach  distribution_channel
                              ?>
                            </select>                
                      </div>
                    </div>       


                    <div class="form-group col-sm-12 div_sold_to hide">
                      <label class="col-sm-3 control-label"><?php echo freetext('sold_to_qt'); ?></label>
                      <div class="col-sm-9">
                        <select disabled  name='sold_to' class='form-control ' id="sold_to">
                          <option selected='selected' value='0'>กรุณาเลือก</option>                         
                       </select>
                      </div>
                    </div>
                  
                     <div class="form-group col-sm-12 div_prospect_customer">
                      <label class="col-sm-3 control-label"><?php echo freetext('prospect_customer'); ?></label>
                      <div class="col-sm-9">
                        <select  name='prospect_customer' class='form-control prospect_customer' >
                          <option selected='selected' value='0'>กรุณาเลือก</option>   
                          <?php  
                            $count =0;
                            $prospect  = $this->__quotation_model->get_prospect();
                            if($prospect->num_rows()!=0){
                            foreach($distribution_channel as $a => $a_value) {
                              foreach ($prospect->result_array() as $row){ 
                                if($a_value == $row['distribution_channel'] ){
                                   $count ++;
                          ?>    
                             <option value="<?php echo $row['id'] ?>"><?php echo $row['title']; ?></option> 
                           <?php 
                                  }//end if
                                } //end foreach                               
                              }//end foreach

                              if($count==0){
                                    echo "<option value='0'>ไม่มีข้อมูล1</option>";
                              }//end if

                            }else{                              
                           ?>
                            <option value="0">ไม่มีข้อมูลl</option> 
                           <?php 
                              } //end else

                           ?>
                       </select>
                       <?php  //print_r( $prospect); ?>
                      </div>
                    </div>
                 </div>

                   
                 

                     <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo freetext('create_date'); ?></label>
                        <div class="col-sm-9">
                          <input type="text" autocomplete="off" readonly class="form-control"  value="<?php echo date('d.m.Y'); ?>"/>
                          <input type="hidden" class="form-control" name="create_date" value="<?php echo date('Y-m-d')?>"/>
                        </div>
                    </div>
                 

                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                  <button type="submit" class="btn btn-primary btn_insert" name="save" >
                    <i class="fa fa-save h5"></i> <?php echo freetext('save'); ?>
                  </button> 
                  <button type="submit" class="btn btn-primary btn_insert_hide hide" disabled  >
                    <i class="fa fa-save h5"></i> <?php echo freetext('save'); ?>
                  </button>                                   
                </div>

              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </form>
      </div>
  





      <div class="modal fade" id="modal-insert-prospect">
          <form action='<?php echo site_url($this->page_controller.'/insert_quotation');  ?>' method="POST" data-parsley-validate>         
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo freetext('remark');?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>  

                   <div class="form-group col-sm-12">
                      <label class="col-sm-3 control-label"><?php echo freetext('title'); ?></label>
                      <div class="col-sm-9">
                         <input type="text" autocomplete="off" class="form-control" name="title" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" />
                      </div>
                    </div>  
                   
                   <input type='hidden' name='job_type'  value=''>
                  <!--  <div class="form-group col-sm-12">
                    <label class="col-sm-3 control-label"><?php// echo freetext('job_type'); ?></label>
                     <div class="col-sm-9">
                        <div class="col-sm-3">
                          <label>
                            <input type='radio' name='job_type' class="ZQT1" value='ZQT1' checked='checked'>
                            <?php// echo freetext('ZQT1'); //No have serial code?>                            
                          </label>
                        </div>
                        <div class="col-sm-3"> 
                          <label >
                           <input type='radio' name='job_type' class="ZQT2" value='ZQT2'>
                            <?php //echo freetext('ZQT2'); //No have serial code?>                            
                          </label>
                        </div>
                        <div class="col-sm-3"> 
                          <label >
                           <input type='radio' name='job_type' class="ZQT2_extra job_type" value='ZQT2_extra'>
                            <?php //echo freetext('ZQT2_extra'); //No have serial code?>                            
                          </label>
                        </div>
                        <div class="col-sm-3"> 
                          <label >
                           <input type='radio' name='job_type' class="ZQT3" value='ZQT3'>
                            <?php// echo freetext('ZQT3'); //No have serial code?>                            
                          </label>
                        </div>
                      </div>
                    </div> -->

                    <div class="form-group col-sm-12 doc_type_prospect">
                    <label class="col-sm-3 control-label"><?php echo freetext('doc_type'); ?></label>
                     <div class="col-sm-9">
                        <div class="col-sm-5">
                          <label>
                            <input type='radio' name='doc_type'  value='1' checked="checked">
                            <?php echo freetext('prospect'); //No have serial code?>                            
                          </label>
                        </div>
                       
                      </div>
                    </div>
                 
                 

                     <div class="form-group col-sm-12">
                        <label class="col-sm-3 control-label"><?php echo freetext('create_date'); ?></label>
                        <div class="col-sm-9">
                          <input type="text" autocomplete="off" readonly class="form-control"  value="<?php echo date('d.m.Y'); ?>"/>
                          <input type="hidden" class="form-control" name="create_date" value="<?php echo date('Y-m-d')?>"/>
                        </div>
                    </div>
                 

                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                  <button type="submit" class="btn btn-primary btn_insert" name="save" >
                    <i class="fa fa-save h5"></i> <?php echo freetext('save'); ?>
                  </button> 
                  <button type="submit" class="btn btn-primary btn_insert_hide hide" disabled  >
                    <i class="fa fa-save h5"></i> <?php echo freetext('save'); ?>
                  </button>                                   
                </div>

              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </form>
      </div>















