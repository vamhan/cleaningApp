<?php

  foreach ($user_list as $user) {
?>
<div class="user_view modal fade" id="view_user_<?php echo $user['employee_id']; ?>" data-id="<?php echo $user['employee_id']; ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('user_view'); ?></h4>
      </div>
      <div class="modal-body"> 

<?php
 // echo "allow_mobile_login:".$user['allow_mobile_login']."<br>";
 // echo "allow_direct_login:".$user['allow_direct_login']."<br>";
 // echo "allow_tablet_login:".$user['allow_tablet_login']."<br>";
?>

        <div class="panel-group" id="view_accordion2_<?php echo $user['employee_id']; ?>" style="height:450px;overflow-y:auto;">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" href="#view_user_profile_<?php echo $user['employee_id']; ?>">
                  <?php echo freetext('profile'); ?>
                </a>
              </h4>
            </div>
            <div id="view_user_profile_<?php echo $user['employee_id']; ?>" class="m-t-sm panel-collapse collapse in">         
              <div class="row m-b-sm m-l-sm m-r-sm">
                <div class="col-sm-6 font-bold"><?php echo freetext('user_id'); ?></div>
                <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $user['employee_id'];?>" readonly></div>
              </div>
              <div class="row m-b-sm m-l-sm m-r-sm">
                <div class="col-sm-6 font-bold"><?php echo freetext('username'); ?></div>
                <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $user['user_login'];?>" readonly></div>
              </div>
              <div class="row m-b-sm m-l-sm m-r-sm">
                <div class="col-sm-6 font-bold"><?php echo freetext('firstname'); ?></div>
                <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $user['user_firstname'];?>" readonly></div>
              </div>
              <div class="row m-b-sm m-l-sm m-r-sm">
                <div class="col-sm-6 font-bold"><?php echo freetext('lastname'); ?></div>
                <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $user['user_lastname'];?>" readonly></div>
              </div>
              <div class="row m-b-sm m-l-sm m-r-sm">
                <div class="col-sm-6 font-bold"><?php echo freetext('gender'); ?></div>
                <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $user['gender'];?>" readonly></div>
              </div>
              <div class="row m-b-sm m-l-sm m-r-sm">
                <div class="col-sm-6 font-bold"><?php echo freetext('email'); ?></div>
                <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $user['user_email'];?>" readonly></div>
              </div>
              <div class="row m-b-sm m-l-sm m-r-sm">
                <div class="col-sm-6 font-bold"><?php echo freetext('phone'); ?></div>
                <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $user['user_phone'];?>" readonly></div>
              </div>
              <div class="row m-b-sm m-l-sm m-r-sm">
                <div class="col-sm-6 font-bold"><?php echo freetext('mobile'); ?></div>
                <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $user['user_mobile'];?>" readonly></div>
              </div>
              <div class="row m-b-sm m-l-sm m-r-sm">
                <div class="col-sm-6 font-bold"><?php echo freetext('fax'); ?></div>
                <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $user['user_fax'];?>" readonly></div>
              </div>

              <div class="line line-dashed"></div>
                <form class="bs-example form-horizontal" action="<?php echo site_url('__cms_permission/save_config_login'); ?>" method="post" enctype="multipart/form-data"> 
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <input type="hidden" autocomplete="off" class="form-control" name="employee_id" value="<?php echo $user['employee_id'];?>" readonly>
                   <div class="col-sm-3 font-bold"><?php echo freetext('group_name'); ?></div>
                    <div class="col-sm-3" >
                      <label>
                        <input type="checkbox" value="1" name="allow_mobile_login" <?php if($user['allow_mobile_login']==1){ echo "checked='checked'"; } ?>>
                         Allow Mobile Login
                      </label>
                    </div>

                    <div class="col-sm-3" >
                      <label>
                        <input type="checkbox" value="1" name="allow_direct_login" <?php if($user['allow_direct_login']==1){ echo "checked='checked'"; } ?>>
                         Allow Direct Login
                      </label>
                    </div>

                    <div class="col-sm-3" >
                      <label>
                        <input type="checkbox" value="1" name="allow_tablet_login" <?php if($user['allow_tablet_login']==1){ echo "checked='checked'"; } ?>>
                         Allow Tablet Login
                      </label>
                    </div>
                </div>
                <div class="row m-b-sm m-l-sm m-r-sm margin-top-medium{">
                    <div class="col-sm-3 pull-right" >
                    <button type="submit" class="pull-right btn btn-primary btn-sm" style="width:100px;"><i class="fa fa-save icon marg-right-small"></i> Save</button>
                    </div>
                </div>
              </form>

            </div>
          </div>   
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" href="#view_user_position_<?php echo $user['employee_id']; ?>">
                  <?php echo freetext('position'); ?>
                </a>
              </h4>
            </div>
            <div id="view_user_position_<?php echo $user['employee_id']; ?>" class="m-t-sm panel-collapse collapse in">  
            <?php
              if (!empty($user['position_list'])) {
                foreach ($user['position_list'] as $key => $position) {
            ?>    
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('department'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $position['dept_name'];?>" readonly></div>
                </div>
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('dept_function'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $position['function'];?>" readonly></div>
                </div>
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('position'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $position['title'];?>" readonly></div>
                </div>
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('position_area'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $position['area_id'];?>" readonly></div>
                </div>
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('group_name'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" class="form-control" value="<?php echo $position['group_name'];?>" readonly></div>
                </div>    
            <?php
                }
              }
            ?>    
            </div>
          </div>  
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
  }
?>
