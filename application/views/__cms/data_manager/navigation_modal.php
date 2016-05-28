<div class="create_navigation_group modal fade" id="create_front_navigation_group_modal">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('navigation_group_create'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="create_nav_group_form" method="post" action="<?php echo base_url().'index.php/__cms_data_manager/navigation_group_create/' ?>">
          <input type="hidden" name="page_type" value="front_end">
          <div class="m-t-sm">         
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('group_name'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="group_name" class="form-control" value=""></div>
            </div>         
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('url'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="url" class="form-control" value=""></div>
            </div>  
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary create_nav_group_btn" data-parent="#create_front_navigation_group_modal"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="create_navigation_group modal fade" id="create_back_navigation_group_modal">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('navigation_group_create'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="create_nav_group_form" method="post" action="<?php echo base_url().'index.php/__cms_data_manager/navigation_group_create/' ?>">
          <input type="hidden" name="page_type" value="back_end">
          <div class="m-t-sm">         
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('group_name'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="group_name" class="form-control" value=""></div>
            </div>         
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('url'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="url" class="form-control" value=""></div>
            </div>  
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary create_nav_group_btn" data-parent="#create_back_navigation_group_modal"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="progress_bar modal fade" id="progress_bar">
  <div class="modal-dialog" style="width:50%; margin-top:30%">
    <div class="modal-content">
      <div class="modal-body">
        <div class="progress progress-sm progress-striped active" style="margin:0;"> 
          <div class="progress-bar progress-bar-danger" data-toggle="tooltip" style="width: 100%"></div> 
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="nav_group_delete modal fade" id="delete_nav_group" data-id="0" data-url="<?php echo base_url().'index.php/__cms_data_manager/nav_group_delete/' ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('nav_group_delete'); ?></h4>
      </div>
      <div class="modal-body">
        <?php echo freetext('nav_group_delete_msg'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary del_nav_group_btn" data-parent="#delete_nav_group"><i class="fa fa-trash-o"></i> <?php echo freetext('confirm'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="nav_page_delete modal fade" id="delete_nav_page" data-id="0" data-priority="0" data-url="<?php echo base_url().'index.php/__cms_data_manager/nav_page_delete/' ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('nav_page_delete'); ?></h4>
      </div>
      <div class="modal-body">
        <?php echo freetext('nav_page_delete_msg'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary del_nav_page_btn" data-parent="#delete_nav_page"><i class="fa fa-trash-o"></i> <?php echo freetext('confirm'); ?></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->