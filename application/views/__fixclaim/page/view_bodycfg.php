<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}

</style>
          <div class="div_detail">

             <?php 
                          $project_id = $this->project_id;
                          $actor_by_id = $this->session->userdata('id');//***
                          $fixclaim_id =$this->fixclaim_id;

                          //get data fixclaim
                           $data = $query_fixclaim->row_array(); 
                           $action_plan_id = $data['action_plan_id'];  

                           $raise_date =$data['raise_date'];
                           $raise_by_id =$data['raise_by_id'];
                           $ship_to_id =$data['ship_to_id'];
                           
                           // $serial     =$data['project_asset_id'];
                           // $asset_name =$data['ASSET_NAME'];
                           $serial     =$data['material_no'];
                           $asset_name =$data['material_description'];

                           $title      =$data['title'];
                           $problem    =$data['problem'];
                           $remark     =$data['remark'];
                           $require_date =$data['required_date'];
                           $previous_fix_claim_id =$data['previous_fix_claim_id'];
                           $is_requied_spare =$data['is_required_spare'];
                           $is_urgent        =$data['is_urgent'];

                           $plan_date     =$data['plan_date'];
                           $pick_up_date  =$data['pick_up_date'];
                           $actual_date   =$data['actual_date'];
                           $finish_date   =$data['finish_date'];
                           $delivery_date =$data['delivery_date'];
                           $is_abort      =$data['is_abort'];
                           $is_repair_on_side =$data['is_repair_on_side'];

                           // $accept_delivered  =$data['accept_delivered_date'];
                           // $accept_abort      =$data['accept_abort_date'];

                           $accept_delivered  =$data['close_date'];
                           $accept_abort      =$data['close_date'];

                           //================== get owner  ==========
                           $data_owner = $query_owner->row_array();    

                           if(!empty($data_owner)){
                              $project_owner_id =$data_owner['project_owner_id'];  
                              $project_owner =$data_owner['project_owner_name'].' '.$data_owner['project_owner_lastname'];                               
                            }
                            else{ 
                              $project_owner_id =0; 
                              $project_owner='-'; 
                            }
                          //===========================================


                          //**====start : get actor name =========
                           $this->db->where('employee_id', $raise_by_id);
                           $query_actor=$this->db->get('tbt_user');
                           $data_actor = $query_actor->row_array();      
                           if(!empty($data_actor)){
                              $actor = $data_actor['user_firstname']." ". $data_actor['user_lastname'];
                            }else{ $actor='-'; }

                          //====end :  get actor name =========                      

                        ?>


              <section class="panel panel-default "> 
              <div class="panel panel-heading back-color-gray">                  
               <!--  view : -->  <?php echo freetext('for_reporter'); ?>              
              </div>              
                 <input type="hidden" name="action_plan_id"  class="form-control" readonly value="<?php echo $action_plan_id;  ?>">
                 <input type="hidden" name="fixclaim_id"  class="form-control" readonly value="<?php echo $fixclaim_id;  ?>">
                <!-- start : data action plan -->
                <div class="panel-body"> 
                    <div class="form-group">
                       <!-- start : input group -->
                        <div class="col-sm-12">
                        
                          <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo  '<div class="label-width-adon"><font class="pull-left">'.freetext('raise_date').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="raise_date"  class="form-control" readonly value="<?php  echo  common_easyDateFormat($raise_date);  ?> ">
                             </div>
                          </div>                       

                          <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('raise_by_fixclaim').'</font></div>'; ?></span>
                              <input type="hidden" name="raise_by_id" class="form-control" readonly value="<?php echo $actor_by_id;  ?>">
                              <input type="text" autocomplete="off"   class="form-control" readonly value="<?php echo $actor;  ?>">
                            </div>
                          </div>                            
                        
                      </div>
                      <!-- end : input group -->

                      <!-- start : input group -->
                        <div class="col-sm-12">
                 
                          <!-- start : input group -->
                            <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_name').'</font></div>'; ?></span>
                                <?php
                                    $data_ship_to = $query_ship_to->row_array();  
                                    $ship_to_n = $data_ship_to['ship_to_name1'];                                    
                                ?>                              
                                 <input type="text" autocomplete="off" class="form-control" readonly value="<?php echo $ship_to_n;?>">   
                            </div>
                          </div> 
                       <!-- end : input group --> 

                          <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('project_owner').'</font></div>'; ?></span>
                               <input type="hidden" name="owner_id" class="form-control" readonly value="<?php  echo $project_owner_id; ?>">
                               <input type="text" autocomplete="off"  class="form-control" readonly value="<?php echo $project_owner; ?>">
                            </div>
                          </div>                                  
                    
                      </div>
                      <!-- end : input group -->


                      <!-- start : input group -->
                        <div class="col-sm-12">
                        
                          <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('serial').'</font></div>'; ?></span>
                               <input type="text" autocomplete="off" name="serial" class="form-control" readonly  value="<?php  if(!empty($serial)){ echo  defill($serial); } ?>">
                               <span class="input-group-btn">
                                <!-- <button class="btn btn-default" type="button"><i class="fa fa-th"></i></button> -->
                                 <a  class="btn btn-default select_asset_id" ><i class="fa fa-th"></i></a>
                              </span>
                            </div>
                          </div>                       

                          <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('asset_name').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="asset_name" class="form-control" readonly value="<?php echo $asset_name; ?>">
                            </div>
                          </div>                            
                        
                      </div>
                      <!-- end : input group -->

                        <!-- start : input group -->
                        <div class="col-sm-12">
                          <div class="form-group col-sm-12">
                            <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('title_fixclaim').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="title" class="form-control"  value="<?php echo $title; ?>"  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_title'); ?>">
                            </div> 
                          </div>
                      </div>
                      <!-- end : input group -->                       


                    <!-- start : input group -->
                        <div class="col-sm-12">
                            <div class="form-group col-sm-12">
                              <label class="col-sm-2 problem-adon  "><?php echo freetext('problem'); ?></label>
                              <div class="col-sm-10 no-padd">
                                 <textarea data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_problem'); ?>" id="problem" name="problem"  style="width:100%;height:120px;" placeholder="Text input"><?php echo $problem;?></textarea>
                               </div>
                            </div>  
                      </div>
                      <!-- end : input group -->

                       <!-- start : input group -->
                        <div class="col-sm-12">
                       
                            <div class="form-group col-sm-12">
                              <label class="col-sm-2 problem-adon  "><?php echo freetext('remark'); ?></label>
                              <div class="col-sm-10 no-padd">
                                 <textarea id="remark" name="remark"  style="width:100%;height:80px;" placeholder="Text input"><?php echo $remark;?></textarea>
                               </div>
                            </div>                        
                        
                      </div>
                      <!-- end : input group -->

                        <!-- start : input group -->
                        <div class="col-sm-12">
                      
                          <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon">
                                 <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('require_date_for_asset').'</font></div>'; ?>
                              </span>
                               <div class='input-group date col-md-12' id='datetimepicker1' data-date-format="DD-MM-YYYY">
                                  <input type='text' class="form-control" name="require_date" readonly value="<?php echo common_easyDateFormat($require_date); ?>"/>
                                  <span class="input-group-addon btn">
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
                              </div>
                            </div>


                            
                            <div class="col-md-12 ">
                             
                                <label class="checkbox ">
                                    <input type="checkbox" name="is_require_spare" value="1" <?php if($is_requied_spare == 1) { echo "checked='checked'"; } ?> >
                                    <?php echo freetext('require_spare_part_while_fixing'); ?>
                                 </label>                             
                                                      
                                 <label class="checkbox ">
                                  <input type="checkbox" name="is_urgent" value="1" <?php if($is_urgent == 1) { echo "checked='checked'"; } ?>  >
                                   <?php echo freetext('urgent_require_date'); ?>
                                </label>
                           
                             </div>
                          </div>                           

                          <!-- <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('previouse_fix_id').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="previouse_fix_id" class="form-control"  value="<?php //if(!empty($previous_fix_claim_id)){ echo $previous_fix_claim_id; }else{echo '-'; } ?>" >
                            </div>
                          </div>  -->

                           <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon">
                                <label>
                                    <input  <?php if(!empty($previous_fix_claim_id)){  echo "checked='checked'"; } ?> type="checkbox" />
                                    <?php echo freetext('previouse_fix_id'); ?>
                                </label>
                              </span>
                                <input readonly placeholder= "<?php if(empty($previous_fix_claim_id)){ echo 'ไม่มีข้อมูลรหัสใบแจ้งซ่อม'; } ?>"  type="text" autocomplete="off" name="previouse_fix_id" id="ch_number" class="previouse  form-control"  value="<?php if(!empty($previous_fix_claim_id)){ echo $previous_fix_claim_id; } ?>" >                                
                             </div>
                          </div>

                        
                      </div>
                      <!-- end : input group -->

                    </div>                   
                </div>
                <!-- End : data action plan -->

              </section><!-- end : panel -->
              

             <div class="panel panel-default">
                  <div class="panel panel-heading  back-color-gray">                  
                       <?php echo freetext('for_store_manager'); ?>                
                  </div>
                   <div class="panel-body"> 
                    <div class="form-group">

                      <!-- start : input group -->
                        <div class="col-sm-12">
                          <div class="form-group col-sm-12">
                            <div class="input-group">
                              <span class="input-group-addon" style="border-right:solid 1px #ccc;"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('type_fixclaim').'</font></div>'; ?></span>                         
                                <div  style="border:solid 1px #ccc;">
                                  <label style="margin:7px 5px 5px 15px;">
                                     <input  type="checkbox" name="is_repair_on_side"  <?php if($is_repair_on_side == 1) { echo "checked='checked'"; } ?>>
                                      <?php echo freetext('repair_at_psgen'); ?>
                                  </label> 
                                </div>
                            </div> 
                          </div>
                      </div>
                      <!-- end : input group -->


                         <!-- start : input group -->
                        <div class="col-sm-12">
                      
                           <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon">
                                 <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('plan_Date').'</font></div>'; ?>
                              </span>
                               <div class='input-group date col-md-12' id='datetimepicker4' data-date-format="DD-MM-YYYY">
                                  <input type='text' class="form-control" name="plan_date" readonly 
                                  value="<?php if($plan_date!='0000-00-00'){ echo common_easyDateFormat($plan_date); } ?>"/>
                                  <span class="input-group-addon  btn" >
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
                              </div>
                            </div>
                          </div>    

                          <?php if($is_repair_on_side!=1){  ?>
                          <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon">
                                 <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('pick_up_date').'</font></div>'; ?>
                              </span>
                               <div class='input-group date col-md-12' id='datetimepicker5' data-date-format="DD-MM-YYYY">
                                  <input type='text' class="form-control" name="pick_up_date" readonly 
                                  value="<?php if($pick_up_date!='0000-00-00'){ echo common_easyDateFormat($pick_up_date);} ?>"/>
                                  <span class="input-group-addon  btn" >
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
                              </div>
                            </div>
                          </div>                  
                        <?php }//end check is repair on side ?>

                      </div>
                      <!-- end : input group -->



                        <!-- start : input group -->
                        <div class="col-sm-12">
                      
                           <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon">
                                 <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('finish_date').'</font></div>'; ?>
                              </span>
                               <div class='input-group date col-md-12' id='datetimepicker2' data-date-format="DD-MM-YYYY">
                                  <input type='text' class="form-control" name="finish_date" readonly
                                  value="<?php if($finish_date!='0000-00-00'){ echo common_easyDateFormat($finish_date);} ?>"/>
                                  <span class="input-group-addon btn" >
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
                              </div>
                            </div>

                         

                          </div>    

                          <?php if($is_repair_on_side!=1){  ?>
                          <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon">
                                 <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('delivery_date').'</font></div>'; ?>
                              </span>
                               <div class='input-group date col-md-12' id='datetimepicker3' data-date-format="DD-MM-YYYY">
                                  <input type='text' class="form-control" name="delivery_date" readonly
                                  value="<?php if($delivery_date!='0000-00-00'){ echo common_easyDateFormat($delivery_date);} ?>"/>
                                  <span class="input-group-addon btn" >
                                      <span class="glyphicon glyphicon-time" ></span>
                                  </span>
                              </div>
                            </div>
                          </div> 
                        <?php }//end check is repair on side ?>                 
                        
                      </div>
                      <!-- end : input group -->


                    </div>
                  </div>
            </div>

            <div class="panel panel-default">
                  <div class="panel panel-heading  back-color-gray">                  
                       <?php echo freetext('delivered_confirm'); ?>                
                  </div>
                   <div class="panel-body"> 
                    <div class="form-group">

                        <div class="col-sm-2">
                          <div class="form-group col-sm-12">
                              <label class="checkbox ">
                                <input type="checkbox" name="is_abort" value="1" <?php if($is_abort == 1) { echo "checked='checked'"; }?> >
                                <?php echo freetext('Abort_Task'); ?>
                              </label>
                            </div>
                        </div>
                         <!-- start : input group -->
                        <div class="col-sm-10">
                            <?php if($is_abort!=1){ ?>

                            <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon">
                                <label>
                                <input type="checkbox" class="accept_delivered"  <?php if($accept_delivered!='0000-00-00'){ echo "checked='checked'"; } ?>
                                <?php  if( $plan_date=='0000-00-00' || $pick_up_date=='0000-00-00' || $finish_date=='0000-00-00' || $delivery_date=='0000-00-00' ){ echo "disabled"; }  ?> />
                                  <?php echo freetext('accept_delivered'); ?>
                                </label>
                              </span>
                               <input type='hidden' class="form-control " name="accept_delivered" value="<?php echo $accept_delivered;?>" /> 
                               <input type='text' class="form-control check_deliver_date" readonly
                                value="<?php if($accept_delivered!='0000-00-00'){ echo common_easyDateFormat($accept_delivered);}else{ echo " "; } ?>"/>                              
                            </div>
                          </div>   
                          <?php }else{ ?>
                          <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon">
                                <label>
                                <input type="checkbox" class="accept_task_abort"  <?php if($accept_abort!='0000-00-00'){ echo "checked='checked'"; } ?>
                                 <?php  if( $plan_date=='0000-00-00' || $pick_up_date=='0000-00-00' || $finish_date=='0000-00-00' || $delivery_date=='0000-00-00' ){ echo "disabled"; }  ?> />
                                  <?php echo freetext('accept_task_abort'); ?>
                                </label>
                              </span>
                               <input type='hidden' class="form-control " name="accept_task_abort" value="<?php echo $accept_abort; ?>"/> 
                               <input type='text' class="form-control check_abort_date"  readonly
                                value="<?php if($accept_abort!='0000-00-00'){ echo common_easyDateFormat($accept_abort);}else{ echo " "; } ?>"/>                              
                            </div>
                          </div>      
                       <?php } ?>
                      </div>
                      <!-- end : input group -->                  
                   
                
                    </div>
                  </div>
                  <footer class="panel-footer text-right bg-light lter">
                      <!-- <a href="<?php //echo site_url($this->page_controller.'/listview/list/'.$project_id ); ?>" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a> -->
                  </footer>
               
            </div>


            <div style="margin: 50px;"></div>

            </div><!-- end : class div_detail -->

            </section><!-- end : scrollable padder -->
          </section><!-- end : class vbox -->
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>



          











