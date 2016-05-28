<?php $emp_id = $this->session->userdata('id'); ?>
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

                            <!-- <div class="col-sm-4 m-t-xs m-b-xs pull-right" >
                              <?php 
                              #CMS 
                              //echo form_open($this->page_controller.'/group_delete/');                               
                              #END_CMS 
                              ?>       

                              <input type="submit" name="delete" class="pull-right btn-sm btn-dark btn" value="Delete" style="display:none;">                             
                             </div> -->

                          </div>
                        </th>
                      </tr>


                     <tr>
                      <!-- <th></th> -->
                      <th ><?php echo freetext('id_fix_cliam'); ?></th>
                      <th ><?php echo freetext('list_of_fix_claim'); ?></th>
                      <th class="tx-center"><?php echo freetext('raise_date'); ?></th>   
                      <th class="tx-center"><?php echo freetext('plan_Date'); ?></th>
                      <th class="tx-center"><?php echo freetext('delivery_date'); ?></th>
                      <th class="tx-center"><?php echo freetext('accept_date'); ?></th>
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

                        if($value['close_date']!='0000-00-00'){
                            $actual_date = common_easyDateFormat($value['close_date']);
                        }else{
                            $actual_date ='-';
                        }
                       
                        // if($value['accept_delivered_date']!='0000-00-00'){
                        //     $actual_date = common_easyDateFormat($value['accept_delivered_date']);
                        // }else if($value['accept_abort_date']!='0000-00-00'){
                        //     $actual_date = common_easyDateFormat($value['accept_abort_date']);
                        // }else{
                        //     $actual_date ='-';
                        // }
                       //==== actor login =====
                        $actor_by_id = $this->session->userdata('id');
                        $raise_by_id = $value['raise_by_id'];
                        $is_match_actor =0;  
                        if($actor_by_id == $raise_by_id){
                          $is_match_actor =1;
                        }else{
                          $is_match_actor = 0;
                        }
                      //======================  
                      
                    ?>
                          <tr>  
                              <!-- <td>
                                <input type="checkbox" name="forms[]" id="forms[]" value="<?php //print $value['id']; ?>">
                                  <span style='padding-left:12px'>
                                      <?php //print $value['plan_id'];?>
                                  </span>
                              </td> -->
                              <td> <?php print $value['id'];?></td>
                              <td>
                                <?php 
                                    if($value['is_urgent']==1){
                                       echo "<i class='margin-right-small tx-red fa fa-exclamation-circle h5 data-toggle='tooltip' data-placement='top' title='ต้องการซ๋อมด่วน'></i>";
                                    }
                                      echo defill($value['material_no']).' '.$value['material_description']; //print $value['title'];  //echo '#'.$value['id']; 
                                  ?>
                              </td>
                              <td class="tx-center"><?php if( $value['raise_date'] !='0000-00-00' ){ echo common_easyDateFormat($value['raise_date']); }else{ echo "-"; }  //print $value['plan_date'];?></td>
                              <td class="tx-center"><?php if( $value['plan_date'] !='0000-00-00' ){ echo common_easyDateFormat($value['plan_date']); }else{ echo "-"; } // print $value['actual_date'];?></td>
                              <td class="tx-center"><?php if( $value['delivery_date'] !='0000-00-00' ){ echo common_easyDateFormat($value['delivery_date']); }else{ echo "-"; }  //print $value['plan_date'];?></td>
                              <td class="tx-center"><?php  echo $actual_date; ?></td>
                              <!-- <START : ACTION SET> -->
                                <td class="tx-center">
                                  <a  data-cms-visible="view" href="<?php echo site_url($this->page_controller.'/detail/view/'.$value['quotation_id'].'/'.$value['id']); ?>" class="btn btn-default">
                                      <i class="fa fa-check-square-o h5"></i>
                                  </a>   
                                </td>    
                                <td class="tx-center">                     
                                  <a data-cms-visible="view" <?php if($value['is_close']==1 || ($this->is_abort !='0000-00-00' && $this->is_abort <= date('Y-m-d')) ){ echo 'disabled'; } ?> href="<?php echo site_url($this->page_controller.'/detail/edit/'.$this->project_id.'/'.$value['id']); ?>" class="btn btn-default">
                                    <i class="fa fa-pencil h5"></i>
                                  </a>
                                </td>   
                                <td class="tx-center">
                                 <!--  <?// echo $is_match_actor;?> -->
                                  <a  data-cms-visible="delete" 
                                   <?php  
                                       // if($is_match_actor == 0){ echo 'disabled'; } 
                                       // if($value['plan_date'] !='0000-00-00' ){echo 'disabled'; } 
                                       // if($value['is_close']==1){ echo 'disabled'; }
                                       if($is_match_actor == 0 || $value['plan_date'] !='0000-00-00' || $value['is_close']==1 || ($this->is_abort !='0000-00-00' && $this->is_abort <= date('Y-m-d')) ){
                                           echo 'disabled';
                                       }
                                    ?>                                     
                                    class="btn btn-default commit-delete-btn" id="<?php echo $value['id']; ?>"  actionplan-id="<?php echo $value['action_plan_id']; ?>" project-id="<?php echo $this->project_id; ?>" >
                                    <i class="fa fa-trash-o"></i>
                                  </a>                                
                                </td>
                           <!-- <END : ACTION SET> -->


                          </tr>
                      <?php 
                       }//end frech
                     }//end if
                    
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
                    <?php $this->load->view('__fixclaim/include/tfoot_list'); ?>

                  </table>
                 
                </div>
              </section>
            </div><!-- end div -->
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>





