<?php
  $emp_id = $this->session->userdata('id');
?>
<style type="text/css">
  .table-head,.table-division{ text-align: center }
  .panel-heading .btn-sm { margin-top: -6px}
</style>
            <div class="div_detail">
              <section class="panel panel-default">
                <div class="table-responsive">                  
                  <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
                    <thead>
                      <tr>
                        <th colspan="8">
                          <div class="row">

                            <!-- <div class="col-sm-8 m-t-xs m-b-xs">
                              <div class="select filter" data-resize="auto">
                                <button data-toggle="dropdown" class="btn btn-sm btn-default dropdown-toggle">
                                  <span class="dropdown-label"></span>
                                  <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                  <li data-value="all" data-selected="true"><a href="#">All</a></li>
                                  <li data-value="lt5m"><a href="#">Population &lt; 5M</a></li>
                                  <li data-value="gte5m"><a href="#">Population &gt;= 5M</a></li>
                                </ul>
                              </div>
                            </div> -->
                          
                            <?php 

                              #CMS 
                              echo form_open($this->page_controller.'/listview/list/'.$this->project_id);
                              $keyword = $this->input->post("search");
                              #END_CMS 

                            ?>
                            <div class="col-sm-5 m-t-xs m-b-xs " >
                              <div class="input-group search datagrid-search">
                                <input type="text" autocomplete="off" class="input-sm form-control" name="search" id="search" placeholder="<?php echo freetext('search'); ?>" value='<?php echo !empty($keyword)?$keyword:""; ?>'>
                                <div class="input-group-btn">
                                  <button class="btn btn-default btn-sm sumbit-search" ><i class="fa fa-search"></i></button>
                                </div>                          
                              </div>
                            </div>
                            <?php 
                              echo form_close();
                            ?> 

                            <div class="col-sm-4 m-t-xs m-b-xs pull-right" >
                              <?php 
                              #CMS 
                              echo form_open($this->page_controller.'/group_delete/'); 
                              #END_CMS 
                              ?>                  
                              <input type="submit" name="delete" class="pull-right btn-sm btn-dark btn" value="Delete" style="display:none;">                             
                             </div>

                          </div>
                        </th>
                      </tr>


                     <tr>
                      <!-- <th></th> -->
                      <!-- <th >ID</th> -->
                      <th ><?php echo freetext('list_of_asset_track'); ?></th>
                      <th class="tx-center"><?php echo freetext('plan_date'); ?></th>
                      <th class="tx-center"><?php echo freetext('actual_date'); ?></th>
                      <th class="tx-center"><?php echo freetext('status'); ?></th>
                      <th class="tx-center"><?php echo freetext('view_label'); ?></th>
                      <th class="tx-center"><?php echo freetext('edit_label'); ?></th>
                      <th class="tx-center"><?php echo freetext('del_label'); ?></th>
                    </tr>


                    
                    </thead>
                    
                    <tbody>   
