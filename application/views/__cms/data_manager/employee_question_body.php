<!-- start : content -->
<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default">
      <header class="panel-heading">
        <?php echo $this->page_title; ?>                  
      </header>
      <div class="panel-body">
        <section class="panel panel-default">
          <header class="panel-heading bg-light">
            <ul class="nav nav-tabs nav-justified">
              <li class="<?php if ($tab == 1) { echo "active"; } ?>"><a href="#general_tab" data-toggle="tab">General Question</a></li>
              <li class="<?php if ($tab == 2) { echo "active"; } ?>"><a href="#satisfaction_head_tab" data-toggle="tab">Satisfaction Question for Head</a></li>
              <li class="<?php if ($tab == 3) { echo "active"; } ?>"><a href="#satisfaction_emp_tab" data-toggle="tab">Satisfaction Question for Employee</a></li>
            </ul>
          </header>
          <div class="">
            <div class="tab-content">    
              <div class="tab-pane <?php if ($tab == 1) { echo "active"; } ?>" id="general_tab" style="max-height: 418px;overflow-y: auto;">
                <div class="wrapper-sm text-right">
                  <a class="btn btn-primary create_question"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></a>
                </div>
                <table class="table table-striped m-b-none">
                  <thead>
                    <th width="10%">ลำดับ</th>
                    <th width="80%">คำถาม</th>
                    <th></th>
                  </thead>
                  <tbody>
                  <?php
                    if (!empty($general_list)) {
                      foreach ($general_list as $key => $question) {
                  ?>
                      <tr>
                        <td><?php echo $question['sequence_index']; ?></td>
                        <td><?php echo $question['title']; ?></td>
                        <td>
                          <a href="#" class="btn btn-default edit_btn" data-id="<?php echo $question['id']; ?>" data-title='<?php echo $question['title']; ?>' data-sequence="<?php echo $question['sequence_index']; ?>" data-answer='<?php echo $question['answer_set']; ?>'><i class="fa fa-pencil"></i></a>
                          <a href="#" class="btn btn-default del_btn" data-id="<?php echo $question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
                  <?php
                      }
                    }
                  ?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane <?php if ($tab == 2) { echo "active"; } ?>" id="satisfaction_head_tab" style="max-height: 418px;overflow-y: auto;">
                <div class="wrapper-sm text-right">
                  <a class="btn btn-primary create_satisfaction_head_question"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></a>
                </div>
                <table class="table table-striped m-b-none">
                  <thead>
                    <th width="10%">ลำดับ</th>
                    <th width="80%">คำถาม</th>
                    <th></th>
                  </thead>
                  <tbody>
                  <?php
                    if (!empty($satisfaction_head_list)) {
                      foreach ($satisfaction_head_list as $key => $question) {
                  ?>
                      <tr>
                        <td><?php echo $question['sequence_index']; ?></td>
                        <td><?php echo $question['title']; ?></td>
                        <td>
                          <a href="#" class="btn btn-default edit_satisfaction_question_btn" data-id="<?php echo $question['id']; ?>" data-title='<?php echo $question['title']; ?>' data-sequence="<?php echo $question['sequence_index']; ?>" data-head='<?php echo $question['is_for_head']; ?>'><i class="fa fa-pencil"></i></a>
                          <a href="#" class="btn btn-default del_satisfaction_question_btn" data-head="1" data-id="<?php echo $question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
                  <?php
                      }
                    }
                  ?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane <?php if ($tab == 3) { echo "active"; } ?>" id="satisfaction_emp_tab" style="max-height: 418px;overflow-y: auto;">
                <div class="wrapper-sm text-right">
                  <a class="btn btn-primary create_satisfaction_emp_question"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></a>
                </div>
                <table class="table table-striped m-b-none">
                  <thead>
                    <th width="10%">ลำดับ</th>
                    <th width="80%">คำถาม</th>
                    <th></th>
                  </thead>
                  <tbody>
                  <?php
                    if (!empty($satisfaction_emp_list)) {
                      foreach ($satisfaction_emp_list as $key => $question) {
                  ?>
                      <tr>
                        <td><?php echo $question['sequence_index']; ?></td>
                        <td><?php echo $question['title']; ?></td>
                        <td>
                          <a href="#" class="btn btn-default edit_satisfaction_question_btn" data-id="<?php echo $question['id']; ?>" data-title='<?php echo $question['title']; ?>' data-sequence="<?php echo $question['sequence_index']; ?>" data-head='<?php echo $question['is_for_head']; ?>'><i class="fa fa-pencil"></i></a>
                          <a href="#" class="btn btn-default del_satisfaction_question_btn" data-head="0" data-id="<?php echo $question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
                  <?php
                      }
                    }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
      </div>
    </section>
  </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>       