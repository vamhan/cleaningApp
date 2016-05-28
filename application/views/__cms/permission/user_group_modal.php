<div class="group_create modal fade" id="create_group">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('create_group'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form_create_group" method="post" action="<?php echo base_url().'index.php/__cms_permission/group_create' ?>">
          <div class="panel-group" id="create_group_accordion">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#create_group_accordion" href="#create_group_profile">
                    <?php echo freetext('profile'); ?>
                  </a>
                </h4>
              </div>
              <div id="create_group_profile" class="m-t-sm panel-collapse collapse in">  
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('group_name'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" name="name" class="form-control" value=""></div>
                </div>
              </div>
            </div>  
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary create_group_btn" data-parent="#create_group"><i class="fa fa-plus"></i> Create</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
  foreach ($group_list as $group) {
?>
<div class="group_edit modal fade" id="edit_group_<?php echo $group['id']; ?>"  data-id="<?php echo $group['id']; ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('group_edit'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form_edit_group" data-id="<?php echo $group['id']; ?>" method="post" action="<?php echo base_url().'index.php/__cms_permission/group_edit' ?>">
          <div class="panel-group" id="edit_group_accordion_<?php echo $group['id']; ?>">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#edit_group_accordion_<?php echo $group['id']; ?>" href="#edit_group_profile2_<?php echo $group['id']; ?>">
                    <?php echo freetext('profile'); ?>
                  </a>
                </h4>
              </div>
              <div id="edit_group_profile2_<?php echo $group['id']; ?>" class="m-t-sm panel-collapse collapse in">  
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('group_id'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" name="id" class="form-control" value="<?php echo $group['id'];?>" readonly></div>
                </div>
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('group_name'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" name="name" class="form-control" value="<?php echo $group['name'];?>"></div>
                </div>
              </div>
            </div>  
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary save_group_btn" data-parent="#edit_group_<?php echo $group['id']; ?>"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="group_delete modal fade" id="delete_group_<?php echo $group['id']; ?>" data-id="<?php echo $group['id']; ?>" data-url="<?php echo base_url().'index.php/__cms_permission/delete_group/' ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('group_delete'); ?></h4>
      </div>
      <div class="modal-body">
        <?php echo freetext('group_delete_msg'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary del_group_btn" data-parent="#delete_group_<?php echo $group['id']; ?>"><i class="fa fa-trash-o"></i> <?php echo freetext('confirm'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
  }
?>
