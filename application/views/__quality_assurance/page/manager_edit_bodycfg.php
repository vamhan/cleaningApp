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
            $area =$data_document['area'];//get id                               
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
                <input type="text" autocomplete="off" class="form-control area_input" value="<?php echo $area; ?>">
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
        <section class="panel panel-default">
          <div class="panel-body">
            <form role="form" id="manager_save_form" action="<?php echo site_url('__ps_quality_assurance/manager_update/' ) ?>" method="POST">
              <input type="hidden" name="id" value="<?php echo  $track_doc_id ;?>"/>
              <input type="hidden" name="project_id" value="<?php echo  $project_id ;?>"/>
              <input type="hidden" name="area" value="<?php echo  $area ;?>"/>
              <!-- <div class="col-sm-12"> -->
              <section class="panel panel-default">
                <table id="manager_table" class="table ">
                  <thead>
                    <tr class="back-color-gray">
                      <th style="width:20%;"><?php echo freetext('building'); ?></th>
                      <th style="width:20%;"><?php echo freetext('floor'); ?></th>                    
                      <th style="width:20%;"><?php echo freetext('industry_room'); ?></th>            
                      <th style="width:20%;"><?php echo freetext('area'); ?></th>            
                      <th class="text-center"><?php echo freetext('order_index'); ?>&nbsp;<a href="<?php if (empty($sort) || $sort == 'desc') { echo site_url('__ps_quality_assurance/manager_edit/'.$project_id.'/'.$track_doc_id.'/asc'); } else { echo site_url('__ps_quality_assurance/manager_edit/'.$project_id.'/'.$track_doc_id.'/desc'); } ?>" title="เรียงตามลำดับ"><i class="fa fa-sort"></i></a></th>            
                      <th class="text-center"><?php echo freetext('select'); ?></th>            
                      <th class="text-center"><?php echo freetext('delete'); ?></th>    
                    </tr>
                  </thead>
                  <tbody class="data_list_asset">   
                  <?php
                    if (!empty($data_document['area_list'])) {
                      $count = 0;
                      $building = "";
                      $floor    = "";
                      foreach ($data_document['area_list'] as $key => $area) {

                        $building_id = $area['building_id'];
                        $floor_id    = $area['floor_id'];

                        if ($building == "" || $building != $area['building_id']) {
                          $building = $area['building_id'];
                        } else {
                          $area['building_id'] = "";
                          $area['building'] = "";
                        }

                        if ( ($area['building_id'] == "" && ($floor == "" || $floor != $area['floor_id'])) || $area['building_id'] != "" ) {
                          $floor = $area['floor_id'];
                        } else {
                          $area['floor_id'] = "";
                          $area['floor'] = "";
                        }

                        $is_checked = "";
                        if ($area['is_select'] == 1) {
                          $is_checked = " checked";
                        }

                        // echo "<pre>";
                        // print_r($area);
                        // echo "</pre>";
                  ?>
                      <tr>
                        <td><?php echo $area['building']; ?></td>
                        <td><?php echo $area['floor']; ?></td>
                        <td><?php echo $area['industry_room_description']; ?></td>
                        <td>
                          <?php echo $area['area_name']; ?>
                          <input type='hidden' name='<?php echo "area_".$count."_".$building_id."_".$floor_id."_".$area['industry_room_id']."[id]"; ?>' value='<?php echo $area['id']; ?>'>
                          <input type='hidden' name='<?php echo "area_".$count."_".$building_id."_".$floor_id."_".$area['industry_room_id']."[name]"; ?>' value='<?php echo $area['area_name']; ?>'>
                          <input type='hidden' name='<?php echo "area_".$count."_".$building_id."_".$floor_id."_".$area['industry_room_id']."[origin]"; ?>' value='<?php echo $area['is_origin']; ?>'>
                        </td>
                        <td class="text-center"><input type='text' class='form-control order_index' maxlength='11' name='<?php echo "area_".$count."_".$building_id."_".$floor_id."_".$area['industry_room_id']."[index]"; ?>' value="<?php echo $area['order_index']; ?>"></td>
                        <td class="text-center"><input type='checkbox' class='form-control' style='height:20px; margin-top:7px;' name='<?php echo "area_".$count."_".$building_id."_".$floor_id."_".$area['industry_room_id']."[select]"; ?>'<?php echo $is_checked; ?>></td>
                        <td class="text-center"><?php if ($area['is_origin'] != 1) { ?><a href='#' class='btn btn-default del_area_btn'><i class='fa fa-trash-o'></i></a><?php } ?></td>
                      </tr>
                  <?php
                        $count++;
                      }
                    }
                  ?>                                            
                  </tbody>
                  <tfoot>
                    <th>
                      <select class="form-control select_building">
                        <option value="0">----- <?php echo freetext('building'); ?> -----</option>
                      <?php
                        if (!empty($building_list)) {
                          foreach ($building_list as $key => $building) {
                      ?>
                            <option value="<?php echo $building['id']; ?>"><?php echo $building['title']; ?></option>
                      <?php
                          }
                        }
                      ?>
                      </select>
                    </th>
                    <th>
                      <select class="form-control select_floor inline input-s m-r-md">
                        <option value="0">----- <?php echo freetext('floor'); ?> -----</option>
                      </select>
                      <i class="floor_loading fa fa-spinner" style="display:none"></i>
                    </th>
                    <th>
                      <select class="form-control select_area inline input-s m-r-md">
                        <option value="0">----- <?php echo freetext('area'); ?> -----</option>
                      </select>
                      <i class="area_loading fa fa-spinner" style="display:none"></i>
                    </th>
                    <th>
                      <input class="form-control area_name_alias" >
                    </th>
                    <th class="text-center">
                      <a href="#" class="btn btn-info add_area"><i class="fa fa-plus"></i> <?php echo freetext('add'); ?></a>
                    </th>
                    <th></th>
                    <th></th>
                  </tfoot>
                </table>                                  
              </section>
              <div class="col-sm-12" >
                <?php                 
                  $doc_id      = $data_document['id'];
                  $contract_id = $data_document['contract_id'];
                  $plan_date   = $data_document['plan_date'];

                  $this->db->select('tbt_quality_survey.*');
                  $this->db->join('tbt_action_plan', 'tbt_quality_survey.action_plan_id = tbt_action_plan.id');
                  $this->db->where(array('tbt_quality_survey.contract_id' => $contract_id, 'tbt_action_plan.plan_date <=' => $plan_date, 'tbt_quality_survey.id <' => $doc_id));
                  $this->db->order_by('plan_date desc, tbt_quality_survey.id desc');
                  $this->db->limit(1);
                  $query = $this->db->get('tbt_quality_survey');
                  $row = $query->row_array();

                  $min_pass_score = 80;
                  if (!empty($row) && !empty($row['min_pass_score'])) {
                    $min_pass_score = $row['min_pass_score'];
                  }

                  if (!empty($data_document['min_pass_score'])) {
                    $min_pass_score = $data_document['min_pass_score'];
                  }
                  
                ?>
                  เปอร์เซนต์การประเมิน <input type="text" class="form-control input-s-sm inline percent_val" name="min_pass_score" onkeypress="return isInt(event);" value="<?php echo $min_pass_score; ?>">
                  <input type="hidden" name="approve" class="approve" value="0">
                  <a href="#" class="btn btn-s-md btn-primary approve-btn" data-toggle=""><?php echo freetext('approved'); ?></a> 

                <a href="<?php echo site_url('__ps_quality_assurance/listview/list/'.$project_id ); ?>" class="btn btn-s-md btn-default pull-right margin-left-small"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                <a href="#" class="btn btn-s-md btn-primary save-btn pull-right" data-toggle=""><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></a> 
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















