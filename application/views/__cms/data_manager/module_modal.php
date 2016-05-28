<div class="module_create modal fade xxl" id="create_module">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('module_create'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form_create_module" method="post" action="<?php echo base_url().'index.php/__cms_data_manager/module_create' ?>">
          <div class="m-t-sm">         
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('module_name'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="module_name" class="form-control" value=""></div>
            </div>   
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('description'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="description" class="form-control" value=""></div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary create_module_btn" data-parent="#create_module"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php
  foreach ($module_list as $module) {
?>
<div class="module_view modal fade" id="module_<?php echo $module['id']; ?>" data-id="<?php echo $module['id']; ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('module_view'); ?></h4>
      </div>
      <div class="modal-body view_mode">
        <div class="m-t-sm">          
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('number'); ?></div>
            <div class="col-sm-6"><?php echo $module['id']; ?></div>
          </div>         
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('module_name'); ?></div>
            <div class="col-sm-6"><?php echo $module['module_name']; ?></div>
          </div>   
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('description'); ?></div>
            <div class="col-sm-6"><?php echo $module['description']; ?></div>
          </div>
        </div> 
      </div>

      <div class="modal-body edit_mode" style="display:none;">
        <form class="form_edit_module" method="post" action="<?php echo base_url().'index.php/__cms_data_manager/module_edit' ?>">
          <div id="create_module_profile" class="m-t-sm panel-collapse collapse in"> 
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('number'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="id" class="form-control" value="<?php echo $module['id']; ?>" readonly></div>
            </div>             
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('module_name'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="module_name" class="form-control" value="<?php echo $module['module_name']; ?>"></div>
            </div>   
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('description'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="description" class="form-control" value="<?php echo $module['description']; ?>"></div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary edit_module_btn view_mode" data-parent="#module_<?php echo $module['id']; ?>"><i class="fa fa-pencil" ></i> <?php echo freetext('edit'); ?></button>
        <button type="button" class="btn btn-info back_module_btn edit_mode" data-parent="#module_<?php echo $module['id']; ?>" style="display:none"><i class="fa fa-angle-left" ></i> <?php echo freetext('back'); ?></button>
        <button type="button" class="btn btn-primary save_module_btn edit_mode" data-parent="#module_<?php echo $module['id']; ?>" style="display:none"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="user_edit modal fade" id="edit_module_<?php echo $module['id']; ?>" data-id="<?php echo $module['id']; ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('module_edit'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form_edit_module" method="post" action="<?php echo base_url().'index.php/__cms_data_manager/module_edit' ?>">
          <div id="create_module_profile" class="m-t-sm panel-collapse collapse in"> 
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('number'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="id" class="form-control" value="<?php echo $module['id']; ?>" readonly></div>
            </div>             
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('module_name'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="module_name" class="form-control" value="<?php echo $module['module_name']; ?>"></div>
            </div>   
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('description'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="description" class="form-control" value="<?php echo $module['description']; ?>"></div>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary save_module_btn" data-parent="#edit_module_<?php echo $module['id']; ?>"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="module_delete modal fade" id="delete_module_<?php echo $module['id']; ?>" data-id="<?php echo $module['id']; ?>" data-url="<?php echo base_url().'index.php/__cms_data_manager/module_delete/' ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('module_delete'); ?></h4>
      </div>
      <div class="modal-body">
        <?php echo freetext('module_delete_msg'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary del_module_btn" data-parent="#delete_module_<?php echo $module['id']; ?>"><i class="fa fa-trash-o"></i> <?php echo freetext('confirm'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
  }
?>