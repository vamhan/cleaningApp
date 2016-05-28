<div class="keyuser_module_create modal fade" id="create_key_user">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('create_key_module'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form_create_key_user" method="post" action="<?php echo base_url().'index.php/__cms_permission/keyuser_module_create' ?>">
          <div class="panel-group" id="create_key_user_accordion">
            <div class="panel panel-default">
              <div class="m-t-sm panel-collapse collapse in">  
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('module_name'); ?></div>
                  <div class="col-sm-6">
                    <select name="module_id" class="form-control">
                    <?php
                      if (!empty($module_list)) {
                        foreach ($module_list as $module) {
                    ?>
                          <option value="<?php echo $module->id; ?>"><?php echo freetext($module->module_name); ?></option>
                    <?php
                        }
                      }
                    ?>
                    </select>
                  </div>
                </div>
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('employee'); ?></div>
                  <div class="col-sm-6">
                    <select name="keyuser_emp_id" class="form-control">
                    <?php
                      if (!empty($keyUser_list)) {
                        foreach ($keyUser_list as $user) {
                    ?>
                          <option value="<?php echo $user->employee_id; ?>"><?php echo $user->user_firstname.' '.$user->user_lastname; ?></option>
                    <?php
                        }
                      }
                    ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>  
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary create_keyuser_module_btn" data-parent="#create_key_user"><i class="fa fa-plus"></i> Create</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php
  foreach ($keyUserModule_list as $keyUsermodule) {
?>
<div class="keyuser_module_edit modal fade" id="edit_keyuser_module_<?php echo $keyUsermodule['id']; ?>" data-id="<?php echo $keyUsermodule['id']; ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('keyuser_module_edit'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form_edit_keyuser_module" data-id="<?php echo $keyUsermodule['id']; ?>" method="post" action="<?php echo base_url().'index.php/__cms_permission/keyuser_module_edit' ?>">
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="m-t-sm panel-collapse collapse in"> 
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('employee'); ?></div>
                  <div class="col-sm-6">
                    <input type="hidden" name="module_id" value="<?php echo $keyUsermodule['id']; ?>" >
                    <select name="keyuser_emp_id" class="form-control">
                    <?php
                      if (!empty($keyUser_list)) {
                        foreach ($keyUser_list as $user) {
                          $selected = '';
                          if ($user->employee_id == $keyUsermodule['employee_id']) {
                            $selected = ' selected';
                          }
                    ?>
                          <option value="<?php echo $user->employee_id; ?>"<?php echo $selected; ?>><?php echo $user->user_firstname.' '.$user->user_lastname; ?></option>
                    <?php
                        }
                      }
                    ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>  
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary save_keyuser_module_btn" data-parent="#edit_keyuser_module_<?php echo $keyUsermodule['id']; ?>"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="keyuser_module_delete modal fade" id="delete_keyuser_module_<?php echo $keyUsermodule['id']; ?>" data-id="<?php echo $keyUsermodule['id']; ?>" data-url="<?php echo base_url().'index.php/__cms_permission/keyuser_module_delete/' ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('keyuser_module_delete'); ?></h4>
      </div>
      <div class="modal-body">
        <?php echo freetext('keyuser_module_delete_msg'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary del_keyuser_module_btn" data-parent="#delete_keyuser_module_<?php echo $keyUsermodule['id']; ?>"><i class="fa fa-trash-o"></i> <?php echo freetext('confirm'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
  }
?>