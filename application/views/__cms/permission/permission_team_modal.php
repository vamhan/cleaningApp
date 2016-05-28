<div class="modal fade" id="create_permission_team_modal">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('create_permission_team'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form_create_permission_team" method="post" action="<?php echo base_url().'index.php/__cms_permission/permission_team_create' ?>">
          <div class="panel-group" id="create_permission_team_accordion">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#create_permission_team_accordion" href="#create_permission_team">
                    <?php echo freetext('profile'); ?>
                  </a>
                </h4>
              </div>
              <div id="create_permission_team" class="m-t-sm panel-collapse collapse in">  
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('department_name'); ?></div>
                  <div class="col-sm-6">
                  <?php
                    if (!empty($department_list)) {
                  ?>
                    <select name="department_id" class="form-control">
                  <?php
                      foreach ($department_list as $key => $dept) {
                  ?>
                      <option value="<?php echo $dept['id']; ?>"><?php echo $dept['name']; ?></option>
                  <?php
                      }
                  ?>
                    </select>
                  <?php
                    }
                  ?>
                  </div>
                </div>
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('title'); ?></div>
                  <div class="col-sm-6">
                    <input type="text" autocomplete="off" class="form-control" name="title" >
                  </div>
                </div>
              </div>
            </div> 
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#create_permission_team_accordion" href="#create_permission_team_manager">
                    <?php echo freetext('manager'); ?>
                  </a>
                </h4>
              </div>
              <div id="create_permission_team_manager" class="m-t-sm panel-collapse collapse">
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('manager'); ?></div>
                  <div class="col-sm-6">
                    <select class="form-control manager_list">
                      <option value="0">--- select manager ---</option>
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
                <div class="wrapper pull-right">
                  <a href="#" class="btn btn-info btn-sm add_manager">
                    Add
                  </a>
                </div>
                <div class="col-sm-12" style="overflow-y:auto;max-height:250px;">
                  <table class="table manager_table">
                    <thead>
                      <th>Manager</th>
                      <th>&nbsp;</th>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>   
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#create_permission_team_accordion" href="#create_permission_team_group">
                    <?php echo freetext('group_code'); ?>
                  </a>
                </h4>
              </div>
              <div id="create_permission_team_group" class="m-t-sm panel-collapse collapse">
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('code'); ?></div>
                  <div class="col-sm-6">
                    <input type="text" autocomplete="off" class="form-control group_code">
                  </div>
                </div>
                <div class="wrapper pull-right">
                  <a href="#" class="btn btn-info btn-sm add_group">
                    Add
                  </a>
                </div>
                <div class="col-sm-12" style="overflow-y:auto;max-height:250px;">
                  <table class="table group_code_table">
                    <thead>
                      <th>Code</th>
                      <th>&nbsp;</th>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>  
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary create_permission_team_btn" data-parent="#create_permission_team_modal"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
  if (!empty($team_list)) {
    foreach ($team_list as $key => $team) {
?><div class="modal fade" id="edit_permission_team_<?php echo $team['id']; ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('edit_permission_team'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form_edit_permission_team" method="post" action="<?php echo base_url().'index.php/__cms_permission/permission_team_edit' ?>">
          <input type="hidden" name="id" value="<?php echo $team['id']; ?>">
          <div class="panel-group" id="edit_permission_team_accordion_<?php echo $team['id']; ?>">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#edit_permission_team_accordion_<?php echo $team['id']; ?>" href="#edit_permission_team_profile_<?php echo $team['id']; ?>">
                    <?php echo freetext('profile'); ?>
                  </a>
                </h4>
              </div>
              <div id="edit_permission_team_profile_<?php echo $team['id']; ?>" class="m-t-sm panel-collapse collapse in">  
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('department_name'); ?></div>
                  <div class="col-sm-6">
                  <?php
                    if (!empty($department_list)) {
                  ?>
                    <select name="department_id" class="form-control">
                  <?php
                      foreach ($department_list as $key => $dept) {
                        $selected = "";
                        if ($dept['id'] == $team['department_id']) {
                          $selected = " selected";
                        }
                  ?>
                      <option value="<?php echo $dept['id']; ?>"<?php echo $selected; ?>><?php echo $dept['name']; ?></option>
                  <?php
                      }
                  ?>
                    </select>
                  <?php
                    }
                  ?>
                  </div>
                </div>
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('title'); ?></div>
                  <div class="col-sm-6">
                    <input type="text" autocomplete="off" class="form-control" name="title" value="<?php echo $team['title'] ?>" >
                  </div>
                </div>
              </div>
            </div> 
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#edit_permission_team_accordion_<?php echo $team['id']; ?>" href="#edit_permission_team_manager_<?php echo $team['id']; ?>">
                    <?php echo freetext('manager'); ?>
                  </a>
                </h4>
              </div>
              <div id="edit_permission_team_manager_<?php echo $team['id']; ?>" class="m-t-sm panel-collapse collapse">
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('manager'); ?></div>
                  <div class="col-sm-6">
                    <select class="form-control manager_list">
                      <option value="0">--- select manager ---</option>
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
                <div class="wrapper pull-right">
                  <a href="#" class="btn btn-info btn-sm add_manager">
                    Add
                  </a>
                </div>
                <div class="col-sm-12" style="overflow-y:auto;max-height:250px;">
                  <table class="table manager_table">
                    <thead>
                      <th>Manager</th>
                      <th>&nbsp;</th>
                    </thead>
                    <tbody>
                  <?php
                    if ( !empty($team['manager_list'])) {
                      $count = 0;
                      foreach ($team['manager_list'] as $manager) {
                  ?>
                        <tr class="manager_row_<?php echo $manager['employee_id']; ?>">
                          <td><?php echo $manager['user_firstname'].' '.$manager['user_lastname']; ?></td>
                          <td class="text-right">
                            <input type="hidden" name="manager_<?php echo $count++; ?>" value="<?php echo $manager['employee_id']; ?>">
                            <a href="#" class="btn btn-sm btn-default del_manager_btn"><i class="fa fa-trash-o"></i></a>
                          </td>
                        </tr>
                  <?php
                        $count++;
                      }
                    }
                  ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>   
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#edit_permission_team_accordion_<?php echo $team['id']; ?>" href="#edit_permission_team_group_<?php echo $team['id']; ?>">
                    <?php echo freetext('group_code'); ?>
                  </a>
                </h4>
              </div>
              <div id="edit_permission_team_group_<?php echo $team['id']; ?>" class="m-t-sm panel-collapse collapse">
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('code'); ?></div>
                  <div class="col-sm-6">
                    <input type="text" autocomplete="off" class="form-control group_code">
                  </div>
                </div>
                <div class="wrapper pull-right">
                  <a href="#" class="btn btn-info btn-sm add_group">
                    Add
                  </a>
                </div>
                <div class="col-sm-12" style="overflow-y:auto;max-height:250px;">
                  <table class="table group_code_table">
                    <thead>
                      <th>Code</th>
                      <th>&nbsp;</th>
                    </thead>
                    <tbody>
                  <?php
                    if ( !empty($team['team_list'])) {
                      $count = 0;
                      foreach ($team['team_list'] as $group) {
                  ?>
                        <tr class="code_<?php echo $group['code']; ?>">
                          <td><?php echo $group['code']; ?></td>
                          <td class="text-right">
                            <input type="hidden" name="group_code_<?php echo $count; ?>" value="<?php echo $group['code']; ?>">
                            <a href="#" class="btn btn-sm btn-default del_group_btn"><i class="fa fa-trash-o"></i></a>
                          </td>
                        </tr>
                  <?php
                        $count++;
                      }
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
        <button type="button" class="btn btn-primary edit_permission_team_btn" data-parent="#edit_permission_team_<?php echo $team['id']; ?>"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
    }
  }
?>

<div class="modal fade" id="permission_area_team_member">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4">Permission Area Team Member</h4>
      </div>
      <div class="modal-body loading_div text-center">
        <img style="max-width: 20%;" src="http://fc07.deviantart.net/fs70/f/2011/299/d/9/simple_loading_wheel_by_candirokz1-d4e1shx.gif">
      </div>
      <div class="modal-body body_div" style='display:none'>       
        <form class="form_permission_area_team_member" method="post" action="<?php echo base_url().'index.php/__cms_permission/permission_area_team_member' ?>">
          <input type="hidden" name="dept" value="">  
          <input type="hidden" name="code" value="">
          <div class="panel panel-default">
            <div class="m-t-sm panel-body">  
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('code'); ?></div>
                  <div class="col-sm-6">
                    <select class="form-control member_list">
                      <option value="0">--- select member ---</option>
                    </select>
                  </div>
                </div>
                <div class="wrapper pull-right">
                  <a href="#" class="btn btn-info btn-sm add_member">
                    Add
                  </a>
                </div>
                <div class="col-sm-12" style="overflow-y:auto;max-height:250px;">
                  <table class="table member_list_table">
                    <thead>
                      <th>Member</th>
                      <th>&nbsp;</th>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>         
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary save_permission_area_team_member_btn"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="permission_area_team_delete modal fade">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4">Delete Permission Area Team</h4>
      </div>
      <div class="modal-body">
        Would you like to delete <span class="title"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary del_permission_area_team_btn"><i class="fa fa-trash-o"></i> <?php echo freetext('confirm'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
