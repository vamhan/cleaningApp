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
                          $_page_size = 10;
                          $page_size = 1*$_page_size;

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

                              $survey_officer_id =$data_document['survey_officer_id'];//get id    
                            }
                            else{ 
                              $project_title='-'; 
                              //$actual_date = '0000-00-00';
                            }

                          //====end :  get data document name =========

                          //====start : get survey_officer name =========
                           $this->db->where('employee_id',$survey_officer_id);
                          //$this->db->where('id', $survey_officer_id);
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
                                <button class="btn btn-default disabled" type="button"><i class="fa fa-th"></i></button>
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
                              <input type="text" autocomplete="off" name="survey_officer_name" class="form-control" readonly value="<?php if(!empty($survey_officer_name)){ echo $survey_officer_name;}else{ echo "-"; }  ?>">
                            </div>
                          </div>

                           <div class="col-md-4">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo freetext('actor'); ?></span>
                               <input type="text" autocomplete="off" name="actor_name" class="form-control" readonly  value="<?php  if($actor != " "){echo $actor;}else{echo "-";} //  echo $actor_name.' '.$actor_surname;?>">                             
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
                        <header class="panel-heading bg-light">
                          <ul class="nav nav-tabs nav-justified">
                            <?php  //echo $this->untrack  ?>
                              <li class="h5 track"><a href="#track" data-toggle="tab"><?php echo freetext('track_asset_tab');?></a></li>
                              <li class="h5 untrack"><a href="#untrack" data-toggle="tab"><?php echo freetext('untrack_asset_tab');?></a></li>                           
                          </ul>
                        </header>
                        <div class="panel-body">
                          <div class="tab-content">
                            <!-- start : tab track asset -->

                            <div class="tab-pane" id="track">
                             
                               <!-- /////////////////////////////////////////// -->
                                    <!-- start : table track asset -->
                              <form role="form" action="<?php echo site_url('__ps_asset_track/update_track_asset/'.$track_doc_id.'/'.$project_id ) ?>" method="POST">
                              <input type="hidden" class="form-control project_id"  value="<?php echo $project_id;?>"/>
                              <input type="hidden" class="form-control track_doc_id"  value="<?php echo $track_doc_id;?>"/>
                              <input type="hidden" name="plan_id" class="form-control" readonly value="<?php echo $plan_id;?>"/>
                              <input type="hidden" name="actual_date" class="form-control" readonly value="<?php echo $actual_date;?>"/>
                              <input type="hidden" name="actor_by_id" class="form-control" readonly  value="<?php echo  $actor_by_id; //$actor;?>"/>
                              <input type="hidden" name="fixclaim_asset_id" class="form-control" readonly  value="0"/>
                              <input type="hidden" name="fixclaim_asset_name" class="form-control" readonly  value=""/>
                            <!--   <input type="hidden" name="doc_status" class="form-control" readonly  value="<?php echo  $doc_status ;?>"/> -->
                             
                              <!-- <input type="text" autocomplete="off" name="texttest" class="form-control" /> -->
                              <!-- <div class="col-sm-12"> -->
                                <section class="panel panel-default">
                                <table id="table1" class="table ">
                                 
                                                <thead>
                                                    <tr class="back-color-gray">
                                                        <th><?php echo freetext('serial'); ?></th>
                                                        <th><?php echo freetext('date'); ?></th>                    
                                                        <th><?php echo freetext('asset_name'); ?></th>
                                                        <th class="tx-center"><?php echo freetext('exist'); ?></th>
                                                        <th class="tx-center"><?php echo freetext('not_exist'); ?></th>
                                                        <th class="tx-center"><?php echo freetext('exist_with_condition'); ?></th>
                                                        <th class="tx-center"><?php echo freetext('status'); ?></th>
                                                        <th ><?php echo freetext('remark'); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="data_list_asset">                                                
                                               
                                                    <?php
                                                    foreach ($query_track->result_array() as $row)
                                                      {
                                                          $serial= $row['asset_no'];
                                                          $asset_name=$row['ASSET_NAME_PJ'];
                                                          //$asset_date = common_easyDateFormat($row['asset_date']);
                                                          if( $row['asset_date'] !='0000-00-00'  ){
                                                              $asset_date = common_easyDateFormat($row['asset_date']);
                                                          }else{  $asset_date = '-'; }

                                                          $remark =$row['remark'];
                                                          $check_remark_icon='';
                                                          if(!empty($remark)){ $check_remark_icon='text-primary'; }else{  $check_remark_icon='text-muted'; }
                                                          
                                                          $status_tracking =  $row['status_tracking'];  

                                                          //== start : check asset ========
                                                          $asset_color=''; 
                                                          $asset_icon=''; 
                                                         

                                                          $is_spare =$row['is_spare'];
                                                          $is_fixing =$row['is_fixing'];
                                                          $is_clear_job =$row['is_clear_job'];
                                                            
                                                          if($is_spare==1 && $is_fixing!=1) { 
                                                            $asset_color = 'tx-blue';
                                                            $asset_icon='<i class="fa fa-warning h5"></i>';
                                                          }
                                                           if($is_fixing==1) { 
                                                            $asset_color = 'tx-red';
                                                            $asset_icon='<i class="fa fa-info-circle h5"></i>';
                                                          }
                                                          if($is_clear_job==1 && $is_fixing!=1) { 
                                                            $asset_color = 'tx-green';
                                                            $asset_icon='';
                                                          }
                                                          if($is_clear_job==1 && $is_spare==1 && $is_fixing!=1) { 
                                                            $asset_color = 'tx-blue';
                                                            $asset_icon='<i class="fa fa-warning h5"></i>';
                                                          }
                                                           //== End : check asset ========

                                                          //== start : check status value ========                                                  
                                                            if(!empty($status_tracking)){
                                                                $checked1 = ""; $checked2 = ""; $checked3 = "";                                                          
                                                              if($status_tracking=='EXIST'){
                                                                  $checked1= "checked=checked";   
                                                              }else if($status_tracking=='NOT_EXIST'){
                                                                  $checked2 = "checked=checked";
                                                              }else if($status_tracking=='EXIST_WITH_CON'){
                                                                  $checked3 = "checked=checked";
                                                              }
                                                            }else{ $checked1 = ""; $checked2 = ""; $checked3 = ""; }//UNCHECK

                                                            if($is_fixing==1){
                                                               $checked3= "checked=checked";
                                                            }

                                                          //== End : check status value ========   

                                                          //== start : icon status ========   
                                                            // if($status_tracking!='UNCHECK'){
                                                            //     if($status_tracking=='EXIST'){
                                                            //       $status = "<i class='tx-green fa fa-check h5'></i>";
                                                            //     }else if($status_tracking=='NOT_EXIST' ||$status_tracking=='EXIST_WITH_CON'){
                                                            //       $status = "<i class='tx-yellow fa fa-warning h5'></i>";
                                                            //     }
                                                            // }else{ $status = "-"; }

                                                              $status = '-';
                                                            if($status_tracking=='UNCHECK' && ( $actual_date =='0000-00-00' || $actual_date =='' || $actual_date =='null' ) ){
                                                               $status = "-";
                                                            }else if($status_tracking =='UNCHECK'  &&  $actual_date !='0000-00-00'){  
                                                               $status = "<i class='tx-yellow fa fa-warning h5'></i>";
                                                            }else if($status_tracking !='UNCHECK' &&  $actual_date !='0000-00-00'){
                                                               $status = "<i class='tx-green fa fa-check h5'></i>";
                                                            }

                                                        //== end : icon status ========   

                                                            //hot fix -> change remark serial 
                                                           $fixed_serial = str_replace('.', '_', $serial);
                                                           
                                                            //<a href='#'  serial='$serial' class='btn btn-default' type='button' id='button_remark'><i class='fa fa-plus-square-o'></i></a>
                                                          echo "<tr class='$asset_color' data='".defill($serial)."'>
                                                              <td class='col1'>
                                                                  $asset_icon ".defill($serial)."
                                                                  <input type='hidden' class='form-control' name='$serial' value='$serial'>                                                                
                                                              </td>
                                                              <td class='col2'>$asset_date</td>
                                                              <td class='col3'>$asset_name</td>
                                                              <td class='tx-center col4'>
                                                                 <div class='radio-exit'><label><input type='radio' name='radio_$serial' id='Radios1' value='EXIST' $checked1 ></label></div>
                                                              </td>
                                                              <td class='tx-center col5'>
                                                                 <div class='radio-notexit'><label><input type='radio' name='radio_$serial' id='Radios2' value='NOT_EXIST' $checked2 ></label></div>
                                                              </td>
                                                              <td class='tx-center col6'>
                                                                 <div class='radio-condition'><label><input type='radio' name='radio_$serial' id='Radios3' value='EXIST_WITH_CON' $checked3></label></div>
                                                              </td>
                                                              <td class='tx-center col7'>
                                                                   $status
                                                              </td>
                                                              <td class='col8'>      
                                                                <div class='input-group div-remark-group' >
                                                                  <input type='hidden' class='form-control input-remark-group' name='remark_$fixed_serial' value='$remark' id='remark_$fixed_serial' >
                                                                  <span class='input-group-btn'>                                                                  
                                                                     <a  href='#' serial='$fixed_serial' class='btn btn-default btn_remark' type='button' > 
                                                                       <i class='fa fa-align-justify'></i>
                                                                       &nbsp;
                                                                       &nbsp;
                                                                       <i class='fa fa-circle  text-xs v-middle $check_remark_icon' id='remark_icon_$fixed_serial'></i>
                                                                     </a>                                                                                                              
                                                                    <a class='btn btn-default claim-button link_to_fixclaim'  porject-id='$project_id' doc-id='$track_doc_id' asset-id='$serial' asset-name='$asset_name'  data-toggle='tooltip' data-placement='top' title='go to fixclaim' > 
                                                                      <i class='fa fa-cog'></i> ".freetext('claim')."
                                                                    </a>
                                                                  </span> 
                                                                </div> 

                                                              </td>
                                                          </tr>";   
                                                          //<a  href='".site_url('__ps_fix_claim/detail/insert/'.$project_id.'/'.$track_doc_id.'/'.$serial.'/'.$asset_name)."'  class='btn btn-default claim-button' data-toggle='tooltip' data-placement='top' title='go to fixclaim'  type='button'><i class='fa fa-cog'></i> ".freetext('claim')."</a>
                                                          //target='_blank' <a href='#' serial='$serial' class='btn btn-default btn_remark' type='button'><i class='fa fa-plus-square-o'></i></a> 
                                                                      
                                                      }
                                                    ?>                                               
                                                    

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th><input type='text' id="search_col1_table1" class='form-control' onkeypress="return isNumberKey(event)" placeholder='<?php echo freetext('serial'); ?>' /></th>
                                                        <th><input type='text' id="search_col2_table1" class='form-control' placeholder='<?php echo freetext('date'); ?>'/></th>                    
                                                        <th><input type='text' id="search_col3_table1" class='form-control' placeholder='<?php echo freetext('asset_name'); ?>'/></th>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                          <select class="form-control" name="ft_status" id="ft_status">
                                                               <option <?php if($status_asset_track =='0') {?> selected='selected'<?php } ?> value='0'><?php echo freetext('all'); ?></option>
                                                               <option <?php if($status_asset_track =='EXIST') {?> selected='selected'<?php } ?> value='EXIST'><?php echo freetext('exist'); ?></option> 
                                                               <option <?php if($status_asset_track =='NOT_EXIST') {?> selected='selected'<?php } ?> value='NOT_EXIST'><?php echo freetext('not_exist'); ?></option> 
                                                               <option <?php if($status_asset_track =='EXIST_WITH_CON') {?> selected='selected'<?php } ?> value='EXIST_WITH_CON'><?php echo freetext('exist_with_condition'); ?></option>
                                                               <option <?php if($status_asset_track =='UNCHECK') {?> selected='selected'<?php } ?> value='UNCHECK'><?php echo freetext('uncheck'); ?></option>   
                                                          </select>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>                                  

                                  </section>
                             <!--  </div> -->

                                 <!-- Start : foot table -->
                               <div class="col-sm-12 padd-all-small">                               
                                <span class="h5 badge bg-primary margin-left-medium"><?php echo freetext('green_is_clear'); ?></span>
                                <span class="h5 badge back-color-blue margin-left-medium"><?php echo freetext('blue_is_spare'); ?></span>
                                <span class="h5 badge bg-danger margin-left-medium"><?php echo freetext('red_is_fixing'); ?></span>
                                <span class="h5 badge bg-default margin-left-medium"><?php echo freetext('is_default'); ?></span>
                               </div>
                               
                               <div class="col-sm-12" >
                                <br/>                               
                                  <!-- //=================== start : get uncheck ====================== -->
                                      <?php
                                          $this->db->select('count(*) as count', 'tbt_asset_track.*');
                                          $this->db->where('status_tracking','UNCHECK');
                                          $this->db->where('asset_track_document_id',$track_doc_id);
                                          //$this->db->where('is_fixing',0);
                                          $query = $this->db->get('tbt_asset_track'); 
                                          $data_count = $query->row_array();  
                                          $count_uncheck = $data_count['count'];

                                          if($count_uncheck==0){
                                            $msg_sap = 'คุณต้องการจะจบแผนงาน';
                                          }else {  $msg_sap = 'คุณยังตรวจงานไม่สมบูรณ์'; }
                                      ?>
                                  <!-- //=================== End : get uncheck ====================== -->
                                  <!--  <a href="<?php //echo site_url('__ps_asset_track/submit_to_sap/'.$track_doc_id.'/'.$project_id ); ?>" class="btn btn-s-md btn-info pull-left"><i class="fa fa-mail-forward h5"></i> <?php //echo freetext('submit'); ?></a>   -->
                               
                                  <input type="hidden"  name="msg_sap" class="msg_sap" id="msg_sap" value="<?php echo $msg_sap;?>" />
                                  <a <?php if( $actual_date =='0000-00-00' || $actual_date ==''  || $actual_date =='null'  ){ echo 'disabled'; } ?> class="btn btn-s-md btn-info pull-left submit-to-sap"   
                                    doc-id="<?php echo $track_doc_id; ?>" 
                                    porject-id="<?php echo $project_id; ?>" >
                                    <i class="fa fa-mail-forward h5"></i> <?php echo freetext('submit'); ?>
                                  </a>

                                  <a href="<?php echo site_url('__ps_asset_track/listview/list/'.$project_id ); ?>" class="btn btn-s-md btn-default pull-right margin-left-small"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                                  <button type="submit" class="btn btn-s-md btn-primary pull-right  submit-save" data-toggle=""><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button> 
                              </div>

                               </from>
                               <!-- End : foot table -->    

                             
                               <!-- //////////////////////////////////////////// -->

                            </div><!-- end : tab track asset -->

                            <!-- start : tab untracked -->
                            <div class="tab-pane" id="untrack">
                                <!-- start : table track asset -->
                               <!--  <div class="col-sm-12"> -->
                                  <section class="panel panel-default">                                 
                                    <table class="table  m-b-none">
                                      <thead >
                                        <tr class="back-color-gray">
                                          <th><?php echo freetext('serial'); ?></th>
                                          <th><?php echo freetext('asset_name'); ?></th>                    
                                          <th><?php echo freetext('input_by'); ?></th>                                          
                                          <th><?php echo freetext('remark'); ?></th>
                                          <th><?php echo freetext('delete'); ?></th>
                                        </tr>
                                      </thead>
                                      <tbody>                                    

                                        <?php 
                                        $query_untrack_data = $query_untrack->row_array();
                                          if(empty($query_untrack_data)){

                                              echo "<tr>
                                                  <td colspan='4'>ไม่มีข้อมูล</td>                                                  
                                              </tr>";
                                          }else{

                                              foreach ($query_untrack->result_array() as $row){
                                                $serial= $row['asset_no'];
                                                $asset_name=$row['asset_description'];
                                                $input_by_id=$row['input_by_id'];//get 
                                                $remark=$row['remark'];
                                               
                                               //====start : get inputby name =========
                                               $this->db->where('employee_id', $input_by_id);
                                               $query_input_by=$this->db->get('tbt_user');
                                               $datax = $query_input_by->row_array();      
                                               if(!empty($datax)){
                                                  $input_by_name = $datax['user_firstname']." ". $datax['user_lastname'];
                                                }else{ $input_by_name='-'; }

                                              //====end : get inputby name =========

                                                echo "<tr>
                                                      <td>".defill($serial)."</td>
                                                      <td>$asset_name</td>
                                                      <td>".$input_by_name."</td>
                                                      <td>$remark</td>
                                                      <td>
                                                        <a class='btn btn-default pull-left submit-delete-untrack' doc-id='$track_doc_id' porject-id='$project_id' asset-id='$serial' > 
                                                          <i class='fa fa-trash-o h5'></i>
                                                        </a>
                                                      </td>
                                                </tr>";
                                            }// end foreach
                                          }//end else
                                      ?>    

                                      </tbody>
                                    </table>

                                  </section>
                                <!-- </div> -->
                                 <!-- end : table track asset -->

                              <!-- Start : foot table -->                                                              
                               <div class="col-sm-12" >
                                  <br/>
                                  <a href='#modal-add-Untrack' data-toggle="modal" class="btn btn-s-md btn-default pull-right " ><i class="fa fa-plus h5"></i> <?php echo freetext('add'); ?></a>
                               </div>
                               <!-- End : foot table -->

                            </div><!-- end : tab untracked -->
                            
                          </div>
                        </div>
                      </section>
                    <!-- / .nav-justified -->


                    </div>
                  </div>
            </div>

            </div><!-- end : class div_detail -->

            </section><!-- end : scrollable padder -->
          </section><!-- end : class vbox -->
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>



          











