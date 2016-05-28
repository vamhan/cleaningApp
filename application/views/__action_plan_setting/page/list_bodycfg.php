<style type="text/css">
  .table-head,.table-division{ text-align: center }
  .panel-heading .btn-sm { margin-top: -6px}
</style>

<section class="vbox">
  <section class="scrollable">
    <section class="panel panel-default">
      <header class="panel-heading bg-light">
        <?php 
        #CMS 
        //echo $this->tab."|";
        echo $this->page_title_ico;
        print($this->page_title);
        #END_CMS 
        ?>

        <?php $error = $this->session->flashdata('error'); ?>
        <?php if (!empty($error)): ?>
            <script type="text/javascript">alert('<?php echo $error; ?>');</script>
        <?php endif ?>
      </header>
      <div class="panel-body">
        <?php
        $position_list = $this->session->userdata('position');
        $children = array();
        foreach ($position_list as $key => $position) {
          $children = $this->__ps_project_query->getPositionChild($children, $position);
        }

        if (!empty($children)) {
          ?>
          <ul class="nav nav-tabs nav-justified">
            <li class="<?php  if($this->tab==1){ echo "active"; } ?> h5"><a href="#track" data-toggle="tab"><?php echo freetext('track_project');?></a></li>
            <li class="<?php  if($this->tab==2){ echo "active"; } ?> h5"><a href="#untrack" data-toggle="tab"><?php echo freetext('untrack_project');?></a></li>
          </ul>
          <div class="tab-content">
            <!-- start : tab track asset -->
            <div class="tab-pane <?php  if($this->tab==1){ echo 'active'; } ?>" id="track">
              <div class="table-responsive">      
                <form id="save_track_project" action="<?php echo site_url('__ps_action_plan_setting/save_track_project') ?>" method="POST">           
                  <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
                    <thead>
                      <tr>
                        <th class='table-head'></th>
                        <th class='table-head'></th>
                        <th class='table-head'><?php echo freetext('contract'); ?></th>
                        <th class='table-head'><?php echo freetext('sold_to'); ?></th>
                        <th class='table-head' style="width:20%;"><?php echo freetext('ship_to'); ?></th>
                        <th class='table-head'><?php echo freetext('type'); ?></th>
                        <th class='table-head'><?php echo freetext('start_project'); ?></th>
                        <th class='table-head'><?php echo freetext('end_project'); ?></th>
                        <th style="width:5px;"><a class="collapse_all" title="Collapse All" data-status="active" href="#"><i class="fa fa-caret-up"></i></a></th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <?php                      
                      if(!empty($result)){
                        $content = $result['track_result'];                  
                        foreach ($content as $key => $value) {               
                          // Changed by Sunday 2015-09-09 to fix multiple function
                          $aceess_module = array();
                          foreach ($all_module as $module){
                            $permission = $module_permission[$module['id']];
                            $permission_position = $permission[$value['position_id']];
                            if (!empty($permission_position) && array_key_exists("create", $permission_position)) {
                              $permission_create = $permission_position['create'];
                              if($permission_create['value']){
                                $aceess_module[$module['id']] = true;
                              }
                            }
                          }

                          if (empty($aceess_module)) {
                            continue;
                          }

                          ?>
                          <tr>
                            <td>
                              <input type="checkbox" name="track_check[]" id="track_check[]" value="<?php print $value['contract_id']; ?>" checked>
                            </td>
                            <td>
                              <a href="#" class="btn btn-default commit-delete-btn" data-contractid ="<?php echo $value['contract_id'] ?>" data-shiptoid ="<?php echo $value['ship_to_id'] ?>" data-function ="<?php echo $value['function'] ?>" ><i class="fa fa-trash-o h5"></i></a>
                            </td>

                            <td>
                              <?php print $value['contract_id'];?>&nbsp;<span class="badge bg-info"> <?php print freetext(strtolower($value['function']));?></span>
                            </td>

                            <td>
                              <?php print $value['customer_name'];?>
                            </td>

                            <td>
                              <?php print $value['ship_to_id'].' '.$value['shop_to_title'];?>
                            </td>

                            <td>
                              <?php print $value['job_type_title'];?>
                            </td>

                            <td>
                              <?php if (!empty($value['project_start']) && $value['project_start'] != '0000-00-00') { print common_easyDateFormat($value['project_start']); } else { echo "-"; } ?>
                            </td>

                            <td>
                              <?php if (!empty($value['project_end']) && $value['project_end'] != '0000-00-00') { print common_easyDateFormat($value['project_end']); } else { echo "-"; } ?>
                            </td>
                            <td style="width:5px;"><a class="collapse_single" href="#" data-status="active" data-target="<?php echo $value['contract_id']; ?>"><i class="fa fa-caret-up"></i></a></td>
                          </tr>
                          <?php
                          if (!empty($all_module) && $aceess_module) {
                            ?>
                            <tr class="module_row" data-ship="<?php echo $value['contract_id']; ?>">
                              <td colspan="8">
                                <div style="overflow-y: auto;max-height: 300px;overflow-x: hidden;">
                                  <div class="wrapper row m-b-xs b-b">
                                    <div class="col-sm-3 font-bold"><?php echo freetext('module_name'); ?></div>
                                    <div class="col-sm-3 font-bold"><?php echo freetext('in_charge'); ?></div>
                                    <div class="col-sm-4 font-bold"><?php echo freetext('frequency_plan'); ?></div>
                                    <div class="col-sm-1 font-bold"><?php echo freetext('this_time'); ?></div>
                                    <div class="col-sm-1 font-bold"><?php echo freetext('next_time'); ?></div>
                                  </div>
                                  <?php
                                  foreach ($all_module as $module) {
                                    if($aceess_module[$module['id']] == null || !$aceess_module[$module['id']]){
                                      break;
                                    }

                                    $obj_id = "";
                                    $emp_id = "";
                                    $emp_name = "";
                                    $period = "";
                                    $disabled = "";

                                    $this_month_text = "text-muted";
                                    $next_month_text = "text-muted";

                                    $this_month_url = "";
                                    $next_month_url = "";
                                    $url_disabled= "";     
                                    $next_url_disabled = "";  

                                    if (!empty($module_list[$value['contract_id']][$module['id']])) {
                                      $obj_list = $module_list[$value['contract_id']][$module['id']];

                                      $count_obj = 0;
                                      foreach ($obj_list as $assign_id => $obj) {  

                                        //$obj_id = $assign_id;
                                        $obj_id = $obj['assign_id'];

                                        $emp_id = "";
                                        $emp_name = "";
                                        $period = "";
                                        $disabled = "";

                                        $this_month_text = "text-muted";
                                        $next_month_text = "text-muted";

                                        $this_month_url = "";
                                        $next_month_url = "";
                                        $url_disabled= "";     
                                        $next_url_disabled = "";    

                                        if ($obj['this_month_flag'] == 'plan') {
                                          $this_month_text = "text-primary";
                                        } else if ($obj['this_month_flag'] == 'complete') {
                                          $this_month_text = "text-info";
                                        } else if ($obj['this_month_flag'] == 'unplan') {
                                          $this_month_text = "text-danger";
                                        }

                                        if ($obj['next_month_flag'] == 'plan') {
                                          $next_month_text = "text-primary";
                                        } else if ($obj['next_month_flag'] == 'complete') {
                                          $next_month_text = "text-info";
                                        } else if ($obj['next_month_flag'] == 'unplan') {
                                          $next_month_text = "text-danger";
                                        }

                                        $emp_id = $obj['employee_id'];
                                        $emp_name = $obj['user_firstname'].' '.$obj['user_lastname'];
                                        $period = $obj['month_period'];

                                        if (!empty($obj['month_period'])) {
                                          $disabled = " disabled";
                                        }

                                        $this_month_url = $obj['this_month_url'];
                                        $next_month_url = $obj['next_month_url'];

                                        if (empty($this_month_url)) {
                                          $url_disabled = "disabled_btn";
                                        }

                                        if (empty($next_month_url)) {
                                          $next_url_disabled = "disabled_btn";
                                        }

                                        $visit_class="";
                                        if ($module['module_name'] == 'customer_visitation') {
                                          $visit_class = " visitation_row";
                                        }
                                        ?>
                                        <div class="wrapper-sm row m-b-xs b-b<?php echo $visit_class; ?>" data-id="<?php echo $obj_id; ?>" data-index="<?php echo $count_obj; ?>" data-contactid="<?php echo $value['contract_id'] ?>" data-module="<?php echo $module['id'] ?>">
                                          <div class="col-sm-3">
                                            <?php if ($count_obj == 0) { echo freetext($module['module_name']); } ?>
                                            <?php
                                            if ($module['module_name'] == 'customer_visitation') {
                                              if ($count_obj == 0) {
                                                ?>
                                                <a href="#" class="btn btn-xs btn-default m-l-xs visit_add_emp"><i class="fa fa-plus"></i></a>
                                                <?php
                                              }
                                            }
                                            ?>
                                          </div>
                                          <div class="col-sm-3 employee_section">
                                            <div class="col-sm-12 input-group">
                                              <input type="hidden" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][id]" value="<?php echo $obj_id ?>">
                                              <input type="hidden" class="emp_id_input employee_id_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $count_obj; ?>" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][employee]" value="<?php if (!empty($emp_id)) echo $emp_id; else echo $value['assign_user_id']; ?>">
                                              <input type="text" autocomplete="off" class="text-center emp_id_input form-control employee_name_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $count_obj; ?>" readonly  value="<?php if (!empty($emp_name) && trim($emp_name) != "") echo $emp_name; else echo $value['assign_firstname'].' '.$value['assign_lastname']; ?>">
                                              <input type="hidden" class="function_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $count_obj; ?>" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][function]" value="<?php echo $value['function'] ?>">
                                            </div>
                                          </div>
                                          <div class="col-sm-4">
                                            <span style="padding-top:15px;padding-right:5px;">วางแผนความถี่</span><?php if (empty($disabled)) { ?><span class="btn btn-default btn-xs minus_freq"><i class="fa fa-minus"></i></span> <?php } ?><input type="text" autocomplete="off"<?php echo $disabled;?> onkeypress="return false;" onkeydown="return false;" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][period]" class="form-control inline m-l-xs m-r-xs" style="width:60px;"  value="<?php if ($period > 0) { echo $period; } ?>"> <?php if (empty($disabled)) { ?><span class="btn btn-default btn-xs plus_freq"><i class="fa fa-plus"></i></span><?php } ?><span style="padding-left:5px;padding-top:15px;">เดือนครั้ง</span>
                                          </div>
                                          <div class="col-sm-1"><a target="_blank" href="<?php echo $this_month_url; ?>" title="<?php echo array_key_exists('this_month_title', $obj)? $obj['this_month_title'] : ''; ?>" class="this_month_btn btn btn-default <?php echo $url_disabled; ?>"><i class="fa fa-calendar">&nbsp;</i><i class="fa fa-circle <?php echo $this_month_text; ?>"></i></a></div>
                                          <div class="col-sm-1"><a target="_blank" href="<?php echo $next_month_url; ?>" title="<?php echo array_key_exists('next_month_title', $obj)? $obj['next_month_title'] : ''; ?>"  class="btn btn-default <?php echo $next_url_disabled; ?>"><i class="fa fa-calendar">&nbsp;</i><i class="fa fa-circle <?php echo $next_month_text; ?>"></i></a></div>
                                        </div>
                                        <?php
                                        $count_obj++;
                                      }
                                    } else {

                                      $count_obj = 0;
                                      if (empty($this_month_url)) {
                                        $url_disabled = "disabled_btn";
                                      }

                                      if (empty($next_month_url)) {
                                        $next_url_disabled = "disabled_btn";
                                      }

                                      $visit_class="";
                                      if ($module['module_name'] == 'customer_visitation') {
                                        $visit_class = " visitation_row";
                                      }
                                      ?>
                                      <div class="wrapper-sm row m-b-xs b-b<?php echo $visit_class; ?>" data-id="<?php echo $obj_id; ?>" data-index="<?php echo $count_obj; ?>" data-contactid="<?php echo $value['contract_id'] ?>" data-module="<?php echo $module['id'] ?>">
                                        <div class="col-sm-3">
                                          <?php echo freetext($module['module_name']); ?>
                                          <?php
                                          if ($module['module_name'] == 'customer_visitation') {
                                            ?>
                                            <a href="#" class="btn btn-xs btn-default m-l-xs visit_add_emp"><i class="fa fa-plus"></i></a>
                                            <?php
                                          }
                                          ?>
                                        </div>
                                        <div class="col-sm-3 employee_section">
                                          <div class="col-sm-12 input-group">
                                            <input type="hidden" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][id]" value="<?php echo $obj_id ?>">
                                            <input type="hidden" class="emp_id_input employee_id_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $count_obj; ?>" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][employee]" value="<?php if (!empty($emp_id)) echo $emp_id; else echo $value['assign_user_id']; ?>">
                                            <input type="text" autocomplete="off" class="text-center emp_id_input form-control employee_name_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $count_obj; ?>" readonly  value="<?php if (!empty($emp_name) && trim($emp_name) != "") echo $emp_name; else echo $value['assign_firstname'].' '.$value['assign_lastname']; ?>"> 
                                            <input type="hidden" class="function_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $count_obj; ?>" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][function]" value="<?php echo $value['function'] ?>">
                                          </div>
                                        </div>
                                        <div class="col-sm-4">                                  
                                          <span style="padding-top:15px;padding-right:5px;">วางแผนความถี่</span><?php if (empty($disabled)) { ?><span class="btn btn-default btn-xs minus_freq"><i class="fa fa-minus"></i></span> <?php } ?><input type="text" autocomplete="off"<?php echo $disabled;?> onkeypress="return false;" onkeydown="return false;" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][period]" class="form-control inline m-l-xs m-r-xs" style="width:60px;"  value="<?php if ($period > 0) { echo $period; } ?>">                                     <?php if (empty($disabled)) { ?><span class="btn btn-default btn-xs plus_freq"><i class="fa fa-plus"></i></span><?php } ?><span style="padding-left:5px;padding-top:15px;">เดือนครั้ง</span>
                                        </div>
                                        <div class="col-sm-1"><a target="_blank" href="<?php echo $this_month_url; ?>" title="<?php echo $obj['this_month_title']; ?>" class="this_month_btn btn btn-default <?php echo $url_disabled; ?>"><i class="fa fa-calendar">&nbsp;</i><i class="fa fa-circle <?php echo $this_month_text; ?>"></i></a></div>
                                        <div class="col-sm-1"><a target="_blank" href="<?php echo $next_month_url; ?>" title="<?php echo $obj['next_month_title']; ?>" class="btn btn-default <?php echo $next_url_disabled; ?>"><i class="fa fa-calendar">&nbsp;</i><i class="fa fa-circle <?php echo $next_month_text; ?>"></i></a></div>
                                      </div>
                                      <?php
                                    }
                                    ?>
                                    <?php
                                  }
                                  ?>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <?php
                        }
                        ?>
                        <?php 
                      }
                    }
                    ?>
                  </tbody>
                </table>
                <div class="panel-footer text-right">
                  <input type="submit" class="submit-track btn btn-primary" value="<?php echo freetext('save'); ?>">
                </div>
              </form>
            </div>
          </div>
          <div class="tab-pane <?php  if($this->tab==2){ echo 'active'; } ?>" id="untrack">
            <div class="table-responsive">   
              <form id="save_untrack_project" action="<?php echo site_url('__ps_action_plan_setting/save_untrack_project') ?>" method="POST">              
                <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
                  <thead>
                    <tr>
                      <th class='table-head'></th>
                      <th class='table-head'></th>
                      <th class='table-head'><?php echo freetext('contract'); ?></th>
                      <th class='table-head'><?php echo freetext('sold_to'); ?></th>
                      <th class='table-head' style="width:20%;"><?php echo freetext('ship_to'); ?></th>
                      <th class='table-head'><?php echo freetext('type'); ?></th>
                      <th class='table-head'><?php echo freetext('start_project'); ?></th>
                      <th class='table-head'><?php echo freetext('end_project'); ?></th>
                      <th style="width:5px;"><a class="collapse_all" title="Collapse All" data-status="active" href="#"><i class="fa fa-caret-up"></i></a></th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    <?php                      
                    if(!empty($result)){
                      $content = $result['untrack_result'];         
                      foreach ($content as $key => $value) {  

                        // Changed by Sunday 2015-09-09 to fix multiple function
                        $aceess_module = array();
                        foreach ($all_module as $module){
                          $permission = $module_permission[$module['id']];
                          $permission_position = $permission[$value['position_id']];
                          if (!empty($permission_position) && array_key_exists("create", $permission_position)) {
                            $permission_create = $permission_position['create'];
                            if($permission_create['value']){
                              $aceess_module[$module['id']] = true;
                            }
                          }
                        }
                        if (empty($aceess_module)) {
                          continue;
                        }
                        ?>
                        <tr>
                          <td>
                            <input type="checkbox" name="untrack_check[]" id="untrack_check[]" value="<?php print $value['contract_id']; ?>">
                          </td>
                          <td>
                            <a href="#" class="btn btn-default commit-delete-btn" data-contractId ="<?php echo $value['contract_id'] ?>" data-shiptoid ="<?php echo $value['ship_to_id'] ?>" data-function ="<?php echo $value['function'] ?>" ><i class="fa fa-trash-o h5"></i></a>
                          </td>
                          <td>
                            <?php print $value['contract_id'];?>&nbsp;<span class="badge bg-info"> <?php print freetext(strtolower($value['function']));?></span>
                          </td>

                          <td>
                            <?php print $value['customer_name'];?>
                          </td>

                          <td>
                            <?php print $value['ship_to_id'].' '.$value['shop_to_title'];?>
                          </td>

                          <td>
                            <?php print $value['job_type_title'];?>
                          </td>

                          <td>
                            <?php if (!empty($value['project_start']) && $value['project_start'] != '0000-00-00') { print common_easyDateFormat($value['project_start']); } else { echo "-"; } ?>
                          </td>

                          <td>
                            <?php if (!empty($value['project_end']) && $value['project_end'] != '0000-00-00') { print common_easyDateFormat($value['project_end']); } else { echo "-"; } ?>
                          </td>
                          <td style="width:5px;"><a class="collapse_single" href="#" data-status="active" data-target="<?php echo $value['contract_id']; ?>"><i class="fa fa-caret-up"></i></a></td>
                        </tr>
                        <?php
                        if (!empty($all_module)) {
                          ?>
                          <tr class="module_row" data-ship="<?php echo $value['contract_id']; ?>">
                            <td colspan="8">
                              <div style="overflow-y: auto;max-height: 300px;overflow-x: hidden;">
                                <div class="wrapper row m-b-xs b-b">
                                  <div class="col-sm-3 font-bold"><?php echo freetext('module_name'); ?></div>
                                  <div class="col-sm-3 font-bold"><?php echo freetext('in_charge'); ?></div>
                                  <div class="col-sm-4 font-bold"><?php echo freetext('frequency_plan'); ?></div>
                                  <div class="col-sm-1 font-bold"><?php echo freetext('this_time'); ?></div>
                                  <div class="col-sm-1 font-bold"><?php echo freetext('next_time'); ?></div>
                                </div>
                                <?php
                                foreach ($all_module as $module) {
                                  if($aceess_module[$module['id']] == null || !$aceess_module[$module['id']]){
                                    break;
                                  }

                                  $obj_id = "";
                                  $emp_id = "";
                                  $emp_name = "";
                                  $period = "";
                                  $disabled = "";

                                  $this_month_text = "text-muted";
                                  $next_month_text = "text-muted";

                                  $this_month_url = "";
                                  $next_month_url = "";
                                  $url_disabled= "";     
                                  $next_url_disabled = "";  


                                  $exists_assign_list  = array();
                                  if (!empty($module_list[$value['contract_id']][$module['id']])) {
                                    $assign_list = $module_list[$value['contract_id']][$module['id']];
                                    foreach ($assign_list as $key_exists_assign => $exists_assign) {
                                      if($exists_assign['function'] == $value['function']){
                                        array_push($exists_assign_list, $exists_assign); 
                                      }
                                    }
                                  }

                                  if (!empty($exists_assign_list)) {
                                    $obj_list = $exists_assign_list;
                                    $count_obj = 0;

                                    foreach ($obj_list as $assign_id => $obj) {  
                                      //$obj_id = $assign_id;
                                      $obj_id = $obj['assign_id'];
                                      $emp_id = "";
                                      $emp_name = "";
                                      $period = "";
                                      $disabled = "";

                                      $this_month_text = "text-muted";
                                      $next_month_text = "text-muted";

                                      $this_month_url = "";
                                      $next_month_url = "";
                                      $url_disabled= "";     
                                      $next_url_disabled = "";     

                                      if ($obj['this_month_flag'] == 'plan') {
                                        $this_month_text = "text-primary";
                                      } else if ($obj['this_month_flag'] == 'complete') {
                                        $this_month_text = "text-info";
                                      } else if ($obj['this_month_flag'] == 'unplan') {
                                        $this_month_text = "text-danger";
                                      }

                                      if ($obj['next_month_flag'] == 'plan') {
                                        $next_month_text = "text-primary";
                                      } else if ($obj['next_month_flag'] == 'complete') {
                                        $next_month_text = "text-info";
                                      } else if ($obj['next_month_flag'] == 'unplan') {
                                        $next_month_text = "text-danger";
                                      }


                                      $emp_id = $obj['employee_id'];
                                      $emp_name = $obj['user_firstname'].' '.$obj['user_lastname'];
                                      $period = $obj['month_period'];

                                      if (!empty($obj['month_period'])) {
                                        $disabled = " disabled";
                                      }

                                      $this_month_url = $obj['this_month_url'];
                                      $next_month_url = $obj['next_month_url'];

                                      if (empty($this_month_url)) {
                                        $url_disabled = "disabled_btn";
                                      }

                                      if (empty($next_month_url)) {
                                        $next_url_disabled = "disabled_btn";
                                      }

                                      $visit_class="";
                                      if ($module['module_name'] == 'customer_visitation') {
                                        $visit_class = " visitation_row";
                                      }


                                      ?>
                                      <div class="wrapper-sm row m-b-xs b-b<?php echo $visit_class; ?>" data-id="<?php echo $obj_id; ?>" data-index="<?php echo $count_obj; ?>" data-contactid="<?php echo $value['contract_id'] ?>" data-module="<?php echo $module['id'] ?>">
                                        <div class="col-sm-3">
                                          <?php if ($count_obj == 0) { echo freetext($module['module_name']); } ?>
                                          <?php
                                          if ($module['module_name'] == 'customer_visitation') {
                                            if ($count_obj == 0) {
                                              ?>
                                              <a href="#" class="btn btn-xs btn-default m-l-xs visit_add_emp"><i class="fa fa-plus"></i></a>
                                              <?php
                                            }
                                          }
                                          ?>
                                        </div>
                                        <div class="col-sm-3 employee_section">
                                          <div class="col-sm-12 input-group">
                                            <input type="hidden" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][id]" value="<?php echo $obj_id ?>">
                                            <input type="hidden" class="emp_id_input employee_id_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $count_obj; ?>" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][employee]" value="<?php if (!empty($emp_id)) echo $emp_id; else echo $value['assign_user_id']; ?>">
                                            <input type="text" autocomplete="off" class="text-center emp_id_input form-control employee_name_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $count_obj; ?>" readonly  value="<?php if (!empty($emp_name) && trim($emp_name) != "") echo $emp_name; else echo $value['assign_firstname'].' '.$value['assign_lastname']; ?>">                                            
                                            <input type="hidden" class="function_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $count_obj; ?>" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][function]" value="<?php echo $value['function'] ?>">

                                          </div>
                                        </div>
                                        <div class="col-sm-4">                                    
                                          <span style="padding-top:15px;padding-right:5px;">วางแผนความถี่</span><?php if (empty($disabled)) { ?><span class="btn btn-default btn-xs minus_freq"><i class="fa fa-minus"></i></span> <?php } ?><input type="text" autocomplete="off"<?php echo $disabled;?> onkeypress="return false;" onkeydown="return false;" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][period]" class="form-control inline m-l-xs m-r-xs" style="width:60px;"  value="<?php if ($period > 0) { echo $period; } ?>">                                     <?php if (empty($disabled)) { ?><span  class="btn btn-default btn-xs plus_freq"><i class="fa fa-plus"></i></span><?php } ?><span style="padding-left:5px;padding-top:15px;">เดือนครั้ง</span>
                                        </div>
                                        <div class="col-sm-1"><a target="_blank" href="<?php echo empty($this_month_url)?'': $this_month_url; ?>"  title="<?php echo !array_key_exists('this_month_title', $obj)?'': $obj['this_month_title']; ?>" class="this_month_btn btn btn-default <?php echo $url_disabled; ?>"><i class="fa fa-calendar">&nbsp;</i><i class="fa fa-circle <?php echo empty($this_month_text)?'': $this_month_text; ?>"></i></a></div>
                                        <div class="col-sm-1"><a target="_blank" href="<?php echo empty($next_month_url)?'':$next_month_url; ?>" title="<?php echo !array_key_exists('next_month_title', $obj)?'': $obj['next_month_title']; ?>" class="btn btn-default <?php echo $next_url_disabled; ?>"><i class="fa fa-calendar">&nbsp;</i><i class="fa fa-circle <?php echo empty($next_month_text)?'':$next_month_text; ?>"></i></a></div>
                                      </div>
                                      <?php
                                      $count_obj++;
                                    }
                                  } else {

                                    $count_obj = 0;
                                    if (empty($this_month_url)) {
                                      $url_disabled = "disabled_btn";
                                    }

                                    if (empty($next_month_url)) {
                                      $next_url_disabled = "disabled_btn";
                                    }

                                    $visit_class="";
                                    if ($module['module_name'] == 'customer_visitation') {
                                      $visit_class = " visitation_row";
                                    }
                                    ?>
                                    <div class="wrapper-sm row m-b-xs b-b<?php echo $visit_class; ?>" data-id="<?php echo $obj_id; ?>" data-index="<?php echo $count_obj; ?>" data-contactid="<?php echo $value['contract_id'] ?>" data-module="<?php echo $module['id'] ?>">
                                      <div class="col-sm-3">
                                        <?php echo freetext($module['module_name']); ?>
                                        <?php
                                        if ($module['module_name'] == 'customer_visitation') {
                                          ?>
                                          <a href="#" class="btn btn-xs btn-default m-l-xs visit_add_emp"><i class="fa fa-plus"></i></a>
                                          <?php
                                        }
                                        ?>
                                      </div>
                                      <div class="col-sm-3 employee_section">
                                        <div class="col-sm-12 input-group">
                                          <input type="hidden" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][id]" value="<?php echo $obj_id ?>">
                                          <input type="hidden" class="emp_id_input employee_id_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $count_obj; ?>" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][employee]" value="<?php if (!empty($emp_id)) echo $emp_id; else echo $value['assign_user_id'] ?>">
                                          <input type="text" autocomplete="off" class="text-center emp_id_input form-control employee_name_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $count_obj; ?>" readonly  value="<?php if (!empty($emp_name) && trim($emp_name) != "") echo $emp_name; else echo $value['assign_firstname'].' '.$value['assign_lastname']; ?>">
                                          <input type="hidden" class="function_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $count_obj; ?>" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][function]" value="<?php echo $value['function'] ?>">
                                        </div>
                                      </div>
                                      <div class="col-sm-4">                                  
                                        <span style="padding-top:15px;padding-right:5px;">วางแผนความถี่</span><?php if (empty($disabled)) { ?><span class="btn btn-default btn-xs minus_freq"><i class="fa fa-minus"></i></span> <?php } ?><input type="text" autocomplete="off"<?php echo $disabled;?> onkeypress="return false;" onkeydown="return false;" name="assign_<?php echo $value['contract_id'] ?>_<?php echo $module['id'] ?>_<?php echo $value['function'] ?>[<?php echo $count_obj; ?>][period]" class="form-control inline m-l-xs m-r-xs" style="width:60px;"  value="<?php if ($period > 0) { echo $period; } ?>">                                     <?php if (empty($disabled)) { ?><span class="btn btn-default btn-xs plus_freq"><i class="fa fa-plus"></i></span><?php } ?><span style="padding-left:5px;padding-top:15px;">เดือนครั้ง</span>
                                      </div>
                                      <div class="col-sm-1"><a target="_blank" href="<?php echo $this_month_url; ?>" title="<?php echo array_key_exists('this_month_title', $obj)? $obj['this_month_title'] : ''; ?>" class="this_month_btn btn btn-default <?php echo $url_disabled; ?>"><i class="fa fa-calendar">&nbsp;</i><i class="fa fa-circle <?php echo empty($this_month_text)?'': $this_month_text; ?>"></i></a></div>
                                      <div class="col-sm-1"><a target="_blank" href="<?php echo $next_month_url; ?>" title="<?php echo array_key_exists('next_month_title', $obj)? $obj['next_month_title'] : ''; ?>" class="btn btn-default <?php echo $next_url_disabled; ?>"><i class="fa fa-calendar">&nbsp;</i><i class="fa fa-circle <?php echo empty($next_month_text)?'': $next_month_text; ?>"></i></a></div>
                                    </div>
                                    <?php
                                  }
                                  ?>
                                  <?php
                                }
                                ?>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <?php
                      }
                      ?>
                      <?php 
                    }
                  }
                  ?>
                </tbody>
              </table>
              <div class="panel-footer text-right">
                <input type="submit" class="submit-untrack btn btn-primary" value="<?php echo freetext('save'); ?>">
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php
    } else {
      ?>
      <div class="table-responsive">   
        <form id="save_assign_user" action="<?php echo site_url('__ps_action_plan_setting/save_assign_user') ?>" method="POST">              
          <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
            <thead>
              <tr>
                <th class='table-head'><?php echo freetext('sold_to'); ?></th>
                <th class='table-head'><?php echo freetext('ship_to'); ?></th>
                <th class='table-head'><?php echo freetext('type'); ?></th>
                <th class='table-head'><?php echo freetext('start_project'); ?></th>
                <th class='table-head'><?php echo freetext('end_project'); ?></th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php             
              if(!empty($module_list)){                  
                foreach ($module_list as $key => $project) {
                  $value = $project['project'];                   
                  ?>
                  <tr>
                    <td>
                      <?php print $value['customer_name'];?>
                    </td>

                    <td>
                      <?php print $value['shop_to_title'];?>
                    </td>

                    <td>
                      <?php print $value['job_type_title'];?>
                    </td>

                    <td>
                      <?php if (!empty($value['project_start']) && $value['project_start'] != '0000-00-00') { print common_easyDateFormat($value['project_start']); } else { echo "-"; } ?>
                    </td>

                    <td>
                      <?php if (!empty($value['project_end']) && $value['project_end'] != '0000-00-00') { print common_easyDateFormat($value['project_end']); } else { echo "-"; } ?>
                    </td>
                  </tr>
                  <?php
                  if (!empty($project['module_list'])) {
                    foreach ($project['module_list'] as $key => $module_obj) {
                      if ($key != '12') {
                        $module = $module_obj['module_info'];
                        ?>
                        <tr>
                          <td></td>
                          <td colspan="5" class="text-right">
                            <span style="padding-top:15px;"><?php echo freetext($module['module_name']); ?></span>
                            <?php
                            if (!empty($module_obj['assign_list'])) {
                              ?>
                              <?php

                              $count = 0;
                              foreach ($module_obj['assign_list'] as $key => $assign) {                                
                                if (!empty($assign['plan_date'])) {
                                  $count++;
                                }
                                ?> 
                                <input type="hidden" name="assign_<?php echo $value['contract_id']; ?>_<?php echo $module['id']; ?>_<?php echo $assign['sequence']; ?>" value="<?php echo $assign['plan_date']; ?>" >
                                <?php
                              }

                              if ($count == 0) {
                                $class = 'text-muted';
                              } else if (sizeof($module_obj['assign_list']) == $count) {
                                $class ='text-primary';
                              } else {
                                $class ='text-warning';
                              }
                              ?>
                              <a  class="btn btn-default slot-btn m-l-md"  data-toggle="modal" data-target="#modal-assign-<?php echo $value['contract_id']; ?>-<?php echo $module['id']; ?>" data-shipto="<?php echo $value['contract_id']; ?>" data-module="<?php echo $module['id']; ?>">  
                                <i class="fa fa-calendar"></i>
                                &nbsp;                      
                                <i class="fa fa-circle <?php echo $class; ?> text-xs v-middle mark-<?php echo $value['contract_id']; ?>-<?php echo $module['id']; ?>"></i>
                              </a>
                              <?php
                            }
                            ?>
                          </td>
                        </tr>
                        <?php
                      } else {
                        foreach ($module_obj as $jobtype_id => $clearjob_obj) {
                          if (!empty($clearjob_obj)) {
                            foreach ($clearjob_obj as $freq => $clearjob_freq_obj) {
                              $module = $clearjob_freq_obj['module_info'];
                              ?>
                              <tr>
                                <td></td>
                                <td colspan="5" class="text-right">
                                  <span style="padding-top:15px;"><?php echo freetext($module['module_name']); ?></span>
                                  <?php
                                  if (!empty($clearjob_freq_obj['assign_list'])) {
                                    ?>
                                    <?php

                                    $count = 0;
                                    foreach ($clearjob_freq_obj['assign_list'] as $key => $assign) {                                
                                      if (!empty($assign['plan_date'])) {
                                        $count++;
                                      }
                                      ?> 
                                      <input type="hidden" name="clearjobassign_<?php echo $value['contract_id']; ?>_<?php echo $module['id']; ?>_<?php echo $freq; ?>_<?php echo $assign['sequence']; ?>" value="<?php echo $assign['plan_date']; ?>" >
                                      <?php
                                    }

                                    if ($count == 0) {
                                      $class = 'text-muted';
                                    } else if (sizeof($clearjob_freq_obj['assign_list']) == $count) {
                                      $class ='text-primary';
                                    } else {
                                      $class ='text-warning';
                                    }
                                    ?>
                                    <a  class="btn btn-default slot-btn m-l-md"  data-toggle="modal" data-target="#clearmodal-assign-<?php echo $value['contract_id']; ?>-<?php echo $module['id']; ?>-<?php echo $freq; ?>" data-shipto="<?php echo $value['contract_id']; ?>" data-module="<?php echo $module['id']; ?>">  
                                      <i class="fa fa-calendar"></i>
                                      &nbsp;                      
                                      <i class="fa fa-circle <?php echo $class; ?> text-xs v-middle clearmark-<?php echo $value['contract_id']; ?>-<?php echo $module['id']; ?>-<?php echo $freq; ?>"></i>
                                    </a>
                                    <?php
                                  }
                                  ?>
                                </td>
                              </tr>
                              <?php
                            }
                          }
                        }
                      }
                    }
                  }
                  ?>
                  <?php 
                }
              }
              ?>
            </tbody>
          </table>
          <div class="panel-footer text-right">
            <input type="submit" class="save-assign btn btn-primary" value="<?php echo freetext('save'); ?>">
          </div>
        </form>
      </div>
      <?php
    }
    ?>
  </div>
</section>
</section>
</section>


<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>

<!--Start: modal confirm delete untrack -->
<div class="modal fade" id="modal-delete-assign"  is-confirm='0'>                  
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
