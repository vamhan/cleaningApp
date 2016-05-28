    <?php 
      //get project id                
      // if(!empty($result)){
      //     $content = $result['list'];                  
      //     foreach ($content as $key => $value) {
      //        // $project_id =$value['project_id'];
      //         $ship_to_id =$value['ship_to_id'];
      //         $project_owner_id =$value['project_owner_id'];
      //         $contract_id =$value['contract_id'];
      //     }
      // }

      // get project id                
      if(!empty($result)){
          /*$content = $result['list']; 
          foreach ($content as $key => $value) {
              $project_id =$value['project_id'];
              $ship_to_id =$value['ship_to_id'];
          }*/
          $project_id = $result['project_id'];
          $ship_to_id = $result['project']['ship_to_id'];
          $sold_to_id = $result['project']['sold_to_id'];
          $ship_to_name = $result['project']['ship_to_name'];
          $project_owner_id = $result['project']['project_owner_id'];
          $contract_id = $result['project']['contract_id'];
          $start_date_project = $result['project']['project_start'];
          $end_date_project = $result['project']['project_end'];

      }

    ?>

    
      <div class="modal fade" id="modal-addListasset">
           <!-- #### remark-->
            <form action='<?php echo site_url('__ps_action_plan/create_action_plan');  ?>' method="POST">
              <input type="hidden" name="url" value="<?php echo current_url(); ?>"/>
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo freetext('add_acction_plan');?> </h4>
                  </div>
                  <div class="modal-body" style='overflow:auto'>
                      <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label"><?php echo freetext('part'); ?><span class="pull-right"><span class="part_alert text-danger" style="display:none;"><i class="fa fa-exclamation"></i></span></span></label>
                       <div class="col-sm-8">
                          <select class="form-control input-s-sm inline" name="sequence" disabled></select>&nbsp;&nbsp;<span class="all_parts"></span>
                        </div>
                      </div>

                      <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label"><?php echo freetext('event_title'); ?></label>
                       <div class="col-sm-8">
                          <input type="text" autocomplete="off" class="form-control event_title" name="title" data-default="1"> 
                        </div>
                      </div>

                      <div class="form-group col-sm-12">
                         <label class="col-sm-4 control-label"><?php echo freetext('ship_to'); ?></label>
                         <div class="col-sm-8">
                            <input type="type" class="form-control ship_to_id" value="<?php echo $ship_to_name; ?>" autocomplete="off" disabled />
                            <input type="hidden" name="contract_id" value="<?php echo $contract_id; ?>" autocomplete="off" />
                            <div class="" style="padding:0 12px;">
                              <ul class="ship_to_list dropdown-menu text-left" style="padding:6px 12px; width:100%;">
                              </ul>
                            </div>
                          </div>
                      </div>  

                      <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label"><?php echo freetext('survey_officer'); ?></label>
                       <div class="col-sm-8">
                          <input type="text" autocomplete="off" class="form-control actor" readonly value="<?php echo $this->session->userdata('actual_name');?>"> 
                          <input type="hidden" class="form-control actor_id" name="actor_id" value="<?php echo $this->session->userdata('id'); ?>"> 
                        </div>
                      </div>

                      <div class="form-group col-sm-12">
                         <label class="col-sm-4 control-label"><?php echo freetext('event_category'); ?></label>
                         <div class="col-sm-8">
                            <input type='hidden' name='event_category_id' value='<?php echo $this->cat_id; ?>' >
                            <select class="form-control event_category col-sm-4" disabled >  
                              <?php
                                if (!empty($event_category)) {
                                  foreach ($event_category as $key => $cat) {
                              ?>
                                    <option value='<?php echo $cat['id'] ?>' <?php if ($cat['id'] == $this->cat_id) { echo "selected"; } ?>><?php echo freetext($cat['module_name']); ?></option> 
                              <?php
                                  }
                                }
                              ?>           
                            </select>
                          </div>
                      </div>  

                      <div class="form-group col-sm-12">
                              <label class="col-sm-4 control-label"><?php echo freetext('plan_date'); ?></label>
                              <div class="col-sm-8">
                                <input type='hidden' class="plan_date" name="plan_date" value=""/>
                                <div class='input-group date' id='datetimepicker5' data-date-format="DD.MM.YYYY">
                                    <input type='text' class="form-control" value="" disabled/>
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


























