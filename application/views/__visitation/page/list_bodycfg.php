<?php
  $emp_id = $this->session->userdata('id');
  $function = $this->session->userdata('function');
?>
<style type="text/css">
  .table-head,.table-division{ text-align: center }
  .panel-heading .btn-sm { margin-top: -6px}
</style>
    <div class="div_detail">   
     <!-- .nav-justified -->
        <section class="panel panel-default">
         <!--  <header class="panel-heading font-bold">                  
                  Qoutation Management
          </header> -->
          <header class="panel-heading bg-light">
            <ul class="nav nav-tabs nav-justified">
                <li class="h5 tab2"><a href="<?php echo site_url($this->page_controller.'/listview_quotation'); ?>" ><?php echo freetext('current_customer');?></a></li>
                <?php
                  if (in_array('MK', $function) || in_array('CR', $function)) {
                ?>
                <li class="h5 tab1"><a href="<?php echo site_url($this->page_controller.'/listview_prospect'); ?>" ><?php echo freetext('prospect');?></a></li>                           
                <?php
                  }
                ?>
            </ul>
          </header>
          <div class="panel-body">
            <div class="tab-content">
            <?php
              if (in_array('MK', $function) || in_array('CR', $function)) {
            ?>
               <!--############################ start : tab1 ###################################-->
              <div class="tab-pane" id="tab1" style="max-height: 500px; overflow: auto;">  
              <!-- tab1 -->              
                  <section class="panel panel-default">
                          <div class="table-responsive">                  
                            <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
                              <thead>
                                <tr>
                                  <th colspan="9">
                                    <div class="row">                                                   
                                      <?php 
                                        #CMS 
                                        echo form_open('');//.$this->project_id
                                        $keyword = $this->input->post("search");
                                        #END_CMS 
                                      ?>
                                      <div class="col-sm-12 m-t-xs m-b-xs " >
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
                                        //echo form_open($this->page_controller.'/group_delete/'); 
                                        #END_CMS 
                                        ?>                  
                                        <input type="submit" name="delete" class="pull-right btn-sm btn-dark btn" value="Delete" style="display:none;">                             
                                       </div>

                                    </div>
                                  </th>
                                </tr>
                                <tr>
                                  <th style="width:20%"><?php echo freetext('list_of_visitation'); ?></th>
                                  <th style="width:10%" class="tx-center"><?php echo freetext('customer'); ?></th>
                                  <th style="width:10%" class="tx-center"><?php echo freetext('visit_actor'); ?></th>
                                  <th style="width:10%" class="tx-center"><?php echo freetext('department'); ?></th>
                                  <th class="tx-center"><?php echo freetext('reason'); ?></th>
                                  <th class="tx-center"><?php echo freetext('visit_plan_date'); ?></th>
                                  <th class="tx-center"><?php echo freetext('visit_actual_date'); ?></th>
                                  <th class="tx-center">&nbsp;</th>
                                </tr>
                              </thead>
                              
                              <tbody>   
                              <!-- ////////////////////////////////////// -->
                              <?php                      
                                if(!empty($result)){
                                $content = $result['list'];        
                                foreach ($content as $key => $value) {     
                                  // echo "<pre>";               
                                  // print_r($value);
                                  // echo "</pre>";
                              ?>
                                    <tr>  
                                      <td><?php echo $value['title'];  ?></td>
                                      <td class="tx-center"><?php echo $value['prospect_title'];  ?></td>
                                      <td class="tx-center"><?php echo $value['visitor_firstname'].' '.$value['visitor_lastname']; ?></td>
                                      <td class="tx-center"><?php echo $value['department_name']; ?></td>
                                      <td class="tx-center"><?php echo $value['visit_reason']; ?></td>
                                      <td class="tx-center"><?php if( $value['plan_date'] !='0000-00-00' && !empty($value['plan_date']) ){ echo common_easyDateFormat($value['plan_date']); }else{ echo "-"; } ?></td>
                                      <td class="tx-center"><?php if( $value['actual_date'] !='0000-00-00' && !empty($value['actual_date']) ){ echo common_easyDateFormat($value['actual_date']); }else{ echo "-"; }?></td>
                                      <td class="tx-center">
                                        <a href="<?php echo site_url($this->page_controller.'/view_quotation/edit_prospect/'.$value['id']); ?>" class="btn btn-default"
                                        <?php 
                                          if( 
                                            !array_key_exists('view', $permission) ||
                                            (
                                              strtotime($value['plan_date']) > strtotime(date('Y-m-d '.'00:00:00')) && 
                                              date('m Y', strtotime($value['plan_date'])) != date('m Y') 
                                            )
                                          ) { 
                                            echo "disabled"; 
                                          } 
                                        ?>
                                        >
                                            <i class="fa fa-check-square-o h5"></i>
                                          </a>
                                        <a href="<?php echo site_url($this->page_controller.'/detail_quotation/edit_prospect/'.$value['id']); ?>" class="btn btn-default" 
                                        <?php 
                                          if(
                                              !array_key_exists('edit', $permission) ||
                                              $emp_id != $value['visitor_id'] ||
                                              (
                                                $value['submit_date_sap'] !='0000-00-00' || 
                                                date('m Y', strtotime($value['plan_date'])) != date('m Y')                                                 
                                              )
                                            ) { 
                                              echo "disabled"; 
                                            } 
                                        ?>
                                        >
                                          <i class="fa fa-pencil h5"></i>
                                        </a>
                                        <a href="#" class="btn btn-default commit-delete-btn" data-type="prospect" data-id="<?php echo $value['id']; ?>" 
                                        <?php 
                                          if( 
                                              !array_key_exists('delete', $permission) ||
                                              $emp_id != $value['visitor_id'] ||  
                                              (
                                                $value['submit_date_sap'] !='0000-00-00' || 
                                                ( 
                                                  $value['actual_date'] !='0000-00-00' && 
                                                  !empty($value['actual_date']) 
                                                ) 
                                              )
                                          ) { 
                                            echo "disabled"; 
                                          } 
                                        ?>
                                        ><i class="fa fa-trash-o h5"></i></a>
                                      </td>
                                    </tr>
                                <?php 
                                 }
                               }
                               //======= No data ===========
                                if(empty($result['list'])){
                                    echo "<tr>
                                            <td colspan='9'>ไม่มีข้อมูล</td>                                           
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
                              <?php $this->load->view('__visitation/include/tfoot_list'); ?>
                            </table>                 
                        </div>
                      </section>
              </div>
              <!--############################ END : tab1 #######################################  -->
              <?php
                }
              ?>
               <!--############################ start : tab2 ###################################-->
              <div class="tab-pane" id="tab2" style="max-height: 500px; overflow: auto;">
                <!-- tab2  -->
                  <section class="panel panel-default">
                          <div class="table-responsive">                  
                            <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
                              <thead>
                                <tr>
                                  <th colspan="9">
                                    <div class="row">                                                   
                                      <?php 
                                        $position_list = $this->session->userdata('position');

                                        $children = array();
                                        foreach ($position_list as $key => $position) {
                                            $children = $this->__ps_project_query->getPositionChild($children, $position);
                                        }
                                        #CMS 
                                        echo form_open('');//.$this->project_id
                                        $keyword = $this->input->post("search");
                                        #END_CMS 
                                      ?>
                                      <div class="col-sm-12 m-t-xs m-b-xs " >
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
                                        //echo form_open($this->page_controller.'/group_delete/'); 
                                        #END_CMS 
                                        ?>                  
                                        <input type="submit" name="delete" class="pull-right btn-sm btn-dark btn" value="Delete" style="display:none;">                             
                                       </div>

                                    </div>
                                  </th>
                                </tr>
                                <tr>
                                  <th style="width:20%"><?php echo freetext('list_of_visitation'); ?></th>
                                  <th style="width:10%" class="tx-center"><?php echo freetext('customer'); ?></th>
                                  <th style="width:10%" class="tx-center"><?php echo freetext('visit_actor'); ?></th>
                                  <th style="width:10%" class="tx-center"><?php echo freetext('department'); ?></th>
                                  <th class="tx-center"><?php echo freetext('reason'); ?></th>
                                  <th class="tx-center"><?php echo freetext('visit_plan_date'); ?></th>
                                  <th class="tx-center"><?php echo freetext('visit_actual_date'); ?></th>
                                  <th class="tx-center">&nbsp;</th>
                                </tr>
                              </thead>
                              
                              <tbody>   
                              <!-- ////////////////////////////////////// -->
                              <?php                      
                                if(!empty($result)){
                                $content = $result['list'];                  
                                foreach ($content as $key => $value) { 
                                  // echo "<pre>";               
                                  // print_r($value);
                                  // echo "</pre>"; 
                              ?>
                                    <tr>  
                                      <td><?php echo $value['title'];  ?></td>
                                      <td class="tx-center"><?php echo $value['customer_name'];  ?></td>
                                      <td class="tx-center"><?php echo $value['visitor_firstname'].' '.$value['visitor_lastname']; ?></td>
                                      <td class="tx-center"><?php echo $value['department_name']; ?></td>
                                      <td class="tx-center"><?php echo $value['visit_reason']; ?></td>
                                      <td class="tx-center"><?php if( $value['plan_date'] !='0000-00-00' && !empty($value['plan_date']) ){ echo common_easyDateFormat($value['plan_date']); }else{ echo "-"; } ?></td>
                                      <td class="tx-center"><?php if( $value['actual_date'] !='0000-00-00' && !empty($value['actual_date']) ){ echo common_easyDateFormat($value['actual_date']); }else{ echo "-"; }?></td>
                                      <td class="tx-center">
                                        <a href="<?php echo site_url($this->page_controller.'/view_quotation/edit_quotation/'.$value['id']); ?>" class="btn btn-default"
                                        <?php 
                                          if( 
                                            !array_key_exists('view', $permission) ||
                                            (
                                              strtotime($value['plan_date']) > strtotime(date('Y-m-d '.'00:00:00')) && 
                                              date('m Y', strtotime($value['plan_date'])) != date('m Y') 
                                            )
                                          ) { 
                                            echo "disabled"; 
                                          } 
                                        ?>
                                        >
                                          <i class="fa fa-check-square-o h5"></i>
                                        </a>
                                        <a href="<?php echo site_url($this->page_controller.'/detail_quotation/edit_quotation/'.$value['id']); ?>" class="btn btn-default" 
                                        <?php 
                                          if(
                                            !array_key_exists('edit', $permission) ||

                                            // $emp_id != $value['visitor_id'] ||  
                                            ( 
                                              empty($children) &&
                                              (
                                                $value['submit_date_sap'] !='0000-00-00' || 
                                                date('m Y', strtotime($value['plan_date'])) != date('m Y')
                                              )
                                            )
                                          ) { 
                                            echo "disabled"; 
                                          } 
                                        ?>
                                        >
                                          <i class="fa fa-pencil h5"></i>
                                        </a>
                                        <a href="#" class="btn btn-default commit-delete-btn" data-type="quotation" data-id="<?php echo $value['id']; ?>" 
                                        <?php 
                                          if( 
                                            !array_key_exists('delete', $permission) ||
                                            $emp_id != $value['visitor_id'] ||  
                                            $value['submit_date_sap'] !='0000-00-00' || 
                                            ( 
                                              $value['actual_date'] !='0000-00-00' && 
                                              !empty($value['actual_date']) 
                                            ) 
                                          ) { 
                                            echo "disabled"; 
                                          } 
                                        ?>
                                        >
                                          <i class="fa fa-trash-o h5"></i>
                                        </a>
                                      </td>
                                    </tr>
                                <?php 
                                 }
                               }
                               //======= No data ===========
                                if(empty($result['list'])){
                                    echo "<tr>
                                            <td colspan='9'>ไม่มีข้อมูล</td>                                           
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
                              <?php $this->load->view('__visitation/include/tfoot_list'); ?>
                            </table>                 
                        </div>
                      </section>
              </div>
              <!--############################ end : tab2 ###################################-->
            </div>

          <!-- start :  boton insert -->
            <?php
              if (array_key_exists('create', $permission)) { 
            ?>
                <a href="#modal-insert" data-toggle="modal" class="btn btn-default pull-right" ><i class="fa fa-plus"></i> <?php echo freetext('add'); ?></a>
            <?php
              }
            ?>
          <!-- end :  boton insert -->

          </div><!-- end penel -->
        </section>
   <!--end: .nav-justified -->

    </div><!-- end div -->
    </section>
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
 

   <!-- <START : ACTION SET> -->
  <!--   <td class="tx-center">
      <a  data-cms-visible="view"  href="<?php //echo site_url($this->page_controller.'/detail/view/'.$value['project_id'].'/'.$value['id']); ?>" class="btn btn-default">
          <i class="fa fa-check-square-o h5"></i>
      </a>   
    </td>    
    <td class="tx-center">                     
      <a  data-cms-visible="edit" href="<?php //echo site_url($this->page_controller.'/detail_quotation/edit_prospect/'.$value['id']); ?>" class="btn btn-default">
        <i class="fa fa-pencil h5"></i>
      </a>
    </td>  
    <td class="tx-center">
      <a  data-cms-visible="view"  href="<?php //echo site_url($this->page_controller.'/detail/view/'.$value['project_id'].'/'.$value['id']); ?>" class="btn btn-default">
          <i class="fa fa-copy h5"></i>
      </a>   
    </td>  
    <td class="tx-center">
      <a  data-cms-visible="view"  href="<?php //echo site_url($this->page_controller.'/detail/view/'.$value['project_id'].'/'.$value['id']); ?>" class="btn btn-default">
          <i class="fa fa-paste h5"></i>
      </a>   
    </td> 
    <td class="tx-center">
      <a  data-cms-visible="delete" 
      <?php                                      
          // if(!empty($submit_sap) || $is_disable_date_delete==1){
          //     echo 'disabled';
          // }
      ?> 
        class="btn btn-default commit-delete-btn" id="<?php //echo $value['id']; ?>"  doctype="prospect"  ><i class="fa fa-trash-o"></i>
        </a>                                
    </td>   --> 
    <!-- <END : ACTION SET> -->



