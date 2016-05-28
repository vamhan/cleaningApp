<?php $emp_id = $this->session->userdata('id'); ?>
<?php $limit_requisition_time = strtotime(date('Y-m-01', strtotime("+2 months"))) ?>
<?php $date_now = strtotime(date('Y-m-d', time())) ?>
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
                        <th colspan="10">
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
                          </div>
                        </th>
                      </tr>
                     <tr>
                      <!-- <th></th> -->
                      <th ><?php echo freetext('requisition_id'); ?></th>
                      <th ><?php echo freetext('list_of_equipment_requisition'); ?></th>
                      <th class="tx-center"><?php echo freetext('status'); ?></th>   
                      <th class="tx-center"><?php echo freetext('type'); ?></th>
                      <th class="tx-center"><?php echo freetext('sale_order_id'); ?></th>
                      <th class="tx-center"><?php echo freetext('create_date'); ?></th>
                      <th class="tx-center"><?php echo freetext('require_date_label'); ?></th>
                      <th class="tx-center"><?php echo freetext('view_label'); ?></th>
                      <th class="tx-center"><?php echo freetext('requisition_label'); ?></th>
                      <th class="tx-center"><?php echo freetext('del_label'); ?></th>
                     
                    </tr>


                    
                    </thead>
                    
                    <tbody>   
<!-- ////////////////////////////////////// -->
                    <?php                      
                      if(!empty($result)){
                      $content = $result['list'];                  
                      
                      foreach ($content as $key => $value) {
                    ?>
                          <tr>  
                              <!-- <td>
                                <input type="checkbox" name="forms[]" id="forms[]" value="<?php //print $value['id']; ?>">
                                  <span style='padding-left:12px'>
                                      <?php //print $value['plan_id'];?>
                                  </span>
                              </td> -->
                              <td><?php echo $value['id'];?></td>
                              <td><?php echo $value['title']; //echo '#'.$value['id']; ?></td>
                              <td class="tx-center"><?php if (!empty($value['status'])) { echo freetext($value['status']."_status"); } //echo '#'.$value['id']; ?></td>
                              <td class="tx-center"><?php echo freetext($value['order_type']."_".$value['item_category']); //echo '#'.$value['id']; ?></td>
                              <td class="tx-center"><?php echo $value['sale_order_id']; //echo '#'.$value['id']; ?></td>
                              <td class="tx-center"><?php if( $value['create_date'] !='0000-00-00' ){ echo common_easyDateFormat($value['create_date']); }else{ echo "-"; }  //print $value['plan_date'];?></td>
                              <td class="tx-center"><?php if( $value['require_date'] !='0000-00-00' ){ echo common_easyDateFormat($value['require_date']); }else{ echo "-"; } // print $value['actual_date'];?></td>                                            
                                <!-- <START : ACTION SET> -->
                                <td class="tx-center">      
                                <?php
                                  $disabled = "";
                                  if (!array_key_exists('view', $permission)) {
                                    $disabled = " disabled";
                                  }
                                ?>

                                  <a  data-cms-visible="view" href="<?php echo site_url($this->page_controller.'/detail/view/'.$this->project_id.'/'.$value['id']); ?>"  <?php echo $disabled; ?> class="btn btn-default">
                                      <i class="fa fa-check-square-o h5"></i>
                                  </a>   
                                </td>    
                                <td class="tx-center">
                                <?php
                                  $disabled = "";
                                  if (!array_key_exists('edit', $permission) ||
                                        $value['status'] == 'approved' || 
                                        (
                                          $value['status'] == 'submit' &&
                                          !array_key_exists('approve', $permission)
                                        ) ||
                                        (
                                          $value['order_type'] == 'ZORX' && 
                                          ( 
                                            strtotime($value['require_date']) >= $limit_requisition_time ||
                                            strtotime($value['require_date']) < $date_now
                                          ) 
                                        )
                                        || ($this->is_abort !='0000-00-00' && $this->is_abort <= date('Y-m-d'))
                                  ) {
                                    $disabled = " disabled";
                                  }
                                ?>
                                  <a <?php echo $disabled; ?> href="<?php echo site_url($this->page_controller.'/detail/edit/'.$this->project_id.'/'.$value['id']); ?>" class="btn btn-default">
                                      <i class="fa fa-pencil h5"></i>
                                  </a>   
                                </td>      
                                <td class="tx-center">
                                <?php
                                  $disabled = "";
                                  if (
                                        !array_key_exists('delete', $permission) ||
                                        $value['status'] != 'being' || 
                                        (
                                          $value['order_type'] == 'ZORX' && 
                                          ( 
                                            strtotime($value['require_date']) >= $limit_requisition_time ||
                                            strtotime($value['require_date']) < $date_now
                                          )
                                        )
                                        || ($this->is_abort !='0000-00-00' && $this->is_abort <= date('Y-m-d'))
                                  ) {
                                    $disabled = " disabled";
                                  }
                                ?>
                                  <a <?php echo $disabled; ?> class="btn btn-default commit-delete-btn" id="<?php echo $value['id']; ?>" project-id="<?php echo $this->project_id; ?>" main-table="<?php //echo $this->table;#CMS?>"><i class="fa fa-trash-o"></i></a>
                                
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
                    <?php $this->load->view('__equipment_requisition/include/tfoot_list'); ?>

                  </table>
                 
                </div>
              </section>
            </div><!-- end div -->
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>





