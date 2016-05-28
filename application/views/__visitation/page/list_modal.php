
      <div class="modal fade" id="modal-insert">
           <!-- #### remark-->
            <form action='<?php echo site_url('__ps_action_plan/create_action_plan');  ?>' method="POST">
              <input type="hidden" name="url" value="<?php echo current_url(); ?>"/>
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo freetext('add_visit_action_plan');?> </h4>
                  </div>
                  <div class="modal-body" style='overflow:auto'>
                      <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label"><?php echo freetext('event_visit_title'); ?></label>
                       <div class="col-sm-8">
                          <input type="text" autocomplete="off" class="form-control event_title" name="title" data-default="1"> 
                        </div>
                      </div>

                      <?php
                          $function = $this->session->userdata('function');
                          if (in_array('MK', $function) || in_array('CR', $function)) {
                      ?>
                      <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label"><?php echo freetext('doc_type'); ?><span class="pull-right"><span class="type_alert text-danger" style="display:none;"><i class="fa fa-exclamation"></i></span></span></label>
                       <div class="col-sm-8">
                          <input type="radio" class="project_type_radio" name="type[]" value="prospect"> <?php echo freetext('prospect'); ?>
                          &nbsp;
                          <input type="radio" class="project_type_radio" name="type[]" value="quotation"> <?php echo freetext('current_customer'); ?>
                        </div>
                      </div>                         

                      <?php
                        $permission = $this->permission[$this->cat_id];
                      ?>

                      <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label"><?php echo freetext('distribution_channel'); ?></label>
                        <div class="col-sm-8">
                          <select name = "distribution_channel" class="form-control distribution_channel col-sm-4"> 
                            <?php foreach ($distribution_channel_list as $key => $distribution_channel): ?>
                                <?php foreach ($bapi_distribution_list as $key => $bapi_distribution): ?>
                                      <?php if ($distribution_channel == $bapi_distribution['id']): ?>
                                        <option value="<?php echo $bapi_distribution['id'] ?>" ><?php echo $bapi_distribution['distribution_channel_description'] ?></option>
                                      <?php endif ?>
                                <?php endforeach ?>
                                
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>

                      <?php
                          }
                      ?>

                      <div class="form-group col-sm-12 prospect_div" style="display:none;">
                         <label class="col-sm-4 control-label"><?php echo freetext('prospect'); ?><span class="pull-right"><span class="prospect_loading" style="display:none;"><i class="fa fa-spinner"></i></span></span></label>
                         <div class="col-sm-8">
                            <input type="type" class="form-control prospect_id" value="" autocomplete="off" />
                            <input type="hidden" name="prospect_id" value="" autocomplete="off" />
                            <div class="" style="padding:0 12px;">
                              <ul class="prospect_list dropdown-menu text-left" style="padding:6px 12px; width:100%;">
                              </ul>
                            </div>
                          </div>
                      </div> 

                      <div class="form-group col-sm-12 ship_to_div" <?php if (in_array('MK', $function) || in_array('CR', $function)) { ?>style="display:none;" <?php } ?>>
                         <label class="col-sm-4 control-label"><?php echo freetext('ship_to'); ?><span class="pull-right"><span class="ship_to_loading" style="display:none;"><i class="fa fa-spinner"></i></span></span></label>
                         <div class="col-sm-8">
                            <input type="type" class="form-control ship_to_id" value="" autocomplete="off" />
                            <input type="hidden" name="contract_id" value="" autocomplete="off" />
                            <div class="" style="padding:0 12px;">
                              <ul class="ship_to_list dropdown-menu text-left" style="padding:6px 12px; ">
                              </ul>
                            </div>
                          </div>
                      </div>  

                      <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label"><?php echo freetext('visit_actor'); ?></label>
                       <div class="col-sm-8">
                          <input type="text" autocomplete="off" class="form-control actor" readonly value="<?php echo $this->session->userdata('actual_name'); ?>"> 
                          <input type="hidden" class="form-control actor_id" name="actor_id" value="<?php echo $this->session->userdata('id'); ?>"> 
                        </div>
                      </div>


                      <div class="form-group col-sm-12">
                         <label class="col-sm-4 control-label"><?php echo freetext('event_category'); ?></label>
                         <div class="col-sm-8">
                            <input type='hidden' name='event_category_id' value='4' >
                            <select class="form-control event_category col-sm-4" disabled >  
                                  <option value='4' selected><?php echo freetext('customer_visitation'); ?></option>         
                            </select>
                          </div>
                      </div>   
                      <div class="form-group col-sm-12 visit_reason_div">
                         <label class="col-sm-4 control-label"><?php echo freetext('visit_reason'); ?></label>
                         <div class="col-sm-8">
                            <select  name='visitation_reason_id' class="form-control visitation_reason col-sm-4"  >                                  
                              <option value=''>--- กรุณาเลือก<?php echo freetext('visit_reason'); ?> ---</option>   
                              <?php
                                if (!empty($visit_reason_list)) {
                                  foreach ($visit_reason_list as $visit_reason) {
                              ?>
                                  <option value="<?php echo $visit_reason['id']; ?>" ><?php echo $visit_reason['title'].'-'.$visit_reason['function']; ?></option>
                              <?php
                                  }
                                }
                              ?>          
                            </select>
                          </div>
                      </div> 
                      <div class="form-group col-sm-12">
                         <label class="col-sm-4 control-label"><?php echo freetext('contact_type'); ?></label>
                         <div class="col-sm-8">
                            <select  name='contact_type' class="form-control contact_type col-sm-4"  >       
                              <option value=''>--- กรุณาเลือก<?php echo freetext('contact_type'); ?> ---</option>  
                                <?php
                                  if (!empty($visit_connect_list)) {
                                    foreach ($visit_connect_list as $visit_connect) {
                                ?>
                                    <option value="<?php echo $visit_connect['id']; ?>" ><?php echo $visit_connect['title']; ?></option>
                                <?php
                                    }
                                  }
                                ?>        
                            </select>
                          </div>
                      </div> 

                      <div class="form-group col-sm-12">
                              <label class="col-sm-4 control-label"><?php echo freetext('plan_visit_date'); ?></label>
                              <div class="col-sm-8">
                                <input type='hidden' class="plan_date" name="plan_date" value="<?php echo date('Y-m-d') ?>"/>
                                <div class='input-group date' id='datetimepicker5' data-date-format="DD.MM.YYYY">
                                    <input type='text' class="form-control" value="<?php echo date('d.m.Y') ?>" disabled/>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                              </div>
                      </div>

                      <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label"><?php echo freetext('remark'); ?></label>
                        <div class="col-sm-8">
                           <textarea name="remark" class="remark form-control" placeholder="Text input"></textarea>
                         </div>
                      </div>
                  </div>

                  <div class='clear:both'></div>
                  <div class="modal-footer">
                    <a class="btn btn-primary create_btn"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></a> 
                    <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>                  
                     <!-- <input type='hidden' name="callback_url"value="<?php //echo site_url($this->page_controller.'/listview'); ?>">
                    <input type='submit' class="btn btn-primary" value="Save"> -->
                                     
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </form>
      </div>
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

