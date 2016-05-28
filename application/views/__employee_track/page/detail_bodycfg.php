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
                          $status_asset_track =$this->status;
                          $actor_by_id = $this->session->userdata('id');

                           //====start : get data document  =========
                          $data_document = $query_documet->row_array();    

                           if(!empty($data_document)){
                              $project_title =$data_document['title'];
                              $actual_date =$data_document['actual_date'];
                              $plan_id =$data_document['plan_id']; 
                              $plan_date =$data_document['plan_date'];                      
                              $actor_id =$data_document['actor_by_id'];//get id        
                              $doc_status =$data_document['status'];//get id                             

                              $survey_officer_id =$data_document['survey_officer_id'];//get id    
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
                          <div class="col-md-12">
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
                        </div>
                      </div>
                     
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo freetext('actual_date'); ?></span>
                              <input type="text" autocomplete="off" class="form-control" readonly value="<?php if( $actual_date !='0000-00-00' && !empty($actual_date) ){ echo common_easyDateFormat($actual_date); }else{ echo "-"; } //$actual_date?> ">
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
                </div>
                <!-- End : data action plan -->

              </section><!-- end : panel -->
              

              <div class="panel row">
                  <div class="panel-collapse in">
                    <div class="panel-body text-sm">
                        
                     <!-- .nav-justified -->
                      <section class="panel panel-default">
                        <div class="panel-body">
                             
                               <!-- /////////////////////////////////////////// -->
                                    <!-- start : table track asset -->
                          <form role="form" id="employee_save_form" action="<?php echo site_url('__ps_employee_track/update_track_employee/'.$track_doc_id.'/'.$project_id ) ?>" method="POST">
                              <input type="hidden" class="form-control project_id"  value="<?php echo $project_id;?> "/>
                              <input type="hidden" class="form-control track_doc_id"  value="<?php echo $track_doc_id;?> "/>
                              <input type="hidden" name="plan_id" class="form-control" readonly value="<?php echo $plan_id;?> "/>
                              <input type="hidden" name="actual_date" class="form-control" readonly value="<?php echo $actual_date;?> "/>
                              <input type="hidden" name="actor_by_id" class="form-control" readonly  value="<?php echo  $actor_by_id ; //$actor;?>"/>
                             
                              <!-- <div class="col-sm-12"> -->
                                <section class="panel panel-default">
                                <table id="table1" class="table ">
                                 
                                                <thead>
                                                    <tr class="back-color-gray">
                                                        <th><?php echo freetext('code'); ?></th>
                                                        <th><?php echo freetext('level'); ?></th>                    
                                                        <th><?php echo freetext('employee_name'); ?></th>
                                                        <th class="tx-center"><?php echo freetext('exist'); ?></th>
                                                        <th class="tx-center"><?php echo freetext('not_exist'); ?></th>
                                                        <th class="tx-center"><?php echo freetext('uncheck'); ?></th>
                                                        <th class="tx-center"><?php echo freetext('status'); ?></th>
                                                        <th class="tx-center"><?php echo freetext('check'); ?></th>
                                                        <th class="tx-center"><?php echo freetext('satisfied'); ?></th>
                                                        <th ><?php echo freetext('remark'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="data_list_asset">                                                
                                               
                                                    <?php
                                                    foreach ($query_track->result_array() as $row)
                                                      {

                                                          $serialized_answer_class = "primary";
                                                          if (empty($row['serialized_answer'])) {
                                                            $serialized_answer_class = "muted";
                                                          }
                                                          $serialized_satisfaction_answer_class = "primary";
                                                          if (empty($row['serialized_satisfaction_answer'])) {
                                                            $serialized_satisfaction_answer_class = "muted";
                                                          }

                                                          $emp_id=defill($row['employee_id']);
                                                          $raw_emp_id=$row['employee_id'];
                                                          $level=$row['level'];
                                                          $name=$row['actor_name'].' '.$row['actor_surname'];
                                                          $remark =$row['remark'];
                                                          $status =  $row['status'];  

                                                          //== start : check status value ========                                                  
                                                            if(!empty($status)){
                                                                $checked1 = ""; $checked2 = ""; $checked3 = "";                                                        
                                                              if($status=='EXIST'){
                                                                  $checked1= "checked=checked";   
                                                              }else if($status=='NOT_EXIST'){
                                                                  $checked2 = "checked=checked";
                                                              }else if($status=='UNCHECK'){
                                                                  $checked3 = "checked=checked";
                                                              }
                                                            }else{ $checked1 = ""; $checked2 = ""; $checked3 = ""; }//UNCHECK
                                                          //== End : check status value ========   

                                                          //== start : icon status ========   
                                                            // if($status_tracking!='UNCHECK'){
                                                            //     if($status_tracking=='EXIST'){
                                                            //       $status = "<i class='tx-green fa fa-check h5'></i>";
                                                            //     }else if($status_tracking=='NOT_EXIST' ||$status_tracking=='EXIST_WITH_CON'){
                                                            //       $status = "<i class='tx-yellow fa fa-warning h5'></i>";
                                                            //     }
                                                            // }else{ $status = "-"; }

                                                            $status_icon = "";
                                                            if($status == "" && $doc_status == "warning"){  
                                                               $status_icon = "<i class='tx-yellow fa fa-warning h5'></i>";
                                                            }else if($status != ""){
                                                               $status_icon = "<i class='tx-green fa fa-check h5'></i>";
                                                            }

                                                            $remark_color = "muted";
                                                            if (!empty($remark)) {
                                                              $remark_color = "primary";
                                                            }


                                                        //== end : icon status ========   

                                                            //<a href='#'  serial='$serial' class='btn btn-default' type='button' id='button_remark'><i class='fa fa-plus-square-o'></i></a>
                                                          echo "<tr>
                                                              <td>
                                                                  $emp_id
                                                                  <input type='hidden' class='form-control' name='$raw_emp_id' value='$raw_emp_id'>                                                                
                                                              </td>
                                                              <td>$level</td>
                                                              <td>$name</td>
                                                              <td class='tx-center'>
                                                                 <div class='radio-exit'><label><input type='radio' name='radio_$raw_emp_id' id='Radios1' value='EXIST' $checked1 ></label></div>
                                                              </td>
                                                              <td class='tx-center'>
                                                                 <div class='radio-notexit'><label><input type='radio' name='radio_$raw_emp_id' id='Radios2' value='NOT_EXIST' $checked2 ></label></div>
                                                              </td>
                                                              <td class='tx-center'>
                                                                 <div class='radio-condition'><label><input type='radio' name='radio_$raw_emp_id' id='Radios3' value='UNCHECK' $checked3 ></label></div>
                                                              </td>
                                                              <td class='tx-center'>
                                                                   $status_icon
                                                              </td>
                                                              <td class='tx-center'>                                                                  
                                                                     <a href='#modal-check' data-toggle='modal'  serial='$raw_emp_id' data-empid='$emp_id' data-doc='$track_doc_id' class='btn btn-default btn_check_employee' type='button'>
                                                                      <i class='fa fa-check'></i>
                                                                      &nbsp;                      
                                                                      <i class='fa fa-circle text-$serialized_answer_class text-xs v-middle'></i>  
                                                                     </a> 
                                                                  
                                                              </td>
                                                              <td class='tx-center'>                                                             
                                                                    <a href='#modal-satisfaction' data-toggle='modal'  serial='$raw_emp_id' data-empid='$emp_id' data-doc='$track_doc_id' class='btn btn-default btn_satisfaction_employee' type='button'>
                                                                      <i class='fa fa-smile-o'></i>
                                                                      &nbsp;                      
                                                                      <i class='fa fa-circle text-$serialized_satisfaction_answer_class text-xs v-middle'></i> 
                                                                    </a> 
                                                              </td>
                                                              <td>      
                                                                <div class='input-group div-remark-group' >
                                                                  <input type='hidden' class='form-control input-remark-group hidden-md' name='remark_$raw_emp_id' value='$remark' id='remark_$raw_emp_id' >
                                                                  <span class='input-group-btn' style='float:left;'>                                                                  
                                                                     <a href='#' serial='$raw_emp_id' class='btn btn-default btn_remark' type='button'>
                                                                      <i class='fa fa-align-justify'></i>
                                                                      &nbsp;                      
                                                                      <i class='fa fa-circle text-$remark_color text-xs v-middle'></i>                    
                                                                     </a> 
                                                                  </span> 
                                                                </div>                                            
                                                              </td>
                                                          </tr>";
                                                      }
                                                    ?>                                               
                                                    
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <!-- <th><?php //echo freetext('code'); ?></th>
                                                        <th><?php //echo freetext('level'); ?></th>                    
                                                        <th><?php //echo freetext('employee_name'); ?></th> -->
                                                        <th><input type='text' id="search_col1_table1" class='form-control' onkeypress="return isNumberKey(event)" placeholder='<?php echo freetext('code'); ?>' /></th>
                                                        <th><input type='text' id="search_col2_table1" class='form-control' placeholder='<?php echo freetext('level'); ?>'/></th>                    
                                                        <th><input type='text' id="search_col3_table1" class='form-control' placeholder='<?php echo freetext('employee_name'); ?>'/></th>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                          <select class="form-control" name="ft_status" id="ft_status">
                                                               <option <?php if($filter_status =='0') {?> selected='selected'<?php } ?> value='0'><?php echo freetext('all'); ?></option>
                                                               <option <?php if($filter_status =='EXIST') {?> selected='selected'<?php } ?> value='EXIST'><?php echo freetext('exist'); ?></option> 
                                                               <option <?php if($filter_status =='NOT_EXIST') {?> selected='selected'<?php } ?> value='NOT_EXIST'><?php echo freetext('not_exist'); ?></option> 
                                                               <option <?php if($filter_status =='UNCHECK') {?> selected='selected'<?php } ?> value='UNCHECK'><?php echo freetext('uncheck'); ?></option>
                                                          </select>
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>                                  

                                  </section>
                             <!--  </div> -->

                                 <div class="col-sm-12" >
                                  <br/>                               
                                    <!-- //=================== start : get uncheck ====================== -->
                                        <?php
                                            $this->db->select('count(*) as count', 'tbt_asset_track.*');
                                            $this->db->where('status_tracking','UNCHECK');
                                            $this->db->where('asset_track_document_id',$track_doc_id);
                                            $query = $this->db->get('tbt_asset_track'); 
                                            $data_count = $query->row_array();  
                                            $count_uncheck = $data_count['count'];

                                            if($count_uncheck==0){
                                              $msg_sap = 'คุณต้องการจะจบแผนงาน';
                                            }else {  $msg_sap = 'คุณยังตรวจงานไม่สมบูรณ์ คุณต้องการจบแผนการทำงานใช่หรือไม่'; }
                                        ?>
                                    <!-- //=================== End : get uncheck ====================== -->
                                    <!--  <a href="<?php //echo site_url('__ps_employee_track/submit_to_sap/'.$track_doc_id.'/'.$project_id ); ?>" class="btn btn-s-md btn-info pull-left"><i class="fa fa-mail-forward h5"></i> <?php //echo freetext('submit'); ?></a>   -->

                                    <input type="hidden" class="submit_status" value="<?php echo $data_document['status']; ?>" />
                                    <input type="hidden" class="submit_input" name="submit" value="0" />
                                    <input type="hidden"  name="msg_sap" class="msg_sap" id="msg_sap" value="<?php echo $msg_sap;?>" />
                                    <a <?php if( $actual_date =='0000-00-00' ){ echo 'disabled'; } ?> class="btn btn-s-md btn-info pull-left submit-to-sap"   
                                      doc-id="<?php echo $track_doc_id; ?>" 
                                      porject-id="<?php echo $project_id; ?>" >
                                      <i class="fa fa-mail-forward h5"></i> <?php echo freetext('submit'); ?>
                                    </a>

                                    <a href="<?php echo site_url('__ps_employee_track/listview/list/'.$project_id ); ?>" class="btn btn-s-md btn-default pull-right margin-left-small"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                                    <button type="submit" class="btn btn-s-md btn-primary save-btn pull-right" data-toggle=""><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button> 
                                </div>
                          </form>
                      </section>
                    <!-- / .nav-justified -->


                    </div>
                  </div>
            </div>

            </div><!-- end : class div_detail -->

            </section><!-- end : scrollable padder -->
          </section><!-- end : class vbox -->
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>



          