<!-- ////////////////////////////////////// -->
                    <?php
                      
                      if(!empty($result)){
                      $content = $result['list'];                  
                      foreach ($content as $key => $value) {
                            $submit_sap = $value['submit_date_sap'];//submit_date
                        //== start: get status ================  

                            if(!empty($value['status_asset_track_document'])){
                                if($value['status_asset_track_document']=='warning'){
                                   $icon_status = "<i class='tx-yellow fa fa-warning h5'></i>";  
                                }else{
                                  $icon_status = "<i class='tx-green fa fa-check h5'></i>";
                                }
                            }else{
                                 $icon_status = "-";   
                            }
                      // === end get status =============================================

                       //== start: check status assetrack not_exist ================  
                            $status_not_exit = 0;

                            $query_not_exit = $this->__asset_track_model->getAssetrack_Notexit($value['id']);
                              if(!empty($query_not_exit)){
                                 foreach ($query_not_exit->result_array() as $data){                              
                                    $serial= $data['asset_no'];
                                    $status_assetrack = $data['status_tracking'];
                                    //echo $serial.' '.$status_assetrack.' '.$value['id'].'<br>';   
                                    $status_not_exit = 1;                                                           
                                }//end foreach
                                  
                              }else{
                                 //echo $value['id'].' null<br>';
                                 $status_not_exit = 0;
                              }
                      // === end check status assetrack not_exist =============================================



                      //=========== checkout month year action plan ============
                        date_default_timezone_set('Asia/Bangkok');
                        $date_action_plan = getdate(strtotime($value['plan_date']));
                        $date_today = getdate(strtotime(date('Y-m-d 00:00:00')));
                        $is_disable_date = 0;
                        $is_disable_date_delete = 0;
                        
                        if($date_today['mon'] == $date_action_plan['mon']  && $date_today['year'] == $date_action_plan['year']){
                            $is_disable_date = 0;
                        }else{
                            $is_disable_date = 1;
                        }

                        if( $value['actual_date_plan'] !='0000-00-00' && !empty($value['actual_date_plan']) || $date_today['year'] > $date_action_plan['year'] || ($date_today['year'] == $date_action_plan['year'] && $date_today['mon'] < $date_action_plan['mon'] ) ){
                            $is_disable_date_delete = 1;
                        }else{
                            $is_disable_date_delete = 0;
                        }  
                      //========================================================

                    ?>
                          <tr>  
                              <!-- <td>
                                <input type="checkbox" name="forms[]" id="forms[]" value="<?php //print $value['id']; ?>">
                                  <span style='padding-left:12px'>
                                      <?php //print $value['plan_id'];?>
                                  </span>
                              </td> -->
                              <!-- <td><?php //print $value['id'];?></td> -->
                              <td><?php print $value['title']; //echo '#'.$value['id']; ?></td>
                              <td class="tx-center"><?php if( $value['plan_date'] !='0000-00-00' ){ echo common_easyDateFormat($value['plan_date']); }else{ echo "-"; }  //print $value['plan_date'];?></td>
                              <td class="tx-center"><?php if( $value['actual_date_plan'] !='0000-00-00' && !empty($value['actual_date_plan']) ){ echo common_easyDateFormat($value['actual_date_plan']); }else{ echo "-"; } // print $value['actual_date'];?></td>
                              <td class="tx-center">
                                <?php  echo $icon_status;  
                                       //echo  $status_not_exit;
                                       //echo ' '.$value['status_asset_track_document']; 
                                    if($status_not_exit==1){
                                      echo "<i class='margin-left-medium tx-red fa fa-exclamation-circle h5 data-toggle='tooltip' data-placement='top' title='have asset not exit'></i>";
                                    }
                                ?>
                              </td>

                               <!-- <START : ACTION SET> -->
                                <td class="tx-center">
                                  <a  data-cms-visible="view" 
                                  <?php
                                    if (!array_key_exists('view', $permission)) {
                                      echo " disabled";
                                    }
                                  ?>                  
                                  href="<?php echo site_url($this->page_controller.'/detail/view/'.$value['quotation_id'].'/'.$value['id']); ?>" class="btn btn-default">
                                      <i class="fa fa-check-square-o h5"></i>
                                  </a>   
                                </td>    
                                <td class="tx-center">                     
                                  <?php $group = $this->session->userdata('group'); ?>
                                  <a  data-cms-visible="edit"  
                                  <?php 
                                    if($is_disable_date==1 || !array_key_exists('edit', $permission) || ($this->is_abort !='0000-00-00' && $this->is_abort <= date('Y-m-d'))){ 
                                      echo 'disabled'; 
                                    } ?> <?php if(!empty($submit_sap) ){ echo 'disabled'; } ?> href="<?php echo site_url($this->page_controller.'/detail/save/'.$value['quotation_id'].'/'.$value['id']); ?>" class="btn btn-default">
                                    <i class="fa fa-pencil h5"></i>
                                  </a>
                                </td>   
                                <td class="tx-center">
                                  <a  data-cms-visible="delete" 
                                  <?php 
                                      // if($is_disable_date==1){ echo 'disabled'; }
                                      // if(!empty($submit_sap) ){ echo 'disabled'; }
                                      if(!empty($submit_sap) || $is_disable_date_delete==1 || !array_key_exists('delete', $permission) || ($this->is_abort !='0000-00-00' && $this->is_abort <= date('Y-m-d'))  ){
                                          echo 'disabled';
                                      }
                                  ?> 
                                    class="btn btn-default commit-delete-btn" id="<?php echo $value['id']; ?>"  actionplan-id="<?php echo $value['action_plan_id']; ?>" porject-id="<?php echo $this->project_id; ?>" main-table="<?php echo $this->table;#CMS?>"><i class="fa fa-trash-o"></i>
                                    </a>                                
                                </td>
                                <!-- <END : ACTION SET> -->
                          </tr>
                      <?php 
                       }
                     }
                     //======= No data ===========
                      if(empty($result['list'])){
                        echo "<tr>
                                  <td>ไม่มีข้อมูล</td>
                              </tr>";
                      }
                    //======= No data ===========
                    ?>
<!-- ////////////////////////////////////////// -->


                    </tbody>

                     <?php 
                      echo form_close();
                     ?> 
                    <!-- include : tfoot table -->
                    <?php $this->load->view('__asset_track/include/tfoot_list'); ?>

                  </table>
                 
                </div>
              </section>
            </div><!-- end div -->
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>





