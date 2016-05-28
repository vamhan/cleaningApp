<div class="modal fade" id="create_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('create_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="create_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/create_employee_question/' ?>">
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">ลำดับ</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="sequence_index" class="form-control input-s-sm" value=""></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('question'); ?></div>
            <div class="col-sm-6"><textarea name="title" rows="4" class="form-control"></textarea></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('positive_label'); ?></div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="positive_label" class="form-control" value=""></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('negative_label'); ?></div>
            <div class="col-sm-6">
              <input type="text" autocomplete="off" name="negative_label" class="form-control" value="">
              <br>
              <input type="checkbox" name="negative_remark" value="1"> Remark
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary create_question_btn" data-parent="#create_question"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div class="modal fade" id="create_satisfaction_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('create_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="create_satisfaction_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/create_satisfaction_employee_question/' ?>">
          <input type="hidden" name="is_for_head" >
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">ลำดับ</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="sequence_index" class="form-control input-s-sm" value=""></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('question'); ?></div>
            <div class="col-sm-6"><textarea name="title" rows="4" class="form-control"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary create_satisfaction_question_btn" data-parent="#create_satisfaction_question"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 

<div class="modal fade" id="edit_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('edit_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="edit_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/edit_employee_question/' ?>">
          <input type="hidden" name="id" value="">
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">ลำดับ</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="sequence_index" class="form-control input-s-sm" value=""></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('question'); ?></div>
            <div class="col-sm-6"><textarea name="title" rows="4" class="form-control"></textarea></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('positive_label'); ?></div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="positive_label" class="form-control" value=""></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('negative_label'); ?></div>
            <div class="col-sm-6">
              <input type="text" autocomplete="off" name="negative_label" class="form-control" value="">
              <br>
              <input type="checkbox" name="negative_remark" value="1"> Remark
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary edit_question_btn" data-parent="#edit_question"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div class="modal fade" id="edit_satisfaction_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('edit_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="edit_satisfaction_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/edit_satisfaction_employee_question/' ?>">
          <input type="hidden" name="is_for_head" >
          <input type="hidden" name="id" value="">
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">ลำดับ</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="sequence_index" class="form-control input-s-sm" value=""></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('question'); ?></div>
            <div class="col-sm-6"><textarea name="title" rows="4" class="form-control"></textarea></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary edit_satisfaction_question_form_btn" data-parent="#edit_satisfaction_question"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div class="modal fade" id="del_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('del_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="del_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/delete_employee_question/' ?>">
          <input type="hidden" name="id" value="">
        </form>
        คุณต้องการลบคำถามใช่หรือไม่
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary del_question_btn" data-parent="#del_question"><i class="fa fa-trash-o"></i> <?php echo freetext('delete'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div class="modal fade" id="del_satisfaction_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('del_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="del_satisfaction_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/delete_satisfaction_employee_question/' ?>">
          <input type="hidden" name="is_for_head" >
          <input type="hidden" name="id" value="">
        </form>
        คุณต้องการลบคำถามใช่หรือไม่
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary del_satisfaction_question_form_btn" data-parent="#del_satisfaction_question"><i class="fa fa-trash-o"></i> <?php echo freetext('delete'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  