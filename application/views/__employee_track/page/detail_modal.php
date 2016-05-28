    <?php
      // get project id                
      if(!empty($result)){
          $content = $result['list'];                  
          foreach ($content as $key => $value) {
              $project_id =$value['project_id'];
              $ship_to_id =$value['ship_to_id'];
          }
      }

    ?>

      <div class="modal fade" id="modal-remark">
         <!-- #### remark-->
         
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo freetext('remark');?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>              
                 

                  <div class="form-group  col-sm-12">
                     <textarea id="remark_area" name="remark_area"  style="width:500px;height:150px;" placeholder="ใส่ข้อความ" ></textarea>
                  </div>     
                </div>

                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                  <button type="submit" class="btn btn-primary" name="save" id="remark_save"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button>                  
                                   
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->            
      </div>

         <!--Start: modal check -->
        <div class="modal fade" id="modal-check">           
          <form id="question_check_form" action='<?php echo site_url($this->page_controller.'/check_employee_track');  ?>' method="POST">
            <input type="hidden" name="employee_id" id="employee_id" value="" />
            <input type="hidden" name="doc_id" id="doc_id" value="" />
            <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
            <div class="modal-dialog  modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Loading data...</h4>
                </div>

                <div class="modal-body loading_div text-center">
                  <img style="max-width: 20%;" src="http://fc07.deviantart.net/fs70/f/2011/299/d/9/simple_loading_wheel_by_candirokz1-d4e1shx.gif">
                </div>
                <div class="modal-body data_div" style="display:none;">
                    <div class="row">
                      <div class="form-group col-sm-5">
                        <img style="width:100%" src="">
                      </div>
                      <div class="col-sm-7">
                        <div class="row col-sm-12 pull-right">
                          <div class="col-sm-6 bg-light dker font-bold text-center" style="padding:5px;">
                            <label class="control-label"><b><?php echo freetext('code'); ?></b></label>
                          </div>
                          <div class="col-sm-6 bg-light" style="height:33px;padding:5px;">
                            <label class="control-label" id="emp_code"></label>
                          </div>
                        </div>
                        <div class="row col-sm-12 pull-right m-t-sm">
                          <div class="col-sm-6 bg-light dker font-bold text-center" style="padding:5px;">
                            <label class="control-label"><b><?php echo freetext('employee_name'); ?></b></label>
                          </div>
                          <div class="col-sm-6 bg-light" style="height:33px;padding:5px;">
                            <label class="control-label" id="emp_name"></label>
                          </div>
                        </div>
                        <div class="row col-sm-12 pull-right m-t-sm">
                          <div class="col-sm-6 bg-light dker font-bold text-center" style="padding:5px;height:74px;">
                            <label class="control-label"><b><?php echo freetext('course'); ?></b></label>
                          </div>
                          <div class="col-sm-6 bg-light" style="height:74px;padding:5px;">
                            <label class="control-label" id="emp_course"></label>
                          </div>
                        </div>
                        <div class="row col-sm-12 pull-right m-t-sm">
                          <div class="col-sm-6 bg-light dker font-bold text-center" style="padding:5px;">
                            <label class="control-label"><b><?php echo freetext('number_of_card'); ?></b></label>
                          </div>
                          <div class="col-sm-6 bg-light" style="height:33px;padding:5px;">
                            <label class="control-label"  id="emp_card"></label>
                          </div>
                        </div>
                        <div class="row col-sm-12 pull-right m-t-sm">
                          <div class="col-sm-6 bg-light dker font-bold text-center" style="padding:5px;height:74px;">
                            <label class="control-label"><b><?php echo freetext('remark'); ?></b></label>
                          </div>
                          <div class="col-sm-6 bg-light" style="padding:5px; height:74px;">
                            <label class="control-label"  id="emp_remark" ></label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="question_list" class="row m-t-md">
                      <?php
                        if (!empty($query_question)) {
                          $count = 1;
                          foreach ($query_question as $question) {
                            $title = $question['title'];
                            $answer_set = json_decode($question['answer_set']);

                      ?>
                            <div class="form-group col-sm-12">
                               <label class="col-sm-7 control-label"><?php echo $title; ?></label>
                               <div class="col-sm-5">
                                 <div class="col-sm-6"><input type="radio" name="question_<?php echo $question['id']; ?>" data-id="<?php echo $question['id']; ?>" value="1" class="positive_input"> <?php echo $answer_set->positive->label ?></div>
                                 <div class="col-sm-6"><input type="radio" name="question_<?php echo $question['id']; ?>" data-id="<?php echo $question['id']; ?>" value="0" class="negative_input"> <?php echo $answer_set->negative->label ?></div>
                                 <?php
                                  if ($answer_set->negative->remark == "yes") {
                                 ?>
                                  <br>
                                  <div class="m-t-sm"><textarea name="negative_<?php echo $question['id']; ?>" style="width:100%; display:none;"></textarea></div>
                                 <?php
                                  }
                                 ?>
                                </div>
                            </div> 
                      <?php
                            $count++;
                          }
                        }
                      ?>
                    </div>
                </div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                  <button type="submit" class="btn btn-primary" name="save"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button> 
                   <!-- <input type='hidden' name="callback_url"value="<?php //echo site_url($this->page_controller.'/listview'); ?>">
                  <input type='submit' class="btn btn-primary" value="Save"> -->
                                   
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </form>
        </div><!--end: modal check -->

         <!--Start: modal check -->
        <div class="modal fade" id="modal-satisfaction">           
          <form id="question_satisfaction_form" action='<?php echo site_url($this->page_controller.'/satisfaction_employee_track');  ?>' method="POST">
            <input type="hidden" name="employee_id" id="employee_id" value="" />
            <input type="hidden" name="doc_id" id="doc_id" value="" />
            <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Loading data...</h4>
                </div>

                <div class="modal-body loading_div text-center">
                  <img style="max-width: 20%;" src="http://fc07.deviantart.net/fs70/f/2011/299/d/9/simple_loading_wheel_by_candirokz1-d4e1shx.gif">
                </div>
                <div class="modal-body data_div">

                    <div id="satisfaction_question_list" class="row m-t-md">
                      <?php
                        if (!empty($query_satisfaction_question)) {
                      ?>
                            <div class="form-group col-sm-12">
                               <label class="col-sm-6 control-label"></label>
                               <div class="col-sm-6">
                                 <div class="col-sm-2">ดีมาก</div>
                                 <div class="col-sm-2">ดี</div>
                                 <div class="col-sm-2">ปานกลาง</div>
                                 <div class="col-sm-2">พอใช้</div>
                                 <div class="col-sm-2">ปรับปรุง</div>
                                </div>
                            </div> 
                      <?php
                          $count = 1;
                          foreach ($query_satisfaction_question as $question) {
                            $title = $question['title'];

                      ?>
                            <div class="form-group col-sm-12 question_list" data-level="<?php echo $question['is_for_head']; ?>">
                               <label class="col-sm-6 control-label"><?php echo $title; ?></label>
                               <div class="col-sm-6">
                                 <div class="col-sm-2"><input type="radio" name="question_<?php echo $question['id']; ?>" value="5"></div>
                                 <div class="col-sm-2"><input type="radio" name="question_<?php echo $question['id']; ?>" value="4"></div>
                                 <div class="col-sm-2"><input type="radio" name="question_<?php echo $question['id']; ?>" value="3"></div>
                                 <div class="col-sm-2"><input type="radio" name="question_<?php echo $question['id']; ?>" value="2"></div>
                                 <div class="col-sm-2"><input type="radio" name="question_<?php echo $question['id']; ?>" value="1"></div>
                                </div>
                            </div> 
                      <?php
                            $count++;
                          }
                        }
                      ?>
                    </div>

                    <div>
                      <textarea name="opinion_satisfaction_answer" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                  <button type="submit" class="btn btn-primary" name="save"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button> 
                   <!-- <input type='hidden' name="callback_url"value="<?php //echo site_url($this->page_controller.'/listview'); ?>">
                  <input type='submit' class="btn btn-primary" value="Save"> -->
                                   
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </form>
        </div><!--end: modal check -->











