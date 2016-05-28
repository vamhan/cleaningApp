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
              <li class="<?php if ($tab == 1) { echo "active"; } ?>"><a href="#area_question" data-toggle="tab">Area Question</a></li>
              <li class="<?php if ($tab == 2) { echo "active"; } ?>"><a href="#customer_question" data-toggle="tab">For Customer Question</a></li>
              <li class="<?php if ($tab == 3) { echo "active"; } ?>"><a href="#document_question" data-toggle="tab">Document Control Question</a></li>
              <li class="<?php if ($tab == 4) { echo "active"; } ?>"><a href="#kpi_question" data-toggle="tab">KPI Question</a></li>
              <li class="<?php if ($tab == 5) { echo "active"; } ?>"><a href="#policy_question" data-toggle="tab">Policy Question</a></li>
            </ul>
          </header>
          <div class="">
            <div class="tab-content">    
              <div class="tab-pane <?php if ($tab == 1) { echo "active"; } ?>" id="area_question" style="max-height: 418px;overflow-y: auto;">
                <table class="table table-striped m-b-none">
                    <thead>
                      <tr>    
                        <th width="20%">รหัส</th>
                        <th width="70%">ชื่อ</th>    
                        <th>&nbsp;</th>                 
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      if (!empty($industry_list)) {
                        foreach ($industry_list as $key => $industry) {
                    ?>
                        <tr>
                          <td><?php echo $industry['id']; ?></td>
                          <td><?php echo $industry['title']; ?></td>
                          <td class="text-right">
                            <a href="<?php echo site_url('__cms_data_manager/quality_industry_question/'.$industry['id']); ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                          </td>
                        </tr>
                    <?php
                        }
                      } else {
                    ?>
                      <tr><td colspan="3" class="text-center"><?php echo freetext('empty_question'); ?></td></tr>
                    <?php
                      }
                    ?>
                    </tbody>
                </table>
              </div>
              <!-- For Customer -->
              <div class="tab-pane <?php if ($tab == 2) { echo "active"; } ?>" id="customer_question" style="max-height: 418px;overflow-y: auto;">
                <div class="wrapper-sm text-right">
                  <a class="btn btn-primary create_question" data-tab="2" data-table="tbm_quality_survey_customer_question" data-parent="0"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></a>
                  <a class="btn btn-info edit_score" data-parent="0"><i class="fa fa-star"></i> ระดับคะแนน</a>
                </div>
                <table class="table table-striped m-b-none">
                    <thead>
                      <tr>    
                        <th width="20%">ข้อ</th>
                        <th width="60%">คำถาม</th>    
                        <th>&nbsp;</th>                 
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      if (!empty($customer_question_list)) {
                        foreach ($customer_question_list as $key => $question) {
                    ?>
                          <tr>
                            <td><?php echo $question['sequence_index']; ?></td>
                            <td><?php echo $question['title']; ?></td>
                            <td class="text-right">
                            <?php
                              if ($question['is_subject'] == 1) {
                            ?>
                              <a href="#" class="btn btn-default create_question" data-tab="2" data-table="tbm_quality_survey_customer_question" data-parent="<?php echo $question['id']; ?>"><i class="fa fa-plus"></i></a>
                            <?php
                              }
                            ?>
                              <a href="#" class="btn btn-default edit_question" data-subject="<?php echo $question['is_subject']; ?>" data-index="<?php echo $question['sequence_index']; ?>" data-title="<?php echo $question['title']; ?>" data-tab="2" data-table="tbm_quality_survey_customer_question" data-id="<?php echo $question['id']; ?>"><i class="fa fa-pencil"></i></a>
                              <a href="#" class="btn btn-default delete_question" data-tab="2" data-table="tbm_quality_survey_customer_question" data-id="<?php echo $question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                            </td>
                          </tr>
                    <?php
                          if (!empty($question['sub_question'])) {
                            foreach ($question['sub_question'] as $key2 => $sub_question) {
                    ?>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sub_question['sequence_index']; ?></td>
                                <td><?php echo $sub_question['title']; ?></td>
                                <td class="text-right">
                                <?php
                                  if ($sub_question['is_subject'] == 1) {
                                ?>
                                  <a href="#" class="btn btn-default create_question" data-tab="2" data-table="tbm_quality_survey_customer_question" data-parent="<?php echo $sub_question['id']; ?>"><i class="fa fa-plus"></i></a>
                                <?php
                                  }
                                ?>
                                  <a href="#" class="btn btn-default edit_question"  data-subject="<?php echo $sub_question['is_subject']; ?>" data-index="<?php echo $sub_question['sequence_index']; ?>" data-title="<?php echo $sub_question['title']; ?>" data-tab="2" data-table="tbm_quality_survey_customer_question" data-id="<?php echo $sub_question['id']; ?>"><i class="fa fa-pencil"></i></a>
                                  <a href="#" class="btn btn-default delete_question" data-tab="2" data-table="tbm_quality_survey_customer_question" data-id="<?php echo $sub_question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                                </td>
                              </tr>
                    <?php
                              if (!empty($sub_question['sub_question'])) {
                                foreach ($sub_question['sub_question'] as $key3 => $sub_sub_question) {
                    ?>
                                  <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sub_sub_question['sequence_index']; ?></td>
                                    <td><?php echo $sub_sub_question['title']; ?></td>
                                    <td class="text-right">
                                      <a href="#" class="btn btn-default edit_question"  data-subject="<?php echo $sub_sub_question['is_subject']; ?>" data-index="<?php echo $sub_sub_question['sequence_index']; ?>" data-title="<?php echo $sub_sub_question['title']; ?>" data-tab="2" data-table="tbm_quality_survey_customer_question" data-id="<?php echo $sub_sub_question['id']; ?>"><i class="fa fa-pencil"></i></a>
                                      <a href="#" class="btn btn-default delete_question" data-tab="2" data-table="tbm_quality_survey_customer_question" data-id="<?php echo $sub_sub_question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                  </tr>
                    <?php
                                }
                              }
                            }
                          }
                        }
                      } else {
                    ?>
                      <tr><td colspan="3" class="text-center"><?php echo freetext('empty_question'); ?></td></tr>
                    <?php
                      }
                    ?>
                    </tbody>
                </table>
              </div>
              <!-- Document Control -->
              <div class="tab-pane <?php if ($tab == 3) { echo "active"; } ?>" id="document_question" style="max-height: 418px;overflow-y: auto;">
                <div class="wrapper-sm text-right">
                  <a class="btn btn-primary create_question" data-tab="3" data-table="tbm_quality_survey_document_control_question" data-parent="0"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></a>
                </div>
                <table class="table table-striped m-b-none">
                    <thead>
                      <tr>    
                        <th width="20%">ข้อ</th>
                        <th width="60%">คำถาม</th>    
                        <th>&nbsp;</th>                 
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      if (!empty($document_question_list)) {
                        foreach ($document_question_list as $key => $question) {
                    ?>
                          <tr>
                            <td><?php echo $question['sequence_index']; ?></td>
                            <td><?php echo $question['title']; ?></td>
                            <td class="text-right">
                            <?php
                              if ($question['is_subject'] == 1) {
                            ?>
                              <a href="#" class="btn btn-default create_question" data-tab="3" data-table="tbm_quality_survey_document_control_question" data-parent="<?php echo $question['id']; ?>"><i class="fa fa-plus"></i></a>
                            <?php
                              }
                            ?>
                              <a href="#" class="btn btn-default edit_question" data-subject="<?php echo $question['is_subject']; ?>" data-index="<?php echo $question['sequence_index']; ?>" data-title="<?php echo $question['title']; ?>" data-tab="3" data-table="tbm_quality_survey_document_control_question" data-id="<?php echo $question['id']; ?>"><i class="fa fa-pencil"></i></a>
                              <a href="#" class="btn btn-default delete_question" data-tab="3" data-table="tbm_quality_survey_document_control_question" data-id="<?php echo $question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                            </td>
                          </tr>
                    <?php
                          if (!empty($question['sub_question'])) {
                            foreach ($question['sub_question'] as $key2 => $sub_question) {
                    ?>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sub_question['sequence_index']; ?></td>
                                <td><?php echo $sub_question['title']; ?></td>
                                <td class="text-right">
                                <?php
                                  if ($sub_question['is_subject'] == 1) {
                                ?>
                                  <a href="#" class="btn btn-default create_question" data-tab="3" data-table="tbm_quality_survey_document_control_question" data-parent="<?php echo $sub_question['id']; ?>"><i class="fa fa-plus"></i></a>
                                <?php
                                  }
                                ?>
                                  <a href="#" class="btn btn-default edit_question"  data-subject="<?php echo $sub_question['is_subject']; ?>" data-index="<?php echo $sub_question['sequence_index']; ?>" data-title="<?php echo $sub_question['title']; ?>" data-tab="3" data-table="tbm_quality_survey_document_control_question" data-id="<?php echo $sub_question['id']; ?>"><i class="fa fa-pencil"></i></a>
                                  <a href="#" class="btn btn-default delete_question" data-tab="3" data-table="tbm_quality_survey_document_control_question" data-id="<?php echo $sub_question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                                </td>
                              </tr>
                    <?php
                              if (!empty($sub_question['sub_question'])) {
                                foreach ($sub_question['sub_question'] as $key3 => $sub_sub_question) {
                    ?>
                                  <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sub_sub_question['sequence_index']; ?></td>
                                    <td><?php echo $sub_sub_question['title']; ?></td>
                                    <td class="text-right">
                                      <a href="#" class="btn btn-default edit_question"  data-subject="<?php echo $sub_sub_question['is_subject']; ?>" data-index="<?php echo $sub_sub_question['sequence_index']; ?>" data-title="<?php echo $sub_sub_question['title']; ?>" data-tab="3" data-table="tbm_quality_survey_document_control_question" data-id="<?php echo $sub_sub_question['id']; ?>"><i class="fa fa-pencil"></i></a>
                                      <a href="#" class="btn btn-default delete_question" data-tab="3" data-table="tbm_quality_survey_document_control_question" data-id="<?php echo $sub_sub_question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                  </tr>
                    <?php
                                }
                              }
                            }
                          }
                        }
                      } else {
                    ?>
                      <tr><td colspan="3" class="text-center"><?php echo freetext('empty_question'); ?></td></tr>
                    <?php
                      }
                    ?>
                    </tbody>
                </table>
              </div>
              <!-- KPI -->
              <div class="tab-pane <?php if ($tab == 4) { echo "active"; } ?>" id="kpi_question" style="max-height: 418px;overflow-y: auto;">
                <div class="wrapper-sm text-right">
                  <a class="btn btn-primary create_kpi_question" data-tab="4" data-table="tbm_quality_survey_kpi_question" data-parent="0"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></a>
                </div>
                <table class="table table-striped m-b-none">
                    <thead>
                      <tr>    
                        <th width="20%">ข้อ</th>
                        <th width="60%">คำถาม</th>    
                        <th>&nbsp;</th>                 
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      if (!empty($kpi_question_list)) {
                        foreach ($kpi_question_list as $key => $question) {
                    ?>
                          <tr>
                            <td><?php echo $question['sequence_index']; ?></td>
                            <td><?php echo $question['title']; ?></td>
                            <td class="text-right">
                            <?php
                              if ($question['is_subject'] == 1) {
                            ?>
                              <a href="#" class="btn btn-default create_kpi_question" data-tab="4" data-table="tbm_quality_survey_kpi_question" data-parent="<?php echo $question['id']; ?>"><i class="fa fa-plus"></i></a>
                            <?php
                              }
                            ?>
                              <a href="#" class="btn btn-default edit_kpi_question" data-subject="<?php echo $question['is_subject']; ?>" data-index="<?php echo $question['sequence_index']; ?>" data-title="<?php echo $question['title']; ?>" data-tab="4" data-table="tbm_quality_survey_kpi_question" data-id="<?php echo $question['id']; ?>" data-score="<?php echo $question['score']; ?>" data-hr="<?php echo $question['is_hr_question']; ?>"><i class="fa fa-pencil"></i></a>
                              <a href="#" class="btn btn-default delete_question" data-tab="4" data-table="tbm_quality_survey_kpi_question" data-id="<?php echo $question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                            </td>
                          </tr>
                    <?php
                          if (!empty($question['sub_question'])) {
                            foreach ($question['sub_question'] as $key2 => $sub_question) {
                    ?>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sub_question['sequence_index']; ?></td>
                                <td><?php echo $sub_question['title']; ?></td>
                                <td class="text-right">
                                <?php
                                  if ($sub_question['is_subject'] == 1) {
                                ?>
                                  <a href="#" class="btn btn-default create_kpi_question" data-tab="4" data-table="tbm_quality_survey_kpi_question" data-parent="<?php echo $sub_question['id']; ?>"><i class="fa fa-plus"></i></a>
                                <?php
                                  }
                                ?>
                                  <a href="#" class="btn btn-default edit_kpi_question"  data-subject="<?php echo $sub_question['is_subject']; ?>" data-index="<?php echo $sub_question['sequence_index']; ?>" data-title="<?php echo $sub_question['title']; ?>" data-tab="4" data-table="tbm_quality_survey_kpi_question" data-id="<?php echo $sub_question['id']; ?>" data-score="<?php echo $sub_question['score']; ?>" data-hr="<?php echo $sub_question['is_hr_question']; ?>"><i class="fa fa-pencil"></i></a>
                                  <a href="#" class="btn btn-default delete_question" data-tab="4" data-table="tbm_quality_survey_kpi_question" data-id="<?php echo $sub_question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                                </td>
                              </tr>
                    <?php
                              if (!empty($sub_question['sub_question'])) {
                                foreach ($sub_question['sub_question'] as $key3 => $sub_sub_question) {
                    ?>
                                  <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sub_sub_question['sequence_index']; ?></td>
                                    <td><?php echo $sub_sub_question['title']; ?></td>
                                    <td class="text-right">
                                      <a href="#" class="btn btn-default edit_kpi_question"  data-subject="<?php echo $sub_sub_question['is_subject']; ?>" data-index="<?php echo $sub_sub_question['sequence_index']; ?>" data-title="<?php echo $sub_sub_question['title']; ?>" data-tab="4" data-table="tbm_quality_survey_kpi_question" data-id="<?php echo $sub_sub_question['id']; ?>" data-score="<?php echo $sub_sub_question['score']; ?>" data-hr="<?php echo $sub_sub_question['is_hr_question']; ?>"><i class="fa fa-pencil"></i></a>
                                      <a href="#" class="btn btn-default delete_question" data-tab="4" data-table="tbm_quality_survey_kpi_question" data-id="<?php echo $sub_sub_question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                  </tr>
                    <?php
                                }
                              }
                            }
                          }
                        }
                      } else {
                    ?>
                      <tr><td colspan="3" class="text-center"><?php echo freetext('empty_question'); ?></td></tr>
                    <?php
                      }
                    ?>
                    </tbody>
                </table>
              </div>
              <!-- Policy -->
              <div class="tab-pane <?php if ($tab == 5) { echo "active"; } ?>" id="policy_question" style="max-height: 418px;overflow-y: auto;">
                <div class="wrapper-sm text-right">
                  <a class="btn btn-primary create_question" data-tab="5" data-table="tbm_quality_survey_policy_question" data-parent="0"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></a>
                </div>
                <table class="table table-striped m-b-none">
                    <thead>
                      <tr>    
                        <th width="20%">ข้อ</th>
                        <th width="60%">คำถาม</th>    
                        <th>&nbsp;</th>                 
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      if (!empty($policy_question_list)) {
                        foreach ($policy_question_list as $key => $question) {
                    ?>
                          <tr>
                            <td><?php echo $question['sequence_index']; ?></td>
                            <td><?php echo $question['title']; ?></td>
                            <td class="text-right">
                            <?php
                              if ($question['is_subject'] == 1) {
                            ?>
                              <a href="#" class="btn btn-default create_question" data-tab="5" data-table="tbm_quality_survey_policy_question" data-parent="<?php echo $question['id']; ?>"><i class="fa fa-plus"></i></a>
                            <?php
                              }
                            ?>
                              <a href="#" class="btn btn-default edit_question" data-subject="<?php echo $question['is_subject']; ?>" data-index="<?php echo $question['sequence_index']; ?>" data-title="<?php echo $question['title']; ?>" data-tab="5" data-table="tbm_quality_survey_policy_question" data-id="<?php echo $question['id']; ?>"><i class="fa fa-pencil"></i></a>
                              <a href="#" class="btn btn-default delete_question" data-tab="5" data-table="tbm_quality_survey_policy_question" data-id="<?php echo $question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                            </td>
                          </tr>
                    <?php
                          if (!empty($question['sub_question'])) {
                            foreach ($question['sub_question'] as $key2 => $sub_question) {
                    ?>
                              <tr>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sub_question['sequence_index']; ?></td>
                                <td><?php echo $sub_question['title']; ?></td>
                                <td class="text-right">
                                <?php
                                  if ($sub_question['is_subject'] == 1) {
                                ?>
                                  <a href="#" class="btn btn-default create_question" data-tab="5" data-table="tbm_quality_survey_policy_question" data-parent="<?php echo $sub_question['id']; ?>"><i class="fa fa-plus"></i></a>
                                <?php
                                  }
                                ?>
                                  <a href="#" class="btn btn-default edit_question"  data-subject="<?php echo $sub_question['is_subject']; ?>" data-index="<?php echo $sub_question['sequence_index']; ?>" data-title="<?php echo $sub_question['title']; ?>" data-tab="5" data-table="tbm_quality_survey_policy_question" data-id="<?php echo $sub_question['id']; ?>"><i class="fa fa-pencil"></i></a>
                                  <a href="#" class="btn btn-default delete_question" data-tab="5" data-table="tbm_quality_survey_policy_question" data-id="<?php echo $sub_question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                                </td>
                              </tr>
                    <?php
                              if (!empty($sub_question['sub_question'])) {
                                foreach ($sub_question['sub_question'] as $key3 => $sub_sub_question) {
                    ?>
                                  <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sub_sub_question['sequence_index']; ?></td>
                                    <td><?php echo $sub_sub_question['title']; ?></td>
                                    <td class="text-right">
                                      <a href="#" class="btn btn-default edit_question"  data-subject="<?php echo $sub_sub_question['is_subject']; ?>" data-index="<?php echo $sub_sub_question['sequence_index']; ?>" data-title="<?php echo $sub_sub_question['title']; ?>" data-tab="5" data-table="tbm_quality_survey_policy_question" data-id="<?php echo $sub_sub_question['id']; ?>"><i class="fa fa-pencil"></i></a>
                                      <a href="#" class="btn btn-default delete_question" data-tab="5" data-table="tbm_quality_survey_policy_question" data-id="<?php echo $sub_sub_question['id']; ?>"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                  </tr>
                    <?php
                                }
                              }
                            }
                          }
                        }
                      } else {
                    ?>
                      <tr><td colspan="3" class="text-center"><?php echo freetext('empty_question'); ?></td></tr>
                    <?php
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