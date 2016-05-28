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
              <li class="area">
                <a href="#" class="question_option for_customer_question" data-area="0" data-areaid="for_customer" data-subject="<?php echo freetext('for_customer'); ?>"><?php echo freetext('for_customer'); ?></a>
              </li>
              <li class="area">
                <a href="#" class="question_option kpi_question" data-area="0" data-areaid="kpi" data-subject="<?php echo freetext('kpi'); ?>"><?php echo freetext('kpi'); ?></a>
              </li>
              <li class="area">
                <a href="#" class="question_option document_control" data-area="0" data-areaid="document_control" data-subject="<?php echo freetext('doc_control'); ?>"><?php echo freetext('doc_control'); ?></a>
              </li>
              <li class="area">
                <a href="#" class="question_option policy_question" data-area="0" data-areaid="policy" data-subject="<?php echo freetext('policy'); ?>"><?php echo freetext('policy'); ?></a>
              </li>
              <li class="divider" style="height:2px;margin:0;"></li>
            <?php
              if (!empty($data_document['area_list'])) {
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
                <li class="building_li<?php echo $building_active;?>">
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
                          $area_active = "";

                          $area_type = $value['industry_room_description'];
                          $status = "";
                          // if ($value['status'] == "complete") {
                          //   $status = "<i class='fa fa-check text-success'></i>";
                          // }
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
                <a href="#" class="btn btn-default prev_btn" disabled><i class="fa fa-angle-left"></i>&nbsp;Prev</a>
                <a href="#" class="btn btn-default next_btn">Next&nbsp;<i class="fa fa-angle-right"></i></a>
            </div>
          </div>
          <div class="panel-body">
            <form role="form" id="save_form" action="<?php echo site_url('__ps_quality_assurance/survey_save/' ) ?>" method="POST">
              <input type="hidden" name="doc_id" value="<?php echo  $track_doc_id ;?>"/>
              <input type="hidden" name="project_id" value="<?php echo  $project_id ;?>"/>
              <input type="hidden" name="area" value="<?php echo  $area ;?>"/>
              <!-- <div class="col-sm-12"> -->
              <section class="panel panel-default">
                <?php
                  if (!empty($data_document['question_list'])) {
                    $count = 0;
                   
                    foreach ($data_document['question_list'] as $key => $type) {
                
                      $display = 'none';
                      if ($count == 0) {
                        $display = 'table';
                      }
                ?>
                      <table id="<?php echo "question-table-".$key; ?>" data-index="<?php echo $count; ?>" class="table question-table" style="display:<?php echo $display; ?>;">
                        <?php
                          if ($key != "kpi" && $key != "for_customer" && $key != "document_control" && $key != "policy") {
                        ?>
                        <thead>
                          <tr class="back-color-gray"> 
                            <th style="width:30%" rowspan="2"><?php echo freetext('question'); ?></th>
                        <?php
                            if (!empty($answer_list['area_answer'][$key]['answer_list'])) {
                              foreach ($answer_list['area_answer'][$key]['answer_list'] as $month_key => $month_answer) {
                                $month_parts = explode('-', $month_key);
                                $month       = $month_parts[1];
                        ?>
                                <th class="text-center" colspan="4"  style="width:10%;border: 1px solid #d4d4d4;"><?php echo $month; ?></th>
                        <?php
                              }
                            }
                        ?>
                          </tr> 
                          <tr class="back-color-gray">
                        <?php
                            if (!empty($answer_list['area_answer'][$key]['answer_list'])) {
                              foreach ($answer_list['area_answer'][$key]['answer_list'] as $month_key => $month_answer) {
                        ?>
                                <th class="text-center" style="border: 1px solid #d4d4d4;"><?php echo freetext('result'); ?></th>
                                <th class="text-center" style="border: 1px solid #d4d4d4;"><?php echo freetext('weight'); ?></th>
                                <th class="text-center" style="border: 1px solid #d4d4d4;"><?php echo freetext('remark'); ?></th>
                                <th class="text-center" style="border: 1px solid #d4d4d4;"><?php echo freetext('image'); ?></th>
                        <?php
                              }
                            }
                        ?>                            
                          </tr>
                        </thead>
                        <tbody class="data_list_asset">  
                        <?php
                            foreach ($type as $question) {
                        ?>
                            <tr>
                                <td><?php echo $question['title']; ?></td>
                        <?php
                            if (!empty($answer_list['area_answer'][$key]['answer_list'])) {
                              foreach ($answer_list['area_answer'][$key]['answer_list'] as $month_key => $month_answer) {
                                if (!empty($month_answer)) {
                                  foreach ($month_answer as $question_id => $answer) {
                                    if ($question_id == $question['id']) {
                                      $disable_image_view = ' disabled';
                                      $images = "";
                                      $images_count = 0;
                                      if (array_key_exists('images', $answer)) {
                                        $images_list = $answer['images'];
                                        $images_count = sizeof($answer['images']);

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

                                      if (!array_key_exists('status', $answer)) {
                                        $answer['status'] = "";
                                      }
                          ?>
                                      <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo freetext($answer['status']); ?></td>
                                      <td class="text-center"><?php echo $answer['weight']; ?></td>
                                      <td class="text-center">
                                        <?php
                                          if ($answer['status'] == 'not_pass' && !empty($answer['remark'])) {
                                        ?>
                                            <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo str_replace(' ', '_', $month_key).'_'.$question['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                            <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                              <i class="fa fa-exclamation-circle text-danger h5"></i>
                                            </a>
                                        <?php
                                          }
                                        ?>
                                      </td>
                                      <td class="text-center" style="border-right: 1px solid #d4d4d4;">
                                        <input type="hidden" class="question_<?php echo $key; ?>_<?php echo str_replace(' ', '_', $month_key).'_'.$question['id']; ?>_images" value="<?php echo $images; ?>" >
                                        <a href="#" class="btn btn-default btn-sm view_image" style="border-radius:5px;" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" <?php echo $disable_image_view; ?>><i class="fa fa-picture-o"></i> (<?php echo $images_count; ?>)</a>
                                      </td>
                          <?php
                                    }
                                  } 
                                }else {
                          ?>
                                      <td style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td class="text-center"  style="border-right: 1px solid #d4d4d4;">
                                        <a href="#" class="btn btn-default btn-sm view_image" style="border-radius:5px;" disabled><i class="fa fa-picture-o"></i> (0)</a>
                                      </td>
                          <?php
                                }
                              }
                            }
                        ?>    
                            </tr>
                        <?php
                            }
                        ?>                                    
                        </tbody>
                        <?php
                          } else if ($key == 'kpi') {
                        ?>
                        <thead>
                            <tr class="back-color-gray"> 
                              <th style="width:80%"><?php echo freetext('question'); ?></th>
                              <th style="width:10%" class="text-center"><?php echo freetext('score'); ?></th>
                        <?php
                            if (!empty($answer_list['KPI_answer'])) {
                              foreach ($answer_list['KPI_answer'] as $month_key => $month_answer) {
                                $month_parts = explode('-', $month_key);
                                $month       = $month_parts[1];
                        ?>
                                <th class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $month; ?></th>                                
                        <?php
                              }
                            }
                        ?>                                       
                            </tr>
                        </thead>
                        <tbody class="data_list_asset"> 
                        <?php
                            $total = array();
                            foreach ($type as $section) {
                              if (array_key_exists('title', $section)) {
                        ?>
                                <tr>
                                  <td><?php if ($section['sequence_index'] != 0) { echo $section['sequence_index'].' '; }  echo $section['title']; ?></td>
                                  <td class="text-center"><u><?php if (!empty($section['score'])) echo $section['score']; ?></u></td>
                        <?php
                                if (!empty($answer_list['KPI_answer'])) {
                                  foreach ($answer_list['KPI_answer'] as $month_key => $month_answer) {
                        ?>
                                  <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                  }
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
                                          <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } echo $sub_section['title']; ?></td>
                                          <td class="text-center"><u><?php if (!empty($sub_section['score'])) echo $sub_section['score']; ?></u></td>
                        <?php
                                      if (!empty($answer_list['KPI_answer'])) {
                                        foreach ($answer_list['KPI_answer'] as $month_key => $month_answer) {
                        ?>
                                          <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                        }
                                      }
                        ?>
                                      </tr>
                        <?php
                                      foreach ($sub_section['question_list'] as $question) {
                        ?>
                                      <tr>
                                        <td style="padding-left:60px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } echo $question['title']; ?></td>
                                        <td class="text-center"><?php echo $question['score']; ?></td>
                        <?php
                                      if (!empty($answer_list['KPI_answer'])) {
                                        foreach ($answer_list['KPI_answer'] as $month_key => $month_answer) {
                                          if (!empty($month_answer)) {
                                            foreach ($month_answer as $question_id => $answer) {
                                              if ($question_id == $question['id']) {
                                                if (!array_key_exists($month_key, $total)) {
                                                  $total[$month_key] = 0;
                                                }

                                                $total[$month_key] += intval($answer);
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $answer; ?></td>
                        <?php
                                              }
                                            }
                                          } else {
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                          }
                                        }
                                      }
                        ?>               
                                      </tr>
                        <?php
                                      }
                                    } else {

                        ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } echo $sub_section['title']; ?></td>
                                        <td class="text-center"><?php echo $sub_section['score']; ?></td>
                        <?php
                                      if (!empty($answer_list['KPI_answer'])) {
                                        foreach ($answer_list['KPI_answer'] as $month_key => $month_answer) {
                                          if (!empty($month_answer)) {
                                            foreach ($month_answer as $question_id => $answer) {
                                              if ($question_id == $sub_section['id']) {
                                                if (!array_key_exists($month_key, $total)) {
                                                  $total[$month_key] = 0;
                                                }

                                                $total[$month_key] += intval($answer);
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $answer; ?></td>
                        <?php
                                              }
                                            }
                                          } else {
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                          }
                                        }
                                      }
                        ?>               
                                      </tr>
                      <?php
                                    }
                                  }
                                } else if (array_key_exists('question_list', $section)) {
                                  foreach ($section['question_list'] as $question) {
                          ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } echo $question['title']; ?></td>
                                        <td class="text-center"><?php echo $question['score']; ?></td>
                        <?php
                                      if (!empty($answer_list['KPI_answer'])) {
                                        foreach ($answer_list['KPI_answer'] as $month_key => $month_answer) {
                                          if (!empty($month_answer)) {
                                            foreach ($month_answer as $question_id => $answer) {
                                              if ($question_id == $question['id']) {
                                                if (!array_key_exists($month_key, $total)) {
                                                  $total[$month_key] = 0;
                                                }

                                                $total[$month_key] += intval($answer);
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $answer; ?></td>
                        <?php
                                              }
                                            }
                                          } else {
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                          }
                                        }
                                      }
                        ?>               
                                      </tr>
                        <?php 
                                  }
                                }
                              } else {
                                  foreach ($section as $question) {
                          ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } echo $question['title']; ?></td>
                                        <td class="text-center"><?php echo $question['score']; ?></td>
                        <?php
                                      if (!empty($answer_list['KPI_answer'])) {
                                        foreach ($answer_list['KPI_answer'] as $month_key => $month_answer) {
                                          if (!empty($month_answer)) {
                                            foreach ($month_answer as $question_id => $answer) {
                                              if ($question_id == $question['id']) {
                                                if (!array_key_exists($month_key, $total)) {
                                                  $total[$month_key] = 0;
                                                }

                                                $total[$month_key] += intval($answer);
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $answer; ?></td>
                        <?php
                                              }
                                            }
                                          } else {
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                          }
                                        }
                                      }
                        ?>               
                                      </tr>
                        <?php 
                                  }
                              }
                            }
                        ?>
                        <tr>
                          <td>&nbsp;</td>
                          <td class="text-center"><u>Total</u></td>
                        <?php
                          if (!empty($answer_list['KPI_answer'])) {
                            foreach ($answer_list['KPI_answer'] as $month_key => $month_answer) {
                              if (array_key_exists($month_key, $total)) {
                        ?>
                                  <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $total[$month_key]; ?></td>
                        <?php
                              } else {
                        ?>
                                  <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                              }
                            }
                          }
                        ?>       
                        </tr>
                        </tbody>
                        <?php
                          } else if ($key == 'for_customer') {
                        ?>
                        <thead>
                            <tr class="back-color-gray"> 
                              <th style="width:80%"><?php echo freetext('question'); ?></th>
                        <?php
                            if (!empty($answer_list['customer_answer'])) {
                              foreach ($answer_list['customer_answer'] as $month_key => $month_answer) {
                                $month_parts = explode('-', $month_key);
                                $month       = $month_parts[1];
                        ?>
                                <th class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $month; ?></th>                                
                        <?php
                              }
                            }
                        ?>                                       
                            </tr>
                        </thead>
                        <tbody class="data_list_asset"> 
                        <?php
                            foreach ($type as $section) {
                              if (array_key_exists('title', $section)) {
                        ?>
                                <tr>
                                  <td><?php if ($section['sequence_index'] != 0) { echo $section['sequence_index'].' '; }  echo $section['title']; ?></td>
                        <?php
                                if (!empty($answer_list['customer_answer'])) {
                                  foreach ($answer_list['customer_answer'] as $month_key => $month_answer) {
                        ?>
                                  <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                  }
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
                                        <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } echo $sub_section['title']; ?></td>
                        <?php
                                    if (!empty($answer_list['customer_answer'])) {
                                      foreach ($answer_list['customer_answer'] as $month_key => $month_answer) {
                        ?>
                                        <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                      }
                                    }
                        ?>
                                    </tr>
                        <?php
                                      foreach ($sub_section['question_list'] as $question) {
                        ?>
                                      <tr>
                                        <td style="padding-left:60px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } echo $question['title']; ?></td>
                        <?php
                                        if (!empty($answer_list['customer_answer'])) {
                                          foreach ($answer_list['customer_answer'] as $month_key => $month_answer) {
                                            if (!empty($month_answer)) {
                                              foreach ($month_answer as $question_id => $answer) {
                                                if ($question_id == $question['id']) {
                                                  if (!array_key_exists('status', $answer)) {
                                                    $answer['status'] = "";
                                                  }
                        ?>
                                                  <td class="text-left" style="border-left: 1px solid #d4d4d4;">
                                                    <?php echo freetext($answer['status']); ?>
                                                    <?php
                                                      if (!empty($answer['remark'])) {
                                                    ?>
                                                    &nbsp;
                                                    <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo str_replace(' ', '_', $month_key).'_'.$question['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                                    <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                                      <i class="fa fa-exclamation-circle text-danger h5"></i>
                                                    </a>
                                                    <?php
                                                      }
                                                    ?>
                                                  </td>
                        <?php
                                                }
                                              }
                                            } else {
                        ?>
                                              <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                            }
                                          }
                                        }
                        ?>               
                                      </tr>
                        <?php
                                      }
                                    } else {
                      ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } echo $sub_section['title']; ?></td>
                        <?php
                                        if (!empty($answer_list['customer_answer'])) {
                                          foreach ($answer_list['customer_answer'] as $month_key => $month_answer) {
                                            if (!empty($month_answer)) {
                                              foreach ($month_answer as $question_id => $answer) {
                                                if ($question_id == $sub_section['id']) {
                                                  if (!array_key_exists('status', $answer)) {
                                                    $answer['status'] = "";
                                                  }
                        ?>
                                                  <td class="text-left" style="border-left: 1px solid #d4d4d4;">
                                                    <?php echo freetext($answer['status']); ?>
                                                    <?php
                                                      if (!empty($answer['remark'])) {
                                                    ?>
                                                    &nbsp;
                                                    <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo $sub_section['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                                    <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $sub_section['id']; ?>" data-area="<?php echo $key; ?>" > 
                                                      <i class="fa fa-exclamation-circle text-danger h5"></i>
                                                    </a>
                                                    <?php
                                                      }
                                                    ?>
                                                  </td>
                        <?php
                                                }
                                              }
                                            } else {
                        ?>
                                              <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                            }
                                          }
                                        }
                        ?>               
                                      </tr>
                      <?php
                                    }
                                  }
                                } else if (array_key_exists('question_list', $section)) {
                                  foreach ($section['question_list'] as $question) {
                                      
                          ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } echo $question['title']; ?></td>
                        <?php
                                        if (!empty($answer_list['customer_answer'])) {
                                          foreach ($answer_list['customer_answer'] as $month_key => $month_answer) {
                                            if (!empty($month_answer)) {
                                              foreach ($month_answer as $question_id => $answer) {
                                                if ($question_id == $question['id']) {
                                                  if (!array_key_exists('status', $answer)) {
                                                    $answer['status'] = "";
                                                  }
                        ?>
                                                  <td class="text-left" style="border-left: 1px solid #d4d4d4;">
                                                    <?php echo freetext($answer['status']); ?>
                                                    <?php
                                                      if (!empty($answer['remark'])) {
                                                    ?>
                                                    &nbsp;
                                                    <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo str_replace(' ', '_', $month_key).'_'.$question['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                                    <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                                      <i class="fa fa-exclamation-circle text-danger h5"></i>
                                                    </a>
                                                    <?php
                                                      }
                                                    ?>
                                                  </td>
                        <?php
                                                }
                                              }
                                            } else {
                        ?>
                                              <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                            }
                                          }
                                        }
                        ?>               
                                      </tr>
                        <?php 
                                  }
                                }
                              } else {
                                  foreach ($section as $question) {
                          ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } echo $question['title']; ?></td>
                        <?php
                                        if (!empty($answer_list['customer_answer'])) {
                                          foreach ($answer_list['customer_answer'] as $month_key => $month_answer) {
                                            if (!empty($month_answer)) {
                                              foreach ($month_answer as $question_id => $answer) {
                                                if ($question_id == $question['id']) {
                                                  if (!array_key_exists('status', $answer)) {
                                                    $answer['status'] = "";
                                                  }
                        ?>
                                                  <td class="text-left" style="border-left: 1px solid #d4d4d4;">
                                                    <?php echo freetext($answer['status']); ?>
                                                    <?php
                                                      if (!empty($answer['remark'])) {
                                                    ?>
                                                    &nbsp;
                                                    <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo str_replace(' ', '_', $month_key).'_'.$question['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                                    <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                                      <i class="fa fa-exclamation-circle text-danger h5"></i>
                                                    </a>
                                                    <?php
                                                      }
                                                    ?>
                                                  </td>
                        <?php
                                                }
                                              }
                                            } else {
                        ?>
                                              <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                            }
                                          }
                                        }
                        ?>               
                                      </tr>
                        <?php 
                                  }
                              }
                            }
                        ?>
                            <tr>
                              <td colspan="7" style="padding:20px;">
                                <div class="signature_area row m-t-md">
                                  <img src="<?php if (!empty($signature) && !empty($signature['signature'])) { echo site_url($signature['signature']);  } ?>" style="max-width:250px; float:right;" class="signature_img" >
                                </div>
                              </td>
                            </tr>
                        </tbody>
                        <?php
                          } else if ($key == 'document_control') {
                        ?>
                        <thead>
                          <tr class="back-color-gray"> 
                            <th style="width:30%" rowspan="2"><?php echo freetext('question'); ?></th>
                        <?php
                            if (!empty($answer_list['document_answer'])) {
                              foreach ($answer_list['document_answer'] as $month_key => $month_answer) {
                                $month_parts = explode('-', $month_key);
                                $month       = $month_parts[1];
                        ?>
                                <th class="text-center" colspan="3"  style="width:10%;border: 1px solid #d4d4d4;"><?php echo $month; ?></th>
                        <?php
                              }
                            }
                        ?>
                          </tr> 
                          <tr class="back-color-gray">
                        <?php
                            if (!empty($answer_list['document_answer'])) {
                              foreach ($answer_list['document_answer'] as $month_key => $month_answer) {
                        ?>
                                <th class="text-center" style="border: 1px solid #d4d4d4;"><?php echo freetext('result'); ?></th>
                                <th class="text-center" style="border: 1px solid #d4d4d4;"><?php echo freetext('weight'); ?></th>
                                <th class="text-center" style="border: 1px solid #d4d4d4;"><?php echo freetext('remark'); ?></th>
                        <?php
                              }
                            }
                        ?>                            
                          </tr>
                        </thead>
                        <tbody class="data_list_asset"> 
                        <?php
                            foreach ($type as $section) {
                              if (array_key_exists('title', $section)) {
                        ?>
                                <tr>
                                  <td><?php if ($section['sequence_index'] != 0) { echo $section['sequence_index'].' '; }  echo $section['title']; ?></td>
                        <?php
                                if (!empty($answer_list['document_answer'])) {
                                  foreach ($answer_list['document_answer'] as $month_key => $month_answer) {
                        ?>
                                  <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                  <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                  <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                  }
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
                                        <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } echo $sub_section['title']; ?></td>
                        <?php
                                      if (!empty($answer_list['document_answer'])) {
                                        foreach ($answer_list['document_answer'] as $month_key => $month_answer) {
                        ?>
                                        <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                        <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                        <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                        }
                                      }
                        ?>
                                      </tr>
                        <?php
                                      foreach ($sub_section['question_list'] as $question) {
                        ?>
                                      <tr>
                                        <td style="padding-left:60px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } echo $question['title']; ?></td>
                        <?php
                                      if (!empty($answer_list['document_answer'])) {
                                        foreach ($answer_list['document_answer'] as $month_key => $month_answer) {
                                          if (!empty($month_answer)) {
                                            foreach ($month_answer as $question_id => $answer) {
                                              if ($question_id == $question['id']) {
                                                if (!array_key_exists('status', $answer)) {
                                                  $answer['status'] = "";
                                                }
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo freetext($answer['status']); ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $answer['weight']; ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;">
                                                  <?php
                                                    if (!empty($answer['remark'])) {
                                                  ?>
                                                      <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo str_replace(' ', '_', $month_key).'_'.$question['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                                      <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                                        <i class="fa fa-exclamation-circle text-danger h5"></i>
                                                      </a>
                                                  <?php
                                                    }
                                                  ?>
                                                </td>
                        <?php
                                              }
                                            }

                                          } else {
                        ?>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                          }
                                        }
                                      }
                        ?>               
                                      </tr>
                        <?php
                                      }
                                    } else {
                        ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } echo $sub_section['title']; ?></td>
                        <?php
                                      if (!empty($answer_list['document_answer'])) {
                                        foreach ($answer_list['document_answer'] as $month_key => $month_answer) {
                                          if (!empty($month_answer)) {
                                            foreach ($month_answer as $question_id => $answer) {
                                              if ($question_id == $sub_section['id']) {
                                                if (!array_key_exists('status', $answer)) {
                                                  $answer['status'] = "";
                                                }
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo freetext($answer['status']); ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $answer['weight']; ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;">
                                                  <?php
                                                    if (!empty($answer['remark'])) {
                                                  ?>
                                                      <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo $sub_section['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                                      <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $sub_section['id']; ?>" data-area="<?php echo $key; ?>" > 
                                                        <i class="fa fa-exclamation-circle text-danger h5"></i>
                                                      </a>
                                                  <?php
                                                    }
                                                  ?>
                                                </td>
                        <?php
                                              }
                                            }

                                          } else {
                        ?>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                          }
                                        }
                                      }
                        ?>               
                                      </tr>
                      <?php
                                    }
                                  }
                                } else if (array_key_exists('question_list', $section)) {
                                  foreach ($section['question_list'] as $question) {
                      ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } echo $question['title']; ?></td>
                        <?php
                                      if (!empty($answer_list['document_answer'])) {
                                        foreach ($answer_list['document_answer'] as $month_key => $month_answer) {
                                          if (!empty($month_answer)) {
                                            foreach ($month_answer as $question_id => $answer) {
                                              if ($question_id == $question['id']) {
                                                if (!array_key_exists('status', $answer)) {
                                                  $answer['status'] = "";
                                                }
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo freetext($answer['status']); ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $answer['weight']; ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;">
                                                  <?php
                                                    if (!empty($answer['remark'])) {
                                                  ?>
                                                      <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo str_replace(' ', '_', $month_key).'_'.$question['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                                      <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                                        <i class="fa fa-exclamation-circle text-danger h5"></i>
                                                      </a>
                                                  <?php
                                                    }
                                                  ?>
                                                </td>
                        <?php
                                              }
                                            }

                                          } else {
                        ?>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                          }
                                        }
                                      }
                        ?>               
                                      </tr>
                        <?php 
                                  }
                                }
                              } else {
                                  foreach ($section as $question) {
                          ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } echo $question['title']; ?></td>
                        <?php
                                      if (!empty($answer_list['document_answer'])) {
                                        foreach ($answer_list['document_answer'] as $month_key => $month_answer) {
                                          if (!empty($month_answer)) {
                                            foreach ($month_answer as $question_id => $answer) {
                                              if ($question_id == $question['id']) {
                                                if (!array_key_exists('status', $answer)) {
                                                  $answer['status'] = "";
                                                }
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo freetext($answer['status']); ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $answer['weight']; ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;">
                                                  <?php
                                                    if (!empty($answer['remark'])) {
                                                  ?>
                                                      <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo str_replace(' ', '_', $month_key).'_'.$question['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                                      <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                                        <i class="fa fa-exclamation-circle text-danger h5"></i>
                                                      </a>
                                                  <?php
                                                    }
                                                  ?>
                                                </td>
                        <?php
                                              }
                                            }

                                          } else {
                        ?>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                          }
                                        }
                                      }
                        ?>               
                                      </tr>
                        <?php 
                                  }
                              }
                            }
                        ?>
                        </tbody>
                        <?php
                          } else if ($key == 'policy') {
                        ?>
                        <thead>
                          <tr class="back-color-gray"> 
                            <th style="width:30%" rowspan="2"><?php echo freetext('question'); ?></th>
                        <?php
                            if (!empty($answer_list['policy_answer'])) {
                              foreach ($answer_list['policy_answer'] as $month_key => $month_answer) {
                                $month_parts = explode('-', $month_key);
                                $month       = $month_parts[1];
                        ?>
                                <th class="text-center" colspan="3"  style="width:10%;border: 1px solid #d4d4d4;"><?php echo $month; ?></th>
                        <?php
                              }
                            }
                        ?>
                          </tr> 
                          <tr class="back-color-gray">
                        <?php
                            if (!empty($answer_list['policy_answer'])) {
                              foreach ($answer_list['policy_answer'] as $month_key => $month_answer) {
                        ?>
                                <th class="text-center" style="border: 1px solid #d4d4d4;"><?php echo freetext('result'); ?></th>
                                <th class="text-center" style="border: 1px solid #d4d4d4;"><?php echo freetext('weight'); ?></th>
                                <th class="text-center" style="border: 1px solid #d4d4d4;"><?php echo freetext('remark'); ?></th>
                        <?php
                              }
                            }
                        ?>                            
                          </tr>
                        </thead>
                        <tbody class="data_list_asset"> 
                        <?php
                            foreach ($type as $section) {
                              if (array_key_exists('title', $section)) {
                        ?>
                                <tr>
                                  <td><?php if ($section['sequence_index'] != 0) { echo $section['sequence_index'].' '; }  echo $section['title']; ?></td>
                        <?php
                                if (!empty($answer_list['policy_answer'])) {
                                  foreach ($answer_list['policy_answer'] as $month_key => $month_answer) {
                        ?>
                                  <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                  <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                  <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                  }
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
                                        <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } echo $sub_section['title']; ?></td>
                        <?php
                                      if (!empty($answer_list['policy_answer'])) {
                                        foreach ($answer_list['policy_answer'] as $month_key => $month_answer) {
                        ?>
                                        <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                        <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                        <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                        }
                                      }
                        ?>
                                      </tr>
                        <?php
                                      foreach ($sub_section['question_list'] as $question) {
                        ?>
                                      <tr>
                                        <td style="padding-left:60px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } echo $question['title']; ?></td>
                        <?php
                                      if (!empty($answer_list['policy_answer'])) {
                                        foreach ($answer_list['policy_answer'] as $month_key => $month_answer) {
                                          if (!empty($month_answer)) {
                                            foreach ($month_answer as $question_id => $answer) {
                                              if ($question_id == $question['id']) {
                                                if (!array_key_exists('status', $answer)) {
                                                  $answer['status'] = "";
                                                }
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo freetext($answer['status']); ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $answer['weight']; ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;">
                                                  <?php
                                                    if (!empty($answer['remark'])) {
                                                  ?>
                                                      <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo str_replace(' ', '_', $month_key).'_'.$question['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                                      <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                                        <i class="fa fa-exclamation-circle text-danger h5"></i>
                                                      </a>
                                                  <?php
                                                    }
                                                  ?>
                                                </td>
                        <?php
                                              }
                                            }

                                          } else {
                        ?>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                          }
                                        }
                                      }
                        ?>               
                                      </tr>
                        <?php
                                      }
                                    } else {
                        ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($sub_section['sequence_index'] != 0) { echo $sub_section['sequence_index'].' '; } echo $sub_section['title']; ?></td>
                        <?php
                                      if (!empty($answer_list['document_answer'])) {
                                        foreach ($answer_list['document_answer'] as $month_key => $month_answer) {
                                          if (!empty($month_answer)) {
                                            foreach ($month_answer as $question_id => $answer) {
                                              if ($question_id == $sub_section['id']) {
                                                if (!array_key_exists('status', $answer)) {
                                                  $answer['status'] = "";
                                                }
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo freetext($answer['status']); ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $answer['weight']; ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;">
                                                  <?php
                                                    if (!empty($answer['remark'])) {
                                                  ?>
                                                      <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo $sub_section['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                                      <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $sub_section['id']; ?>" data-area="<?php echo $key; ?>" > 
                                                        <i class="fa fa-exclamation-circle text-danger h5"></i>
                                                      </a>
                                                  <?php
                                                    }
                                                  ?>
                                                </td>
                        <?php
                                              }
                                            }

                                          } else {
                        ?>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                          }
                                        }
                                      }
                        ?>               
                                      </tr>
                      <?php
                                    }
                                  }
                                } else if (array_key_exists('question_list', $section)) {
                                  foreach ($section['question_list'] as $question) {
                      ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } echo $question['title']; ?></td>
                        <?php
                                      if (!empty($answer_list['document_answer'])) {
                                        foreach ($answer_list['document_answer'] as $month_key => $month_answer) {
                                          if (!empty($month_answer)) {
                                            foreach ($month_answer as $question_id => $answer) {
                                              if ($question_id == $question['id']) {
                                                if (!array_key_exists('status', $answer)) {
                                                  $answer['status'] = "";
                                                }
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo freetext($answer['status']); ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $answer['weight']; ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;">
                                                  <?php
                                                    if (!empty($answer['remark'])) {
                                                  ?>
                                                      <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo str_replace(' ', '_', $month_key).'_'.$question['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                                      <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                                        <i class="fa fa-exclamation-circle text-danger h5"></i>
                                                      </a>
                                                  <?php
                                                    }
                                                  ?>
                                                </td>
                        <?php
                                              }
                                            }

                                          } else {
                        ?>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                          }
                                        }
                                      }
                        ?>               
                                      </tr>
                        <?php 
                                  }
                                }
                              } else {
                                  foreach ($section as $question) {
                          ?>
                                      <tr>
                                        <td style="padding-left:40px;"><?php if ($question['sequence_index'] != 0) { echo $question['sequence_index'].' '; } echo $question['title']; ?></td>
                        <?php
                                      if (!empty($answer_list['document_answer'])) {
                                        foreach ($answer_list['document_answer'] as $month_key => $month_answer) {
                                          if (!empty($month_answer)) {
                                            foreach ($month_answer as $question_id => $answer) {
                                              if ($question_id == $question['id']) {
                                                if (!array_key_exists('status', $answer)) {
                                                  $answer['status'] = "";
                                                }
                        ?>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo freetext($answer['status']); ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;"><?php echo $answer['weight']; ?></td>
                                                <td class="text-center" style="border-left: 1px solid #d4d4d4;">
                                                  <?php
                                                    if (!empty($answer['remark'])) {
                                                  ?>
                                                      <input type="hidden" class="form-control" name="question_<?php echo $key; ?>_<?php echo str_replace(' ', '_', $month_key).'_'.$question['id']; ?>[remark]" value="<?php echo $answer['remark']; ?>" >
                                                      <a  class="remark-btn-click" data-month="<?php echo str_replace(' ', '_', $month_key); ?>" style="cursor:pointer;" data-id="<?php echo $question['id']; ?>" data-area="<?php echo $key; ?>" > 
                                                        <i class="fa fa-exclamation-circle text-danger h5"></i>
                                                      </a>
                                                  <?php
                                                    }
                                                  ?>
                                                </td>
                        <?php
                                              }
                                            }

                                          } else {
                        ?>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                                            <td class="text-center" style="border-left: 1px solid #d4d4d4;">&nbsp;</td>
                        <?php
                                          }
                                        }
                                      }
                        ?>               
                                      </tr>
                        <?php 
                                  }
                              }
                            }
                        ?>
                        </tbody>
                        <?php
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
                    <textarea class="form-control" name="comment" style="width:500px; height:80px;" disabled><?php echo $data_document['comment']; ?></textarea>
                    <?php
                      $is_send_email = "";
                      if ($data_document['is_send_email'] == 1) {
                        $is_send_email = " checked";
                      }
                    ?>
                    <input type="checkbox" name="send_comment"<?php echo $is_send_email; ?> disabled> Send E-mail
                </div>
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















