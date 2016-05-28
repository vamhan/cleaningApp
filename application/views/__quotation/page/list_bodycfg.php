<?php
  $emp_id = $this->session->userdata('id');
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
                <li class="h5 tab2"><a href="<?php echo site_url($this->page_controller.'/listview_quotation'); ?>" ><?php echo freetext('quotation');?></a></li>
                <li class="h5 tab1"><a href="<?php echo site_url($this->page_controller.'/listview_prospect'); ?>" ><?php echo freetext('prospect');?></a></li>                           
            </ul>
          </header>
          <div class="panel-body">
            <div class="tab-content">
               <!--############################ start : tab1 ###################################-->
              <div class="tab-pane" id="tab1" style="height: 500px; overflow: auto;">  
              <!-- tab1 -->              
                  <section class="panel panel-default">
                          <div class="table-responsive">                  
                            <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
                              <thead>
                                <tr>
                                  <th colspan="5">
                                    <div class="row">                                                   
                                      <?php 
                                        #CMS 
                                        echo form_open($this->page_controller.'/listview_prospect');//.$this->project_id
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
                                        //echo form_open($this->page_controller.'/group_delete/'); 
                                        #END_CMS 
                                        ?>                  
                                        <input type="submit" name="delete" class="pull-right btn-sm btn-dark btn" value="Delete" style="display:none;">                             
                                       </div>

                                    </div>
                                  </th>
                                </tr>
                               <tr>
                                <th ><?php echo freetext('number'); ?></th>
                                <th ><?php echo freetext('list_of_prospect'); ?></th>
                                <th><?php echo freetext('create_by'); ?></th>
                                <th class="tx-center"><?php echo freetext('create_date'); ?></th>
                                <!-- <th class="tx-center"><?php //echo freetext('status'); ?></th> -->
                                <th class="tx-center">&nbsp;</th>

                               <!--  <th class="tx-center"><?php //echo freetext('view_label'); ?></th>
                                <th class="tx-center"><?php //echo freetext('edit_label'); ?></th>                                
                                <th class="tx-center"><?php //echo freetext('copy_label'); ?></th>
                                <th class="tx-center"><?php //echo freetext('paste_label'); ?></th>
                                <th class="tx-center"><?php //echo freetext('del_label'); ?></th> -->
                              </tr>
                              </thead>
                              
                              <tbody>   
                              <!-- ////////////////////////////////////// -->
                              <?php     
                                               
                                if(!empty($result)){
                                $emp_id = $this->session->userdata('id');
                                $content = $result['list']; 
                                if($result['page']==1){ $count_no =0;}else{ $start_page =$result['page']-1;  $count_no = ($result['page_size']*$start_page);}                                               
                                foreach ($content as $key => $value) {  
                                $count_no++;                  
                              ?>
                                    <tr>  
                                        <td><?php echo $count_no;  ?></td>
                                        <td><?php echo $value['id'].' '.$value['title'];  ?></td>
                                        <td><?php echo $value['user_firstname'].' '.' '.$value['user_lastname']; ?></td>
                                        <td class="tx-center"><?php if( $value['create_date'] !='0000-00-00' ){ echo common_easyDateFormat($value['create_date']); }else{ echo "-"; } ?></td>                                    
                                         <td class="tx-center">
                                           <a  data-cms-visible="view"  
                                          <?php
                                            if (!array_key_exists('view', $permission)) {
                                              echo " disabled";
                                            }
                                          ?>                                           
                                           href="<?php echo site_url($this->page_controller.'/detail_quotation/view_prospect/'.$value['id']); ?>" class="btn btn-default margin-left-small" data-toggle="tooltip" data-placement="top" title="<?php echo freetext('view_label'); ?>">
                                              <i class="fa fa-check-square-o h5"></i>
                                           </a> 

                                           <a  data-cms-visible="edit" href="<?php echo site_url($this->page_controller.'/detail_quotation/edit_prospect/'.$value['id']); ?>" 
                                            <?php
                                              if ($value['project_owner_id'] != $emp_id || !array_key_exists('edit', $permission) || (!empty($value['submit_date_sap']) && $value['submit_date_sap'] != "0000-00-00") ) {
                                                echo " disabled";
                                              }
                                            ?>
                                            class="btn btn-default margin-left-small" data-toggle="tooltip" data-placement="top" title="<?php echo freetext('edit_label'); ?>">
                                            <i class="fa fa-pencil h5"></i>
                                          </a>

                                            <a  data-cms-visible="delete" data-toggle="tooltip" data-placement="top" title="<?php echo freetext('del_label'); ?>" 
                                            <?php
                                              if ($value['project_owner_id'] != $emp_id || !array_key_exists('delete', $permission) || (!empty($value['submit_date_sap']) && $value['submit_date_sap'] != "0000-00-00")) {
                                                echo " disabled";
                                              }
                                            ?>
                                              class="btn btn-default commit-delete-btn margin-left-small" id="<?php echo $value['id']; ?>"  doctype="prospect"  ><i class="fa fa-trash-o"></i>
                                            </a>   
                                       
                                        </td>
                                    </tr>
                                <?php 
                                 }
                               }
                               //======= No data ===========
                                if(empty($result['list'])){
                                    echo "<tr>
                                            <td colspan='10'>ไม่มีข้อมูล</td>                                           
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
                              <?php $this->load->view('__quotation/include/tfoot_list'); ?>
                            </table>                 
                        </div>
                      </section>
                      <?php
                        if (array_key_exists('create', $permission)) {
                      ?>
                       <!-- start :  boton insert QT -->
                         <a href="#modal-insert-prospect" data-toggle="modal" class="btn btn-default pull-right" ><i class="fa fa-plus"></i> <?php echo freetext('add'); ?></a>
                      <!-- end :  boton insert QT-->
                      <?php
                        }
                      ?>
                          <!-- //add : prospect -->
                       
              
              </div>
              <!--############################ END : tab1 #######################################  -->

               <!--############################ start : tab2 ###################################-->
              <div class="tab-pane" id="tab2" style="height: 500px; overflow: auto;">
                <!-- tab2  -->
                  <section class="panel panel-default">
                          <div class="table-responsive">                  
                            <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
                              <thead>
                                <tr>
                                  <th colspan="10">
                                    <div class="row">                                                   
                                      <?php 
                                        #CMS 
                                        echo form_open($this->page_controller.'/listview_quotation');//.$this->project_id
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
                                        //echo form_open($this->page_controller.'/group_delete/'); 
                                        #END_CMS 
                                        ?>                  
                                        <input type="submit" name="delete" class="pull-right btn-sm btn-dark btn" value="Delete" style="display:none;">                             
                                       </div>

                                    </div>
                                  </th>
                                </tr>
                               <tr>
                                <th ><?php echo freetext('number'); ?></th>
                                <th width="20%"><?php echo freetext('list_of_quotation'); ?></th>
                                <th><?php echo freetext('create_by'); ?></th>
                                <th class="tx-center"><?php echo freetext('create_date'); ?></th>
                                <th class="tx-center"><?php echo freetext('status'); ?></th>
                                <th class="tx-center"><?php echo freetext('contract'); ?></th>
                                <th class="tx-center">วันเริ่ม - วันจบโครงการ</th>
                                <th class="tx-center">&nbsp;</th>
                              </tr>
                              </thead>
                              
                              <tbody>   
                              <!-- ////////////////////////////////////// -->
                              <?php                                                     
                                if(!empty($result)){
                                $content = $result['list'];
                                if($result['page']==1){ $count_no =0;}else{ $start_page =$result['page']-1;  $count_no = ($result['page_size']*$start_page);}              
                                foreach ($content as $key => $value) { 

                                    $count_no++;                    
                              ?>
                                    <tr>  
                                        <td><?php echo $count_no;  ?></td>
                                        <td><?php echo $value['id'].' '.$value['title'];  ?></td>
                                        <td><?php echo $value['user_firstname'].' '.' '.$value['user_lastname']; ?></td>
                                        <td class="tx-center"><?php if( $value['create_date'] !='0000-00-00' ){ echo common_easyDateFormat($value['create_date']); }else{ echo "-"; } ?></td>
                                        <td class="tx-center">
                                          <?php 
                                            echo $value['status'];
                                            if ($value['status'] == 'REJECT') {
                                              if (!empty($value['reject_by'])) {
                                                $reject_user = $this->__ps_project_query->getObj('tbt_user', array('user_id' => $value['reject_by']));
                                                echo "<br>[ ".freetext('by').' '.$reject_user['user_firstname'].' '.$reject_user['user_lastname'].' ]';
                                              } else {
                                                echo "<br>โดย ลูกค้า";
                                              }
                                            }  
                                          ?>
                                        </td>
                                        <td class="tx-center"><?php echo $value['contract_id'];  ?></td>
                                        <td class="tx-center">
                                            <?php if($value['project_start'] !='0000-00-00' || $value['project_end'] !='0000-00-00'){
                                                if( $value['project_start'] !='0000-00-00' ){ echo common_easyDateFormat($value['project_start']); } ?>
                                            -  <?php if( $value['project_end'] !='0000-00-00' ){ echo common_easyDateFormat($value['project_end']); }
                                                }
                                             ?>
                                        </td>
                                        <td class="tx-center">
                                          <?php 
                                            $temp_title = $value['title'];
                                            $str = explode(' ', $temp_title);
                                            $str_temp = $str[0];
                                         ?>

                                           <a  data-cms-visible="view"  href="<?php echo site_url($this->page_controller.'/detail_quotation/view_quotation/'.$value['id']); //.$value['id']?>" 
                                              <?php  
                                                   if(!array_key_exists('view', $permission)){
                                                    echo 'disabled';
                                                }
                                              ?>
                                              class="btn btn-default margin-left-small" data-toggle="tooltip" data-placement="top" title="<?php echo freetext('view_label'); ?>">
                                              <i class="fa fa-check-square-o h5"></i>
                                           </a> 

                                          <a  data-cms-visible="edit" href="<?php echo site_url($this->page_controller.'/detail_quotation/edit_quotation/'.$value['id']); //.$value['id']?>" 
                                              <?php  
                                                  if (
                                                      !array_key_exists('edit', $permission) || 
                                                      $emp_id != $value['project_owner_id'] ||
                                                      (
                                                        $value['status']!='OPEN' &&
                                                        (
                                                          $value['status'] != 'REJECT' || 
                                                          ( 
                                                            $value['status'] == 'REJECT' && 
                                                            (
                                                                !empty($value['contract_id']) || empty($value['reject_by']) 
                                                            ) 
                                                          ) 
                                                        ) 
                                                      )
                                                  ){
                                                    echo 'disabled';
                                                }
                                              ?>
                                              class="btn btn-default margin-left-small" data-toggle="tooltip" data-placement="top" title="<?php echo freetext('edit_label'); ?>">
                                              <i class="fa fa-pencil h5"></i>
                                            </a>

                                          <a  data-cms-visible="edit"  href="<?php echo site_url($this->page_controller.'/duplicate_quotation/'.$value['id']); ?>"
                                              <?php  
                                                   if(
                                                      !array_key_exists('create', $permission)
                                                      //|| $str_temp=='Copy'
                                                    ){
                                                    echo 'disabled';
                                                }
                                              ?>                                           
                                              class="btn btn-default margin-left-small" data-toggle="tooltip" data-placement="top" title="<?php echo freetext('duplicate_label'); ?>" >
                                              <i class="fa fa-copy h5"></i>
                                          </a> 

                                           <a  data-cms-visible="edit"  href="<?php echo site_url($this->page_controller.'/duplicate_quotation/'.$value['id'].'/1'); ?>"
                                               <?php                                      
                                                  if(
                                                      !array_key_exists('create', $permission) || 
                                                      $emp_id != $value['project_owner_id'] ||
                                                      ($value['status'] != 'EFFECTIVE' && $value['status'] != 'REJECT') ||                                                                                                            
                                                      empty($value['contract_id']) 
                                                      //|| $str_temp=='Copy'
                                                    ){
                                                      echo 'disabled';
                                                  }
                                                ?> 
                                               class="btn btn-default margin-left-small"  data-toggle="tooltip" data-placement="top" title="<?php echo freetext('paste_label'); ?>">
                                              <i class="fa fa-paste h5"></i>
                                          </a> 

                                           <a  data-cms-visible="delete"  data-toggle="tooltip" data-placement="top" title="<?php echo freetext('del_label'); ?>"
                                            <?php    
                                                if (
                                                    !array_key_exists('delete', $permission) || 
                                                    $emp_id != $value['project_owner_id'] ||
                                                    (
                                                      $value['status']!='OPEN' &&
                                                      (
                                                        $value['status'] != 'REJECT' || 
                                                        ( 
                                                          $value['status'] == 'REJECT' && 
                                                          (
                                                              !empty($value['contract_id']) || empty($value['reject_by']) 
                                                          ) 
                                                        ) 
                                                      ) 
                                                    )
                                                ){
                                                    echo 'disabled';
                                                }
                                            ?> 
                                               class="btn btn-default commit-delete-btn margin-left-small" id="<?php echo $value['id']; ?>"  doctype="quotation"  ><i class="fa fa-trash-o"></i>
                                           </a>     
                                       
                                        </td>

                                    </tr>
                                <?php 
                                 }
                               }
                               //======= No data ===========
                                if(empty($result['list'])){
                                  echo "<tr>
                                            <td colspan='10'>ไม่มีข้อมูล</td>                                           
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
                              <?php $this->load->view('__quotation/include/tfoot_list'); ?>
                            </table>                 
                        </div>
                      </section>
                      <?php
                        if (array_key_exists('create', $permission)) {
                      ?>
                       <!-- start :  boton insert QT -->
                         <a href="#modal-insert-quotation" data-toggle="modal" class="btn btn-default pull-right" ><i class="fa fa-plus"></i> <?php echo freetext('add'); ?></a>
                      <!-- end :  boton insert QT-->
                      <?php
                        }
                      ?>

                  </div>
              <!--############################ end : tab2 ###################################-->
            </div>
         

          </div><!-- end penel -->
        </section>
   <!--end: .nav-justified -->

    </div><!-- end div -->
    </section>
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
 


