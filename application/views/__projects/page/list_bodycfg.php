<style type="text/css">
  .table-head,.table-division{ text-align: center }
  .panel-heading .btn-sm { margin-top: -6px}
</style>

<?php 
// echo '<pre>';
// print_r($result);
// echo '</pre>';
// echo '<hr>';
?>

 <section class="vbox">
            <section class="scrollable padder">
            
              <section class="panel panel-default">
                <header class="panel-heading">
                  <?php 
                    #CMS 
                    echo $this->page_title_ico;
                      print($this->page_title);
                    #END_CMS 
                  ?>
                   </header>
                <div class="table-responsive">                  
                  <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
                    <thead>
                      <tr>
                        <th colspan="9">
                          <div class="row">
                          
                            <?php 
                              #CMS 
                              echo form_open($this->page_controller.'/listview');
                              $keyword = $this->input->post("search");
                              $year = $this->input->post("year");
                              $job_type = $this->input->post("job_type");
                              $relavant = $this->input->post("relavant");
                              #END_CMS 
                            ?>
                            <div class="col-sm-12 m-t-xs m-b-xs " >
                              <!-- start : search-options -->
                              <div class="input-group col-sm-7 search datagrid-search pull-left">
                                <input type="text" autocomplete="off" class="input-sm form-control" name="search" id="search" placeholder="<?php echo freetext('search'); ?>" value='<?php echo !empty($keyword)?$keyword:""; ?>'>
                                <div class="input-group-btn">
                                  <button class="btn btn-default btn-sm sumbit-search" ><i class="fa fa-search"></i></button>
                                </div>                       
                              </div>
                              <!-- end  : search-options -->

                              <!-- start : year-options -->
                              <div class="col-sm-2 pull-left">
                              <select class="input-sm form-control" name='year'>
                                  <?php 
                                    $init_year = 2009;
                                    $current_year = intval(date('Y',time()));
                                    while($current_year > $init_year){
                                      //Detect weather on_year parameter sumitted or not
                                      $selected = ($current_year==$year)?'selected="selected"':'';
                                      ?>
                                      <option value='<?php echo $current_year; ?>' <?php echo $selected; ?> ><?php echo $current_year--; ?></option>
                                      <?php
                                    }
                                  ?>

                                  <option value='' <?php echo empty($year)?"selected='selected'":"" ?> >All</option>
                              </select>
                              </div>
                              <!-- end : year-options -->

                               <!-- start : job_type -->
                              <div class="col-sm-3 pull-left">
                              <select class="input-sm form-control" name='job_type'>   
                                  <option value='all' <?php if ($job_type == 'all') { echo 'selected'; } ?>>ทุกประเภทงาน</option> 
                                  <option value='ZQT1' <?php if ($job_type == 'ZQT1') { echo 'selected'; } ?>>งานประจำ</option>     
                                  <option value='ZQT2' <?php if ($job_type == 'ZQT2') { echo 'selected'; } ?>>งานจร</option>     
                                  <option value='ZQT3' <?php if ($job_type == 'ZQT3') { echo 'selected'; } ?>>งานโอที</option>      
                              </select>
                              </div>
                              <!-- end : job_type -->

                               <!-- start : relavant-options -->
                              <!--div class="col-sm-2 pull-left">
                              <select class="input-sm form-control" name='relavant'>
                                  <option value='all' <?php //if ($relavant == 'all') { echo 'selected'; } ?>>Relavant to All</option>    
                                  <option value='me' <?php //if ($relavant == 'me') { echo 'selected'; } ?>>Relavant to me</option>      
                              </select>
                              </div-->
                              <!-- end : relavant-options -->
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
                              <!-- <input type="submit" name="delete" class="pull-right btn-sm btn-dark btn" value="Delete" style="display:none;">                              -->
                              <!-- <a class='pull-right btn-sm btn-dark btn group-delete-button' style="margin-left:2px;"><?php //echo freetext('delete'); ?></a>
                              <a href="#modal-form" class="pull-right" data-toggle="modal"><button class='btn-sm btn-primary btn'><i class='fa fa-plus-circle'></i>&nbsp;&nbsp;<?php echo freetext('create_new_page'); ?></button></a>                                -->
                            </div>

                          </div>
                        </th>
                      </tr>


                    <tr>
                      <th class='table-head' width="100">เลขที่สัญญา </th>
                      <!-- <th class='table-head'>ชื่อลูกค้า</th> -->
                      <th class='table-head' width="140">เลขที่ใบเสนอราคา</th>
                      <th class='table-head' width="120"><?php echo freetext('ship_to_id'); ?></th>
                      <th class='table-head'><?php echo freetext('ship_to'); ?></th>
                      <th class='table-head' width="100">สถานะ</th>
                      <th class='table-head' width="130"><?php echo freetext('start_project'); ?></th>
                      <th class='table-head' width="150"><?php echo freetext('end_project'); ?></th>
                      <th class='table-head' width="100"><?php echo freetext('type'); ?></th>                      
                      <!-- <th class='table-head'>Project owner</th> -->
                      <th class='table-head'>&nbsp;</th>
                    </tr>
                    
                    </thead>
                    
                    <tbody class="text-center">
                      <?php    
                      $permission = $this->permission;
                      $equipment_requisition_id = 8;
                      $equipment_requisition_permission = array();
                      if (array_key_exists($equipment_requisition_id, $permission)) {
                        $equipment_requisition_permission = $permission[$equipment_requisition_id];
                      }

                      if(!empty($result)){
                      $content = $result['list'];                  
                      foreach ($content as $key => $value) {
                    ?>
                      <tr>
                        <td style='text-align:left'>
                          <input type="checkbox" class='hide' name="forms[]" id="forms[]" value="<?php print $value['id']; ?>">
                            <span style='padding-left:12px'>
                                <?php print $value['contract_id'];?>
                            </span>
                        </td>
                        
                       <!-- <td style='text-align:left'>
                         <?php
                          //if ($value['requisition_alert'] == 1 && !empty($equipment_requisition_permission) && array_key_exists('approve', $equipment_requisition_permission)) {
                         ?>
                            <span><i class="m-l-xs fa fa-info-circle text-danger" style="font-size:1.3em;"></i></span>
                         <?php
                          //}
                         ?>
                         <?php //print $value['customer_name'];?>
                       </td> -->

                      <td style='text-align:center'>
                         <?php print ($value['id']);?>
                       </td>

                       <td style='text-align:left'>
                         <?php print ($value['ship_to_id']);?>
                       </td>

                       <td style='text-align:left'>
                         <?php
                          if ($value['requisition_alert'] == 1 && !empty($equipment_requisition_permission) && array_key_exists('approve', $equipment_requisition_permission)) {
                         ?>
                            <span><i class="m-l-xs fa fa-info-circle text-danger" style="font-size:1.3em;"></i></span>
                         <?php
                          }
                         ?>
                         <?php print $value['shop_to_title'];?>
                       </td>

                       <td style='text-align:ceter'>
                         <?php
                          if ($value['is_abort_date'] !='0000-00-00' && $value['is_abort_date'] <= date('Y-m-d') ){
                         ?>
                            <span>                             
                              <i class="tx-red fa fa-times h4" data-toggle="tooltip" data-placement="top" title="is abort project"></i>
                            </span>
                         <?php
                          }
                         ?>
                          <?php print ($value['status']);?>
                       </td>

                       <td style='text-align:ceter'>
                         <?php print common_easyDateFormat($value['project_start']);?>
                       </td>

                       <td style='text-align:ceter'>
                         <?php print common_easyDateFormat($value['project_end']);?>
                       </td>

                       <td style='text-align:ceter'>
                          <?php 
                          //determine job type
                          $job_type = 'N/A';
                          if(array_key_exists('job_type', $value)){
                            if(strtoupper($value['job_type']) == 'ZQT1'){
                              $job_type = 'งานประจำ';
                            }else if(strtoupper($value['job_type']) == 'ZQT2'){
                              $job_type = 'งานจร';
                            }else if(strtoupper($value['job_type']) == 'ZQT3'){
                              $job_type = 'งานโอที';
                            }//end 
                          }
                         ?>
                         <?php print $job_type;?>
                       </td>

                                              
                        <!-- <START : ACTION SET> -->
                        <td style='text-align:right'>
                          <a class="btn btn-default" target='_self' href="<?php echo site_url('__ps_project/detail/'.$value['id']) ?>" data-toggle=""><i class="fa fa-eye"></i></a>
                        </td>
                        <!-- <END : ACTION SET> -->

                      </tr>
                    <?php 
                       }
                     }
                    ?>

                    </tbody>

                     <?php 
                      echo form_close();
                     ?> 
                    <!-- include : tfoot table -->
                    <?php $this->load->view('__projects/include/tfoot_list'); ?>

                  </table>
                 
                </div>
              </section>
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>





        <!--Start: modal confirm delete -->
        <div class="modal fade" id="modal-delete"  is-confirm='0'>          

            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>

                  <h3 class="title">Delete Confirm</h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <p class='msg'>Do you confirm to delete this item</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-delete  btn-default" data-dismiss="modal" aria-hidden="true">Cancel</span>
                  <span class="btn confirm-delete btn-primary" data-dismiss="modal" >Confirm</span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->           
        </div><!--end: modal confirm delete -->


