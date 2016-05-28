<div class="modal fade" id="create_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('create_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="create_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/create_question/' ?>">
          <input type="hidden" name="tab" value="">
          <input type="hidden" name="table" value="">
          <input type="hidden" name="subject_id" value="0">
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">ข้อ</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="sequence_index" class="form-control input-s-sm" value=""></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('question'); ?></div>
            <div class="col-sm-6"><textarea name="title" rows="4" class="form-control"></textarea></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('is_subject'); ?></div>
            <div class="col-sm-6"><input type="checkbox" autocomplete="off" name="is_subject" value="1"></div>
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

<div class="modal fade" id="edit_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('edit_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="edit_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/edit_question/' ?>">
          <input type="hidden" name="tab" value="">
          <input type="hidden" name="table" value="">
          <input type="hidden" name="id" value="">
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">ข้อ</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="sequence_index" class="form-control input-s-sm" value=""></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('question'); ?></div>
            <div class="col-sm-6"><textarea name="title" rows="4" class="form-control"></textarea></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('is_subject'); ?></div>
            <div class="col-sm-6"><input type="checkbox" autocomplete="off" name="is_subject" value="1"></div>
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

<div class="modal fade" id="del_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('del_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="del_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/delete_question/' ?>">
          <input type="hidden" name="tab" value="">
          <input type="hidden" name="table" value="">
          <input type="hidden" name="id" value="">
        </form>
        คำถามนี้และคำถามย่อยจะถูกลบ คุณต้องการลบคำถามใช่หรือไม่
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary del_question_btn" data-parent="#del_question"><i class="fa fa-trash-o"></i> <?php echo freetext('delete'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div class="modal fade" id="edit_customer_score">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('edit_customer_score'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="edit_customer_score_form" method="post" action="<?php echo site_url().'__cms_data_manager/edit_customer_score/' ?>">          
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">Excellent</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="excellent" class="form-control input-s-sm" value="<?php if (!empty($customer_score) && $customer_score['excellent'] != 0) { echo $customer_score['excellent']; } ?>" onkeypress="return isInt(event);"></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">Good</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="good" class="form-control input-s-sm" value="<?php if (!empty($customer_score) && $customer_score['good'] != 0) { echo $customer_score['good']; } ?>" onkeypress="return isInt(event);"></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">Average</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="average" class="form-control input-s-sm" value="<?php if (!empty($customer_score) && $customer_score['average'] != 0) { echo $customer_score['average']; } ?>" onkeypress="return isInt(event);"></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">Fair</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="fair" class="form-control input-s-sm" value="<?php if (!empty($customer_score) && $customer_score['fair'] != 0) { echo $customer_score['fair']; } ?>" onkeypress="return isInt(event);"></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">Poor</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="poor" class="form-control input-s-sm" value="<?php if (!empty($customer_score) && $customer_score['poor'] != 0) { echo $customer_score['poor']; } ?>" onkeypress="return isInt(event);"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary edit_customer_score_btn" data-parent="#edit_question"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div class="modal fade" id="create_kpi_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('create_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="create_kpi_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/create_question/' ?>">
          <input type="hidden" name="tab" value="">
          <input type="hidden" name="table" value="">
          <input type="hidden" name="subject_id" value="0">
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">ข้อ</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="sequence_index" class="form-control input-s-sm" value=""></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('question'); ?></div>
            <div class="col-sm-6"><textarea name="title" rows="4" class="form-control"></textarea></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('score'); ?></div>
            <div class="col-sm-6"><input type="text" name="score" onkeypress="return isInt(event);" class="form-control"></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('is_hr_question'); ?></div>
            <div class="col-sm-6"><input type="checkbox" autocomplete="off" name="is_hr_question" value="1"></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('is_subject'); ?></div>
            <div class="col-sm-6"><input type="checkbox" autocomplete="off" name="is_subject" value="1"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary create_kpi_question_btn" data-parent="#create_question"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div class="modal fade" id="edit_kpi_question">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('edit_question'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="edit_kpi_question_form" method="post" action="<?php echo site_url().'__cms_data_manager/edit_question/' ?>">
          <input type="hidden" name="tab" value="">
          <input type="hidden" name="table" value="">
          <input type="hidden" name="id" value="">
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold">ข้อ</div>
            <div class="col-sm-6"><input type="text" autocomplete="off" name="sequence_index" class="form-control input-s-sm" value=""></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('question'); ?></div>
            <div class="col-sm-6"><textarea name="title" rows="4" class="form-control"></textarea></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('score'); ?></div>
            <div class="col-sm-6"><input type="text" name="score" onkeypress="return isInt(event);" class="form-control"></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('is_hr_question'); ?></div>
            <div class="col-sm-6"><input type="checkbox" autocomplete="off" name="is_hr_question" value="1"></div>
          </div>
          <div class="row m-b-sm m-l-sm m-r-sm">
            <div class="col-sm-6 font-bold"><?php echo freetext('is_subject'); ?></div>
            <div class="col-sm-6"><input type="checkbox" autocomplete="off" name="is_subject" value="1"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary edit_kpi_question_btn" data-parent="#edit_kpi_question"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  