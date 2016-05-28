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
                        <th colspan="9">
                          <div class="row">                        
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
                      <th ><?php echo freetext('list_of_employee_track'); ?></th>
                      <th class="tx-center"><?php echo freetext('plan_date'); ?></th>
                      <th class="tx-center"><?php echo freetext('actual_date'); ?></th>
                      <th class="tx-center"><?php echo freetext('submit_date_time'); ?></th>
                      <th class="tx-center"><?php echo freetext('status'); ?></th>
                      <th class="tx-center"><?php echo freetext('view_label'); ?></th>
                      <th class="tx-center"><?php echo freetext('edit_label'); ?></th>
                      <th class="tx-center"><?php echo freetext('del_label'); ?></th>
                    </tr>                    
                    </thead>
                    
                    <tbody>   
                    <?php                      
                      if(!empty($result)){
                      $content = $result['list'];                  
                      foreach ($content as $key => $value) {
                            $icon_status = "-";
                            
                            if($value['status'] != null && $value['status'] =='warning'){
                                $icon_status = "<i class='tx-yellow fa fa-warning h5'></i>";  
                            }else if($value['status'] != null && $value['status'] =='check'){
                              $icon_status = "<i class='tx-green fa fa-check h5'></i>";
                            }
                    ?>
                          <tr>  
                              <td><?php print $value['title']; //echo '#'.$value['id']; ?></td>
                              <td class="tx-center"><?php if( $value['plan_date'] !='0000-00-00' ){ echo common_easyDateFormat($value['plan_date']); }else{ echo "-"; }  //print $value['plan_date'];?></td>
                              <td class="tx-center"><?php if( $value['actual_date'] !='0000-00-00' && !empty($value['actual_date'])){ echo common_easyDateFormat($value['actual_date']); }else{ echo "-"; } // print $value['actual_date'];?></td>
                              <td class="tx-center"><?php if( $value['submit_date_sap'] !='0000-00-00 00:00:00' && !empty($value['submit_date_sap'])){ echo common_easyDateTimeFormat($value['submit_date_sap']); }else{ echo "-"; } // print $value['actual_date'];?></td>
                              <td class="tx-center"><?php  echo $icon_status;  //echo $count_uncheck; ?></td>
                               <!-- <START : ACTION SET> -->
                                <td class="tx-center">
                                  <a  data-cms-visible="view" 
                                  <?php 
                                    if( 
                                        !array_key_exists('view', $permission)
                                    ){ 
                                      echo 'disabled'; 
                                    } 
                                  ?>                                   
                                  href="<?php echo site_url($this->page_controller.'/detail/view/'.$value['quotation_id'].'/'.$value['id']); ?>" class="btn btn-default">
                                      <i class="fa fa-check-square-o h5"></i>
                                  </a>   
                                </td>    
                                <td class="tx-center">    
                                  <a  data-cms-visible="edit"
                                  <?php 
                                    if( !array_key_exists('edit', $permission) ||
                                        $value['submit_date_sap'] != "0000-00-00 00:00:00" || 
                                        date('m Y', strtotime($value['plan_date'])) != date('m Y') ||
                                        ($this->is_abort !='0000-00-00' && $this->is_abort <= date('Y-m-d'))
                                    ){ 
                                      echo 'disabled'; 
                                    } 
                                  ?>  
                                  href="<?php echo site_url($this->page_controller.'/detail/save/'.$value['quotation_id'].'/'.$value['id']); ?>" class="btn btn-default">
                                    <i class="fa fa-pencil h5"></i>
                                  </a>
                                </td>   
                                <td class="tx-center">
                                  <a  data-cms-visible="delete" 
                                  <?php 
                                    if(!array_key_exists('delete', $permission) ||
                                        $value['status'] != "" || 
                                        $value['submit_date_sap'] != "0000-00-00 00:00:00" ||
                                        ($this->is_abort !='0000-00-00' && $this->is_abort <= date('Y-m-d'))
                                    ) { 
                                      echo 'disabled'; 
                                    } 
                                  ?>
                                  class="btn btn-default commit-delete-btn" id="<?php echo $value['id']; ?>"  actionplan-id="<?php echo $value['action_plan_id']; ?>" project-id="<?php echo $this->project_id; ?>" main-table="<?php echo $this->table;#CMS?>"><i class="fa fa-trash-o"></i></a>
                                
                                </td>
                                <!-- <END : ACTION SET> -->

                          </tr>
                      <?php 
                       }
                     }
                    ?>
<!-- ////////////////////////////////////////// -->


                    </tbody>

                     <?php 
                      echo form_close();
                     ?> 
                    <!-- include : tfoot table -->
                    <?php $this->load->view('__employee_track/include/tfoot_list'); ?>

                  </table>
                 
                </div>
              </section>
            </div><!-- end div -->
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>





