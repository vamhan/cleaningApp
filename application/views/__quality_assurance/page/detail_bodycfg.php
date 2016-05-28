
<style type="text/css">
  .dt_header{
    display: none  !important;
  }

  .dt_footer .row-fluid{
    display: none  !important;
  }
</style>
<div class="div_detail">
  <section class="panel panel-default ">               
    <!-- start : data action plan -->
    <div class="panel-body"> 
      <div class="form-group">
        <?php 
          $track_doc_id = $this->track_doc_id;
          $project_id = $this->project_id;
          $actor_by_id = $this->session->userdata('id');

          //====start : get data document  =========   
          // echo "<pre>";
          // print_r($data_document);
          // echo "</pre>";
          if(!empty($data_document)){
            $project_title =$data_document['title'];
            $actual_date =$data_document['actual_date'];
            $plan_id =$data_document['plan_id']; 
            $plan_date =$data_document['plan_date'];                      
            $actor_id =$data_document['inspector_id'];//get id        
            $doc_status =$data_document['status'];//get id        
            $doc_area =$data_document['area'];//get id                               
            $contract_id = $data_document['contract_id'];
            $survey_officer_id =$data_document['site_inspector_id'];//get id    
          }
          else{ 
            $project_title='-'; 
          }
          //====end :  get data document name =========

          //====start : get survey_officer name =========
          $this->db->where('employee_id', $survey_officer_id);
          $query_officer=$this->db->get('tbt_user');
          $data_officer = $query_officer->row_array();      
          if(!empty($data_officer)){
            $survey_officer_name = $data_officer['user_firstname']." ". $data_officer['user_lastname'];
          }else{ $survey_officer_name='-'; }
          //====end :  get survey_officer name =========


          //====start : get actor name =========
          $this->db->where('employee_id', $actor_id);
          $query_actor=$this->db->get('tbt_user');
          $data_actor = $query_actor->row_array();      
          if(!empty($data_actor)){
            $actor = $data_actor['user_firstname']." ". $data_actor['user_lastname'];
          }else{ $actor='-'; }
          //====end :  get actor name =========                      

        ?>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-md-8">
              <div class="input-group m-b">
                <span class="input-group-addon"><?php echo freetext('ref_action_plan'); ?></span>
                <?php 
                  $project_id_x = urldecode($project_id); 
                  $project_id_x = str_replace(" ", "", $project_id_x);
                ?>
                <input type="text" autocomplete="off" class="form-control" readonly  value="<?php echo 'ID-'.$project_id_x.'/'.$project_title.'/'.common_easyDateFormat($plan_date); ?>">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><i class="fa fa-th"></i></button>
                </span>
              </div>
            </div>                   
            <div class="col-md-4">
              <div class="input-group m-b">
                <span class="input-group-addon"><?php echo freetext('area'); ?></span>
                <input type="text" autocomplete="off" class="form-control area_input" value="<?php echo $doc_area; ?>">
              </div>
            </div>                       
          </div>
        </div>

        <div class="col-sm-12">
          <div class="row">
            <div class="col-md-4">
              <div class="input-group m-b">
                <span class="input-group-addon"><?php echo freetext('actual_date'); ?></span>
                <input type="text" autocomplete="off" class="form-control" readonly value="<?php if( $actual_date !='0000-00-00' ){ echo common_easyDateFormat($actual_date); }else{ echo "-"; } //$actual_date?> ">
              </div>
            </div>                       
            <div class="col-md-4">
              <div class="input-group m-b">
                <span class="input-group-addon"><?php echo freetext('survey_officer'); ?></span>
                <input type="text" autocomplete="off" name="actor_name" class="form-control" readonly value="<?php  if($survey_officer_name != " "){echo $survey_officer_name;}else{echo "-";} //  echo $actor_name.' '.$actor_surname;?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group m-b">
                <span class="input-group-addon"><?php echo freetext('actor'); ?></span>
                <input type="text" autocomplete="off" name="survey_officer_name" class="form-control" readonly  value="<?php if(!empty($actor)){ echo $actor;}else{ echo "-"; }  ?>">                             
              </div>
            </div>
        </div>
      </div>
    </div>                   
    <!-- End : data action plan -->
  </section><!-- end : panel -->
  <div class="panel row" style="padding-bottom:500px;">
    <div class="panel-collapse in">
      <div class="panel-body text-sm">
        <!-- .nav-justified -->
        <section class="panel panel-default">
          <div class="panel-heading">
            <a href="#" class="btn btn-default dropdown-toggle" style="width:130px;" data-toggle="dropdown">
              Menu <b class="caret"></b>
            </a>
            <ul class="dropdown-menu animated fadeInLeft main-menu" style="padding:0;margin:0;">
              <span class="arrow top" style="left:10%;top:-7px;"></span>
              <li class="outer_li area">
                <a href="#" class="question_option for_customer_question" data-area="0" data-areaid="for_customer" data-subject="<?php echo freetext('for_customer'); ?>"><?php echo freetext('for_customer'); ?></a>
              </li>
              <li class="outer_li area">
                <a href="#" class="question_option kpi_question" data-area="0" data-areaid="kpi" data-subject="<?php echo freetext('kpi'); ?>"><?php echo freetext('kpi'); ?></a>
              </li>
              <li class="outer_li area">
                <a href="#" class="question_option document_control" data-area="0" data-areaid="document_control" data-subject="<?php echo freetext('doc_control'); ?>"><?php echo freetext('doc_control'); ?></a>
              </li>
              <li class="outer_li area">
                <a href="#" class="question_option policy_question" data-area="0" data-areaid="policy" data-subject="<?php echo freetext('policy'); ?>"><?php echo freetext('policy'); ?></a>
              </li>
              <li class="divider" style="height:2px;margin:0;"></li>
            <?php
              // echo "<pre>";
              // print_r($data_document['area_list']);
              // echo "</pre>";
              if (!empty($data_document['area_list'])) {
                $prev_answer_list = array();
                $answer_list = array();
                $count = 0;
                foreach ($data_document['area_list'] as $building => $building_value) {

                  $floor_list = $building_value['floor_list'];
                  $building_active = "";
                  $building_display = "none";

                  $building_title  = $building_value['title'];
                  $building_status = "";
                  // if ($building_value['status'] == "complete") {
                  //   $building_status = "<i class='fa fa-check text-success'></i>";
                  // }
              ?>
                <li class="outer_li building_li<?php echo $building_active;?>">
                  <a href="#" class="building"><?php echo $building_title; ?>&nbsp;<?php echo $building_status; ?></a>
                  <ul class="dropdown-menu floor_list" data-visible="0" style="display: <?php echo $building_display; ?>;position: relative;z-index: 0;box-shadow: none;border: 0;padding:0;margin:0;">
                    <li class="divider" style="margin:0;"></li>
              <?php
                  if (!empty($floor_list)) {
                    foreach ($floor_list as $floor => $floor_value) {
            
                      $area_list = $floor_value['area_list'];
                      $floor_active = "";
                      $floor_display = "none";

                      $floor_title  = $floor_value['title'];
                      $floor_status = "";
                      // if ($floor_value['status'] == "complete") {
                      //   $floor_status = "<i class='fa fa-check text-success'></i>";
                      // }
              ?>
                    <li class="floor_li<?php echo $floor_active;?>">
                      <a href="#" class="floor"><i class="fa fa-angle-right"></i>&nbsp;<?php echo $floor_title; ?>&nbsp;<?php echo $floor_status; ?></a>
                      <ul class="dropdown-menu area_list" data-visible="0" style="display: <?php echo $floor_display; ?>;position: relative;z-index: 0;box-shadow: none;border: 0;padding:0;margin:0;">
                        <li class="divider" style="margin:0;"></li>
              <?php
                      if (!empty($area_list)) {
                        foreach ($area_list as $area => $value) {
                          $answer = unserialize($value['serialized_answer']);
                          if (array_key_exists('prev_result', $value)) {
                            $prev_answer_list[$value['id']] = $value['prev_result'];
                          }
                          $answer_list[$value['id']] = $answer;
                          $area_active = "";

                          $area_type = $value['industry_room_description'];
                          $status = "";
                          if ($value['status'] == "complete") {
                            $status = "<i class='fa fa-check text-success'></i>";
                          }
              ?>        
                          <li class="area <?php echo $area_active;?>"><a href="#" class="area question_option" data-area="1" data-areaid="<?php echo $value['id']; ?>" data-subject="<?php echo $value['building'].' > '.$value['floor'].' > '.$area_type; if (!empty($value['area_name'])) { echo ' ['.$value['area_name'].']'; } ?>">&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;<?php echo $area_type; if (!empty($value['area_name'])) {  echo ' ['.$value['area_name'].']'; } ?>&nbsp;<?php echo $status; ?></a></li>
              <?php
                          $count++;
                        }
                      }
              ?>
                        <li class="divider" style="margin:0;"></li>
                      </ul>
                    </li>
              <?php
                    }
                  }
              ?>
                    <li class="divider" style="margin:0;"></li>
                  </ul>
                </li>
              <?php
                }
              }
            ?>
            </ul>
            <span class="question_subject h5 m-l-md"></span>
            <div class="pull-right">
                <a href="#" class="btn btn-default prev_btn"><i class="fa fa-angle-left"></i>&nbsp;Prev</a>
                <a href="#" class="btn btn-default next_btn">Next&nbsp;<i class="fa fa-angle-right"></i></a>
            </div>
          </div>
          <div class="panel-body">
            <form role="form" id="save_form" action="<?php echo site_url('__ps_quality_assurance/survey_save/' ) ?>" method="POST">
              <?php
                  $recent_table  = "";
                  if ($this->session->userdata($track_doc_id.'_recent_table') != "") {
                    $recent_table = $this->session->userdata($track_doc_id.'_recent_table');
                  }
              ?>
              <input type="hidden" name="doc_id" value="<?php echo  $track_doc_id ;?>"/>
              <input type="hidden" name="project_id" value="<?php echo  $project_id ;?>"/>
              <input type="hidden" name="area" value="<?php echo  $doc_area ;?>"/>
              <input type="hidden" name="recent_table" value="<?php echo $recent_table; ?>"/>
              <input type="hidden" name="submit_val" value="0"/>
              <!-- <div class="col-sm-12"> -->
              <section class="panel panel-default">
                <?php
                    // echo "<pre>";
                    // print_r($answer_list);
                    // echo "</pre>";
                  if (!empty($data_document['question_list'])) {
                    $count = 0;
                    foreach ($data_document['question_list'] as $key => $type) {
                      $display = 'none';
                      if ($count == 0 && empty($recent_table)) {
                        $display = 'table';
                      } else if (!empty($recent_table) && $recent_table == "question-table-".$key) {
                        $display = 'table';
                      }
                ?>
                      <table id="<?php echo "question-table-".$key; ?>" data-index="<?php echo $count; ?>" class="table question-table" style="display:<?php echo $display; ?>;">
                        <?php
                          if ($key != "kpi" && $key != "for_customer" && $key != "document_control" && $key != "policy") {
                        ?>
                          <thead>
                            <tr class="back-color-gray"> 
                              <th style="width:30%"><?php echo freetext('question'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('pass'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('not_pass'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('n/a'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('weight'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('remark'); ?></th>
                              <th style="width:15%" class="text-center"><?php echo freetext('image'); ?></th>
                            </tr>
                          </thead>
                        <?php              
                            // echo "<pre>";
                            // print_r($prev_answer_list);
                            // echo "</pre>";
                            foreach ($type as $question) {

                              $prev_alert      = "";
                              $check_pass      = "";  
                              $check_not_pass  = "";
                              $check_not_check = "";
                              $weight          = "";
                              $remark          = "";
                              $images_count    = 0;
                              $images          = "";
                              $disable_image_view = " disabled";

                              if (array_key_exists($key, $prev_answer_list) && is_array($prev_answer_list[$key]) && array_key_exists($question['id'], $prev_answer_list[$key])) {
                                $prev_question_answer = $prev_answer_list[$key][$question['id']];

                                $prev_images          = "";
                                $prev_remark          = "";

                                if (array_key_exists('images', $prev_question_answer)) {
                                  $prev_images_list = $prev_question_answer['images'];
                                  $prev_images_count = sizeof($prev_question_answer['images']);

                                  if ($prev_images_count > 0) {
                                    // echo "<pre>";
                                    // print_r($prev_images_list);
                                    // echo "</pre>";
                                    foreach ($prev_images_list as $prev_image) {
                                      if (empty($prev_images)) {
                                        $prev_images = site_url($prev_image);
                                      } else {
                                        $prev_images .= '|'.site_url($prev_image);
                                      }
                                    }
                                  }
                                }

                                if (array_key_exists('remark', $prev_question_answer)) {
                                  $prev_remark = $prev_question_answer['remark'];
                                }

                                if (array_key_exists('status', $prev_question_answer) && $prev_question_answer['status'] == 'not_pass') {
                                  $prev_alert = "&nbsp;<a href='#' class='prev_month_alert' data-id='".$question['id']."' data-area='".$key."'><i class='fa fa-exclamation-circle text-danger'></i><input type='hidden' class='prev_question_".$key."_".$question['id']."_images' value='".$prev_images."' ><input type='hidden' class='form-control prev_question_".$key."_".$question['id']."_remark' value='".$prev_remark."' ></a>";
                                }
                              }

                              if (array_key_exists($key, $answer_list) && is_array($answer_list[$key]) && array_key_exists($question['id'], $answer_list[$key])) {
                                $question_answer = $answer_list[$key][$question['id']];
                                // echo "<pre>";
                                // print_r($question_answer);
                                // echo "</pre>";
                                if (array_key_exists('status', $question_answer)) {
                                  $status = $question_answer['status'];
                                  switch ($status) {
                                    case 'pass':
                                      $check_pass = " checked";
                                      break;
                                    case 'not_pass':
                                      $check_not_pass = " checked";
                                      break;
                                    case 'n/a':
                                      $check_not_check = " checked";
                                      break;
                                  }
                                }

                                if (array_key_exists('weight', $question_answer)) {
                                  $weight = $question_answer['weight'];
                                }

                                if (array_key_exists('remark', $question_answer)) {
                                  $remark = $question_answer['remark'];
                                }

                                if (array_key_exists('images', $question_answer)) {
                                  $images_list = $question_answer['images'];
                                  $images_count = sizeof($question_answer['images']);

                                  if ($images_count > 0) {
                                    // echo "<pre>";
                                    // print_r($images_list);
                                    // echo "</pre>";
                                    foreach ($images_list as $image) {
                                      if (empty($images)) {
                                        $images = site_url($image);
                                      } else {
                                        $images .= '|'.site_url($image);
                                      }
                                    }

                                    $disable_image_view = "";
                                  }
                                }
                              }
                        ?>
                            <tr>
                              <td><?php echo $question['title']. ' ' . $prev_alert; ?></td>
                              <td class="text-center"><input type="radio" class="pass" name="question_<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="pass"<?php echo $check_pass; ?>></td>
                              <td class="text-center"><input type="radio" class="not_pass" name="question_<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="not_pass"<?php echo $check_not_pass; ?>></td>
                              <td class="text-center"><input type="radio" class="not_check" name="question_<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="n/a"<?php echo $check_not_check; ?>></td>
                              <td class="text-center"><input type="text" autocomplete="off" class="form-control" name="question_<?php echo $key; ?>_<?php echo $question['id']; ?>[weight]" value="<?php echo $weight; ?>"></td>
                              <td class="text-center">
                                <?php
                                  $remark_color = "muted";
                                  if (!empty($remark)) {
                                    $remark_color = "primary";
                                  }
                                ?>
                                <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo $question['id']; ?>[remark]" value="<?php echo $remark; ?>" >
                                <a  class="btn btn-default remark-btn-click" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                  <i class="fa fa-align-justify"></i>
                                  &nbsp;                      
                                  <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle remark_icon_<?php echo $key; ?>_<?php echo $question['id']; ?>"></i>
                                </a>
                              </td>
                              <td class="text-center">
                                <input type="hidden" class="question_<?php echo $key; ?>_<?php echo $question['id']; ?>_images" value="<?php echo $images; ?>" >
                                <a href="#" class="btn btn-default btn-sm upload_btn" style="border-radius:5px;" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>"><?php echo freetext('upload'); ?></a>
                                <a href="#" class="btn btn-default btn-sm view_image" style="border-radius:5px;" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" <?php echo $disable_image_view; ?>><i class="fa fa-picture-o"></i> (<?php echo $images_count; ?>)</a>
                              </td>
                            </tr>
                        <?php
                            }
                        ?>
                        <?php
                          } else if ($key == 'kpi') {

                              $function = $this->session->userdata('function');

                              $score_status = $this->__ps_project_query->getObj('tbm_quality_survey_customer_score');
                              $customer_answer = unserialize($data_document['customer_serialized_answer']);
                              $customer_full_total = 0;
                              $customer_total = 0;
                              foreach ($customer_answer as $key => $answer) {
                                $customer_full_total += 5;
                                $customer_total += intval($score_status[$answer['status']]);
                              }

                              $kpi_answer = unserialize($data_document['KPI_serialized_answer']);
                        ?>
                            <tr class="back-color-gray"> 
                              <th style="width:80%"><?php echo freetext('question'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('score'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('check_point'); ?></th>
                            </tr>
                        <?php
                            foreach ($type as $section) {
                              if (array_key_exists('title', $section)) {
                        ?>
                                <tr>
                                  <td><?php if ($section['sequence_index'] != 0) { echo $section['sequence_index'].' '; } ?><?php echo $section['title']; ?></td>
                                  <td class="text-center"><u><?php if (!empty($section['score'])) echo $section['score']; ?></u></td>
                                  <?php
                                      if ( $section['is_subject'] == 1) {
                                  ?>
                                        <td class="text-center">&nbsp;</td>
                                  <?php
                                      } else {

                                          if (strpos($section['title'], 'CSI')) { 
                                            $customer_total_transform = round(($customer_total * intval($section['score'])) / $customer_full_total); 
                                        ?>
                                          <input type="hidden" autocomplete="off" class="form-control kpi_score csi_score" data-score="<?php echo $section['score']; ?>" name="kpi_<?php echo $section['id']; ?>" value="<?php if ( !empty($kpi_answer) && array_key_exists($section['id'], $kpi_answer) && !empty($kpi_answer[$section['id']])) { echo $kpi_answer[$section['id']]; } else if (!empty($customer_total_transform)) { echo $customer_total_transform; } ?>">
                                        <?php
                                          } else if (in_array('HR', $function) && $section['is_hr_question'] == 0) {
                                        ?>
                                          <input type="hidden" autocomplete="off" class="form-control kpi_score" data-score="<?php echo $section['score']; ?>" data-hr="<?php echo $section['is_hr_question']; ?>" name="kpi_<?php echo $section['id']; ?>" value="<?php if ( !empty($kpi_answer) && array_key_exists($section['id'], $kpi_answer) && !empty($kpi_answer[$section['id']])) { echo $kpi_answer[$section['id']]; } ?>">
                                        <?php
                                          }
                                        ?>
                                        <input type="text" autocomplete="off" class="form-control kpi_score" data-error="0" data-score="<?php echo $section['score']; ?>" data-hr="<?php echo $section['is_hr_question']; ?>" name="kpi_<?php echo $section['id']; ?>" <?php if (strpos($section['title'], 'CSI') || (in_array('OP', $function) && $section['is_hr_question'] == 1) || (in_array('HR', $function) && $section['is_hr_question'] == 0)) { echo "disabled "; } ?> value="<?php if ( !empty($kpi_answer) && array_key_exists($section['id'], $kpi_answer) && !empty($kpi_answer[$section['id']])) { echo $kpi_answer[$section['id']]; } else if (!empty($customer_total_transform) && strpos($section['title'], 'CSI')) { echo $customer_total_transform; } ?>">
                                  <?php
                                      }
                                  ?>
                                </tr>
                        <?php
                                if (array_key_exists('sub_section', $section)) {
                                  foreach ($section['sub_section'] as $sub_section) {
                        ?>
                        <?php
                                    if (array_key_exists('question_list', $sub_section)) {
                        ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } ?><?php echo $sub_section['title']; ?></td>
                                        <td class="text-center"><u><?php if (!empty($sub_section['score'])) echo $sub_section['score']; ?></u></td>
                                        <td class="text-center">&nbsp;</td>
                                      </tr>
                        <?php
                                      foreach ($sub_section['question_list'] as $question) {
                        ?>
                                        <tr>
                                          <td style="padding-left:60px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $question['title']); ?></td>
                                          <td class="text-center"><?php echo $question['score']; ?></td>
                                          <td class="text-center">
                                            <?php 
                                              if (strpos($question['title'], 'CSI')) { 
                                                $customer_total_transform = round(($customer_total * intval($question['score'])) / $customer_full_total); 
                                            ?>
                                              <input type="hidden" autocomplete="off" class="form-control kpi_score csi_score" data-score="<?php echo $question['score']; ?>" name="kpi_<?php echo $question['id']; ?>" value="<?php if ( !empty($kpi_answer) && array_key_exists($question['id'], $kpi_answer) && !empty($kpi_answer[$question['id']])) { echo $kpi_answer[$question['id']]; } else if (!empty($customer_total_transform)) { echo $customer_total_transform; } ?>">
                                            <?php
                                              } else if (in_array('HR', $function) && $question['is_hr_question'] == 0) {
                                            ?>
                                              <input type="hidden" autocomplete="off" class="form-control kpi_score" data-score="<?php echo $question['score']; ?>" data-hr="<?php echo $question['is_hr_question']; ?>" name="kpi_<?php echo $question['id']; ?>" value="<?php if ( !empty($kpi_answer) && array_key_exists($question['id'], $kpi_answer) && !empty($kpi_answer[$question['id']])) { echo $kpi_answer[$question['id']]; } ?>">
                                            <?php
                                              }
                                            ?>
                                            <input type="text" autocomplete="off" class="form-control kpi_score" data-error="0" data-score="<?php echo $question['score']; ?>" data-hr="<?php echo $question['is_hr_question']; ?>" name="kpi_<?php echo $question['id']; ?>" <?php if (strpos($question['title'], 'CSI') || (in_array('OP', $function) && $question['is_hr_question'] == 1) || (in_array('HR', $function) && $question['is_hr_question'] == 0)) { echo "disabled "; } ?> value="<?php if ( !empty($kpi_answer) && array_key_exists($question['id'], $kpi_answer) && !empty($kpi_answer[$question['id']])) { echo $kpi_answer[$question['id']]; } else if (!empty($customer_total_transform) && strpos($question['title'], 'CSI')) { echo $customer_total_transform; } ?>">
                                          </td>
                                        </tr>
                        <?php
                                      }
                                    } else {

                        ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $sub_section['title']); ?></td>
                                        <td class="text-center"><?php echo $sub_section['score']; ?></td>
                                        <td class="text-center">                                        
                                          <?php 
                                            if (strpos($sub_section['title'], 'CSI')) { 
                                              $customer_total_transform = round(($customer_total * intval($sub_section['score'])) / $customer_full_total);                                              
                                          ?>
                                            <input type="hidden" autocomplete="off" class="form-control kpi_score csi_score" data-score="<?php echo $sub_section['score']; ?>" name="kpi_<?php echo $sub_section['id']; ?>" value="<?php if ( !empty($kpi_answer) && array_key_exists($sub_section['id'], $kpi_answer) && !empty($kpi_answer[$question['id']])) { echo $kpi_answer[$sub_section['id']]; } else if (!empty($customer_total_transform)) { echo $customer_total_transform; }  ?>">
                                          <?php
                                            } else if (in_array('HR', $function) && $sub_section['is_hr_question'] == 0) {
                                            ?>
                                            <input type="hidden" autocomplete="off" class="form-control kpi_score" data-score="<?php echo $sub_section['score']; ?>" data-hr="<?php echo $sub_section['is_hr_sub_section']; ?>" name="kpi_<?php echo $sub_section['id']; ?>" value="<?php if ( !empty($kpi_answer) && array_key_exists($sub_section['id'], $kpi_answer) && !empty($kpi_answer[$sub_section['id']])) { echo $kpi_answer[$sub_section['id']]; } ?>">
                                          <?php
                                            }
                                          ?>
                                          <input type="text" autocomplete="off" class="form-control kpi_score" data-error="0" data-score="<?php echo $sub_section['score']; ?>" data-hr="<?php echo $sub_section['is_hr_question']; ?>" name="kpi_<?php echo $sub_section['id']; ?>" <?php if (strpos($sub_section['title'], 'CSI') || (in_array('OP', $function) && $sub_section['is_hr_question'] == 1) || (in_array('HR', $function) && $sub_section['is_hr_question'] == 0)) { echo "disabled 1"; } ?>  value="<?php if ( !empty($kpi_answer) && array_key_exists($sub_section['id'], $kpi_answer) && !empty($kpi_answer[$question['id']])) { echo $kpi_answer[$sub_section['id']]; } else if (!empty($customer_total_transform) && strpos($question['title'], 'CSI')) { echo $customer_total_transform; }  ?>">
                                        </td>
                                      </tr>
                      <?php
                                    }
                                  }
                                } else if (array_key_exists('question_list', $section)) {
                                  foreach ($section['question_list'] as $question) {
                          ?>
                                    <tr>
                                      <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $question['title']); ?></td>
                                      <td class="text-center"><?php echo $question['score']; ?></td>
                                      <td class="text-center">
                                        <?php 
                                          if (strpos($question['title'], 'CSI')) { 
                                            $customer_total_transform = round(($customer_total * intval($question['score'])) / $customer_full_total);                                            
                                        ?>
                                          <input type="hidden" autocomplete="off" class="form-control kpi_score csi_score" data-score="<?php echo $question['score']; ?>" name="kpi_<?php echo $question['id']; ?>" value="<?php if ( !empty($kpi_answer) && array_key_exists($question['id'], $kpi_answer) && !empty($kpi_answer[$question['id']])) { echo $kpi_answer[$question['id']]; } else if (!empty($customer_total_transform)) { echo $customer_total_transform; }  ?>">
                                        <?php
                                          } else if (in_array('HR', $function) && $question['is_hr_question'] == 0) {
                                            ?>
                                          <input type="hidden" autocomplete="off" class="form-control kpi_score" data-score="<?php echo $question['score']; ?>" data-hr="<?php echo $question['is_hr_question']; ?>" name="kpi_<?php echo $question['id']; ?>" value="<?php if ( !empty($kpi_answer) && array_key_exists($question['id'], $kpi_answer) && !empty($kpi_answer[$question['id']])) { echo $kpi_answer[$question['id']]; } ?>">
                                        <?php
                                          } 
                                        ?>
                                        <input type="text" autocomplete="off" class="form-control kpi_score" data-error="0" data-score="<?php echo $question['score']; ?>" data-hr="<?php echo $question['is_hr_question']; ?>" name="kpi_<?php echo $question['id']; ?>" <?php if (strpos($question['title'], 'CSI') || (in_array('OP', $function) && $question['is_hr_question'] == 1) || (in_array('HR', $function) && $question['is_hr_question'] == 0)) { echo "disabled"; } ?>  value="<?php if ( !empty($kpi_answer) && array_key_exists($question['id'], $kpi_answer) && !empty($kpi_answer[$question['id']])) { echo $kpi_answer[$question['id']]; } else if (!empty($customer_total_transform) && strpos($question['title'], 'CSI')) { echo $customer_total_transform; }  ?>">
                                      </td>
                                    </tr>
                        <?php 
                                  }
                                }
                              } else {
                                  foreach ($section as $question) {
                          ?>
                                    <tr>
                                      <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $question['title']); ?></td>
                                      <td class="text-center"><?php echo $question['score']; ?></td>
                                      <td class="text-center">
                                        <?php 
                                          if (strpos($question['title'], 'CSI')) { 
                                            $customer_total_transform = round(($customer_total * intval($question['score'])) / $customer_full_total);                                            
                                        ?>
                                          <input type="hidden" autocomplete="off" class="form-control kpi_score csi_score" data-score="<?php echo $question['score']; ?>" name="kpi_<?php echo $question['id']; ?>" value="<?php if ( !empty($kpi_answer) && array_key_exists($question['id'], $kpi_answer) && !empty($kpi_answer[$question['id']])) { echo $kpi_answer[$question['id']]; } else if (!empty($customer_total_transform)) { echo $customer_total_transform; }  ?>">
                                        <?php
                                          } else if (in_array('HR', $function) && $question['is_hr_question'] == 0) {
                                            ?>
                                          <input type="hidden" autocomplete="off" class="form-control kpi_score" data-score="<?php echo $question['score']; ?>" data-hr="<?php echo $question['is_hr_question']; ?>" name="kpi_<?php echo $question['id']; ?>" value="<?php if ( !empty($kpi_answer) && array_key_exists($question['id'], $kpi_answer) && !empty($kpi_answer[$question['id']])) { echo $kpi_answer[$question['id']]; } ?>">
                                        <?php
                                          } 
                                        ?>
                                        <input type="text" autocomplete="off" class="form-control kpi_score" data-error="0" data-score="<?php echo $question['score']; ?>" data-hr="<?php echo $question['is_hr_question']; ?>" name="kpi_<?php echo $question['id']; ?>" <?php if (strpos($question['title'], 'CSI') || (in_array('OP', $function) && $question['is_hr_question'] == 1) || (in_array('HR', $function) && $question['is_hr_question'] == 0)) { echo "disabled"; } ?>  value="<?php if ( !empty($kpi_answer) && array_key_exists($question['id'], $kpi_answer) && !empty($kpi_answer[$question['id']])) { echo $kpi_answer[$question['id']]; } else if (!empty($customer_total_transform) && strpos($question['title'], 'CSI')) { echo $customer_total_transform; }  ?>">
                                      </td>
                                    </tr>
                        <?php 
                                  }
                              }
                            }
                          } else if ($key == 'for_customer') {

                              $customer_answer = unserialize($data_document['customer_serialized_answer']);
                       
                        ?>
                            <tr class="back-color-gray"> 
                              <th style="width:45%"><?php echo freetext('question'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('excellent'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('good'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('average'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('fair'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('poor'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('remark'); ?></th>
                            </tr>
                        <?php
                            foreach ($type as $section) {
                              if (array_key_exists('title', $section)) {
                        ?>
                                <tr>
                                  <td><?php if ($section['sequence_index'] != 0) { echo $section['sequence_index'].' '; } ?><?php echo $section['title']; ?></td>
                                  <?php
                                      if ( $section['is_subject'] == 1) {
                                  ?>
                                          <td colspan="6">&nbsp;</td>
                                  <?php
                                      } else {

                                        $excellent_check = "";
                                        $good_check = "";
                                        $average_check = "";
                                        $fair_check = "";
                                        $poor_check = "";
                                        $remark = "";
                                   
                                        if (!empty($customer_answer) && array_key_exists($section['id'], $customer_answer) && array_key_exists('status', $customer_answer[$section['id']])) {
                                          $status = $customer_answer[$section['id']]['status'];
                                          switch ($status) {
                                            case 'excellent':
                                              $excellent_check = " checked";
                                              break;
                                            case 'good':
                                              $good_check = " checked";
                                              break;
                                            case 'average':
                                              $average_check = " checked";
                                              break;
                                            case 'fair':
                                              $fair_check = " checked";
                                              break;
                                            case 'poor':
                                              $poor_check = " checked";
                                              break;
                                          }
                                        }

                                        if (!empty($customer_answer) && array_key_exists($section['id'], $customer_answer) && array_key_exists('remark', $customer_answer[$section['id']])) {
                                          $remark = $customer_answer[$section['id']]['remark'];
                                        }
                                  ?>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $section['id'] ?>[status]" <?php } ?> value="excellent"<?php echo $excellent_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $section['id'] ?>[status]" <?php } ?> value="good"<?php echo $good_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $section['id'] ?>[status]" <?php } ?> value="average"<?php echo $average_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $section['id'] ?>[status]" <?php } ?> value="fair"<?php echo $fair_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $section['id'] ?>[status]" <?php } ?> value="poor"<?php echo $poor_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center">
                                          <?php
                                            $remark_color = "muted";
                                            if (!empty($remark)) {
                                              $remark_color = "primary";
                                            }
                                          ?>
                                          <input type="hidden" class="form-control" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $section['id'] ?>[remark]" <?php } ?> value="<?php echo $remark; ?>" >
                                          <a  class="btn btn-default customer-remark-btn-click" data-id="<?php echo $section['id']; ?>" > 
                                            <i class="fa fa-align-justify"></i>
                                            &nbsp;                      
                                            <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle customer_remark_icon_<?php echo $section['id'] ?>"></i>
                                          </a>
                                        </td>
                                  <?php
                                      }
                                  ?>
                                </tr>
                        <?php
                                if (array_key_exists('sub_section', $section)) {
                                  foreach ($section['sub_section'] as $sub_section) {
                        ?>
                        <?php
                                    if (array_key_exists('question_list', $sub_section)) {
                        ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } ?><?php echo $sub_section['title']; ?></td>
                                        <?php
                                            if ( $sub_section['is_subject'] == 1) {
                                        ?>
                                                <td colspan="6">&nbsp;</td>
                                        <?php
                                            } else {

                                              $excellent_check = "";
                                              $good_check = "";
                                              $average_check = "";
                                              $fair_check = "";
                                              $poor_check = "";
                                              $remark = "";
                                         
                                              if (!empty($customer_answer) && array_key_exists($sub_section['id'], $customer_answer) && array_key_exists('status', $customer_answer[$sub_section['id']])) {
                                                $status = $customer_answer[$sub_section['id']]['status'];
                                                switch ($status) {
                                                  case 'excellent':
                                                    $excellent_check = " checked";
                                                    break;
                                                  case 'good':
                                                    $good_check = " checked";
                                                    break;
                                                  case 'average':
                                                    $average_check = " checked";
                                                    break;
                                                  case 'fair':
                                                    $fair_check = " checked";
                                                    break;
                                                  case 'poor':
                                                    $poor_check = " checked";
                                                    break;
                                                }
                                              }

                                              if (!empty($customer_answer) && array_key_exists($sub_section['id'], $customer_answer) && array_key_exists('remark', $customer_answer[$sub_section['id']])) {
                                                $remark = $customer_answer[$sub_section['id']]['remark'];
                                              }
                                        ?>
                                              <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $sub_section['id'] ?>[status]" <?php } ?> value="excellent"<?php echo $excellent_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                              <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $sub_section['id'] ?>[status]" <?php } ?> value="good"<?php echo $good_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                              <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $sub_section['id'] ?>[status]" <?php } ?> value="average"<?php echo $average_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                              <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $sub_section['id'] ?>[status]" <?php } ?> value="fair"<?php echo $fair_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                              <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $sub_section['id'] ?>[status]" <?php } ?> value="poor"<?php echo $poor_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                              <td class="text-center">
                                                <?php
                                                  $remark_color = "muted";
                                                  if (!empty($remark)) {
                                                    $remark_color = "primary";
                                                  }
                                                ?>
                                                <input type="hidden" class="form-control" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $sub_section['id'] ?>[remark]" <?php } ?> value="<?php echo $remark; ?>" >
                                                <a  class="btn btn-default customer-remark-btn-click" data-id="<?php echo $sub_section['id']; ?>" > 
                                                  <i class="fa fa-align-justify"></i>
                                                  &nbsp;                      
                                                  <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle customer_remark_icon_<?php echo $sub_section['id'] ?>"></i>
                                                </a>
                                              </td>
                                        <?php
                                            }
                                        ?>
                                      </tr>
                        <?php
                                      foreach ($sub_section['question_list'] as $question) {

                                        $excellent_check = "";
                                        $good_check = "";
                                        $average_check = "";
                                        $fair_check = "";
                                        $poor_check = "";
                                        $remark = "";
                                   
                                        if (!empty($customer_answer) && array_key_exists($question['id'], $customer_answer) && array_key_exists('status', $customer_answer[$question['id']])) {
                                          $status = $customer_answer[$question['id']]['status'];
                                          switch ($status) {
                                            case 'excellent':
                                              $excellent_check = " checked";
                                              break;
                                            case 'good':
                                              $good_check = " checked";
                                              break;
                                            case 'average':
                                              $average_check = " checked";
                                              break;
                                            case 'fair':
                                              $fair_check = " checked";
                                              break;
                                            case 'poor':
                                              $poor_check = " checked";
                                              break;
                                          }
                                        }

                                        if (!empty($customer_answer) && array_key_exists($question['id'], $customer_answer) && array_key_exists('remark', $customer_answer[$question['id']])) {
                                          $remark = $customer_answer[$question['id']]['remark'];
                                        }
                        ?>
                                        <tr class="customer_question_row">
                                          <td style="padding-left:60px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $question['title']); ?></td>
                                          <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="excellent"<?php echo $excellent_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                          <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="good"<?php echo $good_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                          <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="average"<?php echo $average_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                          <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="fair"<?php echo $fair_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                          <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="poor"<?php echo $poor_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                          <td class="text-center">
                                            <?php
                                              $remark_color = "muted";
                                              if (!empty($remark)) {
                                                $remark_color = "primary";
                                              }
                                            ?>
                                            <input type="hidden" class="form-control" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[remark]" <?php } ?> value="<?php echo $remark; ?>" >
                                            <a  class="btn btn-default customer-remark-btn-click" data-id="<?php echo $question['id']; ?>" > 
                                              <i class="fa fa-align-justify"></i>
                                              &nbsp;                      
                                              <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle customer_remark_icon_<?php echo $question['id'] ?>"></i>
                                            </a>
                                          </td>
                                        </tr>
                        <?php
                                      }
                                    } else {

                                        $excellent_check = "";
                                        $good_check = "";
                                        $average_check = "";
                                        $fair_check = "";
                                        $poor_check = "";
                                        $remark = "";
                                   
                                        if (!empty($customer_answer) && array_key_exists($sub_section['id'], $customer_answer) && array_key_exists('status', $customer_answer[$sub_section['id']])) {
                                          $status = $customer_answer[$sub_section['id']]['status'];
                                          switch ($status) {
                                            case 'excellent':
                                              $excellent_check = " checked";
                                              break;
                                            case 'good':
                                              $good_check = " checked";
                                              break;
                                            case 'average':
                                              $average_check = " checked";
                                              break;
                                            case 'fair':
                                              $fair_check = " checked";
                                              break;
                                            case 'poor':
                                              $poor_check = " checked";
                                              break;
                                          }
                                        }

                                        if (!empty($customer_answer) && array_key_exists($sub_section['id'], $customer_answer) && array_key_exists('remark', $customer_answer[$sub_section['id']])) {
                                          $remark = $customer_answer[$sub_section['id']]['remark'];
                                        }
                      ?>
                                        <tr class="customer_question_row">
                                          <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $sub_section['title']); ?></td>
                                          <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $sub_section['id'] ?>[status]" <?php } ?> value="excellent"<?php echo $excellent_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                          <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $sub_section['id'] ?>[status]" <?php } ?> value="good"<?php echo $good_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                          <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $sub_section['id'] ?>[status]" <?php } ?> value="average"<?php echo $average_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                          <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $sub_section['id'] ?>[status]" <?php } ?> value="fair"<?php echo $fair_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                          <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $sub_section['id'] ?>[status]" <?php } ?> value="poor"<?php echo $poor_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                          <td class="text-center">
                                            <?php
                                              $remark_color = "muted";
                                              if (!empty($remark)) {
                                                $remark_color = "primary";
                                              }
                                            ?>
                                            <input type="hidden" class="form-control" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $sub_section['id'] ?>[remark]" <?php } ?> value="<?php echo $remark; ?>" >
                                            <a  class="btn btn-default customer-remark-btn-click" data-id="<?php echo $sub_section['id']; ?>" > 
                                              <i class="fa fa-align-justify"></i>
                                              &nbsp;                      
                                              <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle customer_remark_icon_<?php echo $sub_section['id'] ?>"></i>
                                            </a>
                                          </td>
                                        </tr>
                      <?php
                                    }
                                  }
                                } else if (array_key_exists('question_list', $section)) {
                                  foreach ($section['question_list'] as $question) {
                                      $excellent_check = "";
                                      $good_check = "";
                                      $average_check = "";
                                      $fair_check = "";
                                      $poor_check = "";
                                      $remark = "";
                                 
                                      if (!empty($customer_answer) && array_key_exists($question['id'], $customer_answer) && array_key_exists('status', $customer_answer[$question['id']])) {
                                        $status = $customer_answer[$question['id']]['status'];
                                        switch ($status) {
                                          case 'excellent':
                                            $excellent_check = " checked";
                                            break;
                                          case 'good':
                                            $good_check = " checked";
                                            break;
                                          case 'average':
                                            $average_check = " checked";
                                            break;
                                          case 'fair':
                                            $fair_check = " checked";
                                            break;
                                          case 'poor':
                                            $poor_check = " checked";
                                            break;
                                        }
                                      }

                                      if (!empty($customer_answer) && array_key_exists($question['id'], $customer_answer) && array_key_exists('remark', $customer_answer[$question['id']])) {
                                        $remark = $customer_answer[$question['id']]['remark'];
                                      }
                          ?>
                                      <tr class="customer_question_row">
                                        <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $question['title']); ?></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="excellent"<?php echo $excellent_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="good"<?php echo $good_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="average"<?php echo $average_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="fair"<?php echo $fair_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="poor"<?php echo $poor_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center">
                                          <?php
                                            $remark_color = "muted";
                                            if (!empty($remark)) {
                                              $remark_color = "primary";
                                            }
                                          ?>
                                          <input type="hidden" class="form-control" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[remark]" <?php } ?> value="<?php echo $remark; ?>" >
                                          <a  class="btn btn-default customer-remark-btn-click" data-id="<?php echo $question['id']; ?>" > 
                                            <i class="fa fa-align-justify"></i>
                                            &nbsp;                      
                                            <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle customer_remark_icon_<?php echo $question['id'] ?>"></i>
                                          </a>
                                        </td>
                                      </tr>
                        <?php 
                                  }
                                }
                              } else {
                                  foreach ($section as $question) {
                                      $excellent_check = "";
                                      $good_check = "";
                                      $average_check = "";
                                      $fair_check = "";
                                      $poor_check = "";
                                      $remark = "";
                                 
                                      if (!empty($customer_answer) && array_key_exists($question['id'], $customer_answer) && array_key_exists('status', $customer_answer[$question['id']])) {
                                        $status = $customer_answer[$question['id']]['status'];
                                        switch ($status) {
                                          case 'excellent':
                                            $excellent_check = " checked";
                                            break;
                                          case 'good':
                                            $good_check = " checked";
                                            break;
                                          case 'average':
                                            $average_check = " checked";
                                            break;
                                          case 'fair':
                                            $fair_check = " checked";
                                            break;
                                          case 'poor':
                                            $poor_check = " checked";
                                            break;
                                        }
                                      }

                                      if (!empty($customer_answer) && array_key_exists($question['id'], $customer_answer) && array_key_exists('remark', $customer_answer[$question['id']])) {
                                        $remark = $customer_answer[$question['id']]['remark'];
                                      }
                          ?>
                                      <tr class="customer_question_row">
                                        <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $question['title']); ?></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="excellent"<?php echo $excellent_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="good"<?php echo $good_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="average"<?php echo $average_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="fair"<?php echo $fair_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center"><input type="radio" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[status]" <?php } ?> value="poor"<?php echo $poor_check; ?> <?php if (!empty($signature) && !empty($signature['signature'])) { echo "disabled"; } ?>></td>
                                        <td class="text-center">
                                          <?php
                                            $remark_color = "muted";
                                            if (!empty($remark)) {
                                              $remark_color = "primary";
                                            }
                                          ?>
                                          <input type="hidden" class="form-control" <?php if (empty($signature) || empty($signature['signature'])) { ?>name="customer_<?php echo $question['id'] ?>[remark]" <?php } ?> value="<?php echo $remark; ?>" >
                                          <a  class="btn btn-default customer-remark-btn-click" data-id="<?php echo $question['id']; ?>" > 
                                            <i class="fa fa-align-justify"></i>
                                            &nbsp;                      
                                            <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle customer_remark_icon_<?php echo $question['id'] ?>"></i>
                                          </a>
                                        </td>
                                      </tr>
                        <?php 
                                  }
                              }
                            }
                        ?>
                            <tr>
                              <td colspan="7" style="padding:20px;">
                              <?php
                                if (empty($signature) || empty($signature['signature'])) {
                              ?>
                                <div class="row">
                                  <a href="#" class="btn btn-default pull-right btn-sm text-sm signature_pull" style="display:none;" data-id="<?php echo $track_doc_id; ?>">Pull Signature</a>
                                  <a href="#" class="btn btn-default pull-right btn-sm text-sm signature_request" data-id="<?php echo $track_doc_id; ?>">One Time Signature</a>
                                </div>
                              <?php
                                }
                              ?>
                                <div class="signature_area row m-t-md">
                                  <img src="<?php if (!empty($signature) && !empty($signature['signature'])) { echo site_url($signature['signature']);  } ?>" style="max-width:250px; float:right; <?php if (empty($signature) || empty($signature['signature'])) { ?>display:none;<?php } ?>" class="signature_img" >
                                <?php if (empty($signature) || empty($signature['signature'])) { ?>
                                  <textarea class="form-control pull-right input-s request_code text-center" style="resize:none;" rows="1" disabled></textarea> 
                                <?php } ?>
                                </div>
                              </td>
                            </tr>
                        <?php
                          } else if ($key == 'document_control') {

                              $document_answer = unserialize($data_document['document_control_serialized_answer']);

                              // echo "<pre>";
                              // print_r($document_answer);
                              // echo "</pre>";
                        ?>
                            <tr class="back-color-gray"> 
                              <th style="width:40%"><?php echo freetext('question'); ?></th>
                              <th style="width:15%" class="text-center"><?php echo freetext('have'); ?></th>
                              <th style="width:15%" class="text-center"><?php echo freetext('not_have'); ?></th>
                              <th style="width:15%" class="text-center"><?php echo freetext('n/a'); ?></th>
                              <th style="width:15%" class="text-center"><?php echo freetext('weight'); ?></th>
                              <th style="width:15%" class="text-center"><?php echo freetext('remark'); ?></th>
                            </tr>
                        <?php
                            foreach ($type as $section) {
                              if (array_key_exists('title', $section)) {
                        ?>
                                <tr>
                                  <td><?php if ($section['sequence_index'] != 0) { echo $section['sequence_index'].' '; } ?><?php echo $section['title']; ?></td>
                                  <td colspan="6">&nbsp;</td>
                                </tr>
                        <?php
                                if (array_key_exists('sub_section', $section)) {
                                  foreach ($section['sub_section'] as $sub_section) {
                        ?>
                        <?php
                                    if (array_key_exists('question_list', $sub_section)) {
                        ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } ?><?php echo $sub_section['title']; ?></td>
                                        <td colspan="6">&nbsp;</td>
                                      </tr>
                        <?php
                                      foreach ($sub_section['question_list'] as $question) {
                            
                                        $check_pass      = "";
                                        $check_not_pass  = "";
                                        $check_not_exist = "";
                                        $weight          = "";
                                        $remark          = "";

                                        if (!empty($data_document['document_control_serialized_answer']) && array_key_exists($question['id'], $document_answer)) {

                                          if (array_key_exists('status', $document_answer[$question['id']])) {
                                            if ($document_answer[$question['id']]['status'] == 'have') {
                                              $check_have = " checked";
                                            } else if ($document_answer[$question['id']]['status'] == 'not_have') {
                                              $check_not_have = " checked";
                                            } else if ($document_answer[$question['id']]['status'] == 'n/a') {
                                              $check_not_exist = " checked";
                                            }
                                          }

                                          if (array_key_exists('weight', $document_answer[$question['id']])) {
                                            $weight = $document_answer[$question['id']]['weight'];
                                          }

                                          if (array_key_exists('remark', $document_answer[$question['id']])) {
                                            $remark = $document_answer[$question['id']]['remark'];
                                          }
                                        }
                        ?>
                                        <tr class="document_control_question_row">
                                          <td style="padding-left:60px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $question['title']); ?></td>
                                          <td class="text-center"><input type="radio" class="have" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="have"<?php echo $check_have; ?>></td>
                                          <td class="text-center"><input type="radio" class="not_have" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="not_have"<?php echo $check_not_have; ?>></td>
                                          <td class="text-center"><input type="radio" class="not_exist" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="n/a"<?php echo $check_not_exist; ?>></td>
                                          <td class="text-center"><input type="text" autocomplete="off" class="form-control" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[weight]" value="<?php echo $weight; ?>"></td>
                                          <td class="text-center">
                                            <?php
                                              $remark_color = "muted";
                                              if (!empty($remark)) {
                                                $remark_color = "primary";
                                              }
                                            ?>
                                            <input type="hidden" class="form-control" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[remark]" value="<?php echo $remark; ?>" >
                                            <a  class="btn btn-default document-remark-btn-click" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                              <i class="fa fa-align-justify"></i>
                                              &nbsp;                      
                                              <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle document_remark_icon_<?php echo $question['id']; ?>"></i>
                                            </a>
                                          </td>
                                        </tr>
                        <?php
                                      }
                                    } else {
                            
                                        $check_have      = "";
                                        $check_not_have  = "";
                                        $check_not_exist = "";
                                        $weight          = "";
                                        $remark          = "";

                                        if (!empty($data_document['document_control_serialized_answer']) && array_key_exists($sub_section['id'], $document_answer)) {

                                          if (array_key_exists('status', $document_answer[$sub_section['id']])) {
                                            if ($document_answer[$sub_section['id']]['status'] == 'have') {
                                              $check_have = " checked";
                                            } else if ($document_answer[$sub_section['id']]['status'] == 'not_have') {
                                              $check_not_have = " checked";
                                            } else if ($document_answer[$sub_section['id']]['status'] == 'n/a') {
                                              $check_not_exist = " checked";
                                            }
                                          }

                                          if (array_key_exists('weight', $document_answer[$sub_section['id']])) {
                                            $weight = $document_answer[$sub_section['id']]['weight'];
                                          }

                                          if (array_key_exists('remark', $document_answer[$sub_section['id']])) {
                                            $remark = $document_answer[$sub_section['id']]['remark'];
                                          }
                                        }

                        ?>
                                        <tr class="document_control_question_row">
                                          <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $sub_section['title']); ?></td>
                                          <td class="text-center"><input type="radio" class="have" name="<?php echo $key; ?>_<?php echo $sub_section['id']; ?>[status]" value="have"<?php echo $check_have; ?>></td>
                                          <td class="text-center"><input type="radio" class="not_have" name="<?php echo $key; ?>_<?php echo $sub_section['id']; ?>[status]" value="not_have"<?php echo $check_not_have; ?>></td>
                                          <td class="text-center"><input type="radio" class="not_exist" name="<?php echo $key; ?>_<?php echo $sub_section['id']; ?>[status]" value="n/a"<?php echo $check_not_exist; ?>></td>
                                          <td class="text-center"><input type="text" autocomplete="off" class="form-control" name="<?php echo $key; ?>_<?php echo $sub_section['id']; ?>[weight]" value="<?php echo $weight; ?>"></td>
                                          <td class="text-center">
                                            <?php
                                              $remark_color = "muted";
                                              if (!empty($remark)) {
                                                $remark_color = "primary";
                                              }
                                            ?>
                                            <input type="hidden" class="form-control" name="<?php echo $key; ?>_<?php echo $sub_section['id']; ?>[remark]" value="<?php echo $remark; ?>" >
                                            <a  class="btn btn-default document-remark-btn-click" data-id="<?php echo $sub_section['id']; ?>" data-area="<?php echo $key; ?>" > 
                                              <i class="fa fa-align-justify"></i>
                                              &nbsp;                      
                                              <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle document_remark_icon_<?php echo $sub_section['id']; ?>"></i>
                                            </a>
                                          </td>
                                        </tr>
                      <?php
                                    }
                                  }
                                } else if (array_key_exists('question_list', $section)) {
                                  foreach ($section['question_list'] as $question) {
                            
                                    $check_have      = "";
                                    $check_not_have  = "";
                                    $check_not_exist = "";
                                    $weight          = "";
                                    $remark          = "";

                                    if (!empty($data_document['document_control_serialized_answer']) && array_key_exists($question['id'], $document_answer)) {

                                      if (array_key_exists('status', $document_answer[$question['id']])) {
                                        if ($document_answer[$question['id']]['status'] == 'have') {
                                          $check_have = " checked";
                                        } else if ($document_answer[$question['id']]['status'] == 'not_have') {
                                          $check_not_have = " checked";
                                        } else if ($document_answer[$question['id']]['status'] == 'n/a') {
                                          $check_not_exist = " checked";
                                        }
                                      }

                                      if (array_key_exists('weight', $document_answer[$question['id']])) {
                                        $weight = $document_answer[$question['id']]['weight'];
                                      }

                                      if (array_key_exists('remark', $document_answer[$question['id']])) {
                                        $remark = $document_answer[$question['id']]['remark'];
                                      }
                                    }
                          ?>
                                    <tr class="document_control_question_row">
                                      <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $question['title']); ?></td>
                                      <td class="text-center"><input type="radio" class="have" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="have"<?php echo $check_have; ?>></td>
                                      <td class="text-center"><input type="radio" class="not_have" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="not_have"<?php echo $check_not_have; ?>></td>
                                      <td class="text-center"><input type="radio" class="not_exist" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="n/a"<?php echo $check_not_exist; ?>></td>
                                      <td class="text-center"><input type="text" autocomplete="off" class="form-control" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[weight]" value="<?php echo $weight; ?>"></td>
                                      <td class="text-center">
                                        <?php
                                          $remark_color = "muted";
                                          if (!empty($remark)) {
                                            $remark_color = "primary";
                                          }
                                        ?>
                                        <input type="hidden" class="form-control" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[remark]" value="<?php echo $remark; ?>" >
                                        <a  class="btn btn-default document-remark-btn-click" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                          <i class="fa fa-align-justify"></i>
                                          &nbsp;                      
                                          <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle document_remark_icon_<?php echo $question['id']; ?>"></i>
                                        </a>
                                      </td>
                                    </tr>
                        <?php 
                                  }
                                }
                              } else {
                                  foreach ($section as $question) {
                            
                                    $check_have      = "";
                                    $check_not_have  = "";
                                    $check_not_exist = "";
                                    $weight          = "";
                                    $remark          = "";

                                    if (!empty($data_document['document_control_serialized_answer']) && array_key_exists($question['id'], $document_answer)) {

                                      if (array_key_exists('status', $document_answer[$question['id']])) {
                                        if ($document_answer[$question['id']]['status'] == 'have') {
                                          $check_have = " checked";
                                        } else if ($document_answer[$question['id']]['status'] == 'not_have') {
                                          $check_not_have = " checked";
                                        } else if ($document_answer[$question['id']]['status'] == 'n/a') {
                                          $check_not_exist = " checked";
                                        }
                                      }

                                      if (array_key_exists('weight', $document_answer[$question['id']])) {
                                        $weight = $document_answer[$question['id']]['weight'];
                                      }

                                      if (array_key_exists('remark', $document_answer[$question['id']])) {
                                        $remark = $document_answer[$question['id']]['remark'];
                                      }
                                    }
                          ?>
                                    <tr class="document_control_question_row">
                                      <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $question['title']); ?></td>
                                      <td class="text-center"><input type="radio" class="have" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="have"<?php echo $check_have; ?>></td>
                                      <td class="text-center"><input type="radio" class="not_have" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="not_have"<?php echo $check_not_have; ?>></td>
                                      <td class="text-center"><input type="radio" class="not_exist" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="n/a"<?php echo $check_not_exist; ?>></td>
                                      <td class="text-center"><input type="text" autocomplete="off" class="form-control" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[weight]" value="<?php echo $weight; ?>"></td>
                                      <td class="text-center">
                                        <?php
                                          $remark_color = "muted";
                                          if (!empty($remark)) {
                                            $remark_color = "primary";
                                          }
                                        ?>
                                        <input type="hidden" class="form-control" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[remark]" value="<?php echo $remark; ?>" >
                                        <a  class="btn btn-default document-remark-btn-click" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                          <i class="fa fa-align-justify"></i>
                                          &nbsp;                      
                                          <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle document_remark_icon_<?php echo $question['id']; ?>"></i>
                                        </a>
                                      </td>
                                    </tr>
                        <?php 
                                  }
                              }
                            }
                          } else if ($key == 'policy') {

                              $policy_answer = unserialize($data_document['policy_serialized_answer']);
                        ?>
                            <tr class="back-color-gray"> 
                              <th style="width:40%"><?php echo freetext('question'); ?></th>
                              <th style="width:15%" class="text-center"><?php echo freetext('pass'); ?></th>
                              <th style="width:15%" class="text-center"><?php echo freetext('not_pass'); ?></th>
                              <th style="width:15%" class="text-center"><?php echo freetext('weight'); ?></th>
                              <th style="width:15%" class="text-center"><?php echo freetext('remark'); ?></th>
                            </tr>
                        <?php
                            foreach ($type as $section) {
                              if (array_key_exists('title', $section)) {
                        ?>
                                <tr>
                                  <td><?php if ($section['sequence_index'] != 0) { echo $section['sequence_index'].' '; } ?><?php echo $section['title']; ?></td>
                                  <td colspan="6">&nbsp;</td>
                                </tr>
                        <?php
                                if (array_key_exists('sub_section', $section)) {
                                  foreach ($section['sub_section'] as $sub_section) {
                        ?>
                        <?php
                                    if (array_key_exists('question_list', $sub_section)) {
                        ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } ?><?php echo $sub_section['title']; ?></td>
                                        <td colspan="6">&nbsp;</td>
                                      </tr>
                        <?php
                                      foreach ($sub_section['question_list'] as $question) {
                            
                                        $check_pass      = "";
                                        $check_not_pass  = "";
                                        $weight          = "";
                                        $remark          = "";

                                        if (!empty($data_document['policy_serialized_answer']) && array_key_exists($question['id'], $policy_answer)) {

                                          if (array_key_exists('status', $policy_answer[$question['id']])) {
                                            if ($policy_answer[$question['id']]['status'] == 'pass') {
                                              $check_pass = " checked";
                                            } else if ($policy_answer[$question['id']]['status'] == 'not_pass') {
                                              $check_not_pass = " checked";
                                            }
                                          }

                                          if (array_key_exists('weight', $policy_answer[$question['id']])) {
                                            $weight = $policy_answer[$question['id']]['weight'];
                                          }

                                          if (array_key_exists('remark', $policy_answer[$question['id']])) {
                                            $remark = $policy_answer[$question['id']]['remark'];
                                          }
                                        }
                        ?>
                                        <tr class="policy_row">
                                          <td style="padding-left:60px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $question['title']); ?></td>
                                          <td class="text-center"><input type="radio" class="pass" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="pass"<?php echo $check_pass; ?>></td>
                                          <td class="text-center"><input type="radio" class="not_pass" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="not_pass"<?php echo $check_not_pass; ?>></td>
                                          <td class="text-center"><input type="text" autocomplete="off" class="form-control" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[weight]" value="<?php echo $weight; ?>"></td>
                                          <td class="text-center">
                                            <?php
                                              $remark_color = "muted";
                                              if (!empty($remark)) {
                                                $remark_color = "primary";
                                              }
                                            ?>
                                            <input type="hidden" class="form-control" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[remark]" value="<?php echo $remark; ?>" >
                                            <a  class="btn btn-default policy-remark-btn-click" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                              <i class="fa fa-align-justify"></i>
                                              &nbsp;                      
                                              <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle policy_remark_icon_<?php echo $question['id']; ?>"></i>
                                            </a>
                                          </td>
                                        </tr>
                        <?php
                                      }
                                    } else {
                            
                                        $check_pass      = "";
                                        $check_not_pass  = "";
                                        $weight          = "";
                                        $remark          = "";

                                        if (!empty($data_document['policy_serialized_answer']) && array_key_exists($sub_section['id'], $policy_answer)) {

                                          if (array_key_exists('status', $policy_answer[$sub_section['id']])) {
                                            if ($policy_answer[$sub_section['id']]['status'] == 'pass') {
                                              $check_pass = " checked";
                                            } else if ($policy_answer[$sub_section['id']]['status'] == 'not_pass') {
                                              $check_not_pass = " checked";
                                            }
                                          }

                                          if (array_key_exists('weight', $policy_answer[$sub_section['id']])) {
                                            $weight = $policy_answer[$sub_section['id']]['weight'];
                                          }

                                          if (array_key_exists('remark', $policy_answer[$sub_section['id']])) {
                                            $remark = $policy_answer[$sub_section['id']]['remark'];
                                          }
                                        }

                        ?>
                                        <tr class="policy_row">
                                          <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $sub_section['title']); ?></td>
                                          <td class="text-center"><input type="radio" class="pass" name="<?php echo $key; ?>_<?php echo $sub_section['id']; ?>[status]" value="pass"<?php echo $check_pass; ?>></td>
                                          <td class="text-center"><input type="radio" class="not_pass" name="<?php echo $key; ?>_<?php echo $sub_section['id']; ?>[status]" value="not_pass"<?php echo $check_not_pass; ?>></td>
                                          <td class="text-center"><input type="text" autocomplete="off" class="form-control" name="<?php echo $key; ?>_<?php echo $sub_section['id']; ?>[weight]" value="<?php echo $weight; ?>"></td>
                                          <td class="text-center">
                                            <?php
                                              $remark_color = "muted";
                                              if (!empty($remark)) {
                                                $remark_color = "primary";
                                              }
                                            ?>
                                            <input type="hidden" class="form-control" name="<?php echo $key; ?>_<?php echo $sub_section['id']; ?>[remark]" value="<?php echo $remark; ?>" >
                                            <a  class="btn btn-default policy-remark-btn-click" data-id="<?php echo $sub_section['id']; ?>" data-area="<?php echo $key; ?>" > 
                                              <i class="fa fa-align-justify"></i>
                                              &nbsp;                      
                                              <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle policy_remark_icon_<?php echo $sub_section['id']; ?>"></i>
                                            </a>
                                          </td>
                                        </tr>
                      <?php
                                    }
                                  }
                                } else if (array_key_exists('question_list', $section)) {
                                  foreach ($section['question_list'] as $question) {
                            
                                    $check_pass      = "";
                                    $check_not_pass  = "";
                                    $weight          = "";
                                    $remark          = "";

                                    if (!empty($data_document['policy_serialized_answer']) && array_key_exists($question['id'], $policy_answer)) {

                                      if (array_key_exists('status', $policy_answer[$question['id']])) {
                                        if ($policy_answer[$question['id']]['status'] == 'pass') {
                                          $check_pass = " checked";
                                        } else if ($policy_answer[$question['id']]['status'] == 'not_pass') {
                                          $check_not_pass = " checked";
                                        }
                                      }

                                      if (array_key_exists('weight', $policy_answer[$question['id']])) {
                                        $weight = $policy_answer[$question['id']]['weight'];
                                      }

                                      if (array_key_exists('remark', $policy_answer[$question['id']])) {
                                        $remark = $policy_answer[$question['id']]['remark'];
                                      }
                                    }
                          ?>
                                    <tr class="policy_row">
                                      <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $question['title']); ?></td>
                                      <td class="text-center"><input type="radio" class="pass" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="pass"<?php echo $check_pass; ?>></td>
                                      <td class="text-center"><input type="radio" class="not_pass" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="not_pass"<?php echo $check_not_pass; ?>></td>
                                      <td class="text-center"><input type="text" autocomplete="off" class="form-control" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[weight]" value="<?php echo $weight; ?>"></td>
                                      <td class="text-center">
                                        <?php
                                          $remark_color = "muted";
                                          if (!empty($remark)) {
                                            $remark_color = "primary";
                                          }
                                        ?>
                                        <input type="hidden" class="form-control" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[remark]" value="<?php echo $remark; ?>" >
                                        <a  class="btn btn-default policy-remark-btn-click" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                          <i class="fa fa-align-justify"></i>
                                          &nbsp;                      
                                          <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle policy_remark_icon_<?php echo $question['id']; ?>"></i>
                                        </a>
                                      </td>
                                    </tr>
                        <?php 
                                  }
                                }
                              } else {
                                  foreach ($section as $question) {
                            
                                    $check_pass      = "";
                                    $check_not_pass  = "";
                                    $weight          = "";
                                    $remark          = "";

                                    if (!empty($data_document['policy_serialized_answer']) && array_key_exists($question['id'], $policy_answer)) {

                                      if (array_key_exists('status', $policy_answer[$question['id']])) {
                                        if ($policy_answer[$question['id']]['status'] == 'pass') {
                                          $check_pass = " checked";
                                        } else if ($policy_answer[$question['id']]['status'] == 'not_pass') {
                                          $check_not_pass = " checked";
                                        }
                                      }

                                      if (array_key_exists('weight', $policy_answer[$question['id']])) {
                                        $weight = $policy_answer[$question['id']]['weight'];
                                      }

                                      if (array_key_exists('remark', $policy_answer[$question['id']])) {
                                        $remark = $policy_answer[$question['id']]['remark'];
                                      }
                                    }
                          ?>
                                    <tr class="policy_row">
                                      <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } ?><?php echo str_replace("\n", '<br>', $question['title']); ?></td>
                                      <td class="text-center"><input type="radio" class="pass" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="pass"<?php echo $check_pass; ?>></td>
                                      <td class="text-center"><input type="radio" class="not_pass" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[status]" value="not_pass"<?php echo $check_not_pass; ?>></td>
                                      <td class="text-center"><input type="text" autocomplete="off" class="form-control" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[weight]" value="<?php echo $weight; ?>"></td>
                                      <td class="text-center">
                                        <?php
                                          $remark_color = "muted";
                                          if (!empty($remark)) {
                                            $remark_color = "primary";
                                          }
                                        ?>
                                        <input type="hidden" class="form-control" name="<?php echo $key; ?>_<?php echo $question['id']; ?>[remark]" value="<?php echo $remark; ?>" >
                                        <a  class="btn btn-default policy-remark-btn-click" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                          <i class="fa fa-align-justify"></i>
                                          &nbsp;                      
                                          <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle policy_remark_icon_<?php echo $question['id']; ?>"></i>
                                        </a>
                                      </td>
                                    </tr>
                        <?php 
                                  }
                              }
                            }
                          }
                        ?> 
                      </table> 
                <?php
                      $count++;
                    }
                  }
                ?>                                  
              </section>
              <div class="col-sm-12" >
                <div class="pull-left">
                    <h4>Comment</h4>
                    <textarea class="form-control" name="comment" style="width:500px; height:80px;"><?php echo $data_document['comment']; ?></textarea>
                    <?php
                      $is_send_email = "";
                      if ($data_document['is_send_email'] == 1) {
                        $is_send_email = " checked";
                      }
                    ?>
                    <input type="checkbox" name="send_comment"<?php echo $is_send_email; ?>> Send E-mail
                    <span id="submit-span" style="display:none;">
                    <br>
                    <a href="#" class="btn btn-s-md btn-info submit-form-btn m-t-md" data-toggle=""><i class="fa fa-mail-forward h5"></i> <?php echo freetext('submit'); ?></a> 
                    </span>
                </div>
                <a href="<?php echo site_url('__ps_quality_assurance/listview/list/'.$project_id ); ?>" class="save-span btn btn-s-md btn-default pull-right margin-left-small" style="margin-top:7%;"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                <a href="#" class="save-span btn btn-s-md btn-primary save-form-btn pull-right" data-toggle="" style="margin-top:7%;"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></a>               
              </div>
            </form>
          </div>
        </section>
      </div>
    </div>
  </div>

</div><!-- end : class div_detail -->

</section><!-- end : scrollable padder -->
</section><!-- end : class vbox -->
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>















