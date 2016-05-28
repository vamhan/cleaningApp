<div class="department_create modal fade" id="create_department">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('create_department'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form_create_department" method="post" action="<?php echo base_url().'index.php/__cms_permission/department_create' ?>">
          <div class="panel-group" id="create_department_accordion">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#create_department_accordion" href="#create_department_profile">
                    <?php echo freetext('profile'); ?>
                  </a>
                </h4>
              </div>
              <div id="create_department_profile" class="m-t-sm panel-collapse collapse in">  
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('department_name'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" name="name" class="form-control" value=""></div>
                </div>
              </div>
            </div>  
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary create_department_btn" data-parent="#create_department"><i class="fa fa-plus"></i> Create</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
  foreach ($department_list as $group) {
?>
<div class="department_edit modal fade" id="edit_department_<?php echo $group['id']; ?>"  data-id="<?php echo $group['id']; ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('department_edit'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form_edit_department" data-id="<?php echo $group['id']; ?>" method="post" action="<?php echo base_url().'index.php/__cms_permission/department_edit' ?>">
          <div class="panel-group" id="edit_department_accordion_<?php echo $group['id']; ?>">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#edit_department_accordion_<?php echo $group['id']; ?>" href="#edit_department_profile2_<?php echo $group['id']; ?>">
                    <?php echo freetext('profile'); ?>
                  </a>
                </h4>
              </div>
              <div id="edit_department_profile2_<?php echo $group['id']; ?>" class="m-t-sm panel-collapse collapse in">  
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('department_id'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" name="id" class="form-control" value="<?php echo $group['id'];?>" readonly></div>
                </div>
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('department_name'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" name="name" class="form-control" value="<?php echo $group['name'];?>"></div>
                </div>
              </div>
            </div>  
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary save_department_btn" data-parent="#edit_department_<?php echo $group['id']; ?>"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="department_delete modal fade" id="delete_department_<?php echo $group['id']; ?>" data-id="<?php echo $group['id']; ?>" data-url="<?php echo base_url().'index.php/__cms_permission/delete_department/' ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('department_delete'); ?></h4>
      </div>
      <div class="modal-body">
        <?php echo freetext('department_delete_msg'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary del_department_btn" data-parent="#delete_department_<?php echo $group['id']; ?>"><i class="fa fa-trash-o"></i> <?php echo freetext('confirm'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
  }
?>
