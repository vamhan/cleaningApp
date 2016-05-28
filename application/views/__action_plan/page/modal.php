    <?php 
      $position_list = $this->session->userdata('position');
      $children = array();
      foreach ($position_list as $key => $position) {
          $children = $this->__ps_project_query->getPositionChild($children, $position);
      }

      $function_list = $this->session->userdata('function');
    ?>

    <?php
      if (empty($children)) {
    ?>
        <div class="modal fade" id="modal-addActionplan">
           <!-- #### remark-->
            <div class="modal-dialog">
              <section class="panel panel-default">
                <header class="panel-heading text-right bg-light">
                  <ul class="action_tab nav nav-tabs"> 
                    <li class="active"><a href="#general_panel" data-toggle="tab" class="text-dark">ทั่วไป</a></li> 
                  <?php
                    if ($isAllowToCreateVisitation != 0) {
                  ?>
                    <li><a href="#visitation_panel" data-toggle="tab" class="text-dark">ระบบเข้าพบ</a></li> 
                  <?php
                    }
                  ?>
                  </ul>
                </header>
                <div class="panel-body" style='overflow:auto'>
                  <div class="tab-content">
                    <div class="tab-pane active" id="general_panel">
                      <form id="general_form" action='<?php echo site_url($this->page_controller.'/create_action_plan');  ?>' method="POST">
                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('part'); ?><span class="pull-right"><span class="sequence_loading" style="display:none;"><i class="fa fa-spinner"></i></span>&nbsp;&nbsp;<span class="part_alert text-danger" style="display:none;"><i class="fa fa-exclamation"></i></span></span></label>
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
                           <label class="col-sm-4 control-label"><?php echo freetext('ship_to'); ?><span class="pull-right"><span class="ship_to_loading" style="display:none;"><i class="fa fa-spinner"></i></span></span></label>
                           <div class="col-sm-8">
                              <input type="type" class="form-control ship_to_id" value="" autocomplete="off" />
                              <input type="hidden" name="contract_id" value="" autocomplete="off" />
                              <div class="" style="padding:0 12px;">
                                <ul class="ship_to_list dropdown-menu text-left" style="padding:6px 12px; width:100%;">
                                </ul>
                              </div>
                            </div>
                        </div>  

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('survey_officer'); ?></label>
                         <div class="col-sm-8">
                            <input type="text" autocomplete="off" class="form-control actor" readonly value="<?php echo $this->session->userdata('actual_name'); ?>"> 
                            <input type="hidden" class="form-control actor_id" name="actor_id" value="<?php echo $this->session->userdata('id'); ?>"> 
                          </div>
                        </div>


                        <div class="form-group col-sm-12">
                           <label class="col-sm-4 control-label"><?php echo freetext('event_category'); ?><span class="pull-right"><span class="event_loading" style="display:none;"><i class="fa fa-spinner"></i></span></span></label>
                           <div class="col-sm-8">
                              <select  name='event_category_id' class="form-control event_category col-sm-4"  >  
                                <option value='0' data-visit='0'>---------- กรุณาเลือก<?php echo freetext('event_category'); ?> ----------</option>        
                              </select>
                            </div>
                        </div>  


                        <div class="form-group col-sm-12 clear_job_category_div" style="display:none;">
                           <label class="col-sm-4 control-label"><?php echo freetext('clear_job_category'); ?></label>
                           <div class="col-sm-8">
                              <select  name='clear_job_category_id' class="form-control clear_job_category col-sm-4"  >                                  
                                <option value='0'>--- กรุณาเลือก<?php echo freetext('clear_job_category'); ?> ---</option>   
                                <?php
                                  if (!empty($clear_job_category_list)) {
                                    foreach ($clear_job_category_list as $clear_job_category) {
                                ?>
                                    <option value="<?php echo $clear_job_category['id']; ?>" ><?php echo $clear_job_category['title']; ?></option>
                                <?php
                                    }
                                  }
                                ?>          
                              </select>
                            </div>
                        </div> 

                        <div class="form-group col-sm-12 clear_job_type_div" style="display:none;">
                           <label class="col-sm-4 control-label"><?php echo freetext('clear_job_type'); ?></label>
                           <div class="col-sm-8">
                              <input type="hidden" name="clear_job_type_id" class="clear_job_type_input" value="">
                              <input type="hidden" name="frequency" class="frequency_input" value="">
                              <select class="form-control clear_job_type col-sm-4"  >                                  
                                <option value='0'>--- กรุณาเลือก<?php echo freetext('clear_job_type'); ?> ---</option>           
                              </select>
                            </div>
                        </div> 

                        <div class="form-group col-sm-12 staff_div" style="display:none;">
                           <label class="col-sm-4 control-label"><?php echo freetext('staff'); ?></label>
                           <div class="col-sm-8">
                              <input type="hidden"  name='staff' class="form-control staff_input col-sm-4"  >
                              <input type="text" autocomplete="off" class="form-control staff_input col-sm-4" disabled >
                            </div>
                        </div> 
                        <div class="form-group col-sm-12 total_staff_div" style="display:none;">
                           <label class="col-sm-4 control-label"><?php echo freetext('total_staff'); ?></label>
                           <div class="col-sm-8">
                              <input type="text" autocomplete="off"  name='total_staff' class="form-control total_staff_input col-sm-4"  >
                            </div>
                        </div> 

                        <div class="form-group col-sm-12">
                                <label class="col-sm-4 control-label"><?php echo freetext('plan_date'); ?></label>
                                <div class="col-sm-8">
                                  <input type='hidden' class="plan_date" name="plan_date" value=""/>
                                  <div class='input-group date' id='datetimepicker5' data-date-format="DD.MM.YYYY">
                                      <input type='text' class="form-control" disabled/>
                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  </div>
                                </div>
                        </div>
                        
                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('remark'); ?></label>
                          <div class="col-sm-8">
                             <textarea name="remark" class="form-control remark" placeholder="Text input"></textarea>
                           </div>
                        </div>
                      </form>
                    </div>
                <?php
                  if ($isAllowToCreateVisitation != 0) {
                ?>
                    <div class="tab-pane" id="visitation_panel">
                      <form id="visitation_form" action='<?php echo site_url($this->page_controller.'/create_action_plan');  ?>' method="POST">
                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('event_title'); ?></label>
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
                              <input type="type" class="form-control visit_ship_to_id ship_to_id" value="" autocomplete="off" />
                              <input type="hidden" name="contract_id" value="" autocomplete="off" />
                              <div class="" style="padding:0 12px;">
                                <ul class="ship_to_list dropdown-menu text-left" style="padding:6px 12px; width:100%;">
                                </ul>
                              </div>
                            </div>
                        </div>  

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('survey_officer'); ?></label>
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
                                <label class="col-sm-4 control-label"><?php echo freetext('plan_date'); ?></label>
                                <div class="col-sm-8">
                                  <input type='hidden' class="plan_date" name="plan_date" value=""/>
                                  <div class='input-group date' id='datetimepicker30' data-date-format="DD.MM.YYYY">
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
                      </form>
                    </div>
                <?php
                  }
                ?>
                  </div>
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a class="btn btn-primary create_btn"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></a> 
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>                  
                   <!-- <input type='hidden' name="callback_url"value="<?php //echo site_url($this->page_controller.'/listview'); ?>">
                  <input type='submit' class="btn btn-primary" value="Save"> -->
                                   
                </div>
              </section>
            </div>
        </div>
    <?php
      } else {
    ?>
        <div class="modal fade" id="modal-addActionplan">
            <!-- #### remark-->
            <div class="modal-dialog">
              <section class="panel panel-default">
                <header class="panel-heading text-right bg-light">
                  <ul class="action_tab nav nav-tabs"> 
                    <li class="active"><a href="#general_panel" data-toggle="tab" class="text-dark">เพิ่มแผนการตรวจสอบ</a></li> 
                    <?php
                    if ($isAllowToCreateVisitation != 0) {
                      ?>
                      <li><a href="#visitation_panel" data-toggle="tab" class="text-dark">ระบบเข้าพบ</a></li> 
                      <?php
                    }
                    ?>
                  </ul>
                </header>
                <div class="panel-body" style='overflow:auto'>
                  <div class="tab-content">
                    <div class="tab-pane active" id="general_panel">
                      <form action='<?php echo site_url($this->page_controller.'/manager_create_action_plan');  ?>' method="POST">
                        <div id="general_panel" class="modal-body" style='overflow:auto'>
                            <div class="form-group col-sm-12">
                              <label class="col-sm-4 control-label"><?php echo freetext('event_title'); ?></label>
                             <div class="col-sm-8">
                                <input type="text" autocomplete="off" class="form-control event_title" name="title"> 
                              </div>
                            </div>

                            <div class="form-group col-sm-12">
                               <label class="col-sm-4 control-label"><?php echo freetext('ship_to'); ?><span class="pull-right"><span class="ship_to_loading" style="display:none;"><i class="fa fa-spinner"></i></span></span></label>
                               <div class="col-sm-8">
                                  <input type="type" class="form-control ship_to_id" value="" autocomplete="off" />
                                  <input type="hidden" name="contract_id" value="" autocomplete="off" />
                                  <div class="" style="padding:0 12px;">
                                    <ul class="ship_to_list dropdown-menu text-left" style="padding:6px 12px; width:100%;">
                                    </ul>
                                  </div>
                                </div>
                            </div>  

                            <div class="form-group col-sm-12">
                              <label class="col-sm-4 control-label"><?php echo freetext('survey_officer'); ?></label>
                             <div class="col-sm-8">
                                <input type="text" autocomplete="off" class="form-control actor" readonly value="<?php echo $this->session->userdata('actual_name'); ?>"> 
                                <input type="hidden" class="form-control actor_id" name="actor_id" value="<?php echo $this->session->userdata('id'); ?>"> 
                              </div>
                            </div>

                            <div class="form-group col-sm-12">
                                    <label class="col-sm-4 control-label"><?php echo freetext('plan_date'); ?></label>
                                    <div class="col-sm-8">
                                      <input type='hidden' class="plan_date" name="plan_date" value=""/>
                                      <div class='input-group date' id='datetimepicker5' data-date-format="DD.MM.YYYY">
                                          <input type='text' class="form-control" disabled/>
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                      </div>
                                    </div>
                            </div>

                            <div class="form-group col-sm-12">
                              <label class="col-sm-4 control-label"><?php echo freetext('remark'); ?></label>
                              <div class="col-sm-8">
                                 <textarea name="remark" class="form-control remark" placeholder="Text input"></textarea>
                               </div>
                            </div>
                        </div>

                        <div class='clear:both'></div>
                        <div class="modal-footer">
                          <a class="btn btn-primary manager-create_btn"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></a> 
                          <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>                  
                        </div>
                      </form>
                    </div>

                    <?php
                      if ($isAllowToCreateVisitation != 0) {
                    ?>
                        <div class="tab-pane" id="visitation_panel">
                          <form id="visitation_form" action='<?php echo site_url($this->page_controller.'/create_action_plan');  ?>' method="POST">
                            <div class="modal-body" style='overflow:auto'>
                              <div class="form-group col-sm-12">
                                <label class="col-sm-4 control-label"><?php echo freetext('event_title'); ?></label>
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
                                    <input type="type" class="form-control visit_ship_to_id ship_to_id" value="" autocomplete="off" />
                                    <input type="hidden" name="contract_id" value="" autocomplete="off" />
                                    <div class="" style="padding:0 12px;">
                                      <ul class="ship_to_list dropdown-menu text-left" style="padding:6px 12px; width:100%;">
                                      </ul>
                                    </div>
                                  </div>
                              </div>  

                              <div class="form-group col-sm-12">
                                <label class="col-sm-4 control-label"><?php echo freetext('survey_officer'); ?></label>
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
                                      <label class="col-sm-4 control-label"><?php echo freetext('plan_date'); ?></label>
                                      <div class="col-sm-8">
                                        <input type='hidden' class="plan_date" name="plan_date" value=""/>
                                        <div class='input-group date' id='datetimepicker30' data-date-format="DD.MM.YYYY">
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
                            </div>
                          </form>
                        </div>
                    <?php
                      }
                    ?>
                  </div>
                </div>
              </section>
            </div>
        </div>
    <?php
      }
    ?>
      <div class="modal fade" id="modal-delActionplan">
          <form action='<?php echo site_url($this->page_controller.'/delete_action_plan');  ?>' method="POST">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo freetext('del_action_plan');?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>
                  <input type="hidden" class="id" name="id" value="">
                  <?php echo freetext('delete_action_plan_msg'); ?> 
                </div>
                <div class="modal-footer" style='overflow:auto'>
                  <a class="btn btn-primary confirm_del_btn"><i class="fa fa-save h5"></i> <?php echo freetext('delete'); ?></a> 
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a> 
                </div>
              </div>
            </div>
          </form>
      </div>

      <div class="modal fade" id="modal-editActionplan">
         <!-- #### remark-->
          <div class="modal-body loading_div text-center">
            <img style="max-width: 10%;" src="http://fc07.deviantart.net/fs70/f/2011/299/d/9/simple_loading_wheel_by_candirokz1-d4e1shx.gif">
          </div>

          <div class="view_data" style="display:none;">
            <div class="modal-dialog">
              <section class="panel panel-default">
                <header class="panel-heading text-right bg-light">
                  <ul class="action_tab nav nav-tabs pull-left"> 
                    <li class="active"><a href="#edit_panel" data-toggle="tab" class="text-dark"><i class="fa fa-pencil"></i> แก้ไข</a></li> 
                    <li><a href="#duplicate_panel" data-toggle="tab" class="text-dark"><i class="fa fa-copy"></i> คัดลอก</a></li> 
                    <li><a href="" class="text-dark del_btn"><i class="fa fa-trash-o"></i> ลบ</a></li> 
                  </ul>
                  <span class="hidden-sm"><i class='fa fa-circle text-danger status_icon'>&nbsp;</i> <span class="status">Unplan</span>&nbsp;<button type="button" class="close" data-dismiss="modal">&times;</button></span>
                </header>
                <div class="panel-body" style='overflow:auto'>
                  <div class="tab-content">
                    <div class="tab-pane" id="duplicate_panel">
                      <form id="duplicate_plan" action='<?php echo site_url($this->page_controller.'/create_action_plan');  ?>' method="POST">
                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('part'); ?><span class="pull-right"><span class="part_alert text-danger" style="display:none;"><i class="fa fa-exclamation"></i></span></span></label>
                         <div class="col-sm-8">
                            <select class="form-control input-s-sm inline" name="sequence"></select>&nbsp;&nbsp;<span class="all_parts"></span>
                          </div>
                        </div>

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('event_title'); ?></label>
                         <div class="col-sm-8">
                            <input type="text" autocomplete="off" class="form-control event_title" name="title"> 
                          </div>
                        </div>

                        <div class="form-group col-sm-12 prospect_div" style="display:none;">
                           <label class="col-sm-4 control-label"><?php echo freetext('prospect'); ?></label>
                           <div class="col-sm-8">
                              <input type="type" class="form-control prospect_id" value="" disabled/>
                              <input type="hidden" name="prospect_id" value="" autocomplete="off" />
                            </div>
                        </div> 

                        <div class="form-group col-sm-12">
                           <label class="col-sm-4 control-label"><?php echo freetext('ship_to'); ?></label>
                           <div class="col-sm-8">
                              <input type="hidden" class="form-control contract_id" name="contract_id" value="" />
                              <input type="type" class="form-control ship_to_name" value="" disabled />
                            </div>
                        </div>  

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('survey_officer'); ?></label>
                         <div class="col-sm-8">
                            <input type="text" autocomplete="off" class="form-control actor" readonly value="<?php echo $this->session->userdata('id'); ?>"> 
                            <input type="hidden" class="form-control actor_id" name="actor_id" value="<?php echo $this->session->userdata('id'); ?>"> 
                          </div>
                        </div>

                        <div class="form-group col-sm-12">
                           <label class="col-sm-4 control-label"><?php echo freetext('event_category'); ?></label>
                           <div class="col-sm-8">
                              <input type="hidden" name='event_category_id' class="form-control event_category" value="">
                              <select   class="form-control event_category col-sm-4" disabled >  
                                <?php
                                  if (!empty($event_category)) {
                                    foreach ($event_category as $key => $cat) {
                                ?>
                                      <option value='<?php echo $cat['id'] ?>'><?php echo freetext($cat['module_name']); ?></option> 
                                <?php
                                    }
                                  }
                                ?>       
                              </select>
                            </div>
                        </div>  

                        <div class="form-group col-sm-12 visit_reason_div" style="display:none;">
                           <label class="col-sm-4 control-label"><?php echo freetext('visit_reason'); ?></label>
                           <div class="col-sm-8">
                              <select  name='visitation_reason_id' class="form-control visitation_reason col-sm-4"  >                                  
                                <option value=''>--- กรุณาเลือก<?php echo freetext('visit_reason'); ?> ---</option>   
                                <?php
                                  if (!empty($visit_reason_list)) {
                                    foreach ($visit_reason_list as $visit_reason) {
                                ?>
                                    <option value="<?php echo $visit_reason['id']; ?>" ><?php echo $visit_reason['title'].'-'.$visit_reason['function'];  ?></option>
                                <?php
                                    }
                                  }
                                ?>          
                              </select>
                            </div>
                        </div> 
                        <div class="form-group col-sm-12 visit_reason_div" style="display:none;">
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
                                <label class="col-sm-4 control-label"><?php echo freetext('plan_date'); ?></label>
                                <div class="col-sm-8">
                                  <input type='hidden' class="plan_date" name="plan_date" value=""/>
                                  <div class='input-group date' id='datetimepicker15' data-date-format="DD.MM.YYYY">
                                      <input type='text' class="form-control" disabled/>
                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  </div>
                                </div>
                        </div>

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('remark'); ?></label>
                          <div class="col-sm-8">
                             <textarea name="remark" class="form-control remark" placeholder="Text input"></textarea>
                           </div>
                        </div>
                        <div class='clear:both'></div>
                        <div class="pull-right">
                          <a class="btn btn-primary duplicate_btn"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></a> 
                          <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>                  
                           <!-- <input type='hidden' name="callback_url"value="<?php //echo site_url($this->page_controller.'/listview'); ?>">
                          <input type='submit' class="btn btn-primary" value="Save"> -->
                                           
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane active" id="edit_panel">
                      <form id="edit_plan" action='<?php echo site_url($this->page_controller.'/update_action_plan');  ?>' method="POST">
                        <input type="hidden" class="form-control id" name="id"> 

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('action_plan_id'); ?></label>
                         <div class="col-sm-8">
                            <input type="text" autocomplete="off" class="form-control id" disabled > 
                          </div>
                        </div>

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('part'); ?><span class="pull-right"><span class="part_alert text-danger" style="display:none;"><i class="fa fa-exclamation"></i></span></span></label>
                         <div class="col-sm-8">
                            <input type="hidden" class="form-control sequence" name="sequence">
                            <input type="text" autocomplete="off" class="form-control sequence" disabled>
                          </div>
                        </div>

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('event_title'); ?></label>
                         <div class="col-sm-8">
                            <input type="text" autocomplete="off" class="form-control event_title" name="title"  data-default="0"> 
                          </div>
                        </div>

                        <div class="form-group col-sm-12 prospect_div" style="display:none;">
                           <label class="col-sm-4 control-label"><?php echo freetext('prospect'); ?></label>
                           <div class="col-sm-8">
                              <input type="type" class="form-control prospect_id" value="" disabled />
                              <input type="hidden" name="prospect_id" value="" autocomplete="off" />
                            </div>
                        </div> 

                        <div class="form-group col-sm-12">
                           <label class="col-sm-4 control-label"><?php echo freetext('ship_to'); ?></label>
                           <div class="col-sm-8">
                              <input type="hidden" class="form-control contract_id" name="contract_id" value="" />
                              <input type="type" class="form-control ship_to_name"  value="" disabled/>
                            </div>
                        </div>  
                    

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('survey_officer'); ?></label>
                         <div class="col-sm-8">
                            <input type="text" autocomplete="off" class="form-control actor" readonly value="<?php echo $this->session->userdata('id'); ?>"> 
                            <input type="hidden" class="form-control actor_id" name="actor_id" value="<?php echo $this->session->userdata('id'); ?>"> 
                          </div>
                        </div>
                        
                        <div class="form-group col-sm-12">
                           <label class="col-sm-4 control-label"><?php echo freetext('event_category'); ?></label>
                           <div class="col-sm-8">
                              <select  name='event_category_id' class="form-control event_category col-sm-4" disabled > 
                                <?php
                                  if (!empty($event_category)) {
                                    foreach ($event_category as $key => $cat) {
                                ?>
                                      <option value='<?php echo $cat['id'] ?>'><?php echo freetext($cat['module_name']); ?></option> 
                                <?php
                                    }
                                  }
                                ?>           
                              </select>
                              <input type="hidden" class="form-control module_name"  value="" disabled>
                            </div>
                        </div>  

                        <div class="form-group col-sm-12 visit_reason_div" style="display:none;">
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
                        <div class="form-group col-sm-12 visit_reason_div" style="display:none;">
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

                        <div class="form-group col-sm-12 clear_job_category_div" style="display:none;">
                           <label class="col-sm-4 control-label"><?php echo freetext('clear_job_category'); ?></label>
                           <div class="col-sm-8">
                              <select  name='clear_job_category_id' class="form-control clear_job_category col-sm-4"  >                                  
                                <option value='0'>--- Clear Job Category ---</option>   
                                <?php
                                  if (!empty($clear_job_category_list)) {
                                    foreach ($clear_job_category_list as $clear_job_category) {
                                ?>
                                    <option value="<?php echo $clear_job_category['id']; ?>" ><?php echo $clear_job_category['title']; ?></option>
                                <?php
                                    }
                                  }
                                ?>          
                              </select>
                              <input type="hidden" class="form-control module_name"  value="" disabled>
                            </div>
                        </div> 

                        <div class="form-group col-sm-12 clear_job_type_div" style="display:none;">
                           <label class="col-sm-4 control-label"><?php echo freetext('clear_job_type'); ?></label>
                           <div class="col-sm-8">
                              <input type="hidden" name="clear_job_type_id" class="clear_job_type_input" value="">
                              <input type="hidden" name="frequency" class="frequency_input" value="">
                              <input type="text" autocomplete="off" class="form-control clear_job_type col-sm-4" value="" disabled>
                            </div>
                        </div> 

                        <div class="form-group col-sm-12 staff_div" style="display:none;">
                           <label class="col-sm-4 control-label"><?php echo freetext('staff'); ?></label>
                           <div class="col-sm-8">
                              <input type="text" autocomplete="off"  name='staff' class="form-control staff_input col-sm-4"  >
                            </div>
                        </div> 
                        <div class="form-group col-sm-12 total_staff_div" style="display:none;">
                           <label class="col-sm-4 control-label"><?php echo freetext('total_staff'); ?></label>
                           <div class="col-sm-8">
                              <input type="text" autocomplete="off"  name='total_staff' class="form-control total_staff_input col-sm-4"  >
                            </div>
                        </div> 

                        <div class="form-group col-sm-12">
                              <label class="col-sm-4 control-label plan_date_label"><?php echo freetext('plan_date'); ?></label>
                              <label class="col-sm-4 control-label estimate_fix_date_label" style="display:none;"><?php echo freetext('estimate_fix_date'); ?></label>
                              <div class="col-sm-8">
                                <input type='hidden' class="form-control plan_date" name="plan_date" value=""/>
                                <div class='input-group date' id='datetimepicker10' data-date-format="DD.MM.YYYY">
                                    <input type='text' class="form-control" disabled/>
                                    <span class="input-group-addon calendar_picker"><i class="fa fa-calendar"></i></span>
                                </div>
                              </div>
                        </div>

                        <div class="form-group col-sm-12 edit_actual_date_div"  style="display:none;">
                                <label class="col-sm-4 control-label actual_date_label"><?php echo freetext('actual_date'); ?></label>
                                <label class="col-sm-4 control-label actual_fix_date_label" style="display:none;"><?php echo freetext('actual_fix_date'); ?></label>
                                <div class="col-sm-8">
                                  <input type='hidden' class="form-control actual_date" name="actual_date" value=""/>
                                  <div class='input-group date' id='edit_actual_date' data-date-format="DD.MM.YYYY">
                                      <input type='text' class="form-control" disabled/>
                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  </div>
                                </div>
                        </div>

                        <div class="form-group col-sm-12 shift_date_div" style="display:none;">
                           <label class="col-sm-4 control-label"><?php echo freetext('shift_date'); ?></label>
                           <div class="col-sm-8">   
                              <input type="type" class="form-control shift_date" value="" disabled/>
                            </div>
                        </div>  

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('remark'); ?></label>
                          <div class="col-sm-8">
                             <textarea name="remark" class="form-control remark"></textarea>
                           </div>
                        </div>
                        <div class='clear:both'></div>
                        <div class="pull-left">
                          <a class="btn btn-info go_to_btn" target="_blank"><i class="fa fa-reply h5"></i> <?php echo freetext('go_to_plan'); ?></a> 
                        </div>
                        <div class="pull-right">
                          <a class="btn btn-primary edit_btn"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></a> 
                          <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>                  
                           <!-- <input type='hidden' name="callback_url"value="<?php //echo site_url($this->page_controller.'/listview'); ?>">
                          <input type='submit' class="btn btn-primary" value="Save"> -->                                           
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </section><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->           
          </div>
      </div>


      <div class="modal fade" id="modal-editManagerActionplan">
         <!-- #### remark-->
          <div class="modal-body loading_div text-center">
            <img style="max-width: 10%;" src="http://fc07.deviantart.net/fs70/f/2011/299/d/9/simple_loading_wheel_by_candirokz1-d4e1shx.gif">
          </div>

          <div class="view_data" style="display:none;">
            <div class="modal-dialog">
              <section class="panel panel-default">
                <header class="panel-heading text-right bg-light">
                  <ul class="action_tab nav nav-tabs pull-left"> 
                    <li class="active"><a href="#manager_edit_panel" data-toggle="tab" class="text-dark"><i class="fa fa-pencil"></i> แก้ไข</a></li> 
                    <li><a href="" class="text-dark del_btn"><i class="fa fa-trash-o"></i> ลบ</a></li> 
                  </ul>
                  <span class="hidden-sm"><i class='fa fa-circle text-danger status_icon'>&nbsp;</i> <span class="status">Unplan</span>&nbsp;<button type="button" class="close" data-dismiss="modal">&times;</button></span>
                </header>
                <div class="panel-body" style='overflow:auto'>
                  <div class="tab-content">
                    <div class="tab-pane active" id="manager_edit_panel">
                      <form id="manager_edit_plan" action='<?php echo site_url($this->page_controller.'/update_manager_action_plan');  ?>' method="POST">
                        <input type="hidden" class="form-control id" name="id"> 

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('event_title'); ?></label>
                         <div class="col-sm-8">
                            <input type="text" autocomplete="off" class="form-control event_title" name="title"> 
                          </div>
                        </div>

                        <div class="form-group col-sm-12">
                           <label class="col-sm-4 control-label"><?php echo freetext('ship_to'); ?></label>
                           <div class="col-sm-8">
                              <input type="type" class="form-control ship_to_name"  value="" disabled/>
                              <input type="hidden" class="contract_id" name="contract_id" value="" />
                            </div>
                        </div>                      

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('survey_officer'); ?></label>
                         <div class="col-sm-8">
                            <input type="text" autocomplete="off" class="form-control actor" readonly value="<?php echo $this->session->userdata('actual_name'); ?>"> 
                            <input type="hidden" class="form-control actor_id" name="actor_id" value="<?php echo $this->session->userdata('id'); ?>"> 
                          </div>
                        </div>

                        <div class="form-group col-sm-12">
                              <label class="col-sm-4 control-label"><?php echo freetext('plan_date'); ?></label>
                              <div class="col-sm-8">
                                <input type='hidden' class="form-control plan_date" name="plan_date" value=""/>
                                <div class='input-group date' id='datetimepicker20' data-date-format="DD.MM.YYYY">
                                    <input type='text' class="form-control" disabled/>
                                    <span class="input-group-addon calendar_picker"><i class="fa fa-calendar"></i></span>
                                </div>
                              </div>
                        </div>

                        <div class="form-group col-sm-12">
                          <label class="col-sm-4 control-label"><?php echo freetext('remark'); ?></label>
                          <div class="col-sm-8">
                             <textarea name="remark" class="form-control remark" placeholder="Text input"></textarea>
                           </div>
                        </div>
                        <div class='clear:both'></div>
                        <div class="pull-right">
                          <a class="btn btn-primary manager_edit_btn"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></a> 
                          <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>                  
                           <!-- <input type='hidden' name="callback_url"value="<?php //echo site_url($this->page_controller.'/listview'); ?>">
                          <input type='submit' class="btn btn-primary" value="Save"> -->
                                           
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </section><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->           
          </div>
      </div>