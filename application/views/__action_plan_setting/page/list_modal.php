<?php
$position_list = $this->session->userdata('position');
$children = array();
foreach ($position_list as $key => $position) {
    $children = $this->__ps_project_query->getPositionChild($children, $position);
}

if (empty($children)) {
    foreach ($module_list as $key => $project) {
      $value = $project['project'];  
      if (!empty($project['module_list'])) {
        foreach ($project['module_list'] as $key => $module_obj) {
          if ($key != '12') {
            $module = $module_obj['module_info'];
            if (!empty($module_obj['assign_list'])) {
?>
            <div class="modal fade" id="modal-assign-<?php echo $value['contract_id']; ?>-<?php echo $module['id']; ?>" data-type="module" data-module="<?php echo $module['id']; ?>" data-shipto="<?php echo $value['contract_id']; ?>">         
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="title"><?php echo freetext($module['module_name']); ?></h3>
                    </div>
                    <div class="modal-body" style='overflow:auto;max-height: 350px;'>    
                      <table  class="table text-center" id="table-modal-tool" style="margin-bottom:0;">                 
                        <thead>
                          <tr class="back-color-gray">
                            <th class="text-center" style="width:50%;"><?php echo freetext('part'); ?></th>
                            <th class="text-center"><?php echo freetext('date'); ?></th>                                                                        
                          </tr>
                        </thead>
                        <!-- Start : Z001 -->
                        <tbody>   
                        <?php
                        foreach ($module_obj['assign_list'] as $assign) {
                        ?>
                          <tr>
                            <td><?php echo $assign['sequence']; ?></td>
                            <td>
                              <?php
                                $this_month = date('m');
                                $plan_month = date('m', strtotime($assign['plan_date']));
                                $this_year  = date('Y');
                                $plan_year  = date('Y', strtotime($assign['plan_date']));
                                if ( ($assign['plan_date'] == '0000-00-00' || empty($assign['plan_date'])) || ($plan_year > $this_year || ($plan_year == $this_year && $plan_month >= $this_month)) && ($assign['submit_date_sap'] == '0000-00-00' || empty($assign['submit_date_sap'])) && ($assign['actual_date'] == '0000-00-00' || empty($assign['actual_date']))) {
                              ?>
                                <div class='input-group date datetimepicker' data-date-format="DD.MM.YYYY" data-start="<?php echo $value['project_start']; ?>" data-end="<?php echo $value['project_end']; ?>">
                                    <input type='text' class="form-control plan_date" data-sequence="<?php echo $assign['sequence']; ?>" value="<?php if (!empty($assign['plan_date']) && $assign['plan_date'] != '0000-00-00') { echo common_easyDateFormat($assign['plan_date']); } ?>" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                              <?php
                                } else {
                              ?>
                                  <input type='text' class="form-control plan_date" data-sequence="<?php echo $assign['sequence']; ?>" value="<?php if (!empty($assign['plan_date']) && $assign['plan_date'] != '0000-00-00') { echo common_easyDateFormat($assign['plan_date']); } ?>" disabled/>
                              <?php
                                }
                              ?>
                            </td>
                          </tr>
                        <?php
                        }
                        ?>       
                        </tbody>
                      </table>
                    </div>
                    <div class='clear:both'></div>
                        <div class="modal-footer" style="margin-top:0;">
                    <span class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                    <span class="btn confirm-assign-plan btn-primary" ><?php echo freetext('save'); ?></span>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->           
            </div><!--end: modal confirm assign -->
<?php
            }
          } else {
              foreach ($module_obj as $jobtype_id => $clearjob_obj) {
                if (!empty($clearjob_obj)) {
                  foreach ($clearjob_obj as $freq => $clearjob_freq_obj) {

                    $module = $clearjob_freq_obj['module_info'];
                    if (!empty($clearjob_freq_obj['assign_list'])) {
?>
                      <div class="modal fade" id="clearmodal-assign-<?php echo $value['contract_id']; ?>-<?php echo $module['id']; ?>-<?php echo $freq; ?>" data-type="clearjob" data-frequency="<?php echo $freq; ?>" data-module="<?php echo $module['id']; ?>" data-shipto="<?php echo $value['contract_id']; ?>">         
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h3 class="title"><?php echo freetext($module['module_name']); ?></h3>
                              </div>
                              <div class="modal-body" style='overflow:auto;max-height: 350px;'>    
                                <table  class="table text-center" id="table-modal-tool" style="margin-bottom:0;">                 
                                  <thead>
                                    <tr class="back-color-gray">
                                      <th class="text-center" style="width:50%;"><?php echo freetext('part'); ?></th>
                                      <th class="text-center"><?php echo freetext('date'); ?></th>                                                                        
                                    </tr>
                                  </thead>
                                  <!-- Start : Z001 -->
                                  <tbody>   
                                  <?php
                                  foreach ($clearjob_freq_obj['assign_list'] as $assign) {
                                  ?>
                                    <tr>
                                      <td><?php echo $assign['sequence']; ?></td>
                                      <td>                                      
                                        <?php
                                          $this_month = date('m');
                                          $plan_month = date('m', strtotime($assign['plan_date']));
                                          $this_year  = date('Y');
                                          $plan_year  = date('Y', strtotime($assign['plan_date']));
                                          if ( empty($assign['plan_date']) || ($plan_year > $this_year || ($plan_year == $this_year && $plan_month >= $this_month)) && ($assign['submit_date_sap'] == '0000-00-00' || empty($assign['submit_date_sap'])) && ($assign['actual_date'] == '0000-00-00' || empty($assign['actual_date']))) {
                                        ?>
                                          <div class='input-group date datetimepicker' data-date-format="DD.MM.YYYY" data-start="<?php echo $value['project_start']; ?>" data-end="<?php echo $value['project_end']; ?>">
                                              <input type='text' class="form-control plan_date" data-sequence="<?php echo $assign['sequence']; ?>" data-frequency="<?php echo $freq; ?>" value="<?php if (!empty($assign['plan_date']) && $assign['plan_date'] != '0000-00-00') { echo common_easyDateFormat($assign['plan_date']); } ?>" />
                                              <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                              </span>
                                          </div>
                                        <?php
                                          } else {
                                        ?>
                                            <input type='text' class="form-control plan_date" data-sequence="<?php echo $assign['sequence']; ?>" value="<?php if (!empty($assign['plan_date']) && $assign['plan_date'] != '0000-00-00') { echo common_easyDateFormat($assign['plan_date']); } ?>" disabled/>
                                        <?php
                                          }
                                        ?>
                                      </td>
                                    </tr>
                                  <?php
                                  }
                                  ?>       
                                  </tbody>
                                </table>
                              </div>
                              <div class='clear:both'></div>
                              <div class="modal-footer" style="margin-top:0;">
                              <span class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                              <span class="btn confirm-assign-plan btn-primary" ><?php echo freetext('save'); ?></span>
                            </div>
                          </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->           
                      </div><!--end: modal confirm assign -->
<?php                  
                    }
                  }
                }
              }
          }
        }
      }
    }
  }
?>