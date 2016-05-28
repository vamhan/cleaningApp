<style type="text/css">
  .dt_header{
    display: none  !important;
  }

  .dt_footer .row-fluid{
    display: none  !important;
  }
</style>
<?php
  function truncate($val, $f="0")
  {
      if(($p = strpos($val, '.')) !== false) {
          $val = floatval(substr($val, 0, $p + 1 + $f));
      }
      return $val;
  }
?>
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
                <input type="text" autocomplete="off" class="form-control area_input" value="<?php echo $doc_area; ?>" disabled>
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
  <div class="panel row">
    <div class="panel-collapse in">
      <div class="panel-body text-sm">
        <!-- .nav-justified -->
        <section class="panel panel-default" style="margin-bottom:0;">
        <?php
          // echo "<pre>";
          // print_r($data_document);
          // echo "</pre>";
        ?>          
          <div class="panel-heading">
            <a href="#" class="btn btn-default dropdown-toggle" style="width:130px;" data-toggle="dropdown">
              Menu <b class="caret"></b>
            </a>
            <ul class="dropdown-menu animated fadeInLeft main-menu" style="padding:0;margin:0;">
              <span class="arrow top" style="left:10%;top:-7px;"></span>
              <li>
                <a href="#" class="question_option for_customer_question" data-areaid="for_customer" data-subject="<?php echo freetext('for_customer'); ?>"><?php echo freetext('for_customer'); ?></a>
              </li>
              <li>
                <a href="#" class="question_option kpi_question" data-areaid="kpi" data-subject="<?php echo freetext('kpi'); ?>"><?php echo freetext('kpi'); ?></a>
              </li>
              <li>
                <a href="#" class="question_option document_control" data-areaid="document_control" data-subject="<?php echo freetext('doc_control'); ?>"><?php echo freetext('doc_control'); ?></a>
              </li>
              <li>
                <a href="#" class="question_option policy" data-areaid="policy" data-subject="<?php echo freetext('policy'); ?>"><?php echo freetext('policy'); ?></a>
              </li>
              <li>
                <a href="#" class="question_option area" data-areaid="area" data-subject="<?php echo freetext('area'); ?>"><?php echo freetext('area'); ?></a>
              </li>
            </ul>
            <span class="h5 m-l-md header_subject"></span>
          </div>
          <div id="for_customer" class="panel-body result_body" style="display:none;">
            <section class="panel panel-default" style="margin-bottom:0;">
              <div class="panel-heading">
                ผลการตรวจ
              </div>
              <div class="panel-body">
              <?php
              if (!empty($data_document['question_list']['for_customer'])) {
                foreach ($data_document['question_list']['for_customer'] as $key => $section) {

                  $excellent_count  = 0;
                  $good_count       = 0;
                  $average_count    = 0;
                  $fair_count       = 0;
                  $poor_count       = 0;
                  $all_count        = 0;

                  if (array_key_exists('title', $section)) {
              ?>
                  <div class="row wrapper-sm h4" style="font-weight:bold">
                    <div class="col-sm-6"><?php echo $section['title'] ?></div>
                  </div>
              <?php
                    if (array_key_exists('sub_section', $section)) {
                      foreach ($section['sub_section'] as $sub_section) {
                        if (array_key_exists('question_list', $sub_section)) {
                          foreach ($sub_section['question_list'] as $question) {
                            $answer = $data_document['customer_answer'][$question['id']]['status'];
                            switch ($answer) {
                              case 'excellent':
                                $excellent_count++;
                                break;
                              case 'good':
                                $good_count++;
                                break;
                              case 'average':
                                $average_count++;
                                break;
                              case 'fair':
                                $fair_count++;
                                break;
                              case 'poor':
                                $poor_count++;
                                break;
                            }
                            $all_count++;

                          }
                        } else {

                          $answer = $data_document['customer_answer'][$sub_section['id']]['status'];
                          switch ($answer) {
                            case 'excellent':
                              $excellent_count++;
                              break;
                            case 'good':
                              $good_count++;
                              break;
                            case 'average':
                              $average_count++;
                              break;
                            case 'fair':
                              $fair_count++;
                              break;
                            case 'poor':
                              $poor_count++;
                              break;
                          }
                          $all_count++;
                        }
                      }
                    }  else if (array_key_exists('question_list', $section)) { 
                        foreach ($section['question_list'] as $question) {
                          $answer = $data_document['customer_answer'][$question['id']]['status'];
                          switch ($answer) {
                            case 'excellent':
                              $excellent_count++;
                              break;
                            case 'good':
                              $good_count++;
                              break;
                            case 'average':
                              $average_count++;
                              break;
                            case 'fair':
                              $fair_count++;
                              break;
                            case 'poor':
                              $poor_count++;
                              break;
                          }
                          $all_count++;
                        }
                    }

                  } else {
                    foreach ($section as $question) {
                      $answer = $data_document['customer_answer'][$question['id']]['status'];
                      switch ($answer) {
                        case 'excellent':
                          $excellent_count++;
                          break;
                        case 'good':
                          $good_count++;
                          break;
                        case 'average':
                          $average_count++;
                          break;
                        case 'fair':
                          $fair_count++;
                          break;
                        case 'poor':
                          $poor_count++;
                          break;
                      }
                      $all_count++;
                    }
                  }

                  $total = 100;
                  $excellent_per  = round((intval($excellent_count)/intval($all_count))*100, 2);
                  $good_per       = round((intval($good_count)/intval($all_count))*100, 2);
                  $average_per    = round((intval($average_count)/intval($all_count))*100, 2);
                  $fair_per       = round((intval($fair_count)/intval($all_count))*100, 2);
                  $poor_per       = round((intval($poor_count)/intval($all_count))*100, 2);

                  $total -= $excellent_per;
                  if ($average_per == 0 && $fair_per == 0 && $poor_per == 0) {
                    $good_per = $total;
                  } else {
                    $total -= $good_per;
                    if ($fair_per == 0 && $poor_per == 0) {
                      $average_per = $total;
                    } else {
                      $total -= $average_per;

                      if ($poor_per == 0) {
                        $fair_per = $total;
                      } else {
                        $total -= $fair_per;
                        $poor_per = $total;
                      }
                    }
                    
                  }

              ?>
                  <div class="row wrapper-sm h5">
                    <div class="col-sm-2">Excellent</div>
                    <div class="col-sm-2 text-center"><?php echo $excellent_count.' of '.$all_count; ?></div>
                    <div class="col-sm-2"><?php echo $excellent_per.'%'; ?></div>
                  </div>
                  <div class="row wrapper-sm h5">
                    <div class="col-sm-2">Good</div>
                    <div class="col-sm-2 text-center"><?php echo $good_count.' of '.$all_count; ?></div>
                    <div class="col-sm-2"><?php echo $good_per.'%'; ?></div>
                  </div>
                  <div class="row wrapper-sm h5">
                    <div class="col-sm-2">Average</div>
                    <div class="col-sm-2 text-center"><?php echo $average_count.' of '.$all_count; ?></div>
                    <div class="col-sm-2"><?php echo $average_per.'%'; ?></div>
                  </div>
                  <div class="row wrapper-sm h5">
                    <div class="col-sm-2">Fair</div>
                    <div class="col-sm-2 text-center"><?php echo $fair_count.' of '.$all_count; ?></div>
                    <div class="col-sm-2"><?php echo $fair_per.'%'; ?></div>
                  </div>
                  <div class="row wrapper-sm h5">
                    <div class="col-sm-2">Poor</div>
                    <div class="col-sm-2 text-center"><?php echo $poor_count.' of '.$all_count; ?></div>
                    <div class="col-sm-2"><?php echo $poor_per.'%'; ?></div>
                  </div>
            <?php
                }
              }
              ?>
              </div>
            </section>
          </div>
          <div id="kpi" class="panel-body result_body" style="display:none;">
            <section class="panel panel-default" style="margin-bottom:0;">
              <div class="panel-heading">
                ผลการตรวจ
              </div>
              <div class="panel-body">
              <?php
              if (!empty($data_document['question_list']['kpi'])) {
              ?>
                <div class="row wrapper-sm h5" style="font-weight:bold;">
                  <div class="col-sm-6"></div>
                  <div class="col-sm-2 text-center">คะแนนเต็ม</div>
                  <div class="col-sm-2 text-center">คะแนนที่ได้รับ</div>
                  <div class="col-sm-2 text-center">คะแนนเฉลี่ย</div>
                </div>
              <?php
                foreach ($data_document['question_list']['kpi'] as $key => $section) {

                  $actual_score = 0;
                  $count_answer = 0;
              ?>
                  <div class="row wrapper-sm h5">
              <?php
                  if (array_key_exists('title', $section)) {
              ?>
                    <div class="col-sm-6"><?php echo $section['title'] ?></div>
                    <div class="col-sm-2 text-center"><?php echo $section['score']; ?></div>
              <?php
                    if (array_key_exists('sub_section', $section)) {
                      foreach ($section['sub_section'] as $sub_section) {
                        if (array_key_exists('question_list', $sub_section)) {
                          foreach ($sub_section['question_list'] as $question) {
                            $actual_score += intval($data_document['KPI_answer'][$question['id']]);
                            $count_answer++;
                          }
                        } else {
                          $actual_score += intval($data_document['KPI_answer'][$sub_section['id']]);
                          $count_answer++;
                        }
                      }
                    }  else if (array_key_exists('question_list', $section)) { 
                        foreach ($section['question_list'] as $question) {
                          $actual_score += intval($data_document['KPI_answer'][$question['id']]);
                          $count_answer++;
                        }
                    }

                  } else {
                    foreach ($section as $question) {
                        $actual_score += intval($data_document['KPI_answer'][$question['id']]);
                        $count_answer++;
                    }
                  }
              ?>
                    <div class="col-sm-2 text-center"><?php echo $actual_score; ?></div>
                    <div class="col-sm-2 text-center"><?php echo round(($actual_score/$count_answer), 1); ?></div>
                  </div>
              <?php
                }
              }
              ?>
              </div>
            </section>
          </div>
          <div id="document_control" class="panel-body result_body" style="display:none;">
            <section class="panel panel-default" style="margin-bottom:0;">
              <div class="panel-heading">
                ผลการตรวจ
              </div>
              <div class="panel-body">
              <?php
              if (!empty($data_document['question_list']['document_control'])) {
                foreach ($data_document['question_list']['document_control'] as $key => $section) {
              ?>
                <div style="border-bottom: 1px solid #d4d4d4; padding-bottom:15px;">
              <?php
                  $not_pass_q_arr = array();
                  $not_pass_arr   = array();
                  $pass_count     = 0;
                  $not_pass_count = 0;
                  $all_count      = 0;

                  if (array_key_exists('title', $section)) {
              ?>
                    <div class="row h4 m-t-md m-b-md" style="font-weight:bold">
                      <div class="col-sm-6"><?php echo $section['title'] ?></div>
                    </div>
              <?php
                    if (array_key_exists('sub_section', $section)) {
                      foreach ($section['sub_section'] as $sub_section) {
                        if (array_key_exists('question_list', $sub_section)) {
                          foreach ($sub_section['question_list'] as $question) {
                            $answer = $data_document['document_control_answer'][$question['id']]['status'];
                            if ($answer == 'not_pass') {
                              $not_pass_q_arr[$question['id']] = $question;
                              $not_pass_arr[$question['id']] = $data_document['document_control_answer'][$question['id']];
                              $not_pass_count++;
                            } else {
                              $pass_count++;
                            }

                            $all_count++;
                          }
                        } else {
                          $answer = $data_document['document_control_answer'][$sub_section['id']]['status'];
                          if ($answer == 'not_pass') {
                            $not_pass_q_arr[$question['id']] = $sub_section;
                            $not_pass_arr[$question['id']] = $data_document['document_control_answer'][$sub_section['id']];
                            $not_pass_count++;
                          } else {
                            $pass_count++;
                          }

                          $all_count++;
                        }
                      }
                    }  else if (array_key_exists('question_list', $section)) { 
                        foreach ($section['question_list'] as $question) {
                            $answer = $data_document['document_control_answer'][$question['id']]['status'];
                            if ($answer == 'not_pass') {
                              $not_pass_q_arr[$question['id']] = $question;
                              $not_pass_arr[$question['id']] = $data_document['document_control_answer'][$question['id']];
                              $not_pass_count++;
                            } else {
                              $pass_count++;
                            }

                            $all_count++;
                        }
                    }

                  } else {
                    foreach ($section as $question) {
                        $answer = $data_document['document_control_answer'][$question['id']]['status'];
                        if ($answer == 'not_pass') {
                          $not_pass_q_arr[$question['id']] = $question;
                          $not_pass_arr[$question['id']] = $data_document['document_control_answer'][$question['id']];
                          $not_pass_count++;
                        } else {
                          $pass_count++;
                        }

                        $all_count++;
                    }
                  }

                  $total = 100;
                  $pass_per = round((intval($pass_count)/intval($all_count))*100, 2);
                  $not_pass_per = $total - $pass_per;
              ?>
                  <div class="row h4 text-success">
                    <div class="col-sm-2">ผ่าน</div>
                    <div class="col-sm-2"><?php echo $pass_count.' of '.$all_count; ?></div>
                    <div class="col-sm-2"><?php echo $pass_per.'%'; ?></div>
                  </div>
                  <div class="row h4 text-danger m-t-md">
                    <div class="col-sm-2">ไม่ผ่าน</div>
                    <div class="col-sm-2"><?php echo $not_pass_count.' of '.$all_count; ?></div>
                    <div class="col-sm-2"><?php echo $not_pass_per.'%'; ?></div>
                  </div>
              <?php
                  if (!empty($not_pass_arr)) {
              ?>
                  <div class="m-t-sm">
                  <?php
                    foreach ($not_pass_arr as $not_pass_question_id => $not_pass_ans) {
                  ?>
                      <div style="padding:10px 15px 0 15px;">
                        <span class="h5"><span style="font-weight:bold;"><?php echo $not_pass_q_arr[$not_pass_question_id]['title']; ?></span>
                          <h6 style="font-weight:bold;">Improvement required</h6>
                          <div class="m-l-md">
                              <?php if (!empty($not_pass_ans['remark'])) { echo str_replace("\n", '<br>', $not_pass_ans['remark']); } else { echo '-'; } ?>
                          </div>
                        </span>
                      </div>
                  <?php
                    }
                  ?>
              <?php
                  }
              ?>
                </div>
              <?php
                }
              }
              ?>
              </div>
            </section>
          </div>
          <div id="policy" class="panel-body result_body" style="display:none;">
            <section class="panel panel-default" style="margin-bottom:0;">
              <div class="panel-heading">
                ผลการตรวจ
              </div>
              <div class="panel-body">
              <?php
              if (!empty($data_document['question_list']['policy'])) {
                foreach ($data_document['question_list']['policy'] as $question_id => $section) {
              ?>
                <div style="border-bottom: 1px solid #d4d4d4; padding-bottom:15px;">
              <?php
                  $not_pass_q_arr = array();
                  $not_pass_arr   = array();
                  $pass_count     = 0;
                  $not_pass_count = 0;
                  $all_count      = 0;

                  if (array_key_exists('title', $section)) {
              ?>
                    <div class="row h4 m-t-md m-b-md" style="font-weight:bold">
                      <div class="col-sm-6"><?php echo $section['title'] ?></div>
                    </div>
              <?php
                    if (array_key_exists('sub_section', $section)) {
                      foreach ($section['sub_section'] as $sub_section) {
                        if (array_key_exists('question_list', $sub_section)) {
                          foreach ($sub_section['question_list'] as $question) {
                            $answer = $data_document['policy_answer'][$question['id']]['status'];
                            if ($answer == 'not_pass') {
                              $not_pass_q_arr[$question['id']] = $question;
                              $not_pass_arr[$question['id']] = $data_document['policy_answer'][$question['id']];
                              $not_pass_count++;
                            } else {
                              $pass_count++;
                            }

                            $all_count++;
                          }
                        } else {
                          $answer = $data_document['policy_answer'][$sub_section['id']]['status'];
                          if ($answer == 'not_pass') {
                            $not_pass_q_arr[$question['id']] = $sub_section;
                            $not_pass_arr[$question['id']] = $data_document['policy_answer'][$sub_section['id']];
                            $not_pass_count++;
                          } else {
                            $pass_count++;
                          }

                          $all_count++;
                        }
                      }
                    }  else if (array_key_exists('question_list', $section)) { 
                        foreach ($section['question_list'] as $question) {
                            $answer = $data_document['policy_answer'][$question['id']]['status'];
                            if ($answer == 'not_pass') {
                              $not_pass_q_arr[$question['id']] = $question;
                              $not_pass_arr[$question['id']] = $data_document['policy_answer'][$question['id']];
                              $not_pass_count++;
                            } else {
                              $pass_count++;
                            }

                            $all_count++;
                        }
                    }

                  } else {
                    foreach ($section as $question) {
                        $answer = $data_document['policy_answer'][$question['id']]['status'];
                        if ($answer == 'not_pass') {
                          $not_pass_q_arr[$question['id']] = $question;
                          $not_pass_arr[$question['id']] = $data_document['policy_answer'][$question['id']];
                          $not_pass_count++;
                        } else {
                          $pass_count++;
                        }

                        $all_count++;
                    }
                  }

                  $total = 100;
                  $pass_per = round((intval($pass_count)/intval($all_count))*100, 2);
                  $not_pass_per = $total - $pass_per;
              ?>
                  <div class="row h4 text-success">
                    <div class="col-sm-2">ผ่าน</div>
                    <div class="col-sm-2"><?php echo $pass_count.' of '.$all_count; ?></div>
                    <div class="col-sm-2"><?php echo $pass_per.'%'; ?></div>
                  </div>
                  <div class="row h4 text-danger m-t-md">
                    <div class="col-sm-2">ไม่ผ่าน</div>
                    <div class="col-sm-2"><?php echo $not_pass_count.' of '.$all_count; ?></div>
                    <div class="col-sm-2"><?php echo $not_pass_per.'%'; ?></div>
                  </div>
              <?php
                  if (!empty($not_pass_arr)) {
              ?>
                  <div class="m-t-sm">
                  <?php
                    foreach ($not_pass_arr as $not_pass_question_id => $not_pass_ans) {
                  ?>
                      <div style="padding:10px 15px 0 15px;">
                        <span class="h5"><span style="font-weight:bold;"><?php echo $not_pass_q_arr[$not_pass_question_id]['title']; ?></span>
                          <h6 style="font-weight:bold;">Improvement required</h6>
                          <div class="m-l-md">
                              <?php if (!empty($not_pass_ans['remark'])) { echo str_replace("\n", '<br>', $not_pass_ans['remark']); } else { echo '-'; } ?>
                          </div>
                        </span>
                      </div>
                  <?php
                    }
                  ?>
                  </div>
              <?php
                  }
              ?>
                </div>
              <?php
                }
              }
              ?>
              </div>
            </section>
          </div>
          <div id="area" class="panel-body result_body">
            <section class="panel panel-default" style="margin-bottom:0;">
              <div class="panel-heading">
                ผลการตรวจ
              </div>
              <div class="panel-body">
              <?php              
                $total = 100;
                $pass_per = round((intval($data_document['all_pass'])/intval($data_document['all_area_question']))*100, 2);
                $not_pass_per = $total - $pass_per;
              ?>
                <div class="row h4 text-success">
                  <div class="col-sm-2">ผ่าน</div>
                  <div class="col-sm-2"><?php echo $data_document['all_pass'].' of '.$data_document['all_area_question']; ?></div>
                  <div class="col-sm-2"><?php echo $pass_per.'%'; ?></div>
                </div>
                <div class="row h4 text-danger m-t-md">
                  <div class="col-sm-2">ไม่ผ่าน</div>
                  <div class="col-sm-2"><?php echo $data_document['all_not_pass'].' of '.$data_document['all_area_question']; ?></div>
                  <div class="col-sm-2"><?php echo $not_pass_per.'%'; ?></div>
                </div>
              </div>
            </section>
            <section class="panel panel-default" style="margin-bottom:0;">
              <div class="panel-heading">
                ความคิดเห็น
              </div>
              <div class="panel-body">
                <div class="wrapper">
                  <?php if (!empty($data_document['comment'])) { echo str_replace("\n", '<br>', $data_document['comment']); } else { echo '-'; } ?>
                </div>
              </div>
            </section>
            <?php
              if (!empty($data_document['area_list'])) {
                foreach ($data_document['area_list'] as $key => $area) {
                  // echo "<pre>";
                  // print_r($area);
                  // echo "</pre>";
                  // echo "<pre>";
                  // print_r($data_document['question_list']);
                  // echo "</pre>";
            ?>
            <section class="panel panel-default" style="margin-bottom:0;">
              <div class="panel-heading">
                <?php echo $area['building'].' > '.$area['floor'].' > '.$area['industry_room_description']; if (!empty($area['area_name'])) { echo '['.$area['area_name'].']'; } ?>
              </div>
              <div class="panel-body">
              <?php
                foreach ($area['answer'] as $question_id => $answer) {
                  if ($answer['status'] == 'not_pass') {
              ?>
                <div class="wrapper" style="border-bottom: 1px solid #d4d4d4">
                  <span class="h5"><span style="font-weight:bold;">Question <?php if (!empty($data_document['question_list'][$area['id']][$question_id]['sequence_index'])) { echo $data_document['question_list'][$area['id']][$question_id]['sequence_index']; } echo '</span> : '.$data_document['question_list'][$area['id']][$question_id]['title']; ?></span>
                  <h6 style="font-weight:bold;">Improvement required</h6>
                  <div class="wrapper-sm">
                      <?php if (!empty($answer['remark'])) { echo str_replace("\n", '<br>', $answer['remark']); } else { echo '-'; } ?>
                  </div>
              <?php
                  if (!empty($answer['images'])) {
              ?>
                  <div id="carousel_<?php echo $question_id; ?>" class="carousel slide carousel-fit" data-ride="carousel">

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                      <?php
                        $image_count = 0;
                        foreach ($answer['images'] as $image) {
                          $active = "";
                          if ($image_count == 0) {
                            $active = " active";
                          }
                      ?>
                        <div class="item<?php echo $active; ?>">
                          <img style="max-width:450px;padding:20px 10px 20px 10px;" src="<?php echo site_url($image); ?>" alt="">
                        </div>
                      <?php
                          $image_count++;
                        }
                      ?>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel_<?php echo $question_id; ?>" data-slide="prev" style="font-size: 3em;color: black;">
                      <i class="fa fa-chevron-circle-left"></i>
                    </a>
                    <a class="right carousel-control" href="#carousel_<?php echo $question_id; ?>" data-slide="next" style="font-size: 3em;color: black; margin-right:15px;">
                      <i class="fa fa-chevron-circle-right"></i>
                    </a>
                  </div>
              <?php
                  }
              ?>
                </div>
              <?php
                  }
                }
              ?>
              </div>
            </section>
            <?php
                }
              }
            ?>
          </div>
        </section>
      </div>
    </div>
  </div>

</div><!-- end : class div_detail -->

</section><!-- end : scrollable padder -->
</section><!-- end : class vbox -->
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>















