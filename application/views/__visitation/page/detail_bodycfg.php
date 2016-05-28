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
                          $actor_by_id = $this->session->userdata('id');

                           //====start : get data document  =========
                          // $data_document = $query_documet->row_array();    

                          // echo "<pre>";
                          // print_r($data_document);
                          // echo "</pre>";
                           if(!empty($data_document)){
                              $project_title =$data_document['title'];
                              $actual_date =$data_document['actual_date'];
                              $plan_id =$data_document['plan_id']; 
                              $plan_date =$data_document['plan_date'];                      
                              $actor_id =$data_document['visitor_id'];//get id                
                              $reason =$data_document['reason'];//get id   

                              $in_time =$data_document['in_time'];//get id                                             
                              $out_time =$data_document['out_time'];//get id  

                              $id = $data_document['contract_id'];
                              if (empty($id)) {
                                $id = $data_document['prospect_id'];
                              }
                              // $doc_status =$data_document['status'];//get id                             

                              // $survey_officer_id =$data_document['survey_officer_id'];//get id    
                              $last_visit = '-';
                              if (!empty($data_document['last_visit']) && !empty($data_document['last_visit']['actual_date']) && $data_document['last_visit']['actual_date'] != "0000-00-00") {
                                $last_visit = common_easyDateFormat($data_document['last_visit']['actual_date']);
                              }
                            }
                            else{ 
                              $project_title='-'; 
                            }

                          //====end :  get data document name =========

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

                              <input type="text" autocomplete="off" class="form-control" readonly  value="<?php echo 'ID-'.$id.'/'.$project_title.'/'.common_easyDateFormat($plan_date); ?>">
                               <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-th"></i></button>
                              </span>
                            </div>
                          </div>  
                          <div class="col-md-4">
                            <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo freetext('reason'); ?></span>
                              <input type="text" autocomplete="off" class="form-control" readonly value="<?php echo $reason; ?> ">
                            </div>
                          </div>                            
                        </div>
                      </div>
                     
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo freetext('actual_date'); ?></span>
                              <input type="text" autocomplete="off" class="form-control" readonly value="<?php if( $actual_date !='0000-00-00' && !empty($actual_date)){ echo common_easyDateFormat($actual_date); }else{ echo "-"; } //$actual_date?> ">
                            </div>
                          </div>       

                           <div class="col-md-4">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo freetext('visit_actor'); ?></span>
                               <input type="text" autocomplete="off" name="survey_officer_name" class="form-control" readonly  value="<?php if(!empty($actor)){ echo $actor;}else{ echo "-"; }  ?>">                             
                            </div>
                          </div>

                           <div class="col-md-4">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo freetext('last_visit'); ?></span>
                               <input type="text" autocomplete="off" name="survey_officer_name" class="form-control" readonly  value="<?php echo $last_visit; ?>">                             
                            </div>
                          </div>

                        </div>
                      </div>
                     
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo freetext('in_time'); ?></span>
                              <input type="text" autocomplete="off" class="form-control" readonly value="<?php if (!empty($in_time) && $in_time != '0000-00-00 00:00:00') { echo common_easyDateTimeFormat($in_time); } else { echo '-'; } ?>">
                            </div>
                          </div>       

                           <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo freetext('out_time'); ?></span>
                               <input type="text" autocomplete="off" class="form-control" readonly  value="<?php if (!empty($out_time) && $out_time != '0000-00-00 00:00:00') { echo common_easyDateTimeFormat($out_time); } else { echo '-'; } ?>">                             
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
                              <li data-id="1" class="h5 tab1<?php if ($tab == 1) { echo " active";} ?>"><a href="#tab1" class="tab_li" data-toggle="tab"><?php echo freetext('customer');?></a></li>
                              <li data-id="2" class="h5 tab2<?php if ($tab == 2) { echo " active";} ?>"><a href="#tab2" class="tab_li" data-toggle="tab"><?php echo freetext('for_manager');?></a></li>
                              <li data-id="3" class="h5 tab3<?php if ($tab == 3) { echo " active";} ?>"><a href="#tab3" class="tab_li" data-toggle="tab"><?php echo freetext('visitation');?></a></li>  
                              <li data-id="4" class="h5 tab4<?php if ($tab == 4) { echo " active";} ?>"><a href="#tab4" class="attach_file_tab" data-toggle="tab"><?php echo freetext('attach_file');?></a></li>  
                              <li data-id="5" class="h5 tab5<?php if ($tab == 5) { echo " active";} ?>"><a href="#tab5" class="tab_li" data-toggle="tab"><?php echo freetext('notice_email');?></a></li>  
                              <li data-id="6" class="h5 tab6<?php if ($tab == 6) { echo " active";} ?>"><a href="#tab6" class="tab_li" data-toggle="tab"><?php echo freetext('not_visit');?></a></li>  
                          </ul>
                        </header>
                        <div class="panel-body">
                          <div class="tab-content attach-tab">
                            <!--################## start : tab4 ################## -->
                            <div class="tab-pane<?php if ($tab == 4) { echo " active";} ?>" id="tab4">
                              <!-- tab4 -->
                               <?php $this->load->view('__visitation/page/detail_body_tab4'); ?>                              
                            </div><!-- end : div tab4 -->
                            <!--################## End : tab4 ################## -->
                          </div>
                          <form role="form" id="visit_form" data-parsley-validate action="<?php echo site_url('__ps_visitation/update_visitation/'.$track_doc_id) ?>" method="POST">
                            <input type="hidden" name="submit_sap" value="0">
                            <input type="hidden" name="tab" value="<?php echo $tab; ?>">
                            <div class="tab-content main-tab">
                              <!--################## start : tab1 ################## -->
                              <div class="tab-pane<?php if ($tab == 1) { echo " active";} ?>" id="tab1">
                                <!-- tab1 -->
                                 <?php $this->load->view('__visitation/page/detail_body_tab1'); ?>                              
                              </div><!-- end : div tab1 -->
                              <!--################## End : tab1 ################## -->
                              <!--################## start : tab1 ################## -->
                              <div class="tab-pane<?php if ($tab == 2) { echo " active";} ?>" id="tab2">
                                <!-- tab2 -->
                                 <?php $this->load->view('__visitation/page/detail_body_tab2'); ?>                              
                              </div><!-- end : div tab2 -->
                              <!--################## End : tab2 ################## -->
                              <!--################## start : tab3 ################## -->
                              <div class="tab-pane<?php if ($tab == 3) { echo " active";} ?>" id="tab3">
                                <!-- tab3 -->
                                 <?php $this->load->view('__visitation/page/detail_body_tab3'); ?>                              
                              </div><!-- end : div tab3 -->
                              <!--################## End : tab3 ################## -->
                              <!--################## start : tab5 ################## -->
                              <div class="tab-pane<?php if ($tab == 5) { echo " active";} ?>" id="tab5">
                                <!-- tab5 -->
                                 <?php $this->load->view('__visitation/page/detail_body_tab5'); ?>                              
                              </div><!-- end : div tab5 -->
                              <!--################## End : tab5 ################## -->
                              <!--################## start : tab6 ################## -->
                              <div class="tab-pane<?php if ($tab == 6) { echo " active";} ?>" id="tab6">
                                <!-- tab6 -->
                                 <?php $this->load->view('__visitation/page/detail_body_tab6', array('not_visit_reason_list' => $not_visit_reason)); ?>                              
                              </div><!-- end : div tab6 -->
                              <!--################## End : tab6 ################## -->
                            </div>
                          </form>
                        </div>
                        <div class="panel-footer row">
                          <div class="pull-left">
                            <a href="#" class="btn btn-info submit-form"><i class="fa fa-mail-forward h5"></i>&nbsp;<?php echo freetext('submit'); ?></a>
                          </div>
                          <div class="pull-right text-right">
                            <a href="#" class="btn btn-primary save-form"><i class="fa fa-save h5"></i>&nbsp;<?php echo freetext('save'); ?></a>
                          </div>
                        </div>
                      </section>
                    </div>
                  </div>
              </div>
          </div>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>











