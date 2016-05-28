<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}

</style>
          <div class="div_detail">

              <section class="panel panel-default "> 
              <div class="panel panel-heading back-color-gray">                  
                 เพิ่มแจ้งซ่อม : <?php echo freetext('for_reporter'); ?>               
              </div>              
                <form action='<?php echo site_url($this->page_controller.'/create_fixclaim/'.$this->project_id); ?>' method="POST" data-parsley-validate> 
                <!-- start : data action plan -->
                <div class="panel-body"> 
                    <div class="form-group">
                        <?php 
                         
                          $project_id = $this->project_id;
                          $actor_by_id = $this->session->userdata('id');    

                          //================== get owner  ==========
                           $data_owner = $query_owner->row_array();    

                           if(!empty($data_owner)){
                              $project_owner_id =$data_owner['project_owner_id'];  
                              $project_owner =$data_owner['project_owner_name'].' '.$data_owner['project_owner_lastname'];                               
                              $contract_id = $data_owner['contract_id'];
                              $ship_to_id_input = $data_owner['ship_to_id'];
                            }
                            else{ 
                              $project_owner_id =0; 
                              $project_owner='-'; 
                              $contract_id ='';
                            }
                          //===========================================                     

                        ?>

                        <!-- start : input group -->
                        <div class="col-sm-12">
                          <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('raise_date').'</font></div>'; ?></span>
                              <input type="hidden" name="raise_date" class="form-control"  value="<?php  echo  date('Y-m-d'); ?> ">
                              <input type="text" autocomplete="off" class="form-control" readonly value="<?php  echo  common_easyDateFormat(date('Y-m-d'));  ?> ">
                            </div>
                          </div>                       

                          <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('raise_by_fixclaim').'</font></div>'; ?></span>
                              <input type="hidden" name="raise_by_id" class="form-control" readonly value="<?php echo $actor_by_id;  ?>">
                              <input type="text" autocomplete="off"   class="form-control" readonly value="<?php echo $this->session->userdata('actual_name');  ?>">
                            </div>
                          </div>         
                      </div>
                      <!-- end : input group -->

                      <!-- start : input group -->
                      <div class="col-sm-12">  

                        <!--  <div class="col-sm-6">
                             <label class="col-sm-3 shipto-adon">
                                <?php //echo '<center>'.freetext('ship_to_name').'</center>'; ?>
                              </label>
                              <div class="col-sm-9 no-padd">
                                <select class="form-control" disabled > 
                                  <select  disabled id="select2-option"  style="width:100%"> 
                                       <?php //foreach ($query_ship_to->result_array() as $row){ ?>
                                           <option value="<?php //echo $row['id']; ?>"><?php //echo $row['name1']; ?></option>
                                        <?php //} ?>
                                  </select>                                  
                                  <input type="hidden"  name="ship_to_id"  class="form-control" readonly value="<?php //echo $ship_to_id_input;  ?>">
                              </div>                            
                          </div> -->

                      <!-- start : input group -->
                            <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_name').'</font></div>'; ?></span>
                                <?php
                                    $data_ship_to = $query_ship_to->row_array();  
                                    $ship_to_n = $data_ship_to['ship_to_name1'];                                    
                                ?>                              
                                 <input type="text" autocomplete="off" class="form-control" readonly value="<?php echo $ship_to_n;?>">   
                                 <input type="hidden"  name="ship_to_id"  class="form-control" readonly value="<?php echo $ship_to_id_input;?>">
                            </div>
                          </div> 
                       <!-- end : input group --> 


                          <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('project_owner').'</font></div>'; ?></span>
                               <input type="hidden" name="owner_id" class="form-control" readonly value="<?php  echo $project_owner_id; ?>">
                               <input type="hidden" name="contract_id" class="form-control"  value="<?php echo $contract_id; ?>">
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
                              <?php 
                                  $_material_no = $this->material_no; 
                                  $trace_id = $this->track_doc_id;
                              ?>
                               <input  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" id="sh_serial" class="form-control" readonly  value="<?php  if(!empty($_material_no)){ echo  defill($_material_no); } ?>">
                               <input type="hidden" name="serial" class="form-control" readonly  value="<?php echo $this->material_no; ?>">
                               <input type="hidden" name="is_assetrack_redireck" class="form-control" readonly  value="<?php if(!empty($_material_no)){ echo '1';  }else{ echo '0'; }  ?>">
                               <input type="hidden" name="trace_id" class="form-control" readonly  value="<?php echo $trace_id; ?>">

                               <span class="input-group-btn">
                                <!-- <button class="btn btn-default" type="button"><i class="fa fa-th"></i></button> -->
                                <a  class="btn btn-default select_asset_id"  <?php if(!empty($_material_no)){ echo 'disabled';  }  ?> ><i class="fa fa-th"></i></a>
                              </span>
                            </div>
                          </div>                      

                          <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('asset_name').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="asset_name" class="form-control" readonly value="<?php  echo $this->material_name; ?>">
                            </div>
                          </div>                            
                        
                      </div>
                      <!-- end : input group -->

                       <!-- start : input group -->
                        <div class="col-sm-12">
                          <div class="form-group col-sm-12">
                            <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('title_fixclaim').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="title" class="form-control"  value="<?php ?>"  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                            </div> 
                          </div>
                      </div>
                      <!-- end : input group -->

                     


                      <!-- start : input group -->
                        <div class="col-sm-12">
                            <div class="form-group col-sm-12">
                              <label class="col-sm-2 problem-adon"><?php echo freetext('problem'); ?></label>
                              <div class="col-sm-10 no-padd">
                                 <textarea data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" id="problem" name="problem"  style="width:100%;height:120px;" placeholder="Text input"></textarea>
                               </div>
                            </div>  
                      </div>
                      <!-- end : input group -->

                       <!-- start : input group -->
                        <div class="col-sm-12">
                       
                            <div class="form-group col-sm-12">
                              <label class="col-sm-2 problem-adon  "><?php echo freetext('remark'); ?></label>
                              <div class="col-sm-10 no-padd">
                                 <textarea id="remark" name="remark"  style="width:100%;height:80px;" placeholder="Text input"></textarea>
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
                              <?php                                 
                                  //echo date('d-m-Y', strtotime(' +15 day'));                                  
                              ?>
                               <div class='input-group date col-md-12' id='datetimepicker1' data-date-format="DD.MM.YYYY">
                                  <input  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type='text' class="form-control" name="require_date" readonly />
                                  <span class="input-group-addon btn" id="date_not_default">
                                      <span class="glyphicon glyphicon-time " ></span>
                                  </span>
                              </div>
                            </div>
                            
                            <div class="col-md-12 ">
                             
                                <label class="checkbox ">
                                    <input type="checkbox"  name="is_require_spare" value="1" >
                                    <?php echo freetext('require_spare_part_while_fixing'); ?>
                                 </label>                             
                                                      
                                 <label class="checkbox ">
                                  <input type="checkbox" name="is_urgent" value="1">
                                   <?php echo freetext('urgent_require_date'); ?>
                                </label>
                           
                             </div>
                          </div>                           

                          <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon">
                                <label> 
                                      <input  type="checkbox"  class="previouse_insert_id" /> 
                                    <?php echo freetext('previouse_fix_id'); ?>
                                </label>
                              </span>
                              <input type="text" autocomplete="off" readonly name="previouse_fix_id" class="form-control previouse_insert"   value="<?php ?>">
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
                                     <input  type="checkbox" name="is_repair_on_side" value="1" disabled>
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
                               <div class='input-group date col-md-12' id='datetimepicker4' data-date-format="YYYY-MM-DD">
                                  <input type='text' class="form-control" name="plan_Date" readonly/>
                                  <span class="input-group-addon  btn" disabled>
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
                              </div>
                            </div>
                          </div>    

                          <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon">
                                 <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('pick_up_date').'</font></div>'; ?>
                              </span>
                               <div class='input-group date col-md-12' id='datetimepicker5' data-date-format="YYYY-MM-DD">
                                  <input type='text' class="form-control" name="pick_up_date" readonly/>
                                  <span class="input-group-addon  btn" disabled>
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
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
                                 <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('finish_date').'</font></div>'; ?>
                              </span>
                               <div class='input-group date col-md-12' id='datetimepicker2' data-date-format="YYYY-MM-DD">
                                  <input type='text' class="form-control" name="finish_date" readonly/>
                                  <span class="input-group-addon btn" disabled>
                                      <span class="glyphicon glyphicon-time"></span>
                                  </span>
                              </div>
                            </div>

                           

                          </div>    

                          <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon">
                                 <?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('delivery_date').'</font></div>'; ?>
                              </span>
                               <div class='input-group date col-md-12' id='datetimepicker3' data-date-format="YYYY-MM-DD">
                                  <input type='text' class="form-control" name="delivery_date" readonly/>
                                  <span class="input-group-addon btn" disabled>
                                      <span class="glyphicon glyphicon-time" ></span>
                                  </span>
                              </div>
                            </div>
                          </div>                  
                        
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
                        <!-- start : input group -->
                        <div class="col-sm-12">

                           <div class="col-md-2 no-padd">
                              <label class="checkbox ">
                                <input type="checkbox" name="Abort_Task" value="1" disabled>
                                <?php echo freetext('Abort_Task'); ?>
                              </label>
                            </div>
                    
                            <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon">
                                <label>
                                <input type="checkbox" name="accept_delivered" class="accept_delivered" value="option1" disabled>
                                  <?php echo freetext('accept_delivered'); ?>
                                </label>
                              </span>
                               <input type='hidden' class="form-control check_deliver_date" /> 
                               <input type='text' class="form-control" name="accept_delivered" readonly/>                              
                            </div>
                          </div>   

                       
                      </div>
                      <!-- end : input group -->                  
                   
                
                    </div>
                  </div>
                  <footer class="panel-footer text-right bg-light lter">
                       <a href="<?php echo site_url($this->page_controller.'/listview/list/'.$project_id ); ?>" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                       <button type="submit" class="btn btn-primary margin-left-small" name="save"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button> 
                  </footer>
                </form>
            </div>


            <div style="margin: 50px;"></div>

            </div><!-- end : class div_detail -->

            </section><!-- end : scrollable padder -->
          </section><!-- end : class vbox -->
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>



          











