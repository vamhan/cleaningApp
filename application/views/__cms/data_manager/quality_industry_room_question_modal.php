<div class="modal fade" id="create_area_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('create_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="create_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/create_area_question/' ?>">
          <input type="hidden" name="industry_id" value="<?php echo $industry_id; ?>">
          <input type="hidden" name="industry_room_id" value="<?php echo $id; ?>">
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">ข้อ</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="sequence_index" class="form-control input-s-sm" value=""></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('question'); ?></div>
            <div class="col-sm-6"><textarea name="title" rows="4" class="form-control"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary create_area_question_btn" data-parent="#create_area_question"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div class="modal fade" id="edit_area_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('create_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="edit_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/edit_area_question/' ?>">
          <input type="hidden" name="industry_id" value="<?php echo $industry_id; ?>">
          <input type="hidden" name="industry_room_id" value="<?php echo $id; ?>">
          <input type="hidden" name="id" value="">
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">ข้อ</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="sequence_index" class="form-control input-s-sm" value=""></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('question'); ?></div>
            <div class="col-sm-6"><textarea name="title" rows="4" class="form-control"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary edit_area_question_btn" data-parent="#edit_area_question"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div class="modal fade" id="del_area_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('del_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="del_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/delete_area_question/' ?>">
          <input type="hidden" name="industry_id" value="<?php echo $industry_id; ?>">
          <input type="hidden" name="industry_room_id" value="<?php echo $id; ?>">
          <input type="hidden" name="id" value="">
        </form>
        คุณต้องการลบคำถามใช่หรือไม่
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary del_area_question_btn" data-parent="#del_area_question"><i class="fa fa-trash-o"></i> <?php echo freetext('delete'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  