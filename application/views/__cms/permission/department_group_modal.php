<?php
  foreach ($department_group_list as $deptgroup) {
?>
<div class="department_group_edit modal fade" id="edit_department_group_<?php echo $deptgroup['dept_id'].'_'.$deptgroup['group_id']; ?>"  data-id="<?php echo $deptgroup['dept_id'].'_'.$deptgroup['group_id']; ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('group_edit'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form_edit_department_group" data-id="<?php echo $deptgroup['dept_id'].'_'.$deptgroup['group_id']; ?>" method="post" action="<?php echo base_url().'index.php/__cms_permission/department_group_edit' ?>">
          <input type="hidden" name="dept_id" value="<?php echo $deptgroup['dept_id']; ?>" />
          <input type="hidden" name="group_id" value="<?php echo $deptgroup['group_id']; ?>" />
          <div class="panel-group" id="edit_group_accordion_<?php echo $deptgroup['group_id']; ?>">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#edit_group_accordion_<?php echo $deptgroup['dept_id'].'_'.$deptgroup['group_id']; ?>" href="#edit_group_permission2_<?php echo $deptgroup['dept_id'].'_'.$deptgroup['group_id']; ?>">
                    <?php echo freetext('permission'); ?>
                  </a>
                </h4>
              </div>
              <div id="edit_group_permission2_<?php echo $deptgroup['dept_id'].'_'.$deptgroup['group_id']; ?>" class="m-t-sm panel-collapse collapse in">
                <div class="permission_table">
                  <table class="table table-striped">
                    <thead>
                      <th><?php echo freetext('number'); ?></th>
                      <th><?php echo freetext('module_name'); ?></th>
                      <th width="60%"></th>
                    </thead>
                    <tbody>
                    <?php

                    $permission_set = '';
                    if (!empty($deptgroup['permission'])) {
                      $permission_set = $deptgroup['permission'];
                    }
                    foreach ($module_list as $module) {
                      $check_arr = '';
                      if ( !empty($permission_set) && array_key_exists($module->id, $permission_set)) {
                        $check_arr = $permission_set[$module->id];
                      }
                    ?>
                        <tr>
                          <td><?php echo $module->id; ?></td>
                          <td><?php echo $module->module_name; ?></td>
                          <td>
                            <?php
                              $checked = '';
                              if (!empty($check_arr) && $check_arr['create']) {
                                $checked = ' checked';
                              }
                            ?>
                            <input type="checkbox" name="module_<?php echo $module->id; ?>_0"<?php echo $checked; ?>> <?php echo freetext('create'); ?>
                            <?php
                              $checked = '';
                              if (!empty($check_arr) && $check_arr['update']) {
                                $checked = ' checked';
                              }
                            ?>
                            <input type="checkbox" name="module_<?php echo $module->id; ?>_1"<?php echo $checked; ?>> <?php echo freetext('update'); ?>
                            <?php
                              $checked = '';
                              if (!empty($check_arr) && $check_arr['delete']) {
                                $checked = ' checked';
                              }
                            ?>
                            <input type="checkbox" name="module_<?php echo $module->id; ?>_2"<?php echo $checked; ?>> <?php echo freetext('delete'); ?>
                            <?php
                              $checked = '';
                              if (!empty($check_arr) && $check_arr['view']) {
                                $checked = ' checked';
                              }
                            ?>
                            <input type="checkbox" name="module_<?php echo $module->id; ?>_3"<?php echo $checked; ?>> <?php echo freetext('view'); ?><?php
                              $checked = '';
                              if (!empty($check_arr) && $check_arr['manage']) {
                                $checked = ' checked';
                              }
                            ?>
                            <input type="checkbox" name="module_<?php echo $module->id; ?>_4"<?php echo $checked; ?>> <?php echo freetext('manage'); ?>                         
                          </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary save_department_group_btn" data-parent="#edit_department_group_<?php echo $deptgroup['dept_id'].'_'.$deptgroup['group_id']; ?>"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
  }
?>
